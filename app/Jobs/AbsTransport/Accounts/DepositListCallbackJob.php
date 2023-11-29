<?php

namespace App\Jobs\AbsTransport\Accounts;


use App\Jobs\CallbackJob;

class DepositListCallbackJob extends CallbackJob
{
    public $tries = 5;
}
