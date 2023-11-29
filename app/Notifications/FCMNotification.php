<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FCMNotification extends Notification
{
    use Queueable;

    protected $content;
    protected $data;
    protected $priority;

    /**
     * Create a new notification instance.
     *
     * @param $content
     * @param $data
     * @param $priority
     * @return void
     */
    public function __construct(array $content, array $data = [], string $priority = FcmMessage::PRIORITY_NORMAL)
    {
        $this->content = $content;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFcm($notifiable)
    {
        $this->content['click_action']='notifications';
        $this->content['sound']='default';

        $message = new FcmMessage();
        $message->content($this->content)
            ->data($this->data)
            ->contentAvailable(true)
            ->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

        return $message;
    }
}
