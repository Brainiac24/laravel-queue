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

class FillCardRequest extends RucardEntity
{

    function __construct(string $pan,float $amount,int $stan,Carbon $date,float $fee,int $curr,string $comment=null) {

        $this->setOpt(RequestType::FILL_CARD);

        $this->setPan($pan);

        $this->setAmount($amount);

        $this->setStan($stan);

        $this->setDate($date);

        $this->setNterm(config('rucard.nterm_fill'));

        $this->setFee($fee);

        $this->setCurr($curr);

        $this->setComment($comment);
    }
}