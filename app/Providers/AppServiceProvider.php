<?php

namespace App\Providers;

use App\Notifications\JobFailedNotification;
use App\Services\Common\Gateway\Slack\SlackRouteService;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    protected function loggerHandlerQueue($filename)
    {
        $logger = new Logger('');
        $logger->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/info-%s.log', storage_path(), $filename, \Carbon\Carbon::now()->toDateString()), Logger::INFO));
        $logger->pushHandler(new StreamHandler(sprintf('%s/logs/jobs/%s/error-%s.log', storage_path(), $filename, \Carbon\Carbon::now()->toDateString()), Logger::ERROR));
        return $logger;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Horizon::auth(function ($request) {

            $logger = $this->loggerHandlerQueue('ip');
            $logger->info($request->getClientIp());

            if (!in_array($request->getClientIp(), config('queue_exchange.allowed_for_dashboard')))
                die('ip not allowed');

            return true;
        });

        Queue::failing(function (JobFailed $event) {

            $eventData = [];
            $eventData['connectionName'] = $event->connectionName;
            $eventData['job'] = $event->job->resolveName();
            $eventData['queue'] = $event->job->getQueue();
            $eventData['tags'] = json_encode($event->job->payload()['tags'], JSON_UNESCAPED_UNICODE);
            $eventData['command'] = $event->job->payload()['data']['commandName'];
//            $eventData['payload'] = json_encode($event->job->payload()['data'], JSON_UNESCAPED_UNICODE);
            $eventData['exception'] = [];
            $eventData['exception']['message'] = $event->exception->getMessage();
            $eventData['exception']['file'] = $event->exception->getFile();
            $eventData['exception']['line'] = $event->exception->getLine();

            // Get some details about the failed job
//            $job = unserialize($event->job->payload()['data']['command']);

            // Send slack notification of the failed job
            (new SlackRouteService())->notify(new JobFailedNotification($eventData));
        });

        Queue::before(function (JobProcessing $event) {
            $logger = $this->loggerHandlerQueue($event->job->getQueue());

            //$payload = json_encode($event->job->payload()['data']['command'], JSON_UNESCAPED_UNICODE);
            $tags = json_encode($event->job->payload()['tags'], JSON_UNESCAPED_UNICODE);

            $logger->info("Started Job: {$event->job->payload()['id']} 
Handler:{$event->job->payload()['data']['commandName']}
Queue:{$event->job->getQueue()}
Tags:{$tags}
Attempts:{$event->job->payload()['attempts']}
");
        });

        Queue::after(function (JobProcessed $event) {
            $logger = $this->loggerHandlerQueue($event->job->getQueue());

            $payload = json_encode($event->job->payload()['data'], JSON_UNESCAPED_UNICODE);
            $tags = json_encode($event->job->payload()['tags'], JSON_UNESCAPED_UNICODE);

            $logger->info("Finished Job: {$event->job->payload()['id']} 
Handler:{$event->job->payload()['data']['commandName']}
Queue:{$event->job->getQueue()}
Tags:{$tags}
Attempts:{$event->job->payload()['attempts']}
Payload:{$payload}
");

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
