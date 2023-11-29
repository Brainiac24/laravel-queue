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
use App\Services\Common\Gateway\BpcMtm\BpcMtmHelper;
use App\Services\Common\Gateway\BpcMtm\BpcMtmStatus;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Common\Helpers\TransactionStatusMaps;
use App\Jobs\BpcMtmTransport\BpcMtmFillCardCallbackJob;
use App\Services\Common\Gateway\BpcMtm\BpcMtmTransport;
use App\Jobs\BpcMtmTransport\BpcMtmCard2CardCallbackJob;
use App\Jobs\BpcMtmTransport\BpcMtmPayFromCardCallbackJob;
use App\Services\Common\Gateway\BpcMtm\BpcMtmCallbackResponse;
use App\Jobs\BpcMtmTransport\BpcMtmGetTransactionStatusCallbackJob;

class BpcMtmGetTransactionStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 5;
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
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/bpc_mtm', 'BPC_MTM_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'ext_id' => 'required|numeric',
            'reversal' => 'nullabe|boolean',
            'parent' => 'nullable|string',
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

            $this->logger->info('PARAMS - QUEUE MTM REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $this->res_data = $transportService->GetTransactionStatus(
                $this->data['ext_id'],
                $this->data['reversal'] ?? 0
            );

            if (is_object($this->res_data) && isset($this->res_data->transactionResponseCode) && $this->res_data->transactionResponseCode == BpcMtmStatus::TRANSACTION_SUCCESS_RESPONSE_CODE) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE MTM RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->SuccessCallback();

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE MTM RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->WrongCallback();

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

            $this->errors = 'FATAL ERROR - QUEUE MTM RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE MTM RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $this->ThrowableCallback();
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function SuccessCallback()
    {
        switch ($this->data['parent'] ?? "") {

            case BpcMtmHelper::BPC_MTM_CARD_2_CARD_JOB:

                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->responseCode;
                /*$dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;*/
                $dataCallback->status_id = TransactionStatusV2::PAY_COMPLETED;
                $dataCallback->status_detail_id = TransactionStatusDetail::OK;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
                $dataCallback->parent_response = $this->data['parent_response'];

                BpcMtmCard2CardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;

            case BpcMtmHelper::BPC_MTM_FILL_CARD_JOB:

                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->responseCode;
                /*$dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;*/
                $dataCallback->status_id = TransactionStatusV2::PAY_COMPLETED;
                $dataCallback->status_detail_id = TransactionStatusDetail::OK;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
                $dataCallback->parent_response = $this->data['parent_response'];

                BpcMtmFillCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

                break;
            case BpcMtmHelper::BPC_MTM_PAY_FROM_CARD_JOB:
                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                /*$dataCallback->response_code = $this->res_data->responseCode;
                $dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;*/
                $dataCallback->status_id = TransactionStatusV2::BLOCKED;
                $dataCallback->status_detail_id = TransactionStatusDetail::OK;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
                $dataCallback->parent_response = $this->data['parent_response'];

                BpcMtmPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            default:
                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->transactionResponseCode;
                /*$dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;*/
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionStatusCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
        }

    }

    public function WrongCallback()
    {
        switch ($this->data['parent'] ?? "") {
            case BpcMtmHelper::BPC_MTM_CARD_2_CARD_JOB:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = false;
                $dataCallback->status_id = TransactionStatusV2::PAY_REJECTED;
                $dataCallback->status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmCard2CardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
            case BpcMtmHelper::BPC_MTM_FILL_CARD_JOB:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status_id = TransactionStatusV2::PAY_REJECTED;
                $dataCallback->status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmFillCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
            case BpcMtmHelper::BPC_MTM_PAY_FROM_CARD_JOB:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = false;
                $dataCallback->status_id = TransactionStatusV2::BLOCK_REJECTED;
                $dataCallback->status_detail_id = TransactionStatusDetail::ERROR_UNKNOWN;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmPayFromCardCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            default:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->response_code = $this->res_data->transactionResponseCode;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionStatusCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
        }
    }

    public function ConnectExceptionCallback()
    {
        switch ($this->data['parent'] ?? "") {
            case BpcMtmHelper::BPC_MTM_CARD_2_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
                break;
            case BpcMtmHelper::BPC_MTM_FILL_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
                break;
            case BpcMtmHelper::BPC_MTM_PAY_FROM_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
            default:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionStatusCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
        }
    }

    public function ThrowableCallback()
    {
        switch ($this->data['parent'] ?? "") {
            case BpcMtmHelper::BPC_MTM_CARD_2_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
                break;
            case BpcMtmHelper::BPC_MTM_FILL_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
                break;
            case BpcMtmHelper::BPC_MTM_PAY_FROM_CARD_JOB:
                $this->release(BpcMtmHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt));
            default:
                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionStatusCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
                break;
        }
    }

}
