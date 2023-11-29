<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\Processing\TransactionStatusDetail;
use App\Jobs\RucardTransport\CancelJob;
use App\Jobs\RucardTransport\CheckBalanceJob;
use App\Jobs\RucardTransport\ConfirmJob;
use App\Jobs\RucardTransport\FillCardCallbackJob;
use App\Jobs\RucardTransport\RucardHelper;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;
use App\Services\Common\Gateway\Rucard\Requests\FillCardRequest;
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

class FillCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    protected $log_name = 'ClassNotSet';

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
            'to.account' => 'required|digits_between:16,20',
            'to.amount' => 'required|numeric',
            'to.commission' => 'required|numeric',
            'to.currency' => 'required|numeric',
            'to.comment' => 'string|nullable',
            'to.exp' => 'string|nullable',
        ];
    }

    public function handle(Rucard $transport)
    {
        if (($this->data['check_before'] ?? false) === true && isset($this->data['to']['exp'])) {

            $data_1 = $this->data;
            $data_1['stan'] = $this->data['stan_balance'];
            $data_1['stan_transaction'] = $this->data['stan'];

            if ($this->data['check_mode'] == RequestType::FILL_CARD) {
                $data_1['from']['account'] = $this->data['to']['account'];
                $data_1['from']['exp'] = $this->data['to']['exp'];
                $data_1['from']['currency'] = $this->data['to']['currency'];
            }

            CheckBalanceJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);

        } else {

            try {

                $data = new FillCardRequest(
                    $this->data['to']['account'],
                    $this->data['to']['amount'],
                    $this->data['stan'],
                    Carbon::createFromFormat('ymdHis', $this->data['datetime']),
                    $this->data['to']['commission'],
                    $this->data['to']['currency'],
                    $this->data['to']['comment'] ?? null
                );

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

                if ($asw['ERRC'] == RucardStatus::OK || $asw['ERRC'] == RucardStatus::DUPLICATE_OPERATION || $asw['ERRC'] == RucardStatus::DUPLICATE_TRANSACTION) {
                    //dd($dataConfirmArr);
                    $data_1 = $this->data;
                    $data_1['from']['account'] = $this->data['to']['account'];
                    $data_1['from']['amount'] = $this->data['to']['amount'];
                    $data_1['from']['currency'] = $this->data['to']['currency'];
                    $data_1['PARENT'] = 'FILL';
                    ConfirmJob::dispatch($data_1)->onQueue(QueueEnum::PROCESSING);

                } elseif ($asw['ERRC'] == RucardStatus::ERROR_EMITENT_UNAVAILABLE) {

                    $log_params['Class'] = $this->log_name;
                    $log_params['SessionId'] = $this->session_id;
                    $log_params['Tries'] = $this->tries;
                    $log_params['Attempts'] = $this->attempts();
                    $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                    $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                    $log_params['ResponseData'] = $this->res_data;

                    $this->logger->info('RESPONSE - QUEUE RUCARD RESPONSE WRONG --- stan: ' . $this->data['stan'] . ' --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                    $data_2 = $this->data;
                    $data_2['from']['account'] = $this->data['to']['account'];
                    $data_2['from']['amount'] = $this->data['to']['amount'];
                    $data_2['from']['currency'] = $this->data['to']['currency'];
                    $data_2['PARENT'] = 'FILL';
                    CancelJob::dispatch($data_2)->onQueue(QueueEnum::PROCESSING);

                } else {

                    $dataUnknown = RucardHelper::data(
                        $this->data['session_id'],
                        false,
                        TransactionStatusV2::PAY_REJECTED,
                        TransactionStatusMaps::$rucard[$asw['ERRC']] ?? TransactionStatusDetail::ERROR_UNKNOWN,
                        addslashes($this->res_data)
                    );

                    FillCardCallbackJob::dispatch($dataUnknown)->onQueue(QueueEnum::PROCESSING);

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

                $data = $this->data;
                $data['from']['account'] = $this->data['to']['account'];
                $data['from']['amount'] = $this->data['to']['amount'];
                $data['from']['currency'] = $this->data['to']['currency'];
                $data['PARENT'] = 'FILL';
                CancelJob::dispatch($data)->onQueue(QueueEnum::PROCESSING);

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

                $data = $this->data;
                $data['from']['account'] = $this->data['to']['account'];
                $data['from']['amount'] = $this->data['to']['amount'];
                $data['from']['currency'] = $this->data['to']['currency'];
                $data['PARENT'] = 'FILL';
                CancelJob::dispatch($data)->onQueue(QueueEnum::PROCESSING);
            }

        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
