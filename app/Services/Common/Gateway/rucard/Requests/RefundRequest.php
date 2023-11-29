<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:30
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class RefundRequest extends RucardEntity
{
    function __construct(string $pan,
                         float  $amount,
                         int    $stan,
                         Carbon $date,
                         int    $curr,
                         int    $orig_stan = null,
                         Carbon $orig_date = null,
                         string $comment = null)
    {

        $this->setOpt(RequestType::REFUND);

        $this->setPan($pan);

        $this->setAmount($amount);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_payment'));

        $this->setCurr($curr);

        $this->setOrig_stan($orig_stan);

        $this->setOrig_date($orig_date);

        $this->setOrig_nterm(config('rucard.nterm_payment'));

        $this->setComment($comment);
    }

}