<?php

namespace App\Notifications;

use App\Services\Common\Gateway\SMSTransporter\SmsTjChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param $to
     * @param $message
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
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
        return $this->message;
    }
}
