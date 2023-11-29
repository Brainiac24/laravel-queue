<?php

namespace App\Jobs;

use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTransactionDataToWebHookUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 60;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;
    protected $callbackUrl = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/merchants', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);

    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'amount' => 'required|numeric',
            'currency_iso_name' => 'required|string',
            'order_number' => 'nullable|numeric',
            'transaction_session_number' => 'required|numeric',
            'merchant_item_name' => 'required|string',
            'comment' => 'required|string',
            'webhook_url' => 'required|string',
        ];
    }

    public function handle()
    {
        $this->session_id = $this->data['session_id'];
        $this->callbackUrl = $this->data['webhook_url'];
        try {

            $headers = [
                'Content-Type' => 'application/json; charset=UTF-8',
            ];

            $body = json_encode([
                "amount" => $this->data['amount'],
                "currency" => $this->data['currency_iso_name'],
                "order_number" => $this->data['order_number'],
                "transaction_number" => $this->data['transaction_session_number'],
                "merchant_name" => $this->data['merchant_item_name'],
                "comment" => $this->data['amount'],
            ]);

            $this->options = [
                'headers' => $headers,
                'decode_content' => false,
                'timeout' => 50,
                'connect_timeout' => 50,
                'verify' => false,
                //'cert' => [config('rucard.path_certificat'),config('rucard.certificat_key_password')],
                //'ssl_key' => [config('rucard.path_certificat_key'),config('rucard.certificat_key_password')],
                'body' => $body,
            ];

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
            $log_params['Url'] = $this->callbackUrl;

            $this->logger->info('PARAMS - QUEUE WEBHOOK_TRANSPORT REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $client = new Client();
            $this->response = $client->post($this->callbackUrl, $this->options);

            $this->logger->info('RAWDATA - QUEUE WEBHOOK_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' ---url: ' . $this->callbackUrl . ' --- response: ' . (string) $this->response->getBody() . ' --- request: ' . print_r($this->options['body'] ?? $this->options, true));

            if ($this->response->getStatusCode() == 200) {
                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('SUCCESS - QUEUE WEBHOOK_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                return $responseBody;
            } else {

                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG - QUEUE WEBHOOK_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                throw new \Exception();
            }

        } catch (\Throwable $e) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
            $log_params['Url'] = $this->callbackUrl;
            $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE WEBHOOK_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . print_r($log_params, true);
            $this->logger->error('FATAL ERROR - QUEUE WEBHOOK_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            throw $e;
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
