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
use Carbon\Carbon;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

abstract class BaseQueueCallbackHttp
{
    protected $method = 'POST';
    protected $hash;
    protected $logger;

    /**
     * BaseQueueCallbackHttp constructor.
     * @param QueueHashContract $hash
     * @throws \Exception
     */
    public function __construct(QueueHashContract $hash)
    {
        $this->hash = $hash;
        $this->logger = new Logger('callback', 'BaseQueueCallbackHttp');
    }


    /**
     * @param string $url
     * @param array $payload
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $url, array $payload): bool
    {
        $uuid = (string)Uuid::uuid4();

        try {

            $datetime = Carbon::now()->format('ymdHis');

            // удаляем параметры с null значениями, т.к. HttpGuzzle не отрпавляет эти данные, иначе будет проблема хэшем
            $payload = array_filter($payload, function ($value) {
                return !is_null($value);
            });

            $client = new Client();
            $options = [
                'connect_timeout' => 50,
                'form_params' => [
                    'payload' => $payload,
                    'hash' => $this->hash->make($datetime, $payload),
                    'datetime' => $datetime,
                ],
            ];

            $this->logger->info(sprintf('Request - %s; url=%s; payload=%s', $uuid, $url, json_encode($options)));
            $response = $client->request($this->method, $url, $options);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->logger->info(sprintf('Response - %s; url=%s; payload=%s', $uuid, $url, $response->getBody()));

            $result = ($response->getStatusCode() === 200 && $data['success'] === true);

            return $result;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Request - %s; url=%s; payload=%s; message=%s; trace=%s;', $uuid, $url, json_encode($payload), $e->getMessage(), $e->getTraceAsString()));
            return false;
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('Request - %s; url=%s; payload=%s; message=%s; trace=%s;', $uuid, $url, json_encode($payload), $e->getMessage(), $e->getTraceAsString()));
            return false;
        }


    }
}