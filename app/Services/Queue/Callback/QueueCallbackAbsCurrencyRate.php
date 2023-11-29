<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 06.09.2018
 * Time: 9:45
 */

namespace App\Services\Queue\Callback;


use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Hash\QueueHashContract;

class QueueCallbackAbsCurrencyRate extends BaseQueueCallbackHttp
{
    protected $url;
    protected $hash;

    /**
     * QueueCallbackAbsCurrencyRate constructor.
     * @param QueueHashContract $hash
     * @throws \Exception
     */
    public function __construct(QueueHashContract $hash)
    {
        $this->hash = $hash;
        $this->logger = new Logger('callback', 'CALLBACK_ABS_CURRENCY_RATE');
        $this->url = config('queue_exchange.callback_url_currency_rate');
    }

    /**
     * @param string $date
     * @param string $codeIso
     * @param string $curIso
     * @param string $rate
     * @param string $rateSale
     * @param string $rateBuy
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $date, string $codeIso, string $curIso, string $rate, string $rateSale, string $rateBuy, string $typeRate): bool
    {
        try {

            /**
             * 'date' => '2018.06.01',
             * 'code_iso' => '840',
             * 'cur_iso' => 'USD',
             * 'rate' => '0',
             * 'sale' => '9.03',
             * 'buy' => '9.02',
             */

            $formParams = [
                'date' => $date,
                'code_iso' => $codeIso,
                'cur_iso' => $curIso,
                'rate' => $rate,
                'sale' => $rateSale,
                'buy' => $rateBuy,
                'type_rate' => $typeRate,
            ];

            return $this->send($this->url, $formParams);

        } catch (\Exception $e) {
            $this->logger->error(sprintf('message=%s; trace=%s;', $e->getMessage(), $e->getTraceAsString()));
            return false;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('message=%s; trace=%s;', $e->getMessage(), $e->getTraceAsString()));
            return false;
        }


    }
}