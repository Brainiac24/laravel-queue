<?php

namespace App\Services\Common\Gateway\TransCapitalBank;

use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class TkbTransport
{
    public $logger;
    public $log_name = 'ClassNotSet';
    protected $tkbUrl = null;
    protected $options = null;
    protected $response = null;
    protected $session_id = null;
    protected $api_url = '';

    public function __construct($api_url = '')
    {
        $this->logger = new Logger('gateways/tkb', 'TKB_TRANSPORT');
        $this->log_name = get_class($this);
        $this->tkbUrl = config('tkb.url');
        $this->tkbLogin = config('tkb.login');
        $this->tkbKey = config('tkb.key');
        $this->api_url = $api_url;
    }

    public function send(ITkbRequest $request, $session_id = '')
    {

        $data_json = json_encode($request->getData());
        $key = base64_encode(hash_hmac("sha1", $data_json, $this->tkbKey, true));

        $this->session_id = $session_id;
        try {

            $headers = [
                'Content-Type' => 'application/json; charset=utf-8',
                'TCB-Header-Login' => $this->tkbLogin,
                'TCB-Header-Sign' => $key,
            ];

            $this->options = [
                'headers' => $headers,
                'decode_content' => false,
                'timeout' => 50,
                'connect_timeout' => 50,
                'verify' => false,
                //'cert' => [config('rucard.path_certificat'),config('rucard.certificat_key_password')],
                //'ssl_key' => [config('rucard.path_certificat_key'),config('rucard.certificat_key_password')],
                'body' => $data_json,
            ];

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
            $log_params['Url'] = $this->tkbUrl;

            $this->logger->info('PARAMS - QUEUE TKB_TRANSPORT REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $client = new Client();
            $this->response = $client->post($this->tkbUrl . $this->api_url, $this->options);

            $this->logger->info('RAWDATA - QUEUE TKB_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' ---url: ' . $this->tkbUrl . ' --- response: ' . (string) $this->response->getBody() . ' --- request: ' . print_r($this->options['body'] ?? $this->options, true));

            if (!empty($this->response->getBody()) && $this->response->getStatusCode() == 200) {
                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->tkbUrl;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('SUCCESS - QUEUE TKB_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                return $responseBody;
            }if (!empty($this->response->getBody()) && $this->response->getStatusCode() == 500){
                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->tkbUrl;
                $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG 500 - QUEUE TKB_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                return $responseBody;
            } else {

                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->tkbUrl;
                $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG - QUEUE TKB_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                throw new \Exception();
            }

        } catch (ServerException $serEx) {

            if ($serEx->getCode() == 500) {
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->tkbUrl;
                $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
                $log_params['ResponseData'] = $this->response;
                $log_params['ErrorMessage'] = $serEx->getMessage();
                $log_params['ErrorTraceData'] = $serEx->getTraceAsString();

                $this->errors = 'ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $a = $serEx->getResponse();
                $b = $serEx->getResponse()->getBody();
                $c = $serEx->getResponse()->getBody()->getContents();
                return $c;
            }else {
                throw $serEx;
            }
            


        } catch (\Throwable $e) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
            $log_params['Url'] = $this->tkbUrl;
            $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE TKB_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . print_r($log_params, true);
            $this->logger->error('FATAL ERROR - QUEUE TKB_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            throw $e;
        }

    }
}
