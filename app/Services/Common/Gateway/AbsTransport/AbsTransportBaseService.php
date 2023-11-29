<?php

namespace App\Services\Common\Gateway\AbsTransport;

use App\Services\Common\Helpers\ArrayToXml;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class AbsTransportBaseService
{

    public $transportEntity;
    private $server_url;
    private $logger;
    public $log_name = 'ClassNotSet';
    public $session_id = null;
    public $response = null;

    public function __construct(AbsTransportEntity $transportEntity)
    {
        //dd(config('abs.server_url'));
        $this->transportEntity = $transportEntity;
        $this->server_url = config('abs.server_url');
        $this->logger = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public function createStruture($request)
    {
        $e = $this->transportEntity;

        $head = $this->transportEntity->getHead();

        return
        $head->child([
            $e->getSessionId(),
            $e->getCallbackUrl(),
        ])->toArray() +
        $request->child([
            $e->getProtocolVersion(),
            $e->getType(),
            $e->getStateCode(),
            $e->getStateMsg(),
            $e->getDateStart(),
            $e->getDateEnd(),
            $e->getData(),
        ])->toArray();

    }

    public function prepareRequest()
    {
        $e = $this->transportEntity;

        $e->getSessionId()->setValue($e->getSessionId()->getValue() ?? ((string) Uuid::uuid4()));

        $structure_arr = $this->createStruture($e->getRequest());

        //dd($structure_arr);
        return $this->arrayToXml((array) $structure_arr);
    }

    protected function arrayToXml(array $data)
    {
        return ArrayToXml::convert($data, ['rootElementName' => $this->transportEntity->getRoot()->getKey()], true, 'UTF-8');
    }

    public function sendRequest($data = null, $url = null)
    {
        if (empty($data)) {
            $data = $this->createStruture($this->transportEntity->getRequest());
        }

        if (empty($url)) {
            $url = $this->server_url;
        }

        $data_xml = $this->arrayToXml((array) $data);
        /*
        if ($is_self_closing_tag_enabled) {
            $data_xml = preg_replace("/<([^>]+)><\/(.+)>/", "<$1 />", $data_xml);
        }
        */

        $responseBody = null;
        $resultArray = null;

        $res = null;

        $uuid = Uuid::uuid4();
        // dd($data);
        //set_time_limit(60);

        try {

            //$this->session_id = json_encode($data);
            $this->session_id = (((array) $data)['head']['session_id'])??'';
            $client = new Client();

            $headers = [
                'Content-Type' => 'application/xml; charset=UTF8;',
            ];

            $options = [
                'connect_timeout' => 30,
                'headers' => $headers,
                'body' => $data_xml,
            ];

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = json_encode($data_xml, JSON_UNESCAPED_UNICODE);
            $log_params['Url'] = $url;

            $this->logger->info('PARAMS - QUEUE BUS_TRANSPORT REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

            $this->response = $client->post($url, $options);

            if (!empty((string) $this->response->getBody()) && $this->response->getStatusCode() == 200) {
                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = json_encode($data_xml, JSON_UNESCAPED_UNICODE);
                $log_params['Url'] = $url;
                $log_params['StatusCode'] = $this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('SUCCESS - QUEUE BUS_TRANSPORT RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

                $res = $responseBody;
            } else {

                $responseBody = (string) $this->response->getBody();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['RequestData'] = json_encode($data_xml, JSON_UNESCAPED_UNICODE);
                $log_params['Url'] = $url;
                $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
                $log_params['ResponseData'] = $responseBody;

                $this->logger->info('WRONG - QUEUE BUS_TRANSPORT RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

                throw new \Exception();
            }

        } catch (\Throwable $e) {
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['RequestData'] = json_encode($data_xml, JSON_UNESCAPED_UNICODE);
            $log_params['Url'] = $url;
            $log_params['StatusCode'] = empty($this->response)?:$this->response->getStatusCode();
            $log_params['ResponseData'] = $this->response;
            $log_params['ErrorMessage'] = $e->getMessage();
            $log_params['ErrorTraceData'] = $e->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS_TRANSPORT RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS_TRANSPORT RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            throw $e;
        }

        return $res;

    }


}
