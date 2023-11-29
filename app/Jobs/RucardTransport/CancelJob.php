<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\RucardTransport\CancelCallbackJob;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\CancelRequest;
use App\Services\Common\Gateway\Rucard\Rucard;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Common\Helpers\TransactionStatusMaps;
use App\Services\Common\Helpers\TransactionStatusV2;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class CancelJob implements ShouldQueue
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
            'from.amount' => 'required|numeric',
            'from.currency' => 'required|numeric',
        ];
    }

    public function handle(Rucard $transport)
    {
        $channel = RequestType::PAY_FROM_CARD;

        if (isset($this->data['PARENT'])) {
            if ($this->data['PARENT']=='FILL') {
                $channel = RequestType::FILL_CARD;
            }elseif ($this->data['PARENT']=='CARD_2_CARD') {
                $channel = RequestType::CARD_2_CARD;
            }
        }

        $data = new CancelRequest(
            $this->data['stan'],
            Carbon::createFromFormat('ymdHis', $this->data['datetime']),
            $this->data['from']['account'],
            $this->data['from']['amount'],
            $this->data['from']['currency'],
            $channel
        );

        $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
        //$uuid = Uuid::uuid4();

        $this->options = $data->getAllParamsToArray();
        $resultCancel = '';
        try {

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE RUCARD REQUEST --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);

            $this->res_data = $transport->send($data, $this->session_id, $this->data['stan']);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            
           
            $arrCancel = Helper::convertXmlToArray($this->res_data);
            $aswCancel = $arrCancel['ASW'];

            if (
                $aswCancel['ERRC'] == RucardStatus::OK ||
                $aswCancel['ERRC'] == RucardStatus::ERROR_TRANSACTION_ORIG_NOT_FOUND2 ||
                $aswCancel['ERRC'] == RucardStatus::TRANSACTION_ALREADY_CANCELED
            ) {

                if (isset($this->data['PARENT']) ) {
                    if ($this->data['PARENT'] == 'FILL' || $this->data['PARENT'] == 'CARD_2_CARD') {
                        $status_id = TransactionStatusV2::PAY_REJECTED;
                    }elseif ($this->data['PARENT'] == 'BLOCK') {
                        $status_id = TransactionStatusV2::BLOCK_REJECTED;
                    }
                } else {
                    $status_id = TransactionStatusV2::CANCELED;
                }

                $dataCancel = RucardHelper::data(
                    $this->data['session_id'],
                    true,
                    $status_id,
                    TransactionStatusMaps::$rucard[$aswCancel['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );

                CancelCallbackJob::dispatch($dataCancel)->onQueue(QueueEnum::PROCESSING);

            } elseif ($aswCancel['ERRC'] == RucardStatus::ERROR_EMITENT_UNAVAILABLE) {
                
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
                
                $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);
            } else {

                if (isset($this->data['PARENT'])) {
                    if ($this->data['PARENT'] == 'FILL' || $this->data['PARENT'] == 'CARD_2_CARD') {
                        $status_id = TransactionStatusV2::PAY_UNKNOWN;
                    }elseif ($this->data['PARENT'] == 'BLOCK') {
                        $status_id = TransactionStatusV2::BLOCK_UNKNOWN;
                    }
                    
                } else {
                    $status_id = TransactionStatusV2::CANCEL_UNKNOWN;
                }
                
                $dataUnknown = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    $status_id,
                    TransactionStatusMaps::$rucard[$aswCancel['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );
                CancelCallbackJob::dispatch($dataUnknown)->onQueue(QueueEnum::PROCESSING);

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
            
            $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
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
            
            $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
