<?php

namespace App\Providers;

use App\Services\Common\Helpers\Logger\Logger;
use App\Services\Common\Helpers\Logger\LoggerContract;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
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
        $this->registerBindRepositories();
        $this->registerBindServices();
    }

    public function registerBindRepositories()
    {
        //binding repository
    }

    public function registerBindServices()
    {
        $this->app->bind(LoggerContract::class, Logger::class);
    }
}
