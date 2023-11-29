<?php

namespace App\Jobs\AbsTransport\Cards;


use App\Jobs\CallbackJob;

class CardCheckStatusCallbackJob extends CallbackJob
{
    public $tries = 5;
}
