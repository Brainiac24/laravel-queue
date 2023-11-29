<?php

namespace App\Jobs\RucardTransport;

use App\Services\Common\Gateway\Rucard\Requests\RefundRequest;
use App\Services\Common\Gateway\Rucard\Rucard;
use App\Services\Common\Helpers\Logger\Logger;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $logger;
    public $log_name = 'ClassNotSet';

    public $tries = 1;
    public $timeout = 60;
    public $errors = '';
    protected $response = null;
    protected $options = null;
    protected $session_id = null;
    protected $res_data = null;

    public function __construct($data)
    {
        $this->data = $data;
        $this->session_id = $this->data['session_id']??null;
        $this->logger = new Logger('gateways/rucard', 'RUCARD_TRANSPORT');
        $this->log_name = get_class($this);
    }

    public static function rules()
    {
        return [
            'session_id' => 'required|alpha_dash',
            'gateway' => 'required|string',
            'pan' => 'required|digits_between:16,20',
            'from.amount' => 'required|numeric',
            'stan' => 'required|integer',
            'date' => 'required|date_format:ymdHis',
            'curr' => 'required|integer',
            'orig_stan' => 'required|integer',
            'orig_date' => 'required|date_format:ymdHis',
            'comment' => 'required|string',
        ];
    }

    public function handle(Rucard $transport)
    {
        $data = new RefundRequest(
            $this->data['pan'],
            $this->data['amount'],
            $this->data['stan'],
            Carbon::parse($this->data['date']),
            $this->data['curr'],
            $this->data['orig_stan'],
            Carbon::parse($this->data['orig_date']),
            $this->data['comment']
        );
        //$result = $this->transport->send($data);
    }

    public function tags()
    {
        return [$this->data['session_id']];
    }
}
