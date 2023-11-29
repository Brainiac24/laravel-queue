<?php

namespace App\Jobs\TransCapitalBankJobs;

use App\Services\Common\Gateway\TransCapitalBank\Apis\RegisterOrderFromRegisteredCard;
use App\Services\Common\Gateway\TransCapitalBank\TkbTransport;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FillRegisteredCardJob implements ShouldQueue
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
        $this->logger = new Logger('gateways/tkb', 'TKB_TRANSPORT');
        $this->log_name = get_class($this);
        $this->api_url = config('tkb.fill_registered_card_url');
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'datetime' => 'nullable|date_format:ymdHis',

            'ext_id' => 'required|string',
            'card_ref_id' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'return_url' => 'required|string',
        ];
    }

    public function handle()
    {

        $transport = new TkbTransport($this->api_url);

        $data = new RegisterOrderFromRegisteredCard(
            $this->data['ext_id'],
            $this->data['card_ref_id'],
            $this->data['amount'],
            $this->data['description'],
            $this->data['return_url']
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
            $OrderId = $arr_response['OrderId'] ?? null;
            $ExtId = $arr_response['ExtId'] ?? null;
            $FormURL = $arr_response['FormURL'] ?? null;
            $ExceptionType = $arr_response['ExceptionType'] ?? null;

            if ($OrderId != null && $ExtId != null && $FormURL != null) {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    true,
                    [
                        "form_url" => $FormURL,
                        "response" => $this->res_data,
                    ]
                );
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
                    $this->res_data
                );

            } else {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    $this->res_data
                );

            }

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
                    $this->res_data
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

        return $this->response;
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
