<?php

namespace App\Jobs\RucardTransport;


use App\Jobs\RucardTransport\PayFromCardJob;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;

class CheckPayFromCardJob extends PayFromCardJob
{
    public function __construct($data)
    {
        $data['check_before'] = true;
        $data['check_mode'] = RequestType::PAY_FROM_CARD;
        parent::__construct($data);
    }
}
