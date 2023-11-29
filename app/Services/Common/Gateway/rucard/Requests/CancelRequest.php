<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:10
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class CancelRequest extends RucardEntity
{
    function __construct(int $stan, Carbon $date, string $pan, float  $amount, int $curr, int $requestType) {

        $this->setOpt(RequestType::CANCEL);

        $this->setStan($stan);

        $this->setDate($date);

        if($requestType == RequestType::FILL_CARD){
            $this->setNterm(config('rucard.nterm_fill'));
        }elseif($requestType == RequestType::PAY_FROM_CARD){
            $this->setNterm(config('rucard.nterm_payment'));
        }elseif($requestType == RequestType::CARD_2_CARD){
            $this->setNterm(config('rucard.nterm_card2card'));
        }




        $this->setPan($pan);

        $this->setAmount($amount);

        $this->setCurr($curr);
    }
}