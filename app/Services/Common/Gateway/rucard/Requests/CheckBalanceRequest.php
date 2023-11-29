<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:38
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class CheckBalanceRequest  extends RucardEntity
{
    function __construct(string $pan,int $exp,int $stan,Carbon $date,int $curr) {

        $this->setOpt(RequestType::CHECK_BALANCE);

        $this->setPan($pan);

        $this->setExp($exp);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_balance'));

        $this->setCurr($curr);
    }
}