<?php
/**
 * Created by PhpStorm.
 * User: Farrukh Kosimov
 * Date: 05.07.2018
 * Time: 13:47
 */

namespace App\Services\Common\Gateway\AbsCftEskhata;


class AbsCftEskhataRate extends AbsCftEskhata implements AbsCftEskhataRateContract
{
    protected $absMethod;
    protected $sendMethod;
    protected $reciveMethod;
    public $log_name = 'ClassNotSet';

    public function __construct()
    {
        parent::__construct();
        $this->sendMethod = self::R_GET_RATE;
        $this->reciveMethod = self::R_GET_RATE;
        $this->log_name = get_class($this);
    }

    public function rGetRate($session_id, $date, $code_iso, $cur_iso, $type_rate)
    {
        $arguments = ['session_id' => (string)$session_id, 'date' => $date, 'code_iso' => $code_iso, 'cur_iso' => $cur_iso, 'type_rate' => $type_rate, 'protocol-version' => self::SERVER_PROTOCOL_VER, 'request-type' => (string)$this->sendMethod];
        $sendRequest = $this->sendRequest($arguments);
        if (isset($sendRequest['response']['state']) && $sendRequest['response']['state'] == 1) {
            $resultArray['session_id'] = $sendRequest['head']['session_id'];
            $resultArray['protocol-version'] = $sendRequest['response']['protocol-version'];
            $resultArray['request-type'] = $sendRequest['response']['request-type'];
            $resultArray['state'] = $sendRequest['response']['state'];
            $resultArray['message'] = $sendRequest['response']['state_msg'];
            $resultArray['request_uuid'] = $sendRequest['request_uuid'];
        } else {
            $resultArray['message'] = $sendRequest['message'];
            $resultArray['state'] = $sendRequest['state'];
            $resultArray['request_uuid'] = $sendRequest['request_uuid'];
        }
        return $resultArray;
    }

    public function aGetRate($session_id)
    {
        $resultArray = ['session_id' => $session_id, 'protocol-version' => '', 'request-type' => '', 'date' => '', 'code_iso' => '', 'cur_iso' => '', 'rate' => '', 'sale' => '', 'buy' => '', 'state' => false, 'message' => '',];
        $sendRequest = $this->checkResult($session_id);
        if (!isset($sendRequest['response']['state_msg'])) {
            if (isset($sendRequest['request']['state_msg'])) {
                $resultArray['message'] = $sendRequest['request']['state_msg'];
                $resultArray['session_id'] = $sendRequest['head']['session_id'];
                $resultArray['protocol-version'] = $sendRequest['request']['protocol-version'];
                $resultArray['request-type'] = $sendRequest['request']['request-type'];
                $resultArray['date'] = $sendRequest['request']['date'];
                $resultArray['code_iso'] = $sendRequest['request']['code_iso'];
                $resultArray['cur_iso'] = $sendRequest['request']['cur_iso'];
                $resultArray['rate'] = $sendRequest['request']['rate'];
                $resultArray['sale'] = $sendRequest['request']['sale'];
                $resultArray['buy'] = $sendRequest['request']['buy'];
                $resultArray['state'] = 1;
                $resultArray['request_uuid'] = $sendRequest['request_uuid'];
            } else {
                $resultArray['state'] = 0;
                $resultArray['message'] = 'NON "REQUEST" METHOD IN REQUEST';
                $resultArray['request_uuid'] = $sendRequest['request_uuid'];
            }
        } else {
            if ($sendRequest['response']['request-type'] == self::A_GET_ANSWER) {
                $resultArray['state'] = 0;
                $resultArray['message'] = $sendRequest['response']['state_msg'];
                $resultArray['request_uuid'] = $sendRequest['request_uuid'];
            } else {
                $resultArray['state'] = 0;
                $resultArray['message'] = 'WRONG ANSWER TYPE SYSTEM WAITS FOR:' . $this->reciveMethod . ' GETS:' . $sendRequest['response']['request-type'];
                $resultArray['request_uuid'] = $sendRequest['request_uuid'];
            }
        }
        return $resultArray;
    }
}
