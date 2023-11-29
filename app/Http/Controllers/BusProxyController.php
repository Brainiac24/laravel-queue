<?php

namespace App\Http\Controllers;

use App\Jobs\BusProxyProcessingCallbackJob;
use App\Jobs\BusProxyRequestCallbackJob;
use App\Services\Common\Helpers\Array2XML;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\HandlerEnum;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusProxyController extends Controller
{
    protected $logger;
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function Callback(Request $req)
    {
        $this->log_name = get_class($this);
        $this->logger = new Logger('gateways/callback_bus', 'CALLBACK_TRANSPORT');

        $resp = (string) $req->getContent();

        $log_params['Class'] = $this->log_name;
        $log_params['ResponseData'] = $resp;

        $this->logger->info('REDIRECT RAWDATA - CALLBACK FROM BUS - QUEUE' , $log_params);


        $toArr = new Array2XML();
        $res = $toArr::XML_TO_ARR($resp);

        $res_data = ($res['request'] ?? $res['response']);

        $this->session_id = $res['head']['session_id'];

        $status = (($res_data['state'] ?? 0) == 1 ? true : false);

        if (($res_data['request-type'] == 'EO_R_DEPOSITS_LIST' || $res_data['request-type']== 'EO_R_CREDITS_LIST') && ($res_data['state'] ?? 0) == -1) {
            $status = true;
        }

        $dataCallback = Helper::data(
            $res['head']['session_id'],
            $status,
            \base64_encode((string) $req->getContent())
        );

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['ResponseData'] = $resp;

        $this->logger->info('REDIRECT PARAMS - REQUEST CALLBACK FROM BUS - QUEUE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

        $requestType = $res_data['request-type'];
        $dataCallback += ['LOG_NAME' => 'CALLBACK FROM BUS ' . $requestType];

        $queueEnum = QueueEnum::REQUEST;

        switch ($requestType) {
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_V2':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE_V2':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            case 'R_PAY_TRANSFER':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                //Подтверждение карда намешад автоматический, так как отсутствует параметр date_doc
                /*$data['session_id'] = $res_data['session_id'];
                $data['id_transfer'] = $res_data['id_transaction'];
                $data['code_transfer'] = $res_data['code_transfer'];
                ConfirmTransfersSoniyaJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);*/
                break;
            case 'R_CONFIRM_SEND':
                $queueEnum = QueueEnum::PROCESSING;
                BusProxyProcessingCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
                break;
            default:
                $queueEnum = QueueEnum::REQUEST;
                BusProxyRequestCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);
        }

        //BusProxyCallbackJob::dispatch($dataCallback)->onQueue($queueEnum);

        $res = response()->xml([
            'head' => [
                'session_id' => $res['head']['session_id'],
            ],
            'response' => [
                'protocol-version' => $res_data['protocol-version'],
                'request-type' => $requestType,
                'state' => 1,
                'state_msg' => 'OK',
            ],
        ], 200, [], 'root');

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['ResponseData'] = json_encode($res, JSON_UNESCAPED_UNICODE);

        $this->logger->info('REDIRECT RESPONSE - REQUEST CALLBACK FROM BUS - QUEUE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

        return $res;
    }
}
