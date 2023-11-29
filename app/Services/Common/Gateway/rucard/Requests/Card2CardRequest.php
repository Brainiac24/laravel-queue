<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:14
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class Card2CardRequest extends RucardEntity
{

    function __construct(string $pan,
                        int $exp,
                         float  $amount,
                         int    $stan,
                         Carbon $date,
                         int    $curr,
                         string $c_pan,
                         float  $fee,
                         string $comment = null,
                         string $c_comment = null,
                         int    $check = null)
    {

        $this->setOpt(RequestType::CARD_2_CARD);

        $this->setPan($pan);

        $this->setExp($exp);

        $this->setAmount($amount);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_card2card'));

        $this->setCurr($curr);

        $this->setC_pan($c_pan);

        $this->setFee($fee);

        $this->setComment($comment);

        $this->setC_comment($c_comment);

        $this->setCheck($check);
    }

}