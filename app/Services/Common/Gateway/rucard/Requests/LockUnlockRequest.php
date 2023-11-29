<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:43
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class LockUnlockRequest extends RucardEntity
{
    function __construct(string $pan,int $exp,int $stan,Carbon $date,int $block,int $curr) {

        $this->setOpt(RequestType::LOCK_UNLOCK);

        $this->setPan($pan);

        $this->setExp($exp);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_balance'));

        $this->setBlock($block);

        $this->setCurr($curr);
    }
}