<?php

namespace App\Jobs\AbsTransport\Accounts;

use Carbon\Carbon;

class AbsHelper
{
    public static function data($session_id, $status, $status_id = null, $status_detail_id = null, $response = null, $balance = null, $transaction_id = null, $is_bus_responded = null)
    {

        return [
            'session_id' => $session_id,
            'status' => $status,
            'data' => [
                'status_id' => $status_id,
                'status_detail_id' => $status_detail_id,
                'response' => $response,
                'balance' => $balance,
                'transaction_id' => $transaction_id,
                'is_bus_responded' => $is_bus_responded,
            ],
        ];

    }

    public static function calculateDelay($attempts, $intervalNextTryAt) {
        return Carbon::now()->addSecond(($attempts * 2) * $intervalNextTryAt);
    }
}