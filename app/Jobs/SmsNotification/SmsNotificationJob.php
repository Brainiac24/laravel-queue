<?php

namespace App\Jobs\SmsNotification;

use App\Jobs\ValidationRuleContract;
use App\Notifications\SmsNotification;
use App\Services\Common\Gateway\SMSTransporter\SMSTransporterRouteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsNotificationJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    public static function rules()
    {
        return [
            'to' => 'required|numeric',
            'message' => 'required',
            'sms_gateway' => 'nullable'
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SMSTransporterRouteService($this->data['to'], $this->data['sms_gateway']??"tcell"))->notify(new SmsNotification($this->data['message']));
    }

    public function tags()
    {
        return [$this->data['to']];
    }
}
