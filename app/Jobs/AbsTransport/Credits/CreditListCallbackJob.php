<?php

namespace App\Jobs\AbsTransport\Credits;


use App\Jobs\CallbackJob;

class CreditListCallbackJob extends CallbackJob
{
    public $tries = 5;
}
