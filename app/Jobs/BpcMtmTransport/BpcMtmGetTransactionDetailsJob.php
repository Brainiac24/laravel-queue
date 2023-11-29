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
use App\Services\Common\Gateway\BpcMtm\BpcMtmCallbackResponse;
use App\Jobs\BpcMtmTransport\BpcMtmGetTransactionDetailsCallbackJob;

class BpcMtmGetTransactionDetailsJob implements ShouldQueue
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
            'utrnno' => 'required|numeric|digits_between:1,12',
            'reversal' => 'required|boolean',
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

            $this->logger->info('PARAMS - QUEUE BPC REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $this->res_data = $transportService->GetTransactionDetails(
                $this->data['utrnno'],
                $this->data['reversal']
           );

            if (is_object($this->res_data) && isset($this->res_data->responseCode) && $this->res_data->responseCode == BpcMtmStatus::OK) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE BUS RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcMtmCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->response_code = $this->res_data->responseCode;
                $dataCallback->processing_code = $this->res_data->processingCode;
                $dataCallback->system_trace_audit_number = $this->res_data->systemTraceAuditNumber;
                $dataCallback->local_transaction_date = $this->res_data->localTransactionDate;
                $dataCallback->rrn = $this->res_data->rrn;
                $dataCallback->authorization_id_response = $this->res_data->authorizationIdResponse;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionDetailsCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE BUS RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcMtmCallbackResponse();
                $dataCallback->status = false;
                $dataCallback->session_id = $this->session_id;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcMtmGetTransactionDetailsCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
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

            $this->errors = 'FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            $dataCallback = new BpcMtmCallbackResponse();
            $dataCallback->status = false;
            $dataCallback->session_id = $this->session_id;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcMtmGetTransactionDetailsCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
