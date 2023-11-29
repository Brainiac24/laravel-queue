<?php

namespace App\Jobs\BpcVisaTransport;

use App\Jobs\BpcVisaTransport\BpcVisaGetCardDataCallbackJob;
use App\Services\Common\Gateway\BpcVisa\BpcVisaCallbackResponse;
use App\Services\Common\Gateway\BpcVisa\BpcVisaTransport;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BpcVisaGetCardDataJob implements ShouldQueue
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
            'account' => 'required|digits_between:16,20',
            'exp' => 'nullable|date_format:Ym',
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

            $this->res_data = $transportService->GetCardData(
                $this->data['account'],
                $this->data['exp']
            );

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
            $dataCallback->balance = ((int) $this->res_data->cardData->accounts->accountData->balance) / 100;
            
            if ($this->res_data->cardData->accounts->accountData->balance < 0) {
                $dataCallback->balance = 0;
            }
            
            $dataCallback->card_status = $this->res_data->cardData->hotCardStatus;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaGetCardDataCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

             /*else {

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
        $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

        BpcVisaGetCardDataCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
        }*/

        } catch (ConnectException $conEx) {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $dataCallback = new BpcVisaCallbackResponse();
            $dataCallback->session_id = $this->session_id;
            $dataCallback->status = false;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaGetCardDataCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);

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

            $this->errors = 'FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $dataCallback = new BpcVisaCallbackResponse();
            $dataCallback->session_id = $this->session_id;
            $dataCallback->status = false;
            $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

            BpcVisaGetCardDataCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function failed(\Exception $exception): void
    {

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['ResponseData'] = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);
        $log_params['ErrorMessage'] = $exception->getMessage();
        $log_params['ErrorTraceData'] = $exception->getTraceAsString();
        $log_params['ErrorDataRaw'] = json_encode($exception, JSON_UNESCAPED_UNICODE);

        $this->errors = 'FAILED JOB ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
        $this->logger->error('FAILED JOB ERROR - QUEUE BPC_VISA RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

        $dataCallback = new BpcVisaCallbackResponse();
        $dataCallback->session_id = $this->session_id;
        $dataCallback->status = false;
        $dataCallback->response = json_encode($this->res_data, JSON_UNESCAPED_UNICODE);

        BpcVisaGetCardDataCallbackJob::dispatch($dataCallback->getData())->onQueue(QueueEnum::PROCESSING);
    }
}
