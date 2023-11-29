<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailNotification extends Notification
{
    use Queueable;

    protected $subject;
    protected $greeting;
    protected $line = [];
    protected $action = [];

    /**
     * MailNotification constructor.
     * @param $subject
     * @param $greeting
     * @param array $line
     * @param array $action
     */
    public function __construct(string $subject, string $greeting, array $line, array $action = [])
    {
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->line = $line;
        $this->action = $action;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage();
        $message->subject($this->subject)
            ->greeting($this->greeting);

        foreach ($this->line as $line) {
            $message->line($line);
        }

        return $message;
    }
}
