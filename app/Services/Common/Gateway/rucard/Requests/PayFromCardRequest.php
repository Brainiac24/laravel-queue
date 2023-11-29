<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 20.02.2019
 * Time: 8:53
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class PayFromCardRequest extends RucardEntity
{

    function __construct(string $pan,
                         float  $amount,
                         int    $stan,
                         Carbon $date,
                         int    $curr,
                         int    $exp,
                         int    $cvv2 = null,
                         string $comment = null)
    {

        $this->setOpt(RequestType::PAY_FROM_CARD);

        $this->setPan($pan);

        $this->setAmount($amount);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_payment'));

        $this->setCurr($curr);

        $this->setExp($exp);

        //$this->setCvv2($cvv2);

        $this->setComment($comment);

        $this->setCheck(0);
    }
}