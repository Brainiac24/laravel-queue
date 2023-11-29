<?php

namespace App\Jobs\TransferFromRu;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Common\Helpers\Helper;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\TransferFromRu\StatusHelper;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Common\Helpers\Logger\Logger;
use App\Jobs\TransferFromRu\PaymentCallbackJob;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Services\Common\Gateway\Transfer\Transfer;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Common\Gateway\Transfer\Requests\PaymentRequest;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    protected $log_name = 'ClassNotSet';

    public $tries = 222;
    public $timeout = 60;
    public $errors = '';
    public $api_url = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;
    protected $intervalNextTryAt = 5;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/tkb', 'BUS2_TRANSPORT');
        $this->log_name = get_class($this);
        $this->api_url = config('tkb.bind_card_url');
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'datetime' => 'nullable|date_format:ymdHis',

            'account' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'settlement_curr' => 'required|string',
            'curr_rate' => 'required|string', // Так как шина проверяет как строковая и обрезает 0,156{0} сделали проверку string а не на numeric
            'pay_id' => 'required|numeric',
            'pay_date' => 'required|date_format:"Y-m-d H:i:s"',
            'card_type' => 'required|string',
        ];
    }

    public function handle()
    {

        $transport = new Transfer($this->api_url);

        $data = new PaymentRequest(
            $this->data['account'],
            $this->data['amount'],
            $this->data['currency'],
            $this->data['settlement_curr'],
            $this->data['curr_rate'],
            $this->data['pay_id'],
            $this->data['pay_date'],
            $this->data['card_type']
        );

        //$uuid = Uuid::uuid4();

        $this->options = $data->getAllParamsToArray();

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

        $this->logger->info('PARAMS - QUEUE BUS2 REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

        $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);

        try {

            $this->res_data = $transport->send($data, $this->session_id);

            $xml_response = simplexml_load_string($this->res_data, "SimpleXMLElement", LIBXML_NOCDATA, '', true);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $status_id = TransactionStatusV2::BLOCK_UNKNOWN;
            $status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;

            $this->logger->info('RESPONSE - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $arr_response = json_decode(json_encode($xml_response), true);
            $code = $arr_response['CODE'] ?? null;

            if ($code === StatusHelper::OK || $code === StatusHelper::DUPLICATE_TRANSACTION) {

                $this->response = Helper::data(
                    $this->data['session_id'],
                    true,
                    [
                        "code" => $code,
                        "message" => $arr_response['MESSAGE'],
                        "ext_id" => $arr_response['EXT_ID'],
                        "reg_date" => Carbon::parse(str_replace("_", " ", $arr_response['REG_DATE']))->format("Y-m-d H:i:s"),
                        "status_id" => TransactionStatusV2::PAY_COMPLETED,
                        "status_detail_id" => TransactionStatusDetail::OK,
                        "response" => $this->res_data,
                    ]
                );
            } elseif ($code === StatusHelper::TEMPORARY_ERROR_RETRY) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->errors = 'ERROR BUS_CODE_RETURNED 1 MUST RETRY - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('ERROR BUS_CODE 1 MUST RETRY - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);
            } elseif (
                $code === StatusHelper::VALIDATION_ERROR ||
                $code === StatusHelper::RECEIVER_NOT_FOUND ||
                $code === StatusHelper::RECEIVER_WRONG_ID ||
                $code === StatusHelper::RECEIVER_ACCOUNT_NOT_ACTIVE ||
                $code === StatusHelper::VALIDATION_WRONG_PAY_ID ||
                $code === StatusHelper::TECHNICAL_TRANSFER_ERROR ||
                $code === StatusHelper::VALIDATION_AMOUNT_ERROR ||
                $code === StatusHelper::VALIDATION_MIN_LIMIT_ERROR ||
                $code === StatusHelper::VALIDATION_MAX_LIMIT_ERROR ||
                $code === StatusHelper::VALIDATION_PAY_DATE_ERROR ||
                $code === StatusHelper::CURRENCY_RATE_ERROR
            ) {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "code" => $code,
                        "message" => $arr_response['MESSAGE'] ?? null,
                        "ext_id" => $arr_response['EXT_ID'] ?? null,
                        "reg_date" => isset($arr_response['EXT_ID']) ? Carbon::parse(str_replace("_", " ", $arr_response['REG_DATE']))->format("Y-m-d H:i:s") : null,
                        "status_id" => TransactionStatusV2::PAY_UNKNOWN,
                        "status_detail_id" => TransactionStatusDetail::ERROR_REQUEST,
                        "response" => $this->res_data,
                    ]
                );
            } else {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "code" => $code,
                        "message" => $arr_response['MESSAGE'] ?? null,
                        "ext_id" => $arr_response['EXT_ID'] ?? null,
                        "reg_date" => isset($arr_response['EXT_ID']) ? Carbon::parse(str_replace("_", " ", $arr_response['REG_DATE']))->format("Y-m-d H:i:s") : null,
                        "status_id" => TransactionStatusV2::PAY_UNKNOWN,
                        "status_detail_id" => TransactionStatusDetail::ERROR_UNKNOWN,
                        "response" => $this->res_data,
                    ]
                );
            }

            PaymentCallbackJob::dispatch($this->response)->onQueue(QueueEnum::PROCESSING);
            //return $this->response;

        } catch (ConnectException $conEx) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        } catch (\Throwable $th) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }

        
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
