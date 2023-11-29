<?php

namespace App\Notifications\User;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnpinnedOldEmail extends Notification
{
    protected $email;

    /**
     * Create a new notification instance.
     *
     * @param $email
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
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
        $notifiable->email = $this->email;

        return (new MailMessage)
            ->subject('Смена почты')
            ->greeting("Здравствуйте, {$notifiable->full_name}")
            ->line("Ваша почта была откреплена от аккаунта {$notifiable->msisdn}");
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
