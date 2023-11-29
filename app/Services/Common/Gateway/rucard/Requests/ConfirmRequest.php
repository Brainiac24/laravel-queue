<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 25.02.2019
 * Time: 8:01
 */

namespace App\Services\Common\Gateway\Rucard\Requests;

use App\Services\Common\Gateway\Rucard\Base\RucardEntity;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;
use Carbon\Carbon;

class ConfirmRequest extends RucardEntity
{
    function __construct(int $stan,Carbon $date, int $requestType, string $pan, float $amount, int $curr) {

        $this->setOpt(RequestType::CONFIRM);

        $this->setStan($stan);
        
        $this->setPan($pan);

        $this->setAmount($amount);

        $this->setCurr($curr);

        $this->setDate($date);

        if($requestType == RequestType::FILL_CARD){
            $this->setNterm(config('rucard.nterm_fill'));
        }elseif($requestType == RequestType::PAY_FROM_CARD){
            $this->setNterm(config('rucard.nterm_payment'));
        }elseif($requestType == RequestType::CARD_2_CARD){
            $this->setNterm(config('rucard.nterm_card2card'));
        }
    }
}