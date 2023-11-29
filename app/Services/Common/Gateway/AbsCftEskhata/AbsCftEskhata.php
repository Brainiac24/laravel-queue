<?php

/**
 * Course updater class
 * Autor: Farrukh Kosimov
 * 04/07/2018  13:08:00
 */

namespace App\Services\Common\Gateway\AbsCftEskhata;

use App\Services\Common\Helpers\ArrayToXml;
use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Psr7\Request;
use Ramsey\Uuid\Uuid;

abstract class AbsCftEskhata
{
    protected $server_url;
    protected const SERVER_PROTOCOL_METHOD = 'POST';
    protected const A_GET_RATE = 'A_GET_RATE_IBANK';
    protected const R_GET_RATE = 'R_GET_RATE_IBANK';
    protected const A_GET_ANSWER = 'A_GET_ANSWER';
    protected const R_GET_ANSWER = 'R_GET_ANSWER';
    protected const PRIMARY_XML_CONTAINER = 'root';
    protected const SERVER_PROTOCOL_VER = '1.00';
    protected $logger;
    public $log_name = 'ClassNotSet';

    /**
     * AbsCftEskhata constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->server_url = config('abscfteskhata.server_url');
        $this->logger = new Logger('gateways/abscft', 'ABS_CFT_ESKHATA');
        $this->log_name = get_class($this);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest($data)
    {
        $head = [];
        $request = [];
        foreach ($data as $key_name => $key_value) {
            if ($key_name == 'session_id' || $key_name == 'application_key') {
                $head[$key_name] = $key_value;
            } else {
                $request[$key_name] = $key_value;
            }
        }
        $root = ['head' => $head, 'request' => $request];
        $xml = ArrayToXml::convert($root, ['rootElementName' => self::PRIMARY_XML_CONTAINER]);
        return $this->sendHTTPRequest($xml);
    }

    /**
     * @param $session_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function checkResult($session_id)
    {
        $root = ['head' => ["session_id" => $session_id], 'request' => ["protocol-version" => self::SERVER_PROTOCOL_VER, "request-type" => self::R_GET_ANSWER,]];
        $xml = ArrayToXml::convert($root, ['rootElementName' => self::PRIMARY_XML_CONTAINER]);
        return $this->sendHTTPRequest($xml);
    }

    /**
     * @param $xml
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function sendHTTPRequest($xml)
    {
        $uuid = (string)Uuid::uuid4();
        // SEND HTTP REQUEST
        try {
            $client = new \GuzzleHttp\Client();
            $this->logger->info(sprintf('Request - %s; url=%s; payload=%s', $uuid, $this->server_url, $xml));
            $request = new Request(self::SERVER_PROTOCOL_METHOD, $this->server_url, ['Content-Type' => 'application/xml; charset=UTF8; verify=true'], $xml);
            $response = $client->send($request);
            $resultArray = json_decode(json_encode(simplexml_load_string((string)$response->getBody()->getContents(), "SimpleXMLElement", LIBXML_NOCDATA)), true);
            $resultArray['request_uuid'] = $uuid;
            $this->logger->info(sprintf('Response - %s; url=%s; payload=%s', $uuid, $this->server_url, $response->getBody()));
            return $resultArray;
        } catch (\Exception $e) {
            $resultArray['message'] = $e->getMessage();
            $resultArray['state'] = -1;
            $resultArray['request_uuid'] = $uuid;
            $this->logger->error(sprintf('Request - %s; url=%s; payload=%s; message=%s; trace=%s;', $uuid, $this->server_url, $xml, $e->getMessage(), $e->getTraceAsString()));
            return $resultArray;
        }
    }
}
