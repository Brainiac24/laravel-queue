<?php

namespace App\Jobs\AbsTransport\Accounts;

use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Jobs\AbsTransport\Accounts\AccountToAccountSyncCallbackJob;
use App\Jobs\AbsTransport\Accounts\AccountToAccountSyncCallbackV2Job;
use App\Jobs\CallbackJob;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\Accounts\Documents\DocumentEntity;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Common\Helpers\TransactionSyncStatus;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class AccountToAccountSyncV2Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 222;
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
        $this->logger = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'user_id' => 'numeric|nullable',
            'transaction_id' => 'required|alpha_dash',
            'acc_number' => 'numeric|nullable',
            'acc_code' => 'required|string',
            'pan' => 'numeric|nullable',
            'doc_id' => 'numeric|nullable',
            'doc_num' => 'required|numeric',
            'doc_datetime' => 'required|date_format:"Y-m-d"',
            'type' => 'string|nullable',
            'curr_code' => 'required|numeric',
            'curr_rate' => 'required|numeric',
            'amount' => 'required|numeric',
            'cont_amount' => 'required|numeric',
            'cont_acc' => 'numeric|nullable',
            'cont_acc_code' => 'required|string',
            'cont_pan' => 'numeric|nullable',
            'cont_user_id' => 'numeric|nullable',
            'cont_name' => 'string|nullable',
            'cont_curr_code' => 'numeric|nullable',
            'cont_inn' => 'numeric|nullable',
            'cont_bank_bic' => 'numeric|nullable',
            'cont_bank_corr_acc' => 'numeric|nullable',
            'cont_bank_name' => 'string|nullable',
            'cont_bank_id' => 'numeric|nullable',
            'purpose' => 'required|string',
            'delimiter_purpose' => 'string|nullable',
            'status' => 'numeric|nullable',
            'operation_type' => 'required|string',
            'commission_amount' => 'numeric|nullable',
            'commission_acc_code' => 'string|nullable',
            'commission_doc_num' => 'string|nullable',
        ];
    }

    public function handle()
    {
        $uuid = null;
        try {
            //$uuid = Uuid::uuid4();

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            //$this->logger->info('PARAMS - QUEUE BUS REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $transportService = new AbsTransportService(new AbsTransportEntity());

            $operation_type = DocumentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_V2;
            if ($this->data['operation_type']=="EXCHANGE") {
                $operation_type = DocumentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_V2;
            }
/*
            if (
                ($this->data['commission_amount']??null) != null && 
                ($this->data['commission_amount']??null) != null && 
                ($this->data['commission_amount']??null) != null
                ) 
            {
                $operation_type = DocumentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_V2;
            }
            */

            $this->res_data = $transportService->getAccountService()->getDocumentServiceV2()->createRequest(
                $this->data['session_id'],
                $this->data['user_id']??'0',
                $this->data['acc_number']??'',
                $this->data['acc_code'],
                $this->data['pan'] ?? '',
                $this->data['doc_id']??'',
                $this->data['doc_num'],
                $this->data['doc_datetime'],
                $this->data['type']??'D',
                $this->data['curr_code'],
                $this->data['curr_rate'],
                $this->data['amount'],
                $this->data['cont_amount'],
                $this->data['cont_acc']??'',
                $this->data['cont_acc_code'],
                $this->data['cont_pan'] ?? '',
                $this->data['cont_user_id'] ?? '0',
                $this->data['cont_name']??'',
                $this->data['cont_curr_code']??'',
                $this->data['cont_inn']??'',
                $this->data['cont_bank_bic']??'',
                $this->data['cont_bank_corr_acc']??'',
                $this->data['cont_bank_name']??'',
                $this->data['cont_bank_id']??'',
                $this->data['purpose'],
                $this->data['delimiter_purpose']??'',
                $this->data['status']??'',
                $operation_type,
                $this->data['commission_amount']??null,
                $this->data['commission_acc_code']??null,
                $this->data['commission_doc_num']??null
            );

            //$arr = Helper::convertXmlToArray($this->res_data);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('SUCCESS - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            //if ($arr['root']['response']['state'] ?? '0' == '1' || $arr['root']['response']['state'] ?? '0' == '-2') {
                
                $dataCallback = AbsHelper::data(
                    $this->data['session_id'],
                    true,
                    null,
                    null,
                    base64_encode($this->res_data),
                    null,
                    $this->data['transaction_id'],
                    true
                );
                                
                AccountToAccountSyncCallbackV2Job::dispatch($dataCallback)->onQueue(QueueEnum::DEFAULT);
        
            /*} else {
                $this->logger->error('Request '.$this->log_name.' BUS_RESPONSE_ERROR EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE attempts - '.$this->attempts().' - uuid ' . (string)$uuid . ' --- data: ' . json_encode($this->data). '--- response: '. addslashes($result) . '--- response_base64: '. base64_encode($result)) ;
                $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);
            }*/

        } catch (ConnectException $conEx) {
           
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
           
            /* $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );*/
            //CallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
            $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
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
            
            /*$dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );*/
            //CallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
            $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
