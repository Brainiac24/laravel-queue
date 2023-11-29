<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\Processing\TransactionStatusDetail;
use App\Jobs\RucardTransport\ConfirmCallbackJob;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\ConfirmRequest;
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

class ConfirmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 20;
    public $timeout = 60;
    protected $intervalNextTryAt = 5;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
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
            if ($this->data['PARENT'] == 'FILL') {
                $channel = RequestType::FILL_CARD;
            } elseif ($this->data['PARENT'] == 'CARD_2_CARD') {
                $channel = RequestType::CARD_2_CARD;
            }
        }

        $data = new ConfirmRequest(
            $this->data['stan'],
            Carbon::createFromFormat('ymdHis', $this->data['datetime']),
            $channel,
            $this->data['from']['account'],
            $this->data['from']['amount'],
            $this->data['from']['currency']
        );

        //$uuid = Uuid::uuid4();

        $this->options = $data->getAllParamsToArray();

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

        $this->logger->info('PARAMS - QUEUE RUCARD REQUEST --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

        $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);

        try {

            $this->res_data = $transport->send($data, $this->session_id, $this->data['stan']);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

            $arrConfirm = Helper::convertXmlToArray($this->res_data);
            $aswConfirm = $arrConfirm['ASW'];

            if ($aswConfirm['ERRC'] == RucardStatus::OK) {
                if (isset($this->data['PARENT']) && ($this->data['PARENT'] == 'FILL' || $this->data['PARENT'] == 'CARD_2_CARD')) {
                    $status_id = TransactionStatusV2::PAY_COMPLETED;
                } else {
                    $status_id = TransactionStatusV2::CONFIRMED;
                }

                $dataConfirm = RucardHelper::data(
                    $this->data['session_id'],
                    true,
                    $status_id,
                    TransactionStatusMaps::$rucard[$aswConfirm['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );

                ConfirmCallbackJob::dispatch($dataConfirm)->onQueue(QueueEnum::PROCESSING);
            } elseif ($aswConfirm['ERRC'] == RucardStatus::ERROR_EMITENT_UNAVAILABLE) {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE WRONG --- stan: '. $this->data['stan'] .' --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $delay = RucardHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);

            } else {
                $dataUnknown = [];
                if (isset($this->data['PARENT']) && ($this->data['PARENT'] == 'FILL' || $this->data['PARENT'] == 'CARD_2_CARD')) {
                    $status_id = TransactionStatusV2::PAY_UNKNOWN;
                } else {
                    $status_id = TransactionStatusV2::CONFIRM_UNKNOWN;
                }

                $dataUnknown = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    $status_id,
                    TransactionStatusMaps::$rucard[$aswConfirm['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );

                //$this->logger->error('Request TEST uuid ' . (string)$uuid . ' --- data: ' . json_encode($dataUnknown));
                ConfirmCallbackJob::dispatch($dataUnknown)->onQueue(QueueEnum::PROCESSING);
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
