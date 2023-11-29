<?php

namespace App\Jobs\Processing;

use App\Jobs\ValidationRuleContract;
use App\Services\Common\Gateway\Processing\OnlineStatusEnum;
use App\Services\Common\Gateway\Processing\ProcessingTransport;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Callback\QueueCallbackProcessing;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Monolog\Handler\StreamHandler;

class ProcessingJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $queueCallback;
    protected $processingTransport;
    protected $logger;

    protected $intervalNextTryAt = 5;

    public $tries = 222;
    public $timeout = 65;


    /**
     * ProcessingJob constructor.
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
            'amount' => 'required|numeric|max:11000',
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

        try {

            $result = null;
            $this->data['delayed'] = $delay;

            // если присуствует параметр delivery_status то нужно отправить запрос на изменение статуса транзакции app_wallet
            if (isset($this->data['delivery_status']) && $this->data['delivery_status'] == TransactionStatus::SEND_STATUS) {
                $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $this->data['result']['private_state_id'], $this->data['result']['message'], $this->data, $delay);
                return true;
            }

            switch ($this->data['status']) {
                case TransactionStatus::NEW:
                    $result = $this->processingTransport->check($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    $this->data['result'] = $result;
                    if ($result['private_state_id'] === TransactionStatusDetail::OK) {
                        $this->data['status'] = TransactionStatus::IN_PROCESSING;
                        self::dispatch($this->data)->delay($delay)->onQueue(QueueEnum::PROCESSING);
                        $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $delay);

                    } else {
                        if ($result['fatal'] === false) {
                            $this->release($delay);
                        } else {
                            // change status transactions
                            $this->data['status'] = TransactionStatus::REJECTED;
                            $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $delay);
                        }
                    }

                    break;
                case TransactionStatus::IN_PROCESSING:
                    $result = $this->processingTransport->pay($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    $this->data['result'] = $result;

                    if ($result['private_state_id'] === TransactionStatusDetail::OK) {

                        $this->data['status'] = TransactionStatus::ACCEPTED;
                        self::dispatch($this->data)->delay($delay)->onQueue(QueueEnum::PROCESSING);
                        $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $delay);

                    } else {
                        if ($result['fatal'] === false) {
                            $this->release($delay);
                        } else {
                            // change status transactions
                            $this->data['status'] = TransactionStatus::REJECTED;
                            $this->callCallbackHandle($this->data['session_id'], $this->data['status'], $result['private_state_id'], $result['message'], $this->data, $delay);
                        }
                    }
                    break;
                case TransactionStatus::ACCEPTED:
                    $result = $this->processingTransport->status($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);
                    $this->data['result'] = $result;

                    if ($result['online_status'] === OnlineStatusEnum::OK) {
                        // change status payment to app_wallet
                        $this->data['status'] = TransactionStatus::COMPLETED;
                        $this->callCallbackHandle($this->data['session_id'], $this->data['status'], TransactionStatusDetail::OK, $result['message'], $this->data, $delay);
                    } elseif ($result['online_status'] === OnlineStatusEnum::IN_PROGRESS) {
                        // если не фатальная ошибка то продолжаем запрашивать статус платежа c процессинга
                        $this->release($delay);
                    } elseif ($result['online_status'] === OnlineStatusEnum::ERROR) {
                        // change status payment to app_wallet
                        $this->data['status'] = TransactionStatus::REJECTED;
                        $this->callCallbackHandle($this->data['session_id'], $this->data['status'], TransactionStatusDetail::ERROR_UNKNOWN, $result['message'], $this->data, $delay);
                    } else {

                        // change status transactions
                        //$this->data['status'] = TransactionStatus::REJECTED;
                        //$this->callCallbackHandle($this->data['id'], $this->data['status'], TransactionStatusDetail::ERROR_UNKNOWN, $result['message'], $this->data, $delay);
                        $this->release($delay);
                    }

                    break;
            }

        } catch (\Exception $e) {
            $this->logger->error("HandleException on class ProcessingJob method handle: message: {$e->getMessage()}. tracing: {$e->getTraceAsString()}",[],false);
            $this->release($delay);
        } catch (\Throwable $e) {
            $this->logger->error("HandleException on class ProcessingJob method handle: message: {$e->getMessage()}. tracing: {$e->getTraceAsString()}",[],false);
            $this->release($delay);
        }
    }

    protected function callCallbackHandle(string $sessionId, string $statusId, string $statusDetailId = null, string $comment = null, array $payload, $delay)
    {
        //нужно учытывать на стороне сервера чтоб не изменил уже завершенный статус на в обработке
        if (!$this->queueCallback->handle($sessionId, $statusId, $statusDetailId, $comment)) {
            //нужно учытывать на стороне сервера чтоб не изменил уже завершенный статус на в обработке
            if (isset($this->data['delivery_status']) && $this->data['delivery_status'] == TransactionStatus::SEND_STATUS) {
                $this->release($delay);
            } else {
                $payload['delivery_status'] = TransactionStatus::SEND_STATUS;
                $payload['result']['private_state_id'] = $statusDetailId;
                self::dispatch($payload)->delay($delay)->onQueue(QueueEnum::DEFAULT);
            }
        }
    }

    public function failed(\Exception $exception = null)
    {
        //$this->changeLoggerHandler();

        //Log::info('notify failed queue');
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
        return [!isset($this->data['delivery_status']) ? null : TransactionStatus::getText($this->data['delivery_status']), TransactionStatus::getText($this->data['status']), $this->data['session_number']];
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
