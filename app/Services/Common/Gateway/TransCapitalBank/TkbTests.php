<?php

require_once("./TkbBaseEntity.php");
require_once("./TkbTransport.php");
require_once("./Apis/BindCard.php");
require_once("./Apis/GetOrderState.php");
require_once("./Apis/RegisterOrderFromRegisteredCard.php");

use App\Services\Common\Gateway\TransCapitalBank\Apis\BindCard;
use App\Services\Common\Gateway\TransCapitalBank\TkbTransport;

$tkbTransport = new TkbTransport();


//print_r($tkbTransport->send((new BindCard('uuid_1'))->getData()));
