<?php

namespace App\Services\Common\Gateway\TransCapitalBank;

class TkbBaseEntity implements ITkbRequest
{
    protected $data = [];

    public function getData() {
        return $this->data;
    }
}
