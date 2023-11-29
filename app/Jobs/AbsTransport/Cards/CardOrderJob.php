<?php

namespace App\Jobs\AbsTransport\Cards;

use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Jobs\AbsTransport\Cards\CardOrderCallbackJob;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CardOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private   $logger;
    public    $log_name = 'ClassNotSet';

    public    $tries             = 5;
    public    $timeout           = 60;
    private   $intervalNextTryAt = 5;
    public    $errors            = '';
    protected $response          = null;
    protected $options           = null;
    protected $session_id        = null;
    protected $res_data          = null;

    public function __construct($data)
    {
        $this->data       = $data;
        $this->session_id = $this->data['session_id'] ?? null;
        $this->logger     = new Logger('gateways/abs', 'ABS_TRANSPORT');
        $this->log_name   = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id'         => 'required|alpha_dash',
            'user_create_id'     => 'required|numeric',
            'client_id'          => 'required|numeric',
            'date_begin'         => 'required|date_format:"Y.m.d"',
            'emb_family'         => 'required|string',
            'emb_name'           => 'required|string',
            'secret_word'        => 'required|string',
            'card_product_id'    => 'required|numeric',
            'delivery_branch_id' => 'required|numeric',
            'vid_dog_id'         => 'required|numeric',
            'fintool_id'         => 'required|numeric',
        ];
    }

    public function handle()
    {
        $uuid = null;
        try {

            $log_params['Class']       = $this->log_name;
            $log_params['SessionId']   = $this->session_id;
            $log_params['Tries']       = $this->tries;
            $log_params['Attempts']    = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE BUS REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $transportService = new AbsTransportService(new AbsTransportEntity());

            $this->res_data = $transportService->getCardService()->orderCardRequest(
                $this->data['session_id'],
                $this->data['user_create_id'],
                $this->data['client_id'],
                $this->data['date_begin'],
                "339386636", //Главная дебетовая карта
                $this->data['emb_family'],
                $this->data['emb_name'],
                $this->data['secret_word'],
                $this->data['card_product_id'],
                $this->data['delivery_branch_id'],
                "339500713", //Общий
                $this->data['vid_dog_id'],
                $this->data['fintool_id']
            );

            $arr = Helper::convertXmlToArray($this->res_data);

            if ($arr['root']['response']['state'] ?? '0' == '1') {

                $log_params['Class']        = $this->log_name;
                $log_params['SessionId']    = $this->session_id;
                $log_params['Tries']        = $this->tries;
                $log_params['Attempts']     = $this->attempts();
                $log_params['RequestData']  = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('SUCCESS - QUEUE BUS RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

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

                CardOrderCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class']        = $this->log_name;
                $log_params['SessionId']    = $this->session_id;
                $log_params['Tries']        = $this->tries;
                $log_params['Attempts']     = $this->attempts();
                $log_params['RequestData']  = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE BUS RESPONSE BUS --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

                $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
                $this->release($delay);
            }

        } catch (ConnectException $conEx) {

            $log_params['Class']          = $this->log_name;
            $log_params['SessionId']      = $this->session_id;
            $log_params['Tries']          = $this->tries;
            $log_params['Attempts']       = $this->attempts();
            $log_params['RequestData']    = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData']   = $this->res_data;
            $log_params['ErrorMessage']   = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        } catch (\Throwable $th) {

            $log_params['Class']          = $this->log_name;
            $log_params['SessionId']      = $this->session_id;
            $log_params['Tries']          = $this->tries;
            $log_params['Attempts']       = $this->attempts();
            $log_params['RequestData']    = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            $log_params['ResponseData']   = $this->res_data;
            $log_params['ErrorMessage']   = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS RESPONSE --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $delay = AbsHelper::calculateDelay($this->attempts(), $this->intervalNextTryAt);
            $this->release($delay);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
