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
use App\Services\Common\Gateway\BpcVisa\BpcVisaTransport;
use App\Jobs\BpcVisaTransport\BpcVisaGetCardBalanceCallbackJob;
use App\Services\Common\Gateway\BpcVisa\BpcVisaCallbackResponse;

class BpcVisaGetCardBalanceJob implements ShouldQueue
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
            'exp' => 'nullable|date_format:ym',
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

            $this->logger->info('PARAMS - QUEUE BPC REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);


            $this->res_data = $transportService->GetCardBalance(
                $this->data['account']
           );
            if (is_object($this->res_data) && isset($this->res_data->balance) && $this->res_data->balance != '-1') {
                

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('SUCCESS - QUEUE BUS RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();

                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = true;
                $dataCallback->balance = (double)$this->res_data->balance/100;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaGetCardBalanceCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                $this->logger->info('WRONG - QUEUE BUS RESPONSE BUS --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = new BpcVisaCallbackResponse();
                $dataCallback->session_id = $this->session_id;
                $dataCallback->status = false;
                $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

                BpcVisaGetCardBalanceCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
            }

        } catch (ConnectException $conEx) {
           
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

            $dataCallback = new BpcVisaCallbackResponse();
            $dataCallback->session_id = $this->session_id;
            $dataCallback->status = false;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaGetCardBalanceCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
           
            //$delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            //$this->release($delay);
        } catch (\Throwable $th) {
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            $dataCallback = new BpcVisaCallbackResponse();
            $dataCallback->session_id = $this->session_id;
            $dataCallback->status = false;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaGetCardBalanceCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
