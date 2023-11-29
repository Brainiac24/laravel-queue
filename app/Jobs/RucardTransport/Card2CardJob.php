<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\Processing\TransactionStatusDetail;
use App\Jobs\RucardTransport\CancelJob;
use App\Jobs\RucardTransport\Card2CardCallbackJob;
use App\Jobs\RucardTransport\CheckBalanceJob;
use App\Jobs\RucardTransport\ConfirmJob;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\Card2CardRequest;
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

class Card2CardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
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
            'commission' => 'numeric|nullable',
            'from.account' => 'required|digits_between:16,20',
            'from.exp' => 'required|date_format:ym',
            'from.amount' => 'required|numeric',
            'from.currency' => 'required|numeric',
            'from.comment' => 'string|nullable',
            'to.account' => 'required|digits_between:16,20',
            'to.comment' => 'string|nullable',
            'check' => 'numeric|nullable',
        ];
    }

    public function handle(Rucard $transport)
    {

        if (($this->data['check_before'] ?? false) === true) {

            $data_1 = $this->data;
            $data_1['stan'] = $this->data['stan_balance'];
            $data_1['stan_transaction'] = $this->data['stan'];

            CheckBalanceJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);

        } else {
            $data = null;
            try {
                $data = new Card2CardRequest(
                    $this->data['from']['account'],
                    $this->data['from']['exp'],
                    $this->data['from']['amount'],
                    $this->data['stan'],
                    Carbon::createFromFormat('ymdHis', $this->data['datetime']),
                    $this->data['from']['currency'],
                    $this->data['to']['account'],
                    $this->data['from']['commission'] ?? 0,
                    $this->data['from']['comment'] ?? null,
                    $this->data['to']['comment'] ?? null,
                    $this->data['check'] ?? null
                );

                $this->options = $data->getAllParamsToArray();

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

                $this->logger->info('PARAMS - QUEUE RUCARD REQUEST --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                //$delay = Carbon::now();

                $this->res_data = $transport->send($data, $this->session_id, $this->data['stan']);

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $arr = Helper::convertXmlToArray($this->res_data);
                $asw = $arr['ASW'];

                if ($asw['ERRC'] == RucardStatus::OK || $asw['ERRC'] == RucardStatus::DUPLICATE_OPERATION || $asw['ERRC'] == RucardStatus::DUPLICATE_TRANSACTION) {

                    /*$data = $this->data;
                    $data['to']['account'] = $this->data['from']['account'];
                    $data['to']['amount'] = $this->data['from']['amount'];
                    $data['to']['currency'] = $this->data['from']['currency'];
                     */
                    ConfirmJob::dispatch($this->data + ['PARENT' => 'CARD_2_CARD'])->onQueue(QueueEnum::PROCESSING);
                } elseif ($asw['ERRC'] == RucardStatus::ERROR_EMITENT_UNAVAILABLE) {
                    $log_params['Class'] = $this->log_name;
                    $log_params['SessionId'] = $this->session_id;
                    $log_params['Tries'] = $this->tries;
                    $log_params['Attempts'] = $this->attempts();
                    $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                    $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                    $log_params['ResponseData'] = $this->res_data;

                    $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE WRONG --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                    CancelJob::dispatch($this->data + ['PARENT' => 'CARD_2_CARD'])->onQueue(QueueEnum::PROCESSING);
                } else {
                    $dataUnknown = RucardHelper::data(
                        $this->data['session_id'],
                        false,
                        TransactionStatusV2::PAY_REJECTED,
                        TransactionStatusMaps::$rucard[$asw['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                        addslashes($this->res_data)
                    );

                    Card2CardCallbackJob::dispatch($dataUnknown)->onQueue(QueueEnum::PROCESSING);
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

                $this->errors = 'ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                CancelJob::dispatch($this->data + ['PARENT' => 'CARD_2_CARD'])->onQueue(QueueEnum::PROCESSING);
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

                $this->errors = 'FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: '. $this->data['stan'] .' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                CancelJob::dispatch($this->data + ['PARENT' => 'CARD_2_CARD'])->onQueue(QueueEnum::PROCESSING);
            }
        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
