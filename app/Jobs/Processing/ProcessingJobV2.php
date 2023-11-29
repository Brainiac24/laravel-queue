<?php

namespace App\Jobs\Processing;

use App\Jobs\ValidationRuleContract;
use App\Services\Common\Gateway\Processing\OnlineStatusEnum;
use App\Services\Common\Gateway\Processing\ProcessingTransport;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\CallbackV2\QueueCallbackProcessing;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ProcessingJobV2 implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $queueCallback;
    protected $processingTransport;
    protected $logger;

    protected $intervalNextTryAt = 5;
    protected $waitSendCallback =3;

    public $tries = 222;
    public $timeout = 65;


    /**
     * ProcessingJobV2 constructor.
     * @param $data
     * @throws \Exception
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->queueCallback = App::make(QueueCallbackProcessing::class);
        $this->processingTransport = new ProcessingTransport();
        $this->logger = new Logger('gateways/processing_job', 'processing_job');
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'session_number' => 'required|numeric',
            'amount' => 'required|numeric|max:20000',
            'processing_code' => 'required|integer',
            'account' => 'required',
            'status' => 'required|alpha_dash',
//            'push_token' => 'required'
        ];
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $delay = Carbon::now()->addSecond(($this->attempts() + $this->attempts()) * $this->intervalNextTryAt);
        $now = Carbon::now();
        $nowWithWaitSendCallback = Carbon::now()->addSecond($this->waitSendCallback);
        //$this->logger->info("attemps: {$this->attempts()}, delay :{$delay}");


        try {

            //$this->changeLoggerHandler();

            $result = null;
            $this->data['delayed'] = $delay;

            // если присуствует параметр delivery_status то нужно отправить запрос на изменение статуса транзакции app_wallet
            if (isset($this->data['delivery_status']) && $this->data['delivery_status'] == TransactionStatusV2::SEND_STATUS) {
                $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $this->data['result']['private_state_id'], $this->data['result']['message'], $this->data, $delay);
                return true;
            }

            switch ($this->data['status']) {
                case TransactionStatusV2::NEW:
                    $result = $this->processingTransport->check($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    $this->data['result'] = $result;
                    if ($result['private_state_id'] === TransactionStatusDetail::OK) {
                        $this->data['status'] = TransactionStatusV2::IN_PROCESSING;
                        self::dispatch($this->data)->onQueue(QueueEnum::PROCESSING);
                        $this->callDispatchHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $now);
                        //$this->logger->info("Callback: status=NEW->IN_PROCESSING, availableAt={$now}",[],false);

                    } else {
                        if ($result['fatal'] === false) {
                            $this->release($delay);
                        } else {
                            // change status transactions
                            if (strpos($result['message'], "payment exists") !== false) {
                                $this->data['status'] = TransactionStatusV2::ACCEPTED;
                                self::dispatch($this->data)->onQueue(QueueEnum::PROCESSING);
                            } else {
                                $this->data['status'] = TransactionStatusV2::REJECTED;
                                $this->callDispatchHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $now);
                            }

                        }
                    }

                    break;
                case TransactionStatusV2::IN_PROCESSING:
                    $result = $this->processingTransport->pay($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    $this->data['result'] = $result;

                    if ($result['private_state_id'] === TransactionStatusDetail::OK) {

                        $this->data['status'] = TransactionStatusV2::ACCEPTED;
                        self::dispatch($this->data)->delay($delay)->onQueue(QueueEnum::PROCESSING);
                        $this->callDispatchHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $nowWithWaitSendCallback);
                        //$this->logger->info("Callback: status=IN_PROCESSING->ACCEPTED, availableAt={$nowWithWaitSendCallback}, delay:{$delay}",[],false);

                    } else {
                        if ($result['fatal'] === false) {
                            $this->release($delay);
                        } else {
                            // change status transactions
                            if (strpos($result['message'], "payment exists") !== false) {
                                $this->data['status'] = TransactionStatusV2::ACCEPTED;
                                self::dispatch($this->data)->onQueue(QueueEnum::PROCESSING);
                            } else {
                                $this->data['status'] = TransactionStatusV2::REJECTED;
                                $this->callDispatchHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $nowWithWaitSendCallback);
                            }
                        }
                    }
                    break;
                case TransactionStatusV2::ACCEPTED:
                    $result = $this->processingTransport->status($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    //Log::info(json_encode($result));
                    $this->data['result'] = $result;

                    if ($result['online_status'] === OnlineStatusEnum::OK) {
                        // change status payment to app_wallet
                        $this->data['status'] = TransactionStatusV2::COMPLETED;
                        $this->callDispatchHandle($this->data['session_id'], $this->data['status'], TransactionStatusDetail::OK, $result['message'], $this->data, $now);
                        //$this->logger->info("Callback: status=ACCEPTED->COMPLETED, availableAt={$now}",[],false);
                    } elseif ($result['online_status'] === OnlineStatusEnum::IN_PROGRESS) {
                        // если не фатальная ошибка то продолжаем запрашивать статус платежа c процессинга
                        $this->release($delay);
                        //$this->logger->info("Callback: status=ACCEPTED->COMPLETED/RELEASE, availableAt={$delay}",[],false);
                    } elseif ($result['online_status'] === OnlineStatusEnum::ERROR) {
                        // change status payment to app_wallet
                        $this->data['status'] = TransactionStatusV2::REJECTED;
                        $this->callDispatchHandle($this->data['session_id'], $this->data['status'], TransactionStatusDetail::ERROR_UNKNOWN, $result['message'], $this->data, $now);
                    } else {

                        // нестандартный ответ: return response <result>1</result><comment>Temporary error. Try request later</comment>
                        if (isset($result['comment']) && $result['comment'] == 'Temporary error. Try request later') {
                            $this->release($delay);
                        }else{
                            // change status transactions
                            $this->data['status'] = TransactionStatusV2::PAY_UNKNOWN;
                            $this->callDispatchHandle($this->data['session_id'], $this->data['status'], TransactionStatusDetail::ERROR_UNKNOWN, $result['message'], $this->data, $now);
                        }
                    }

                    break;
            }

        } catch (\Exception $e) {
            $this->logger->error('HandleException:' . $e->getMessage());
            $this->release($delay);
        } catch (\Throwable $e) {
            $this->logger->error('HandleException:' . $e->getMessage());
            $this->release($delay);
        }

    }

    protected function callCallbackHandle(string $transactionId, string $statusId, string $statusDetailId = null, string $comment = null, array $payload, $delay)
    {
        //нужно учытывать на стороне сервера чтоб не изменил уже завершенный статус на в обработке
        if (!$this->queueCallback->handle($transactionId, $statusId, $statusDetailId, $comment)) {
            $this->callDispatchHandle($transactionId, $statusId, $statusDetailId, $comment, $payload, $delay);
        }
    }

    protected function callDispatchHandle(string $transactionId, string $statusId, string $statusDetailId = null, string $comment = null, array $payload, $delay)
    {
        //нужно учытывать на стороне сервера чтоб не изменил уже завершенный статус на в обработке
        //if (!$this->queueCallback->handle($transactionId, $statusId, $statusDetailId, $comment)) {
        //нужно учытывать на стороне сервера чтоб не изменил уже завершенный статус на в обработке
        if (isset($this->data['delivery_status']) && $this->data['delivery_status'] == TransactionStatusV2::SEND_STATUS) {
            $this->release($delay);
        } else {
            $payload['delivery_status'] = TransactionStatusV2::SEND_STATUS;
            $payload['result']['private_state_id'] = $statusDetailId;
            self::dispatch($payload)->delay($delay)->onQueue(QueueEnum::SEND_STATUS_TO_CALLBACK);
        }
        //}
    }

    public function failed(\Exception $exception = null)
    {
        //$this->changeLoggerHandler();

        $this->logger->error('notify failed queue');
    }

    /*
    protected function release($delay)
    {
        $this->data['attempts']++;
        self::dispatch($this->data)->delay($delay)->onQueue(QueueEnum::PROCESSING);
        $this->job->delete();
    }
    */

    public function tags()
    {
        return [!isset($this->data['delivery_status']) ? null : TransactionStatusV2::getText($this->data['delivery_status']), TransactionStatusV2::getText($this->data['status']), $this->data['session_number']];
    }

    /*
    protected function changeLoggerHandler()
    {
        app()->configureMonologUsing(function ($monolog) {
            $monolog->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $this->job->getQueue(), \Carbon\Carbon::now()->toDateString()), Logger::INFO));
            $monolog->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $this->job->getQueue(), \Carbon\Carbon::now()->toDateString()), Logger::ERROR));
        });
    }
    */
}
