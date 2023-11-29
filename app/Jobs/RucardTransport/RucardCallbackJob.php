<?php

namespace App\Jobs\RucardTransport;


use App\Jobs\RucardTransport\RucardHelper;
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

class RucardCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 222;
    public $attempts=3;
    public $timeout = 60;
    private $callbackUrl = null;
    private $intervalNextTryAt = 5;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id']??null;
        $this->callbackUrl = config('rucard.callback_url');
        $this->logger = new Logger('gateways/rucard', 'RUCARD_TRANSPORT');
        $this->log_name = get_class($this);
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
        $response = null;

        $uuid = Uuid::uuid4();
        $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
        //$this->logger->info($delay);

        try {
            $client = new Client();

            $headers = [
                'Content-Type' => 'application/json; charset=UTF8;',
            ];

            $options = [
                'connect_timeout' => 50,
                'json' => $this->data,
            ];

            $this->logger->info('Request CALLBACK PARAMS uuid ' . (string)$uuid . ' --- data: ' . json_encode($options));
            
            $response = $client->post($this->callbackUrl, $options);
            $data = (string) $response->getBody();
            //dd(json_decode($data)['success']);
            if (!empty($data) && $response->getStatusCode() == 200 && (json_decode($data,true)['success']??false) === true) {
                $this->logger->info('Request CALLBACK SUCCESS uuid ' . (string)$uuid . ' --- url ' .$this->callbackUrl.' --- status_code: ' . $response->getStatusCode() . ' --- data: ' . json_encode($options) . ' --- Response: ' . $data);
            } else {
                $this->logger->info('Request CALLBACK NOT SUCCESS uuid ' . (string)$uuid . ' --- url ' .$this->callbackUrl.' --- status_code: ' . $response->getStatusCode() . ' --- data: ' . json_encode($options) . ' --- Response: ' . $data);
                $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);
                
                //CallbackJob::dispatch($this->data)->delay(10)->onQueue(QueueEnum::PROCESSING);
                //$this->delete();
            }

        } catch (ConnectException $conEx) {
            $this->logger->error('Request CALLBACK ERROR uuid ' . (string)$uuid . ' --- url ' .$this->callbackUrl. '  --- status_code: ' . (empty($response)?null:$response->getStatusCode()) . ' --- data: ' . json_encode($this->data) . ' --- message = ' . $conEx->getMessage() . ' --- trace = ' . $conEx->getTraceAsString());
            $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);

        } catch (\Throwable $e) {

            //dd($this->logger);
            $this->logger->error('Request CALLBACK ERROR uuid ' . (string)$uuid .  ' --- url ' . $this->callbackUrl .' --- status_code: ' . (empty($response)?null:$response->getStatusCode()) . ' --- data: ' . json_encode($this->data) . ' --- message = ' . $e->getMessage() . ' --- trace = ' . $e->getTraceAsString());
            $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
            
            //throw $e;
        }


    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
