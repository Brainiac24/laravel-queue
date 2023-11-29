<?php

namespace App\Jobs\RucardTransport;


use App\Jobs\CallbackJob;

class CheckBalanceCallbackJob extends CallbackJob
{
    public $tries = 5;
}
