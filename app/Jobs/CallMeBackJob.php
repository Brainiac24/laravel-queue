<?php

namespace App\Jobs;

use App\Jobs\CallMeBackCallbackJob;
use App\Services\Common\Helpers\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CallMeBackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 3;
    public $timeout = 60;
    private $intervalNextTryAt = 5;
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
        ];
    }

    public function handle()
    {
        $data = $this->data;
        try {

            $data['status'] = true;

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $callback = new CallMeBackCallbackJob($data);
            $callback->handle();

        } catch (\Throwable $th) {
            $data['status'] = false;

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($data, JSON_UNESCAPED_UNICODE);
            $log_params['StatusCode'] = $this->response->getStatusCode() ?? null;
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $this->release(600); // 10 minutes

        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
