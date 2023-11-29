<?php

namespace App\Jobs\BpcMtmTransport;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Services\Common\Gateway\BpcMtm\BpcMtmStatus;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Common\Helpers\TransactionStatusMaps;
use App\Services\Common\Gateway\BpcMtm\BpcMtmTransport;
use App\Jobs\BpcMtmTransport\BpcMtmLockUnlockCardCallbackJob;
use App\Services\Common\Gateway\BpcMtm\BpcMtmCallbackResponse;

class BpcMtmLockUnlockCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 90;
    private $intervalNextTryAt = 5;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id']??null;
        $this->logger = new Logger('gateways/bpc_mtm', 'BPC_MTM_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'ext_id' => 'required|numeric',
            'account' => 'required|digits_between:16,20',
            'card_status' => 'required|digits_between:0,1',
        ];
    }

    public function handle()
    {
        $uuid = null;
        $transportService = new BpcMtmTransport();
        try {
            //$uuid = Uuid::uuid4();

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE MTM REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            if ($this->data['card_status']==0){
                $this->res_data = $transportService->LockCard(
                    $this->data['ext_id'],
                    $this->data['account'],
                    //Temporary blocked by client 20
                    20
                );
            }else{
                $this->res_data = $transportService->UnlockCard(
                    $this->data['ext_id'],
                    $this->data['account']
                );
            }
            
            $this->LogRaw($transportService);

            if (is_object($this->res_data) && isset($this->res_data->responseCode) && $this->res_data->responseCode == BpcMtmStatus::OK) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE MTM RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->status = true;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->card_status = $this->res_data->responseCode;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmLockUnlockCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE MTM RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmLockUnlockCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            }

        } catch (\Throwable $th) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE MTM RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE MTM RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            $dataCallback = new BpcMtmCallbackResponse();
            $dataCallback->status = false;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcMtmLockUnlockCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            
            $this->LogRaw($transportService);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function LogRaw($transportService) {

        $req=null;
        $res=null;
        if (is_object($transportService->apigate)){
            $req = $transportService->apigate->__getLastRequest();
        }else{
            $req=json_encode($transportService->apigate,JSON_UNESCAPED_UNICODE);
        }
        $pattern = '/(<SOAP-ENV:Header>)(.+)(<\/SOAP-ENV:Header>)/i';
        $req = preg_replace($pattern,"__HEADER__",$req);
        if (is_object($transportService->apigate)){
            $res = $transportService->apigate->__getLastResponse();
        }else{
            $res=json_encode($transportService->apigate, JSON_UNESCAPED_UNICODE);
        }

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = $req;
        $log_params['ResponseData'] = $res;

        $this->logger->info('RAW - QUEUE MTM REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

    }
}
