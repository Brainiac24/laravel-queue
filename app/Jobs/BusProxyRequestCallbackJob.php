<?php

namespace App\Jobs;


use App\Jobs\CallbackJob;

class BusProxyRequestCallbackJob extends CallbackJob
{
    public $tries = 5;
}
