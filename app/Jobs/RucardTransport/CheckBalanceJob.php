<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\Processing\TransactionStatusDetail;
use App\Jobs\RucardTransport\Card2CardCallbackJob;
use App\Jobs\RucardTransport\Card2CardJob;
use App\Jobs\RucardTransport\CheckBalanceCallbackJob;
use App\Jobs\RucardTransport\FillCardCallbackJob;
use App\Jobs\RucardTransport\FillCardJob;
use App\Jobs\RucardTransport\PayFromCardCallbackJob;
use App\Jobs\RucardTransport\PayFromCardJob;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\CheckBalanceRequest;
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

class CheckBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 90;
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
            'from.exp' => 'required|date_format:ym',
            'from.currency' => 'required|numeric',
        ];
    }

    public function handle(Rucard $transport)
    {
        $data = null;

        try {
            $data = new CheckBalanceRequest(
                $this->data['from']['account'],
                $this->data['from']['exp'],
                $this->data['stan'],
                Carbon::createFromFormat('ymdHis', $this->data['datetime']),
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

            $this->logger->info('PARAMS - QUEUE RUCARD REQUEST --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $this->res_data = $transport->send($data, $this->session_id, $this->data['stan']);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $arr = Helper::convertXmlToArray($this->res_data);

            $asw = $arr['ASW'];

            if ($asw['ERRC'] == RucardStatus::OK) {

                if (($this->data['check_before'] ?? false) === true) {
                    unset($this->data['check_before']);
                    $data_1 = $this->data;
                    $data_1['stan'] = $this->data['stan_transaction'];
                    $data_1['stan_balance'] = $this->data['stan'];

                    //if (isset($data['check_mode'])) { Специально закоментирован для того чтобы по просту не проверять баланс без какого либо действия и выдало ошибку
                    switch ($this->data['check_mode']) {
                        case RequestType::FILL_CARD:
                            FillCardJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);
                            break;
                        case RequestType::PAY_FROM_CARD:
                            PayFromCardJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);
                            break;
                        case RequestType::CARD_2_CARD:
                            Card2CardJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);
                            break;
                        default:
                    }
                    //}

                } else {

                    if (($this->data['check_before'] ?? false) === true) {
                        unset($this->data['check_before']);
                        $this->sendRejectedResponse($asw);
                    } else {
                        $dataResult = RucardHelper::data(
                            $this->data['session_id'],
                            true,
                            null,
                            null,
                            addslashes($this->res_data),
                            ((int) $asw['AMOUNT']) / 100
                        );
                        CheckBalanceCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::REQUEST);
                    }

                }

            } else {

                if (($this->data['check_before'] ?? false) === true) {
                    unset($this->data['check_before']);
                    $this->sendRejectedResponse($asw);
                } else {
                    $dataResult = RucardHelper::data(
                        $this->data['session_id'],
                        false,
                        null,
                        null,
                        addslashes($this->res_data)
                    );
                    //$this->logger->info('PAYLOAD --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . print_r($dataResult,true));
                    CheckBalanceCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::REQUEST);
                }
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

            $this->errors = 'ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE RUCARD RESPONSE --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            if (($this->data['check_before'] ?? false) === true) {
                unset($this->data['check_before']);
                $this->sendRejectedResponse();
            } else {
                $dataResult = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    null,
                    null,
                    addslashes($this->res_data)
                );

                CheckBalanceCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);
            }
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

            $this->errors = 'FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE RUCARD RESPONSE --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            if (($this->data['check_before'] ?? false) === true) {
                unset($this->data['check_before']);
                $this->sendRejectedResponse();
            } else {
                $dataResult = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    null,
                    null,
                    addslashes($this->res_data)
                );
                CheckBalanceCallbackJob::dispatch($dataResult)->onQueue(QueueEnum::PROCESSING);
            }
        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }

    public function sendRejectedResponse($asw = null)
    {
        switch ($this->data['check_mode']) {
            case RequestType::FILL_CARD:
                $dataRejected = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    TransactionStatusV2::PAY_REJECTED,
                    empty($asw) ? TransactionStatusDetail::ERROR_UNKNOWN : TransactionStatusMaps::$rucard[$asw['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );
                FillCardCallbackJob::dispatch($dataRejected)->onQueue(QueueEnum::PROCESSING);
                break;

            case RequestType::PAY_FROM_CARD:
                $dataRejected = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    TransactionStatusV2::BLOCK_REJECTED,
                    empty($asw) ? TransactionStatusDetail::ERROR_UNKNOWN : TransactionStatusMaps::$rucard[$asw['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );
                PayFromCardCallbackJob::dispatch($dataRejected)->onQueue(QueueEnum::PROCESSING);
                break;

            case RequestType::CARD_2_CARD:
                $dataRejected = RucardHelper::data(
                    $this->data['session_id'],
                    false,
                    TransactionStatusV2::PAY_REJECTED,
                    empty($asw) ? TransactionStatusDetail::ERROR_UNKNOWN : TransactionStatusMaps::$rucard[$asw['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                    addslashes($this->res_data)
                );
                Card2CardCallbackJob::dispatch($dataRejected)->onQueue(QueueEnum::PROCESSING);
                break;

            default:

        }
    }

}
