<?php

namespace App\Jobs\TransferFromRu;


use App\Jobs\CallbackJob;

class PaymentCallbackJob extends CallbackJob
{
    public $tries = 20;
}
