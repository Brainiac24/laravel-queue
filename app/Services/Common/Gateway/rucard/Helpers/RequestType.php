<?php

namespace App\Services\Common\Gateway\Rucard\Helpers;


class RequestType
{
    const FILL_CARD = 1;
    const PAY_FROM_CARD = 2;
    const CONFIRM = 3;
    const CANCEL = 4;
    const CARD_2_CARD = 5;
    const REFUND = 6;
    const CHECK_BALANCE = 7;
    const LOCK_UNLOCK = 8;
    const HISTORY = 9;
}