<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FCMToTopicNotification extends Notification
{
    use Queueable;

    protected $content;
    protected $data;
    protected $priority;
    private $topic_name;

    /**
     * Create a new notification instance.
     *
     * @param $topic_name
     * @param $content
     * @param $data
     * @param $priority
     * @return void
     */
    public function __construct($topic_name, array $content, array $data = [], string $priority = FcmMessage::PRIORITY_NORMAL)
    {
        $this->content = $content;
        $this->data = $data;
        $this->topic_name = $topic_name;
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
        $this->content['sound']='default';
        $this->content['click_action']='news';

        $message = new FcmMessage();
        $message->to($this->topic_name, $recipientIsTopic = true)
            //->content($this->content)
            //->data($this->data)
            ->data($this->content)
            ->contentAvailable(true)
            ->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

        return $message;
    }
}
