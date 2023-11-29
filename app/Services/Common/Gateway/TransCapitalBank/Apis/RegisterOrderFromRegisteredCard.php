<?php

namespace App\Services\Common\Gateway\TransCapitalBank\Apis;

use App\Services\Common\Gateway\TransCapitalBank\TkbBaseEntity;

class RegisterOrderFromRegisteredCard extends TkbBaseEntity
{
    public function __construct($extId, $cardRefId, $amount, $description, $returnUrl)
    {
        $this->data = [
            'extId' => $extId,
            'cardRefId' => $cardRefId,
            'amount' => $amount * 100,
            'description' => $description,
            'returnUrl' => $returnUrl,
        ];
    }
}
