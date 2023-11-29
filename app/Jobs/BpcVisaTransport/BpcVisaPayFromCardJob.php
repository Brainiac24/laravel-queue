<?php

namespace App\Jobs\BpcVisaTransport;

use App\Jobs\BpcVisaTransport\BpcVisaPayFromCardCallbackJob;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Common\Gateway\BpcVisa\BpcVisaCallbackResponse;
use App\Services\Common\Gateway\BpcVisa\BpcVisaStatus;
use App\Services\Common\Gateway\BpcVisa\BpcVisaTransport;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Common\Helpers\TransactionStatusMaps;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BpcVisaPayFromCardJob implements ShouldQueue
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
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/bpc_visa', 'BPC_VISA_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
//            'ext_id' => 'required|numeric',
            'from.account' => 'required|digits_between:16,20',
            'from.amount' => 'required|numeric',
            'from.currency' => 'required|numeric',
            'from.exp' => 'nullable|date_format:Ym',
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

            $this->logger->info('PARAMS - QUEUE BPC_VISA REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);


            $this->res_data = $transportService->PayFromCard(
                $this->data['from']['account'],
                $this->data['from']['amount'],
                $this->data['from']['currency'],
                $this->data['from']['exp']
            );
            
            $this->LogRaw($transportService);

            if (is_object($this->res_data) && isset($this->res_data->responseCode) && $this->res_data->responseCode == BpcVisaStatus::OK) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE BPC_VISA RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->responseCode;
                $dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;
                $dataCallback->status_id = TransactionStatusV2::BLOCKED;
                $dataCallback->status_detail_id = TransactionStatusMaps::$bpcVisa[$this->res_data->responseCode] ?? TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('WRONG - QUEUE BPC_VISA RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = false;
                $dataCallback->status_id = TransactionStatusV2::BLOCK_UNKNOWN;
                $dataCallback->status_detail_id = TransactionStatusMaps::$bpcVisa[$this->res_data->responseCode] ?? TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            }

        } catch (\SoapFault $sf) {

            try {
                
                $this->LogRaw($transportService);

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($sf, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SOAP_FAULT - QUEUE BPC_VISA RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                if (!isset($sf->detail)) {
                    $this->ThrowHandler($sf);
                    return;
                }

                $responseCode = "-1";
                if (isset($sf->detail->svfeProcessingFault)) {
                    $responseCode = $sf->detail->svfeProcessingFault->responseCode ?? "-1";
                }

                if (
                    $responseCode == BpcVisaStatus::CANNOT_PROCESS_AMOUNT ||
                    $responseCode == BpcVisaStatus::INSUFFICIENT_FUNDS_RETRY ||
                    $responseCode == BpcVisaStatus::BAD_CARD ||
                    $responseCode == BpcVisaStatus::DO_NOT_HONOR_TRANSACTION
                ) {
                    $log_params['Class'] = $this->log_name;
                    $log_params['SessionId'] = $this->session_id;
                    $log_params['Tries'] = $this->tries;
                    $log_params['Attempts'] = $this->attempts();
                    $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                    $log_params['ResponseData'] = json_encode($sf, JSON_UNESCAPED_UNICODE);

                    $this->logger->info('REJECTED - QUEUE BPC_VISA RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                    $dataCallback = new BpcVisaCallbackResponse();
                    $dataCallback->session_id = $this->session_id;
                    $dataCallback->status = false;
                    $dataCallback->status_id = TransactionStatusV2::BLOCK_REJECTED;
                    $dataCallback->status_detail_id = TransactionStatusMaps::$bpcVisa[$responseCode] ?? TransactionStatusDetail::ERROR_UNKNOWN;
                    $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
                    $dataCallback->parent_response = json_encode($sf, JSON_UNESCAPED_UNICODE);

                    BpcVisaPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                } else {
                    $this->ThrowHandler($sf);
                }

            } catch (\Throwable $th) {
                $this->ThrowHandler($th);
            }

        } catch (\Throwable $th) {
            $this->ThrowHandler($th);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function ThrowHandler($th)
    {
        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
        $log_params['ErrorMessage'] = $th->getMessage();
        $log_params['ErrorTraceData'] = $th->getTraceAsString();

        $this->errors = 'FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
        $this->logger->error('FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

        $dataCallback = new BpcVisaCallbackResponse();
        $dataCallback->session_id = $this->session_id;
        $dataCallback->status = false;
        $dataCallback->status_id = TransactionStatusV2::BLOCK_UNKNOWN;
        $dataCallback->status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;
        $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

        BpcVisaPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
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
