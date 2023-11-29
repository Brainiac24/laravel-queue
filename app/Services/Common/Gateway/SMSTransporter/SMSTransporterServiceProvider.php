<?php

namespace App\Services\Common\Gateway\SMSTransporter;

use Illuminate\Support\ServiceProvider;
use App\Services\Common\Gateway\SMSTransporter\SMSTransporterContract;
use App\Services\Common\Gateway\SMSTransporter\SMSTransporter;

class SMSTransporterServiceProvider extends ServiceProvider
{
    protected $defer = true;

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
        $this->app->bind(SMSTransporterContract::class, SMSTransporter::class);
    }

    public function provides()
    {
        return [SMSTransporterContract::class];
    }
}
