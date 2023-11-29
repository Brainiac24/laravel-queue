<?php

namespace App\Services\Queue;

use App\Services\Queue\Hash\QueueHash;
use App\Services\Queue\Hash\QueueHashContract;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueueHashContract::class, QueueHash::class);
    }
}
