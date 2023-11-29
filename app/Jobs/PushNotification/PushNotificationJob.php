<?php

namespace App\Jobs\PushNotification;

use App\Jobs\ValidationRuleContract;
use App\Notifications\FCMNotification;
use App\Notifications\FCMToTopicNotification;
use App\Services\Common\Gateway\FCMMessage\FCMRouteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class PushNotificationJob implements ShouldQueue, ValidationRuleContract
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public static function rules()
    {
        return [
            'push_token' => 'required',
            'topic_name' => 'string|nullable',
            'content' => 'required|array',
            'content.title' => 'required|string',
            'content.body' => 'required|string',
            'content.sound' => 'nullable', // Optional
            'content.icon' => 'nullable', // Optional
            'content.click_action' => 'nullable', // Optional,
            'data' => 'array',
        ];
    }

    /**
     * Create a new job instance.
     *
     * @param $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     *
     */
    public function handle()
    {
        if (isset($this->data['topic_name']) && !empty($this->data['topic_name'])) {
            //if (!App::environment('local')) {
                (new FCMRouteService($this->data['push_token']))->notify(new FCMToTopicNotification($this->data['topic_name'], $this->data['content'], $this->data['data'] ?? []));
            //}
        } else {
            (new FCMRouteService($this->data['push_token']))->notify(new FCMNotification($this->data['content'], $this->data['data'] ?? []));
        }


    }

    public function tags()
    {
        return [$this->data['content']['body']];
    }
}
