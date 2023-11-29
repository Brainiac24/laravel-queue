<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\RucardTransport\FillCardJob;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;

class CheckFillCardJob extends FillCardJob
{
    public function __construct($data)
    {
        $data['check_before'] = true;
        $data['check_mode'] = RequestType::FILL_CARD;
        parent::__construct($data);
    }
}