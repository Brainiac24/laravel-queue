<?php

namespace App\Jobs\TransferFromRu;

use App\Services\Common\Gateway\Transfer\Requests\GetClientInfoRequest;
use App\Services\Common\Gateway\Transfer\Transfer;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class GetClientInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    protected $log_name = 'ClassNotSet';

    public $tries = 1;
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
        ];
    }

    public function handle()
    {

        $transport = new Transfer($this->api_url);

        $data = new GetClientInfoRequest(
            $this->data['account'],
            $this->data['amount'],
            $this->data['currency'],
            $this->data['settlement_curr']
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

            $this->logger->info('RESPONSE - QUEUE BUS2 RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $arr_response = json_decode(json_encode($xml_response), true);
            $code = $arr_response['CODE'] ?? null;

            

            if ($code === "0") {

                $this->response = Helper::data(
                    $this->data['session_id'],
                    true,
                    [
                        "code" => $code,
                        "fio" => $arr_response['FIO'],
                        "amount" => $arr_response['CREDIT_AMOUNT'],
                        "currency_iso_name" => $arr_response['CREDIT_CURR'],
                        "currency_rate" => $arr_response['CURR_RATE'],
                        "response" => $this->res_data,
                    ]
                );
            }else {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    [
                        "code" => $code,
                        "fio" => $arr_response['FIO'] ?? null,
                        "amount" => $arr_response['CREDIT_AMOUNT'] ?? null,
                        "currency_iso_name" => $arr_response['CREDIT_CURR'] ?? null,
                        "currency_rate" => $arr_response['CURR_RATE'] ?? null,
                        "response" => $this->res_data,
                    ]
                );

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

        return $this->response;
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
