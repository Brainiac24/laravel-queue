<?php

namespace App\Services\Common\Gateway\BpcMtm;

use Carbon\Carbon;

class BpcMtmHelper
{
    const BPC_MTM_CARD_2_CARD_JOB = 'BPC_MTM_CARD_2_CARD_JOB';
    const BPC_MTM_PAY_FROM_CARD_JOB = 'BPC_MTM_PAY_FROM_CARD_JOB';
    const BPC_MTM_FILL_CARD_JOB = 'BPC_MTM_FILL_CARD_JOB';
   
    public static function calculateDelay($attempts, $intervalNextTryAt) {
        return Carbon::now()->addSecond(($attempts * 2) * $intervalNextTryAt);
    }

}