<?php

namespace App\Jobs\AbsTransport\Accounts;

use App\Jobs\AbsTransport\Accounts\Traits\AccountJobPropertiesHelperTrait;
use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Helpers\Helper;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DepositChangeContractAccountJob implements ShouldQueue
{
    use AccountJobPropertiesHelperTrait, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return array
     */
    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|alpha_dash',
            'depn_dog_abs_id' => 'required|numeric',
            'prc_acc_abs_id' => 'required|numeric',
        ];
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try{
            $log_params['Class'] = $this->setBaseLogParams();
            $this->logger->info('PARAMS - QUEUE BUS REQUEST --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);
            $transportService = new AbsTransportService(new AbsTransportEntity());
            $this->res_data = $transportService->getAccountService()->ChangeDepositAccount(
                $this->data['session_id'],
                $this->data['depn_dog_abs_id'],
                $this->data['prc_acc_abs_id']
            );
            $busResponseArray = Helper::convertXmlToArray($this->res_data);
            Log::info($busResponseArray);

            if($busResponseArray['root']['response']['state'] ?? 0 == '1'){
                $log_params = $this->setBaseLogParams();
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

                DepositChangeContractAccountCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            } else {

                $log_params = $this->setBaseLogParams();
                $log_params['ResponseData'] = $this->res_data;

                $this->logger->info('WRONG - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name, $log_params);

                throw new \Exception("BUS_RESPONSE_STATE_IS_NOT_SUCCESS EO_R_DEPOSITS_LIST");
            }

        } catch (ConnectException $conEx) {

            $log_params = $this->setBaseLogParams();
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $conEx->getMessage();
            $log_params['ErrorTraceData'] = $conEx->getTraceAsString();

            $this->errors = 'ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('ERROR CONNECTION - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            $result=''; // TODO dlya chego result?
            $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );
            AccountCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            throw $conEx;
        } catch (\Throwable $th) {


           $log_params = $this->setBaseLogParams();
            $log_params['ResponseData'] = $this->res_data;
            $log_params['ErrorMessage'] = $th->getMessage();
            $log_params['ErrorTraceData'] = $th->getTraceAsString();

            $this->errors = 'FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name  . json_encode($log_params);
            $this->logger->error('FATAL ERROR - QUEUE BUS RESPONSE --- session_id: '. $this->session_id.' --- class: '. $this->log_name , $log_params);
            $result = '';
            $dataCallback = AbsHelper::data(
                $this->data['session_id'],
                false,
                null,
                null,
                addslashes($result)
            );
            AccountCreateCallbackJob::dispatch($dataCallback)->onQueue(QueueEnum::REQUEST);
            throw $th;
        }

    }

    public function tags()
    {
        return [$this->data['session_id']];
    }


}
