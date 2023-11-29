<?php

namespace App\Jobs;


use App\Jobs\CallbackJob;

class BusProxyProcessingCallbackJob extends CallbackJob
{
    public $tries = 222;
}
