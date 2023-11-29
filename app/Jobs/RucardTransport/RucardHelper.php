<?php

namespace App\Jobs\RucardTransport;

use Carbon\Carbon;

class RucardHelper
{
    public static function data($session_id, $status, $status_id = null, $status_detail_id = null, $response = null, $balance = 0, $errors='')
    {

        $response =  [
            'session_id' => $session_id,
            'status' => $status,
            'data' => [
                'status_id' => $status_id,
                'status_detail_id' => $status_detail_id,
                'response' => $response,
                'balance' => $balance,
            ],
            'errors'=> $errors
        ];

        return self::utf8ize($response);

    }

    public static function calculateDelay($attempts, $intervalNextTryAt) {
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
