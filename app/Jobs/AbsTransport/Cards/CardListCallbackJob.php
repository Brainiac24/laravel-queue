<?php

namespace App\Jobs\AbsTransport\Cards;


use App\Jobs\CallbackJob;

class CardListCallbackJob extends CallbackJob
{
    public $tries = 5;
}
