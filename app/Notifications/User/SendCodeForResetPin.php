<?php

namespace App\Notifications\User;

use App\Services\Common\Gateway\SMSTransporter\SmsTjChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCodeForResetPin extends Notification
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
        return empty($notifiable->email) ? [SmsTjChannel::class] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSmsTj($notifiable)
    {
        return sprintf('%s: %s- ваш код для подтверждения', config('app.name'), $notifiable->sms_code);
    }

    public function toMail($notifiable)
    {
        //return (new MailRegisteredTmpEmail($notifiable))->to($notifiable->tmp_email);
        //$notifiable->email = $notifiable->tmp_email;

        return (new MailMessage)
            ->subject('Подтверждения сброса пин-кода')
            ->greeting("Здравствуйте, {$notifiable->full_name}")
            ->line(sprintf('Чтобы сбросить пин-код в %s, введите одноразовый код:', config('app.name')))
            ->line($notifiable->email_code);
    }

}
