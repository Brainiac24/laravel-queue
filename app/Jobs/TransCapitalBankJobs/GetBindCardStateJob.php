<?php

namespace App\Jobs\TransCapitalBankJobs;

use App\Jobs\TransCapitalBankJobs\GetOrderStateCallbackJob;
use App\Services\Common\Gateway\TransCapitalBank\Apis\GetOrderState;
use App\Services\Common\Gateway\TransCapitalBank\Helpers\TkbOrderTypeHelper;
use App\Services\Common\Gateway\TransCapitalBank\Helpers\TkbStateHelper;
use App\Services\Common\Gateway\TransCapitalBank\TkbTransport;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetBindCardStateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $logger;
    protected $log_name = 'ClassNotSet';

    public $tries = 22;
    public $timeout = 60;
    public $errors = '';
    public $api_url = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;
    protected $intervalNextTryAt = 5;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger = new Logger('gateways/tkb', 'TKB_TRANSPORT');
        $this->log_name = get_class($this);
        $this->api_url = config('tkb.get_order_state_url');
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'datetime' => 'nullable|date_format:ymdHis',

            'ext_id' => 'required|string',
        ];
    }

    public function handle()
    {

        $transport = new TkbTransport($this->api_url);

        $data = new GetOrderState(
            $this->data['ext_id']
        );

        //$uuid = Uuid::uuid4();

        $this->options = $data->getData();

        $log_params['Class'] = $this->log_name;
        $log_params['SessionId'] = $this->session_id;
        $log_params['Tries'] = $this->tries;
        $log_params['Attempts'] = $this->attempts();
        $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);

        $this->logger->info('PARAMS - QUEUE TKB REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

        $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);

        try {

            $this->res_data = $transport->send($data, $this->session_id);

            $log_params['Class'] = $this->log_name;
            $log_params['SessionId'] = $this->session_id;
            $log_params['Tries'] = $this->tries;
            $log_params['Attempts'] = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData'] = $this->res_data;

            $this->logger->info('RESPONSE - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $arr_response = json_decode($this->res_data, true);
            $ErrorCode = isset($arr_response['ErrorInfo']['ErrorCode']) ? $arr_response['ErrorInfo']['ErrorCode'] : null;
            $OrderType = isset($arr_response['OrderInfo']['Type']) ? $arr_response['OrderInfo']['Type'] : null;
            $OrderState = isset($arr_response['OrderInfo']['State']) ? $arr_response['OrderInfo']['State'] : null;
            $OrderStateDescription = isset($arr_response['OrderInfo']['StateDescription']) ? $arr_response['OrderInfo']['StateDescription'] : null;
            $ExceptionType = $arr_response['ExceptionType'] ?? null;

            $CardRefId = isset($arr_response['OrderAdditionalInfo']['CardRefID']) ? $arr_response['OrderAdditionalInfo']['CardRefID'] : null;

            if ($CardRefId === null && mb_strpos($OrderStateDescription, "CardRefId=") >= 0) {
                $start_str = mb_strpos($OrderStateDescription, "CardRefId=") + 10;
                $CardRefId = trim(mb_substr($OrderStateDescription, $start_str, mb_strlen($OrderStateDescription) - $start_str)); //TODO loop until digit
                $CardRefId = !empty($CardRefId) ? $CardRefId : null;
            }

            if ($ErrorCode === 0) {

                if ($OrderType == TkbOrderTypeHelper::HOLDUNREGISTEREDCARD) {

                    $status = false;
                    if ($OrderState == TkbStateHelper::FILL_DEBET_RETURNED || ($OrderState == TkbStateHelper::ERROR && strpos($OrderStateDescription, "Карта уже привязана!") !== false)) {
                        $status = true;
                    } elseif ($OrderState == TkbStateHelper::ERROR) {
                        $status = false;
                    } else {
                        $this->release($delay);
                        return;
                    }

                    $this->response = Helper::data(
                        $this->data['session_id'],
                        $status,
                        [
                            "state" => $OrderState,
                            "card_number" => isset($arr_response['OrderAdditionalInfo']['CardNumber']) ? $arr_response['OrderAdditionalInfo']['CardNumber'] : null,
                            "card_holder" => isset($arr_response['OrderAdditionalInfo']['CardHolder']) ? $arr_response['OrderAdditionalInfo']['CardHolder'] : null,
                            "card_brand" => isset($arr_response['OrderAdditionalInfo']['CardBrand']) ? $arr_response['OrderAdditionalInfo']['CardBrand'] : null,
                            "email" => isset($arr_response['OrderAdditionalInfo']['Email']) ? $arr_response['OrderAdditionalInfo']['Email'] : null,
                            "card_exp_year" => isset($arr_response['OrderAdditionalInfo']['CardExpYear']) ? $arr_response['OrderAdditionalInfo']['CardExpYear'] : null,
                            "card_ref_id" => $CardRefId,
                            "card_exp_month" => isset($arr_response['OrderAdditionalInfo']['CardExpMonth']) ? $arr_response['OrderAdditionalInfo']['CardExpMonth'] : null,
                            "card_issuing_bank" => isset($arr_response['OrderAdditionalInfo']['CardIssuingBank']) ? $arr_response['OrderAdditionalInfo']['CardIssuingBank'] : null,
                            "card_type" => isset($arr_response['OrderAdditionalInfo']['CardType']) ? $arr_response['OrderAdditionalInfo']['CardType'] : null,
                            "card_level" => isset($arr_response['OrderAdditionalInfo']['CardLevel']) ? $arr_response['OrderAdditionalInfo']['CardLevel'] : null,
                            "response" => $this->res_data,
                        ]
                    );
                } else {
                    $this->response = Helper::data(
                        $this->data['session_id'],
                        true,
                        [
                            "message" => "Error: OrderType is not HOLDUNREGISTEREDCARD",
                            "response" => $this->res_data,
                        ]
                    );
                }
            } elseif ($ExceptionType == 'Error') {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('RESPONSE - QUEUE TKB RESPONSE WRONG --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    $this->res_data
                );
            } else {
                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    $this->res_data
                );
            }

            GetBindCardStateCallbackJob::dispatch($this->response)->onQueue(QueueEnum::REQUEST);
            //return $this->response;

        } catch (ServerException $serEx) {

            if ($serEx->getCode() == 500) {
                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['RequestSended'] = json_encode($this->options, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;
                $log_params['ErrorMessage'] = $serEx->getMessage();
                $log_params['ErrorTraceData'] = $serEx->getTraceAsString();

                $this->errors = 'ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
                $this->logger->error('ERROR RESULT - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $this->response = Helper::data(
                    $this->data['session_id'],
                    false,
                    $this->res_data
                );
            } else {
                throw $serEx;
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

            $this->errors = 'ERROR CONNECTION - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
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

            $this->errors = 'FATAL ERROR - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE TKB RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = Helper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
