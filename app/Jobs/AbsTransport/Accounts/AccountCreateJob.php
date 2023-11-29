<?php

namespace App\Jobs\AbsTransport\Accounts;

use Ramsey\Uuid\Uuid;
use App\Jobs\CallbackJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Common\Helpers\Helper;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Jobs\AbsTransport\Accounts\DepositListCallbackJob;
use App\Jobs\AbsTransport\Accounts\AccountCreateCallbackJob;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;

class AccountCreateJob implements ShouldQueue
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
        $this->logger = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'client_abs_id' => 'required|numeric',
            'kind' => 'required|numeric',
            'create_user' => 'required|numeric',
            'fintool' => 'required|numeric',
        ];
    }

    public function handle()
    {
        $uuid = null;
        $result = '';
        try {
            //$uuid = Uuid::uuid4();
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE BUS REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            
            $transportService = new AbsTransportService(new AbsTransportEntity());

            $this->res_data = $transportService->getAccountService()->CreateAccount(
                $this->data['session_id'],
                $this->data['client_abs_id'],
                $this->data['kind'],
                $this->data['create_user'],
                $this->data['fintool']
            );

            $arr = Helper::convertXmlToArray($this->res_data);

            if ($arr['root']['response']['state'] ?? '0' == '1') {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('SUCCESS - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback = AbsHelper::data(
                    $this->data['session_id'],
                    true,
                    null,
                    null,
                    base64_encode($this->res_data),
                    null,
                    null,
                    true
                );

                AccountCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
                    
                /*$dataCallback = AbsHelper::data(
                    $this->data['session_id'],
                    false,
                    null,
                    null,
                    addslashes($result), 
                    null,
                    true
                );
                DepositListCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);*/

                throw new \Exception("BUS_RESPONSE_STATE_IS_NOT_SUCCESS EO_R_DEPOSITS_LIST");
            }

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
            
            $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );
            AccountCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            throw $conEx;
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

            $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );
            AccountCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            throw $th;
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
