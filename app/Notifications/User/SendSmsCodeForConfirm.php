<?php

namespace App\Notifications\User;

use App\Services\Common\Gateway\SMSTransporter\SmsTjChannel;
use Illuminate\Notifications\Notification;

class SendSmsCodeForConfirm extends Notification
{
    //use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsTjChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSmsTj($notifiable)
    {
        return sprintf('%s: %s - ваш код для подтверждения', config('app.name'), $notifiable->sms_code);
    }

}
