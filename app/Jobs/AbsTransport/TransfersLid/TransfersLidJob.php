<?php

namespace App\Jobs\AbsTransport\TransfersLid;

use App\Jobs\AbsTransport\Accounts\TransfersLidCallbackJob;
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

class TransfersLidJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
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
        $this->logger = new Logger('gateways/lid', 'ABS_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'pay_system' => 'required|numeric',
            'kdp' => 'required|numeric',
            'date_doc' => 'required|date_format:"d.m.Y"',
            'country' => 'numeric|nullable',
            'summa' => 'required|numeric',
            'spr_val' => 'required|numeric',
            'contacts' => 'required|string',
            'doc_num' => 'required|numeric',
            'doc_seria' => 'required|string',
            'cer_type' => 'required|numeric',
            'who' => 'string|nullable',
            'sen_name' => 'string|nullable',
            'enroll_type' => 'numeric|nullable',
            'acc_pan' => 'required|numeric',
            'summa_po' => 'required|numeric',
            'rate' => 'required|numeric',
            'coment' => 'string|nullable',
            'sen_resid' => 'numeric|nullable',
            'rec_name' => 'required|string',
            'rec_citiz' => 'numeric|nullable',
            'rec_resid' => 'numeric|nullable',
            'rec_region' => 'numeric|nullable',
            'rec_address' => 'string|nullable',
            'rec_bdate' => 'date_format:"d.m.Y"|nullable',
            'rec_date_v' => 'date_format:"d.m.Y"|nullable',
            'user_id' => 'numeric|nullable',
            'spr_np' => 'required|numeric',
            'process_lid' => 'numeric|nullable',
            'resource' => 'required|string',
            'ip_address' => 'required|string',
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

            $this->res_data = $transportService->getTransfersLidService()->createRequest(
                $this->data['session_id'],
                $this->data['pay_system'],
                $this->data['kdp'],
                $this->data['date_doc'],
                $this->data['country']??'',
                $this->data['summa'],
                ($this->data['spr_val']=='643'?'810':$this->data['spr_val']),
                $this->data['contacts'],
                $this->data['doc_num'],
                $this->data['doc_seria'],
                $this->data['cer_type'],
                $this->data['who']??'',
                $this->data['sen_name']??'',
                $this->data['enroll_type']??'0',
                $this->data['acc_pan'],
                $this->data['summa_po'],
                $this->data['rate'],
                $this->data['coment']??'',
                $this->data['sen_resid']??'',
                $this->data['rec_name'],
                $this->data['rec_citiz']??'0',
                $this->data['rec_resid']??'',
                $this->data['rec_region']??'0',
                $this->data['rec_address']??'',
                $this->data['rec_bdate']??'',
                $this->data['rec_date_v']??'',
                $this->data['user_id']??'0',
                $this->data['spr_np'],
                $this->data['process_lid']??'1',
                $this->data['resource']??'eskhata_online',
                $this->data['ip_address']
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

                $dataCallback['status'] = true;
                $dataCallback['session_id'] = $this->data['session_id'];
                $dataCallback['data']['response'] = $this->res_data;
                TransfersLidCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);

            } else {

                $log_params['Class'] = $this->log_name;
                $log_params['SessionId'] = $this->session_id;
                $log_params['Tries'] = $this->tries;
                $log_params['Attempts'] = $this->attempts();
                $log_params['RequestData'] = json_encode($this->data, JSON_UNESCAPED_UNICODE);
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                $dataCallback['status'] = false;
                $dataCallback['session_id'] = $this->data['session_id'];
                $dataCallback['data']['response'] = $this->res_data;
                TransfersLidCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
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
            
            $dataCallback['status'] = false;
            $dataCallback['session_id'] = $this->data['session_id'];
            $dataCallback['data']['response'] = $this->res_data;
            TransfersLidCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
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
            
            $dataCallback['status'] = false;
            $dataCallback['session_id'] = $this->data['session_id'];
            $dataCallback['data']['response'] = $this->res_data;
            TransfersLidCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::PROCESSING);
        }
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
