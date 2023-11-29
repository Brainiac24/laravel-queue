<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class JobFailedNotification extends Notification
{
    use Queueable;

    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        Log::info('Sent slack notification for Backend');

        return (new SlackMessage())
            ->from('Queue APP')
            ->to('backend_errors')
            ->error()
            ->content('Queued job failed: ' . $this->event['job'])
            ->attachment(function ($attachment) {
                $attachment->title($this->event['exception']['message'])
                    ->fields([
//                        'ID' => $this->event['id'],
//                        'Name' => $this->event['name'],
                        'Queue' => $this->event['queue'],
                        'File' => $this->event['exception']['file'],
                        'Command' => $this->event['command'],
                        'Line' => $this->event['exception']['line'],
                        'Tags' => $this->event['tags'],
//                        'Payload' => $this->event['payload'],
                    ]);
            });
    }
}
