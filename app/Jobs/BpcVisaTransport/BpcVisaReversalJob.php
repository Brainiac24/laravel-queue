<?php

namespace App\Jobs\BpcVisaTransport;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Common\Gateway\BpcVisa;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Common\Gateway\BpcVisa\BpcVisaStatus;
use App\Services\Common\Helpers\TransactionStatusMaps;
use App\Jobs\BpcVisaTransport\BpcVisaReversalCallbackJob;
use App\Services\Common\Gateway\BpcVisa\BpcVisaTransport;
use App\Services\Common\Gateway\BpcVisa\BpcVisaCallbackResponse;

class BpcVisaReversalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 60;
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
        $this->logger = new Logger('gateways/bpc_visa', 'BPC_VISA_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
//            'ext_id' => 'required|numeric',
            'account' => 'required|digits_between:16,20',
            'amount' => 'required|numeric',
            'currency' => 'required|numeric',
            'processing_code' => 'required|string|min:1|max:6',
            'authorization_id_response' => 'required|string|max:11',
            'rrn' => 'required|string|max:12',
            'system_trace_audit_number' => 'required|digits_between:1,10',
            'local_transaction_date' => 'required|string',

        ];
    }

    public function handle()
    {
        $uuid = null;
        $transportService = new BpcVisaTransport();
        try {
            //$uuid = Uuid::uuid4();

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE BPC_VISA REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $this->res_data = $transportService->Reversal(
                $this->data['account'],
                $this->data['amount'],
                $this->data['currency'],
                $this->data['processing_code'],
                $this->data['local_transaction_date'],
                $this->data['rrn'],
                $this->data['authorization_id_response'],
                $this->data['system_trace_audit_number']
           );
           
           $this->LogRaw($transportService);

            if (is_object($this->res_data) && isset($this->res_data->responseCode) && $this->res_data->responseCode == BpcVisaStatus::OK) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE BPC_VISA RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->responseCode;
                $dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->transactionDate;
                $dataCallback->status_id = TransactionStatusV2::CANCELED;
                $dataCallback->status_detail_id = TransactionStatusMaps::$bpcVisa[$this->res_data->responseCode] ?? TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaReversalCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('WRONG - QUEUE BPC_VISA RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = false;
                $dataCallback->status_id = TransactionStatusV2::CANCEL_UNKNOWN;
                $dataCallback->status_detail_id = TransactionStatusMaps::$bpcVisa[$this->res_data->responseCode] ?? TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaReversalCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            }

        } catch (\Throwable $th) {
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            $dataCallback = new BpcVisaCallbackResponse();
            $dataCallback->session_id = $this->session_id;
            $dataCallback->status = false;
            $dataCallback->status_id = TransactionStatusV2::CANCEL_UNKNOWN;
            $dataCallback->status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaReversalCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            
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

        $this->logger->info('RAW - QUEUE BPC_VISA REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

    }
}
