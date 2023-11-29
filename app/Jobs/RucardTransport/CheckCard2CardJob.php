<?php

namespace App\Jobs\RucardTransport;

use App\Jobs\RucardTransport\Card2CardJob;
use App\Services\Common\Gateway\Rucard\Helpers\RequestType;

class CheckCard2CardJob extends Card2CardJob
{
    public function __construct($data)
    {
        $data['check_before'] = true;
        $data['check_mode'] = RequestType::CARD_2_CARD;
        parent::__construct($data);
    }
}
