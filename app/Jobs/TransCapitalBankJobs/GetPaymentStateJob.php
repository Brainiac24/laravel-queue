<?php

namespace App\Jobs\TransCapitalBankJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Common\Helpers\Helper;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Common\Helpers\Logger\Logger;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Jobs\TransCapitalBankJobs\GetOrderStateCallbackJob;
use App\Services\Common\Gateway\TransCapitalBank\TkbTransport;
use App\Services\Common\Gateway\TransCapitalBank\Apis\GetOrderState;
use App\Services\Common\Gateway\TransCapitalBank\Helpers\TkbStateHelper;
use App\Services\Common\Gateway\TransCapitalBank\Helpers\TkbOrderTypeHelper;

class GetPaymentStateJob implements ShouldQueue
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
        $this->logger = new Logger('gateways/tkb', 'TKB_TRANSPORT');
        $this->log_name = get_class($this);
        $this->api_url = config('tkb.get_order_state_url');
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'datetime' => 'nullable|date_format:ymdHis',

            'ext_id' => 'required|string',
        ];
    }

    public function handle()
    {

        $transport = new TkbTransport($this->api_url);

        $data = new GetOrderState(
            $this->data['ext_id']
        );

        //$uuid = Uuid::uuid4();

        $this->options = $data->getData();

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

        $this->logger->info('PARAMS - QUEUE TKB REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

        $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);

        try {

            $this->res_data = $transport->send($data, $this->session_id);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $arr_response = json_decode($this->res_data, true);
            $ErrorCode = isset($arr_response['ErrorInfo']['ErrorCode']) ? $arr_response['ErrorInfo']['ErrorCode'] : null;
            $OrderType = isset($arr_response['OrderInfo']['Type']) ? $arr_response['OrderInfo']['Type'] : null;
            $OrderState = isset($arr_response['OrderInfo']['State']) ? $arr_response['OrderInfo']['State'] : null;
            $ExceptionType = $arr_response['ExceptionType'] ?? null;
            $status_id = TransactionStatusV2::BLOCK_UNKNOWN;
            $status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;

            if ($ErrorCode === 0) {

                if ($OrderType == TkbOrderTypeHelper::FROMUNREGISTEREDCARD) {

                    $status = false;
                    if ($OrderState == TkbStateHelper::DEBET_SUCCESSED) {
                        $status = true;
                        $status_id = TransactionStatusV2::BLOCKED;
                        $status_detail_id = TransactionStatusDetail::OK;
                    }elseif ($OrderState == TkbStateHelper::ERROR) {
                        $status = false;
                        $status_id = TransactionStatusV2::BLOCK_REJECTED;
                        $status_detail_id = TransactionStatusDetail::ERROR_NOT_ACCEPTED;
                    }else{
                        $this->release($delay);
                        return;
                    }

                    $this->response = Helper::data(
                        $this->data['session_id'],
                        $status,
                        [
                            "status_id" => $status_id,
                            'status_detail_id' => $status_detail_id,
                            "response" => $this->res_data,
                        ]
                    );

                } else {
                    $this->response = Helper::data(
                        $this->data['session_id'],
                        false,
                        [
                            "message" => "Error: OrderType is not FROMUNREGISTEREDCARD",
                            "status_id" => $status_id,
                            'status_detail_id' => $status_detail_id,
                            "response" => $this->res_data,
                        ]
                    );
                }

            } elseif ($ExceptionType == 'Error') {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('RESPONSE - QUEUE TKB RESPONSE WRONG --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "message" => "Critical error",
                        "status_id" => $status_id,
                        'status_detail_id' => $status_detail_id,
                        "response" => $this->res_data,
                    ]
                );

            } else {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "message" => "Critical error 2",
                        "status_id" => $status_id,
                        'status_detail_id' => $status_detail_id,
                        "response" => $this->res_data,
                    ]
                );

            }

            GetPaymentStateCallbackJob::dispatch($this->response)->onQueue(QueueEnum::REQUEST);
            //return $this->response;

        } catch (ServerException $serEx) {

            if ($serEx->getCode() == 500) {
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;
                $log_params['ErrorMessage'] = $serEx->getMessage();
                $log_params['ErrorTraceData'] = $serEx->getTraceAsString();

                $this->errors = 'ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "message" => "Server error",
                        "status_id" => $status_id,
                        'status_detail_id' => $status_detail_id,
                        "response" => $this->res_data,
                    ]
                );
            } else {
                throw $serEx;
            }

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

            $this->errors = 'ERROR CONNECTION - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

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

            $this->errors = 'FATAL ERROR - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }

        
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
