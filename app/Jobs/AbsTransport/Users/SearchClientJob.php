<?php

namespace App\Jobs\AbsTransport\Users;

use Ramsey\Uuid\Uuid;
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
use App\Jobs\AbsTransport\Cards\CardListCallbackJob;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Jobs\AbsTransport\TransfersSoniya\TransfersSoniyaCallbackJob;

class SearchClientJob implements ShouldQueue
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
            'family_cl' => 'required|string', 
            'name_cl' => 'required|string', 
            'sname_cl' => 'string|nullable', 
            'inn' => 'nullable|numeric', 
            'num' => 'nullable|string', 
            'ser' => 'nullable|string', 
            
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

            $this->res_data = $transportService->getUserService()->searchClient(
                 $this->data['session_id'],
                 $this->data['family_cl'],
                 $this->data['name_cl'],
                 $this->data['sname_cl'],
                 $this->data['inn']??"",
                 $this->data['num']??"",
                 $this->data['ser']??""
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

                /*$dataCallback = AbsHelper::data(
                    $this->data['session_id'],
                    true,
                    null,
                    null,
                    base64_encode($this->res_data), 
                    null,
                    null,
                    true
                );

                SearchClientCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);*/

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
                    addslashes($this->res_data), 
                    null,
                    true
                );
                CardListCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);*/

                throw new \Exception("BUS_RESPONSE_STATE_IS_NOT_SUCCESS R_FN_CL_PRIV");
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
                addslashes($this->res_data)
            );
            //TransfersSoniyaCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
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

            $this->errors = 'FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            
            $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($this->res_data)
            );
            //TransfersSoniyaCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
            $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
