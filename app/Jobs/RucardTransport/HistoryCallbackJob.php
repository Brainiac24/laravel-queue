<?php

namespace App\Jobs\RucardTransport;


use App\Jobs\CallbackJob;

class HistoryCallbackJob extends CallbackJob
{
    public $tries = 5;
}
