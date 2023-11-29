<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 16.04.2020
 * Time: 12:56
 */

namespace App\Services\Common\Gateway\Transfer\Requests;

use App\Services\Common\Gateway\Transfer\Base\TransferFromRuEntity;
use App\Services\Common\Gateway\Transfer\Helpers\RequestType;

class GetClientInfoRequest extends TransferFromRuEntity
{

    function __construct( string $account,
                          float  $amount,
                          string $currency,
                          string $settlement_curr)
    {

        $this->setAction(RequestType::GET_CLIENT_INFO);

        $this->setAccount($account);

        $this->setAmount($amount);

        $this->setCurrency($currency);

        $this->setSettlement_curr($settlement_curr);

        $this->setService_type("TKB");
    }


}