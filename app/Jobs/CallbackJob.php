<?php

namespace App\Jobs;

use App\Services\Common\Helpers\Logger\Logger;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class CallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    public $log_name = 'ClassNotSet';
    

    public $tries = 222;
    public $attempts = 3;
    public $timeout = 60;
    protected $callbackUrl = null;
    protected $intervalNextTryAt = 5;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->log_name = $data['LOG_NAME'] ?? get_class($this);
        $this->data = $data;
        $this->session_id = $this->data['session_id']??null;
        $this->callbackUrl = config('callback.callback_url');
        $this->logger = new Logger('gateways/callback', 'CALLBACK_TRANSPORT');
    }

    public static function rules()
    {
        return [];
    }

    public static function user_accounts_list_rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
        ];
    }

    public function handle()
    {

        $data = null;

        $delay = $this->calculateDelay();
        //$this->logger->info($delay);

        try {
            $client = new Client();
            $stan = isset($this->data['stan'])?('--- stan: '. $this->data['stan'] .' '):'';

            $headers = [
                'Content-Type' => 'application/json; charset=UTF8;',
            ];

            $this->options = [
                'connect_timeout' => 50,
                'json' => $this->data,
            ];

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['Url'] = $this->callbackUrl;

            $this->logger->info('PARAMS - QUEUE REQUEST '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

            $this->response = $client->post($this->callbackUrl, $this->options);
            $this->res_data = (string) $this->response->getBody();

            if (!empty($this->res_data) && $this->response->getStatusCode() == 200 && (json_decode($this->res_data, true)['success'] ?? false) === true) {
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('SUCCESS - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            } else {
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

                $delay = $this->calculateDelay();
                $this->release($delay);

                //CallbackJob::dispatch($this->data)->delay(10)->onQueue(QueueEnum::PROCESSING);
                //$this->delete();
            }

        } catch (ConnectException $conEx) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['Url'] = $this->callbackUrl;
            $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params, JSON_UNESCAPED_UNICODE);
            $this->logger->error('ERROR CONNECTION - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            //$this->data['errors'] = $this->errors;
            $delay = $this->calculateDelay();
            $this->release($delay);

        } catch (\Throwable $e) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['Url'] = $this->callbackUrl;
            $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params, JSON_UNESCAPED_UNICODE);
            $this->logger->error('FATAL ERROR - QUEUE RESPONSE '.$stan.'--- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            //$this->data['errors'] = $this->errors;
            $delay = $this->calculateDelay();
            $this->release($delay);

            //throw $e;
        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function calculateDelay()
    {
        return Carbon::now()->addSecond(($this->attempts() * 2) * $this->intervalNextTryAt);
    }
}
