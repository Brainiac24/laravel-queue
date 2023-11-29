<?php

namespace App\Jobs\TransCapitalBankJobs;


use App\Jobs\CallbackJob;

class GetBindCardStateCallbackJob extends CallbackJob
{
    public $tries = 50;
}
