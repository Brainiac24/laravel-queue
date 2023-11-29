<?php

namespace App\Http\Controllers;


use App\Http\Requests\Exchange\ExchangeStoreRequest;
use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Common\Gateway\LogSender\LogSender;
use App\Services\Common\Gateway\LogSender\LogSenderEntity;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Callback\QueueCallbackProcessing;
use App\Services\Queue\Exchange\Exceptions\AccessDeniedException;
use App\Services\Queue\Exchange\QueueExchangeServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ExchangeController extends Controller
{
    protected $exchangeService;

    public function __construct(QueueExchangeServices $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }


    public function store(ExchangeStoreRequest $request)
    {
//        dd($request->getClientIp());
        if (!App::environment('local')) {
            if (!in_array($request->getClientIp(), config('queue_exchange.allowed_ips')))
                throw new AccessDeniedException('Ip not allowed: '.$request->getClientIp());
        }

        try {

            $handler = $request->handler;
            $payload = $request->payload;
            $availableAt = isset($request->available_at) ? Carbon::parse($request->available_at) : null;
            $withQueue = $request->with_queue;
            $datetime = $request->datetime;
            $hash = $request->hash;
            $count = $request->post('count', 1);

            if ($count > 1) {
                for ($i = 0; $i <= $count; $i++)
                    $data = $this->exchangeService->handle($handler, $payload, $availableAt, $withQueue, $datetime, $hash);
            } else $data = $this->exchangeService->handle($handler, $payload, $availableAt, $withQueue, $datetime, $hash);


            return response()->apiSuccess(compact('data'));

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return response()->apiError(['error' => $e->getMessage()]);
        }
    }

    public function testCallback(Request $request)
    {
        $status = $request->payload['status'];
        $id = $request->payload['id'];
        $private_status_id = TransactionStatusDetail::OK;

        $callback = App::make(QueueCallbackProcessing::class);

        $result = $callback->handle($id, $status, $private_status_id);
        dd($result);
    }

    public function testLogSenderSeq()
    {

        $logger = new Logger("test/test","callback");
        $logger->error("message", ['context' => 'test']);

//        $entity = new LogSenderEntity("Ошибка", "tracing", ['test'=>'12345']);
//
//        $logSender = new LogSender($entity);
//        $logSender->handle();
    }
}
