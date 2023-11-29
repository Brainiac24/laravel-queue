<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 17.04.2020
 * Time: 13:19
 */

namespace App\Services\Common\Gateway\Transfer;

use App\Services\Common\Gateway\Transfer\Base\Base;
use App\Services\Common\Gateway\Transfer\Base\IRequest;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;

class Transfer extends Base
{

    public $logger;
    public $log_name = 'ClassNotSet';
    protected $options = null;
    protected $response = null;
    protected $session_id = null;
    protected $api_url = '';

    public function __construct()
    {
        $this->logger = new Logger('gateways/bus_transfer_from_ru', 'BUS_TRANSFER_FROM_RU_TRANSPORT');
        $this->log_name = get_class($this);
        $this->api_url = config('transfer_from_ru.url');
    }

    public function send(IRequest $request, $session_id = '')
    {

        try {

            $this->session_id = $session_id;

            $this->options = $request->getAllParamsToArray();

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options, true);
            $log_params['Url'] = $this->api_url;

            $this->logger->info('PARAMS - QUEUE BUS_TRANSFER_FROM_RU_TRANSPORT REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $client = new Client();
            $this->response = $client->get($this->api_url, ['query' => $this->options]);

            $this->logger->info('RAWDATA - QUEUE BUS_TRANSFER_FROM_RU_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' ---url: ' . $this->api_url . ' --- response: ' . (string) $this->response->getBody() . ' --- request: ' . print_r($this->options, true));

            if (!empty($this->response->getBody()) && $this->response->getStatusCode() == 200) {

                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->api_url;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('SUCCESS - QUEUE RUCARD_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                return $responseBody;

            } else {
                $responseBody = empty($this->response) ?: ((string) $this->response->getBody());

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = print_r($this->options['body'] ?? $this->options, true);
                $log_params['Url'] = $this->api_url;
                $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG - QUEUE RUCARD_TRANSPORT RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                throw new \Exception();
            }

        } catch (\Throwable $e) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = print_r($this->options, true);
            $log_params['Url'] = $this->api_url;
            $log_params['StatusCode'] = empty($this->response) ?: $this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS_TRANSFER_FROM_RU_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . print_r($log_params, true);
            $this->logger->error('FATAL ERROR - QUEUE BUS_TRANSFER_FROM_RU_TRANSPORT --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            throw $e;
        }
    }

}
