<?php

namespace App\Services\Common\Gateway\TransCapitalBank\Apis;

use App\Services\Common\Gateway\TransCapitalBank\TkbBaseEntity;

class GetOrderState extends TkbBaseEntity
{
    public function __construct($extId)
    {
        $this->data = [
            'extId' => $extId
        ];
    }
}
