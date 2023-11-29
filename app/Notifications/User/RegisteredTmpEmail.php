<?php

namespace App\Notifications\User;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredTmpEmail extends Notification
{
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
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        //return (new MailRegisteredTmpEmail($notifiable))->to($notifiable->tmp_email);
        $notifiable->email = $notifiable->tmp_email;

        return (new MailMessage)
            ->subject('Подтверждения привязки почты')
            ->greeting("Здравствуйте, {$notifiable->full_name}")
            ->line(sprintf('Чтобы привязать почту в %s, введите одноразовый код:', config('app.name')))
            ->line($notifiable->email_code);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
