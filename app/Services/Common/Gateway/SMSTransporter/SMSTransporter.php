<?php
/**
 * Created by PhpStorm.
 * User: Farrukh Kosimov
 * Date: 04.07.2018
 * Time: 16:28
 */

namespace App\Services\Common\Gateway\SMSTransporter;

use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class SMSTransporter implements SMSTransporterContract
{
    protected $serverURL;
    protected $serverMethod;
    protected $autoReplaceAnswer;
    protected $logger;

    /**
     * SMSTransporter constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        //Loading Configuration Data
        $this->serverURL = config('smstransporter.smsRequestURL');
        $this->serverMethod = config('smstransporter.smsRequestMethod');
        $this->autoReplaceAnswer = config('smstransporter.autoreplaceAnswer');
        $this->logger = new Logger('gateways/sms', 'SMS_TRANSPORT');
    }

    /**
     * @param $to
     * @param $text
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function send($to, $text, $gateway)
    {
        $uuid = (string) Uuid::uuid4();
        /*
        if (substr($to, 0, 3) != '992') {
            $gateway = 'external';
        }
        */
        $result = [$to, $text, 'sms_accept_result' => false, 'message_id' => 0, 'message_error' => ''];
        try {
            $client = new Client();
            $fullURL = sprintf('%s?n=%s&m=%s&g=%s', $this->serverURL, $to, $text, $gateway);
            //SEND REQUEST
            $res = $client->request($this->serverMethod, $fullURL);
            $resultStr = (string) $res->getBody();
            if ($res->getStatusCode() == 200 && strpos($resultStr, $this->autoReplaceAnswer) !== false) {
                $result['sms_accept_result'] = true;
                $result['message_id'] = str_replace($this->autoReplaceAnswer, '', $resultStr);
                $result['request_uuid'] = $uuid;
                $this->logger->info(sprintf('SMS_NOTIFICATION: SUCCESS - %s; to=%s; gateway=%s; response=%s', $uuid, $to, $gateway, $resultStr));
            } else {
                $result['request_uuid'] = $uuid;
                $this->logger->error(sprintf('SMS_NOTIFICATION: ERROR - %s; to=%s; gateway=%s; response=%s; http_status_code=%s', $uuid, $to, $gateway, $resultStr, $res->getStatusCode()));
            }
        } catch (\Exception $e) {
            $result['error_message'] = $e->getMessage();
            $result['request_uuid'] = $uuid;
            $this->logger->error(sprintf('SMS_NOTIFICATION: ERROR - %s; to=%s; gateway=%s; response=%s; trace=%s;', $uuid, $to, $gateway, $e->getMessage(), $e->getTraceAsString()));
        } catch (\Throwable $e) {
            $result['error_message'] = $e->getMessage();
            $result['request_uuid'] = $uuid;
            $this->logger->error(sprintf('SMS_NOTIFICATION: FATAL_ERROR - %s; to=%s; gateway=%s; response=%s; trace=%s;', $uuid, $gateway, $to, $e->getMessage(), $e->getTraceAsString()));
        }
        return $result;
    }

    /**
     * @param $message_id
     * @return array
     * @throws \Exception
     */
    public function check($message_id)
    {
        return ['message_id' => $message_id, 'succes_result' => true, 'request_uuid' => 'SMSRequest_' . (string) Uuid::uuid4()];
    }
}
