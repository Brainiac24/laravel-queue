<?php

namespace App\Jobs\AbsTransport\Accounts;


use App\Jobs\CallbackJob;

class AccountListCallbackJob extends CallbackJob
{
    public $tries = 5;
}
