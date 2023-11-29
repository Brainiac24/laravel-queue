<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 17.04.2020
 * Time: 13:02
 */

namespace App\Services\Common\Gateway\Transfer\Requests;

use App\Services\Common\Gateway\Transfer\Base\TransferFromRuEntity;
use App\Services\Common\Gateway\Transfer\Helpers\RequestType;

class PaymentRequest extends TransferFromRuEntity
{
    function __construct( string $account,
                          float  $amount,
                          string $currency,
                          string $settlement_curr,
                          string $curr_rate,
                          string $pay_id,
                          string $pay_date,
                          string $card_type)
    {

        $this->setAction(RequestType::PAYMENT);

        $this->setAccount($account);

        $this->setAmount($amount);

        $this->setCurrency($currency);

        $this->setSettlement_curr($settlement_curr);

        $this->setCurr_rate($curr_rate);

        $this->setPay_id($pay_id);

        $this->setPay_date($pay_date);

        $this->setService_type("TKB");

        $this->setCard_type($card_type);
    }

}