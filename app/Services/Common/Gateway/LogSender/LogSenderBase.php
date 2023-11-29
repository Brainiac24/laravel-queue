<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 05.07.2019
 * Time: 9:47
 */

namespace App\Services\Common\Gateway\LogSender;


use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Ramsey\Uuid\Uuid;

abstract class LogSenderBase
{

    protected $log_name;
    protected $data;
    protected $url;
    private $apiKey;
    private $active;

    /**
     * LogSenderBase constructor.
     * @param $data
     * @throws \Exception
     */
    public function __construct($data)
    {
        $this->log_name = get_class($this);
        $this->data = $data;
        $this->active = config('log_sender_seq.active');
        $this->url = config('log_sender_seq.url');
        $this->apiKey = config('log_sender_seq.api_key');
        $this->logger = new Logger('gateways/logsender', 'log_sender');
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        if($this->active==false)
            return null;


        $data = null;
        $response = null;

        $uuid = (string)Uuid::uuid4();

        try {
            $client = new Client();

            $headers = [
                'Content-Type' => 'application/json; charset=UTF8;',
            ];

//            $options = [
//                'connect_timeout' => 5,
//                'json' => (isset($this->data['Class']) && strpos(strtolower($this->data['Class']), "rucard")!==false) ? $this->utf8ize($this->data) : $this->data,
//            ];

            $options = [
                'timeout' => 5,
                'connect_timeout' => 5,
                'json' => $this->data,
            ];

            $slog = [
                'class ' => $this->log_name,
                'uuid' => $uuid,
                'data' => json_encode($this->utf8ize($this->data), JSON_UNESCAPED_UNICODE),
            ];

            $this->logger->info(json_encode($slog,JSON_UNESCAPED_UNICODE),[] , false);
            //dd(json_encode($options));
            $response = $client->post(sprintf('%s?apiKey=%s', $this->url, $this->apiKey), $options);
            $data = (string)$response->getBody();

        } catch (ConnectException $conEx) {
            $slog = [
                'class' => $this->log_name,
                'uuid' => $uuid,
                'url' => $this->url,
                'status_code' => (empty($response) ? null : $response->getStatusCode()),
                'message' => $conEx->getMessage(),
                'exception' => $conEx->getTraceAsString(),
                'data' => json_encode($this->data,JSON_UNESCAPED_UNICODE),
            ];

            $this->logger->error(json_encode($slog,JSON_UNESCAPED_UNICODE), [], false);

        } catch (\Throwable $e) {
            $slog = [
                'class' => $this->log_name,
                'uuid' => $uuid,
                'url' => $this->url,
                'message' => $e->getMessage(),
                'exception' => $e->getTraceAsString(),
                'data' => json_encode($this->data),
            ];

            $this->logger->error(json_encode($slog,JSON_UNESCAPED_UNICODE),[], false);

        }
    }

    public function utf8ize( $mixed ) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "windows-1251");
        }
        return $mixed;
    }
}