<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 06.09.2018
 * Time: 9:45
 */

namespace App\Services\Queue\CallbackV2;


use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Queue\Hash\QueueHashContract;

class QueueCallbackProcessing extends BaseQueueCallbackHttp
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
        $this->logger = new Logger('callback_v2', 'CALLBACK_TRANSACTION_CHANGE_STATUS');
        $this->url = config('queue_exchange_v2.callback_url_change_status_transaction');
    }

    /**
     * @param string $transactionId
     * @param string $statusId
     * @param string|null $statusDetailId
     * @param string|null $comment
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $transactionId, string $statusId, string $statusDetailId = null, string $comment = null): bool
    {

        $data = [
            'status'=>true,
            'session_id' => $transactionId,
            'data'=>[
                'status_id' => $statusId,
                'status_detail_id' => $statusDetailId,
                'response' => $comment,
            ]
        ];

        return $this->send($this->url, $data);
    }
}