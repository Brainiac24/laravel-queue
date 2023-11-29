<?php

namespace App\Jobs\RucardTransport;


use App\Jobs\CallbackJob;

class LockUnlockCallbackJob extends CallbackJob
{
    public $tries = 5;
}
