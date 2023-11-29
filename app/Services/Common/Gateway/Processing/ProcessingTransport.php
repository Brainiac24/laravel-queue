<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 06.07.2018
 * Time: 15:56
 */

namespace App\Services\Common\Gateway\Processing;

use App\Services\Common\Helpers\Logger\Logger;
use Ramsey\Uuid\Uuid;

class ProcessingTransport implements ProcessingTransportContract
{
    protected $server_url;
    protected $point_id;
    protected $login;
    protected $password;
//    protected $valid_answers;
    protected $answers = [];
    protected $commands = [];
    protected $authentication_method;
    protected $server_method;
    protected $resultArray = [];
    protected $logger;

    public function __construct()
    {
        // Initialize variables
        $this->server_url = config('processingconf.server_url');
        $this->point_id = config('processingconf.point_id');
        $this->login = config('processingconf.login');
        $this->password = config('processingconf.password');
//        $this->valid_answers = config('processingconf.valid_answers');
        $this->server_method = config('processingconf.server_method');
        $this->answers = config('processingconf.answers');
        $this->logger = new Logger('gateways/processing', 'PROCESSING');
    }

    /**
     * @param $txn_id
     * @param $sum
     * @param $prv_id
     * @param $number
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pay($txn_id, $sum, $prv_id, $number)
    {
        $fullURL = sprintf('%s?txn_id=%s&sum=%s&prv_id=%s&NUMBER=%s&point_id=%s&command=pay', $this->server_url, $txn_id, $sum, $prv_id, $number, $this->point_id);
        $result = $this->sendRequest($fullURL);
        $resultArray = [];
        if (isset($this->answers[$result['result']])) {
            $resultArray['txn_id'] = $result['osmp_txn_id'];
            $resultArray['message'] = $this->answers[$result['result']]['message'];
            $resultArray['private_state_id'] = $this->answers[$result['result']]['private_state_id'];
            $resultArray['fatal'] = $this->answers[$result['result']]['fatal'];
            $resultArray['requested_txn'] = $result['osmp_txn_id'];
            $resultArray['request_uuid'] = $result['request_uuid'];
            $resultArray['info'] = $result['extra_info'] ?? [];
            $resultArray['response'] = $result['responced_xml'];
            $resultArray['request'] = $fullURL;
        } else
            $resultArray = $this->fail($result);

        return $resultArray;
    }

    /**
     * @param $txn_id
     * @param $sum
     * @param $prv_id
     * @param $number
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check($txn_id, $sum, $prv_id, $number)
    {
        $fullURL = sprintf('%s?txn_id=%s&sum=%s&prv_id=%s&NUMBER=%s&point_id=%s&command=check', $this->server_url, $txn_id, $sum, $prv_id, $number, $this->point_id);
        $resultArray = [];
        $result = $this->sendRequest($fullURL);

        if (isset($this->answers[$result['result']])) {
            $resultArray['txn_id'] = $result['osmp_txn_id'];
            $resultArray['message'] = $this->answers[$result['result']]['message'] . '. ' . json_encode($result['comment']);
            $resultArray['private_state_id'] = $this->answers[$result['result']]['private_state_id'];
            $resultArray['fatal'] = $this->answers[$result['result']]['fatal'];
            $resultArray['requested_txn'] = $txn_id;
            $resultArray['request_uuid'] = $result['request_uuid'];
            $resultArray['info'] = $result['extra_info'] ?? [];
            $resultArray['response'] = $result['responced_xml'];
            $resultArray['request'] = $fullURL;
        } else
            $resultArray = $this->fail($result);

        return $resultArray;
    }

    /**
     * @param $txn_id
     * @param $sum
     * @param $prv_id
     * @param $number
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function status($txn_id, $sum, $prv_id, $number)
    {
        $fullURL = sprintf('%s?txn_id=%s&sum=%s&prv_id=%s&NUMBER=%s&point_id=%s&command=pay&getstatus=1', $this->server_url, $txn_id, $sum, $prv_id, $number, $this->point_id);
        $result = $this->sendRequest($fullURL);
        $resultArray = [];
        if (isset($this->answers[$result['result']])) {
            $resultArray['txn_id'] = $result['osmp_txn_id'];
            $resultArray['requested_txn'] = $txn_id;
            $resultArray['request_uuid'] = $result['request_uuid'];
            $resultArray['info'] = $result['extra_info'] ?? [];
            $resultArray['response'] = $result['responced_xml'];
            $resultArray['request'] = $fullURL;
            $resultArray['online_status'] = $result['online_status'] ?? null;
            $resultArray['fatal'] = $this->answers[$result['result']]['fatal'];
            $resultArray['private_state_id'] = $this->answers[$result['result']]['private_state_id'];
            $resultArray['message'] = $result['params']['Description'] ?? 'Params description not found';
            $resultArray['comment'] = $result['comment'] ?? 'Comment not found';

        } else
            $resultArray = $this->fail($result);

        return $resultArray;
    }

    protected function fail($data)
    {
        return [
            'message' => $data['message'] ?? 'UNKNOWN MESSAGE',
            'request_uuid' => $data['request_uuid'],
            'private_state_id' => $data['private_state_id'] ?? $this->answers[StatusEnum::ERROR_UNKNOWN]['private_state_id'],
            'fatal' => false
        ];
    }

    /**
     * @param $requestStr
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function sendRequest($requestStr)
    {
        set_time_limit ( 70);

        $uuid = (string)Uuid::uuid4();
        try {
            $client = new \GuzzleHttp\Client();
            $this->logger->info(sprintf('Request - %s; url=%s;', $uuid, $requestStr));

            $options =  [
                'auth' => [$this->login, $this->password],
                'connect_timeout' => 55,
            ];

            $response = $client->request($this->server_method, $requestStr, $options);
            $resultArray = json_decode(json_encode(simplexml_load_string((string)$response->getBody(), "SimpleXMLElement", LIBXML_NOCDATA)), true);
            $this->logger->info(sprintf('Response - %s; url=%s; payload=%s', $uuid, $requestStr, $response->getBody()));
            $resultArray['responced_xml'] = (string)$response->getBody();
            $resultArray['request_uuid'] = $uuid;
            return $resultArray;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('Request - %s; url=%s; message=%s; trace=%s;', $uuid, $requestStr, $e->getMessage(), $e->getTraceAsString()));
            return [
                'message' => $e->getMessage(),
                'private_state_id' => $this->answers[StatusEnum::ERROR_CONNECTION]['private_state_id'],
                'request_uuid' => $uuid,
                'fatal' => false
            ];
        }
    }

}