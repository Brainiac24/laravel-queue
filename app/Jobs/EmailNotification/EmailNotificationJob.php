<?php

namespace App\Jobs\EmailNotification;

use App\Jobs\ValidationRuleContract;
use App\Notifications\MailNotification;
use App\Services\Common\Gateway\MailTransport\MailTransportRouteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailNotificationJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * EmailNotificationJob constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function rules()
    {
        return [
            'email' => 'required|email',
            'subject' => 'required',
            'greeting' => 'required|nullable',
            'line' => 'required|array',
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new MailTransportRouteService($this->data['email']))->notify(new MailNotification($this->data['subject'], $this->data['greeting'], $this->data['line']));
    }

    public function tags()
    {
        return [$this->data['email']];
    }
}
