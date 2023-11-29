<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\RucardTransport\HistoryCallbackJob;
use App\Jobs\CallbackJob;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\HistoryRequest;
use App\Services\Common\Gateway\Rucard\Rucard;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class HistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 60;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id']??null;
        $this->logger = new Logger('gateways/rucard', 'RUCARD_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'stan' => 'required|numeric',
            'datetime' => 'required|date_format:ymdHis',
            'from.account' => 'required|digits_between:16,20',
            'from.exp' => 'required|date_format:ym',
            'from.currency' => 'required|numeric',
            'from.cvv2' => 'numeric|nullable',
        ];
    }

    public function handle(Rucard $transport)
    {
        //$uuid = Uuid::uuid4();
        try {

            $data = new HistoryRequest(
                $this->data['from']['account'],
                $this->data['from']['exp'],
                $this->data['stan'],
                Carbon::createFromFormat('ymdHis', $this->data['datetime']),
                $this->data['from']['currency'],
                $this->data['from']['cvv2']??null
            );
            
            $this->options = $data->getAllParamsToArray();
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE RUCARD REQUEST --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            

            $this->res_data = $transport->send($data, $this->session_id, $this->data['stan']);
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);


            $arr = Helper::convertXmlToArray($this->res_data);
            $asw = $arr['ASW'];

            if ($asw['ERRC'] == RucardStatus::OK) {
                $dataResult = RucardHelper::data(
                    $this->data['session_id'],
                    true,
                    null,
                    null,
                    addslashes($this->res_data)
                );
                HistoryCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);
            } else {
                
                $dataResult = RucardHelper::data(
                    $this->data['session_id'],
                    true,
                    null,
                    null,
                    addslashes($this->res_data)
                );
                HistoryCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);
            }

        } catch (ConnectException $conEx) {
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            
            $dataResult = RucardHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($this->res_data)
            );
            HistoryCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);

        } catch (\Throwable $th) {
            
            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            
            $dataResult = RucardHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($this->res_data)
            );
            HistoryCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
