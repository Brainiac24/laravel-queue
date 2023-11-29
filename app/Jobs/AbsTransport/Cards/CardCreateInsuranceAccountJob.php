<?php

namespace App\Jobs\AbsTransport\Cards;

use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Jobs\AbsTransport\Cards\CardCreateInsuranceAccountCallbackJob;
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

class CardCreateInsuranceAccountJob implements ShouldQueue
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
            'session_id'    => 'required|alpha_dash',
            'client_abs_id' => 'numeric|nullable',
            'create_user'   => 'numeric|nullable',
            'fintool'       => 'numeric|nullable',
            'sum_dog'       => 'numeric|nullable',
        ];
    }

    public function handle()
    {
        $uuid = null;
        try {
            //$uuid = Uuid::uuid4();

            $log_params['Class']       = $this->log_name;
            $log_params['SessionId']   = $this->session_id;
            $log_params['Tries']       = $this->tries;
            $log_params['Attempts']    = $this->attempts();
            $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);

            $this->logger->info('PARAMS - QUEUE BUS REQUEST --- session_id: ' . $this->session_id . ' --- class: ' . $this->log_name, $log_params);

            $transportService = new AbsTransportService(new AbsTransportEntity());

            $this->res_data = $transportService->getCardService()->createInsuranceAccountRequest(
                $this->data['session_id'],
                $this->data['client_abs_id'],
                '6119151853',
                $this->data['create_user'],
                $this->data['fintool'],
                $this->data['sum_dog']
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

                CardCreateInsuranceAccountCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);

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
