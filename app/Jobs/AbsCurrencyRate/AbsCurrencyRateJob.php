<?php

namespace App\Jobs\AbsCurrencyRate;

use App\Jobs\ValidationRuleContract;
use App\Services\Common\Gateway\AbsCftEskhata\AbsCftEskhataRate;
use App\Services\Common\Gateway\AbsCftEskhata\AbsCftEskhataRateTypeEnum;
use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Callback\QueueCallbackAbsCurrencyRate;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class AbsCurrencyRateJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $intervalNextTryAt = 15;

    public $tries = 10;
    public $timeout = 30;
    protected $logger;
    public $log_name = 'ClassNotSet';

    public static function rules()
    {
        return [
            'date' => 'required|date_format:Y.m.d',
            'code_iso' => 'required|integer',
            'cur_iso' => 'required|alpha',
            'type_rate' => 'required|in:' . AbsCftEskhataRateTypeEnum::ESH . ',' . AbsCftEskhataRateTypeEnum::NBT . ',' . AbsCftEskhataRateTypeEnum::ESH_TRANSFER,
        ];
    }

    /**
     * AbsCurrencyRateJob constructor.
     * @param $data
     * @throws \Exception
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->logger = new Logger('callback', 'BaseQueueCallbackHttp');
        $this->log_name = get_class($this);
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $rate = new AbsCftEskhataRate();
        $session_id = (string)Uuid::uuid4();

        $delay = Carbon::now()->addSecond($this->attempts() * $this->intervalNextTryAt);

        if (isset($this->data['session_id']) && !empty($this->data['session_id'])) {
            $result = $rate->aGetRate($this->data['session_id']);
//            Log::info($result);
            if ($result['state'] == 1) {
                $callback = App::make(QueueCallbackAbsCurrencyRate::class);
                if (is_numeric($result['sale']) && is_numeric($result['buy'])) {
//                    Log::info(method_exists($callback, 'handle'));
                    $response = $callback->handle($result['date'], $result['code_iso'], $result['cur_iso'], $result['rate'], $result['sale'], $result['buy'], $this->data['type_rate']);
                    $response === true ?: $this->release($delay);
                } else $this->logger->error('Полученный курс not numeric; payload=' . json_encode($result));

            } else {
                $this->release($delay);
            }


        } else {

            $result = $rate->rGetRate($session_id, $this->data['date'], $this->data['code_iso'], $this->data['cur_iso'], $this->data['type_rate']);

            if ($result['state'] == 1 && !empty($result['session_id'])) {
                $this->data['session_id'] = $session_id;

                self::dispatch($this->data)->delay($delay)->onQueue(QueueEnum::DEFAULT);

            } else {
                $this->release($delay);
            }
        }

    }

    public function tags()
    {
        return [$this->data['code_iso'], $this->data['session_id'] ?? null];
    }
}
