<?php

namespace App\Jobs\AbsTransport\Accounts;

use Carbon\Carbon;
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
use App\Jobs\AbsTransport\Accounts\DepositCreateCallbackJob;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;

class DepositCreateJob implements ShouldQueue
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
            'user_create_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'payer_id' => 'nullable|numeric',
            'date_begin' => 'required|date_format:"Y-m-d"',
            'period' => 'nullable|numeric',
            'time_interval' => 'nullable|numeric',
            'vid_dog' => 'required|numeric',
            'summa_dog' => 'required|numeric',
            'fintool' => 'required|numeric',
            'acc_return' => 'nullable|numeric',
            'acc_enrol_prc' => 'nullable|numeric',
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

            $open_account = 1;

            if (isset($this->data['acc_enrol_prc'])){
                $open_account = !empty($this->data['acc_enrol_prc']) ? 0 : 1;
            }

            $this->res_data = $transportService->getAccountService()->CreateDeposit(
                $this->data['session_id'],
                $this->data['user_create_id'],
                $this->data['client_id'],
                $this->data['payer_id'],
                Carbon::parse($this->data['date_begin'])->format('Y.m.d'),
                $this->data['period']??'0',
                $this->data['time_interval']??'',
                $this->data['vid_dog'],
                $this->data['summa_dog'],
                $this->data['fintool'],
                $this->data['acc_return'],
                $this->data['acc_enrol_prc'],
                0, //Периодичность начисления процентов. Логика 0/1
                $open_account // Открыть счет для зачисления процентов. Логика 0/1
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

                DepositCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);

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
            DepositCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
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
            DepositCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            throw $th;
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
