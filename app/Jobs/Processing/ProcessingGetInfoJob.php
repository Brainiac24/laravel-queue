<?php

namespace App\Jobs\Processing;

use App\Jobs\ValidationRuleContract;
use App\Services\Common\Gateway\Processing\ProcessingTransport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ProcessingGetInfoJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $intervalNextTryAt = 5;


    /**
     * ProcessingTransactionJob constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function rules()
    {
        return [
            'session_number' => 'required|numeric',
            'amount' => 'required|numeric|max:10000',
            'processing_code' => 'required|integer',
            'account' => 'required',
        ];
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
//        $this->changeLoggerHandler();

        $processingTransport = new ProcessingTransport();

        $result = $processingTransport->check($this->data['session_number'], $this->data['amount'], $this->data['processing_code'], $this->data['account']);

        return $result['info'];
    }


    public function tags()
    {
        return [TransactionStatus::getText($this->data['status']), $this->data['session_number']];
    }

    protected function changeLoggerHandler()
    {
        app()->configureMonologUsing(function ($monolog) {
            $monolog->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $this->job->getQueue(), \Carbon\Carbon::now()->toDateString()), Logger::INFO));
            $monolog->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $this->job->getQueue(), \Carbon\Carbon::now()->toDateString()), Logger::ERROR));
        });
    }
}
