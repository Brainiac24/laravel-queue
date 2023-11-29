<?php

namespace App\Services\Common\Gateway\TransCapitalBank\Apis;

use App\Services\Common\Gateway\TransCapitalBank\TkbBaseEntity;

class BindCard extends TkbBaseEntity
{
    public function __construct($extId, $amount, $returnUrl)
    {
        $this->data = [
            'extId' => $extId,
            'amount' => $amount * 100,
            'returnUrl' => $returnUrl,
        ];
    }
}
