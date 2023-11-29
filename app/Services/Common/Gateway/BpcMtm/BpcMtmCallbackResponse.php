<?php
namespace App\Services\Common\Gateway\BpcMtm;

use Carbon\Carbon;



class BpcMtmCallbackResponse
{

    public $session_id;
    public $status;
    public $response_code;
    public $processing_code;
    public $system_trace_audit_number;
    public $local_transaction_date;
    public $rrn;
    public $authorization_id_response;
    public $balance;
    public $card_status;
    public $transaction_date;
    public $response;
    public $parent_response;
    public $status_id;
    public $status_detail_id;
    public $history_transactions;

    public function getData()
    {

        return [
            'session_id' => $this->session_id,
            'status' => $this->status,
            'data' => [
                'status_id' => $this->status_id,
                'status_detail_id' => $this->status_detail_id,
                'response_code' => $this->response_code,
                'processing_code' => $this->processing_code,
                'system_trace_audit_number' => $this->system_trace_audit_number,
                'local_transaction_date' => $this->local_transaction_date,
                'rrn' => $this->rrn,
                'authorization_id_response' => $this->authorization_id_response,
                'balance' => $this->balance,
                'card_status' => $this->card_status,
                'transaction_date' => $this->transaction_date,
                'response' => $this->response,
                'parent_response' => $this->parent_response,
                'history_transactions' => $this->history_transactions,
            ],
        ];

    }

    public static function calculateDelay($attempts, $intervalNextTryAt) {
        return Carbon::now()->addSecond(($attempts * 2) * $intervalNextTryAt);
    }

}