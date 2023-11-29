<?php

namespace App\Jobs\AbsTransport\TransfersSoniya;

use App\Jobs\AbsTransport\Accounts\AbsHelper;
use App\Jobs\AbsTransport\Cards\CardListCallbackJob;
use App\Jobs\AbsTransport\TransfersSoniya\TransfersSoniyaCallbackJob;
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
use Ramsey\Uuid\Uuid;

class TransfersSoniyaJob implements ShouldQueue
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
        $this->logger = new Logger('gateways/soniya', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'id_transaction' => 'required|string', 
            'family_cl' => 'required|string', 
            'name_cl' => 'required|string', 
            'sname_cl' => 'string|nullable', 
            'inn' => 'numeric|nullable', 
            'region_ref' => 'required|numeric', 
            'city_ref' => 'required|numeric', 
            'date_pers' => 'required|date_format:"Y.m.d"',
            'sex_ref' => 'required|numeric', 
            'type_ref' => 'required|numeric', 
            'date' => 'required|date_format:"Y.m.d"',
            'num' => 'required|string', 
            'ser' => 'required|string', 
            'who' => 'required|string', 
            'client_phone' => 'required|numeric', 
            'address' => 'required|string', 
            'citizen_id' => 'required|numeric', 
            'rec_family_cl' => 'required|string', 
            'rec_name_cl' => 'required|string', 
            'rec_sname_cl' => 'string|nullable', 
            'rec_receiver_phone' => 'required|numeric', 
            'rec_doc_num' => 'string|nullable', 
            'rec_doc_ser' => 'string|nullable', 
            'summa_pay' => 'required|numeric', 
            'summa' => 'required|numeric', 
            'summa_komis' => 'required|numeric', 
            'currency_code' => 'required|string', 
            'date_doc' => 'required|date_format:"Y.m.d"',
            'rate' => 'required|numeric', 
            'id_np' => 'required|numeric',  
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

            $this->res_data = $transportService->getTransfersSoniyaService()->createRequest(
                 $this->data['session_id'],
                 $this->data['id_transaction'],
                 $this->data['family_cl'],
                 $this->data['name_cl'],
                 $this->data['sname_cl']??'',
                 $this->data['inn']??'',
                 $this->data['region_ref'],
                 $this->data['city_ref'],
                 $this->data['date_pers'],
                 $this->data['sex_ref'],
                 $this->data['type_ref'],
                 $this->data['date'],
                 $this->data['num'],
                 $this->data['ser'],
                 $this->data['who'],
                 $this->data['client_phone'],
                 $this->data['address'],
                 $this->data['citizen_id'],
                 $this->data['rec_family_cl'],
                 $this->data['rec_name_cl'],
                 $this->data['rec_sname_cl'],
                 $this->data['rec_receiver_phone'],
                 $this->data['rec_doc_num']??'',
                 $this->data['rec_doc_ser']??'',
                 $this->data['summa_pay'],
                 $this->data['summa'],
                 $this->data['summa_komis'],
                 $this->data['currency_code'],
                 $this->data['date_doc'],
                 $this->data['rate'],
                 $this->data['id_np']
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

                TransfersSoniyaCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);

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

                throw new \Exception("BUS_RESPONSE_STATE_IS_NOT_SUCCESS R_PAY_TRANSFER");
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
