<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 21.09.2018
 * Time: 15:17
 */

namespace App\Services\Common\Helpers;

use App\Services\Common\Helpers\XmlToArray;
use Carbon\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Helper
{
    /**
     * @param $filename
     * @return Logger
     * @throws \Exception
     */
    public static function changeLoggerHandler($filename)
    {
        $logger = new Logger('processing');
        $logger->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $filename, \Carbon\Carbon::now()->toDateString()), Logger::INFO));
        $logger->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/error-%s.log', storage_path(), $filename, \Carbon\Carbon::now()->toDateString()), Logger::ERROR));
        return $logger;
    }

    public static function xmlToArray(string $data)
    {
        return XmlToArray::convert($data);
    }

    public static function convertXmlToArray($data)
    {
        $content = mb_convert_encoding($data, "utf-8", "windows-1251");
//        $data= mb_convert_encoding($data, "windows-1251", "utf-8");
        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA, '', true);

        $json = json_encode($xml);
        $dataArray[$xml->getName()] = json_decode($json, true);

        return $dataArray;

//        return XmlToArray::convert((string)$data);
    }

    public static function data($session_id, $status, $response = null)
    {
        if (!is_array($response)) {
            $response = [
                'response' => $response,
            ];
        }

        return [
            'session_id' => $session_id,
            'status' => $status,
            'data' => $response,
        ];

    }

    public static function calculateDelay($attempts, $intervalNextTryAt)
    {
        return Carbon::now()->addSecond(($attempts * 2) * $intervalNextTryAt);
    }

    public static function utf8ize( $mixed ) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "windows-1251");
        }
        return $mixed;
    }
}
