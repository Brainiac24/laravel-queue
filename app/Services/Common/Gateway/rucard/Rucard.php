<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 20.02.2019
 * Time: 8:16
 */

namespace App\Services\Common\Gateway\Rucard;

use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Base\IRequest;
use App\Services\Common\Gateway\Rucard\Base\RucardBase;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;

class Rucard extends RucardBase
{
    public $logger;
    public $log_name = 'ClassNotSet';
    protected $callbackUrl = null;
    protected $options = null;
    protected $response = null;
    protected $session_id = null;

    public function __construct()
    {
        $this->logger = new Logger('gateways/rucard', 'RUCARD_TRANSPORT');
        $this->log_name = get_class($this);
        $this->callbackUrl = config('rucard.url');
    }

    /**
     * @param IRequest $request
     * @param $type
     * @return mixed
     */
    public function send(IRequest $request, $session_id = '', $stan = '')
    {

        $this->session_id = $session_id;
        try {

            $headers = [
                'Content-Type' => 'text/xml; charset=windows-1251',
            ];

            $body = $this->convertArrayToXml($request->getAllParamsToArray());

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
            $log_params['RequestData'] = print_r($this->options['body']??$this->options, true);
            $log_params['Url'] = $this->callbackUrl;
            
            $this->logger->info('PARAMS - QUEUE RUCARD_TRANSPORT REQUEST --- stan: '. $stan .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);


            $client = new Client();
            $this->response = $client->post($this->callbackUrl, $this->options);
            
            $this->logger->info('RAWDATA - QUEUE RUCARD_TRANSPORT RESPONSE --- stan: '. $stan .' --- session_id: '. $this->session_id.' ---url: ' . $this->callbackUrl . ' --- response: ' . (string) $this->response->getBody() . ' --- request: ' . print_r($this->options['body']??$this->options, true));
            
            
            if (!empty($this->response->getBody()) && $this->response->getStatusCode() == 200) {
                $responseBody = RucardHelper::utf8ize((string) $this->response->getBody());
                
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body']??$this->options, true);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('SUCCESS - QUEUE RUCARD_TRANSPORT RESPONSE --- stan: '. $stan .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);


                return $responseBody;
            } else {

                $responseBody = RucardHelper::utf8ize((string) $this->response->getBody());

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body']??$this->options, true);
                $log_params['Url'] = $this->callbackUrl;
                $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG - QUEUE RUCARD_TRANSPORT RESPONSE --- stan: '. $stan .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                throw new \Exception();
            }

        } catch (\Throwable $e) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options['body']??$this->options, true);
            $log_params['Url'] = $this->callbackUrl;
            $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
            $log_params['ResponseData'] = RucardHelper::utf8ize($this->response);
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE RUCARD_TRANSPORT --- stan: '. $stan .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . print_r($log_params, true);
            $this->logger->error('FATAL ERROR - QUEUE RUCARD_TRANSPORT --- stan: '. $stan .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            throw $e;
        }

    }
}
