<?php

namespace App\Services\Common\Gateway\TransCapitalBank\Helpers;

class TkbStateHelper
{
    const CREDIT_SUCCESSED = 0;
    const IN_PROCESS = 1;
    const RESERVE_SUCCESSED = 2;
    const DEBET_SUCCESSED = 3;
    const PARTIAL_DEBET_RETURNED = 4;
    const FILL_DEBET_RETURNED = 5;
    const ERROR = 6;
    const DEBET_ORDER_CANCELED = 8;
}
