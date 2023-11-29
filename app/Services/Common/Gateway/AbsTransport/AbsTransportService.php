<?php

namespace App\Services\Common\Gateway\AbsTransport;

use App\Services\Common\Gateway\AbsTransport\AbsTransportBaseService;
use App\Services\Common\Gateway\AbsTransport\Accounts\AccountEntity;
use App\Services\Common\Gateway\AbsTransport\Accounts\AccountService;
use App\Services\Common\Gateway\AbsTransport\Cards\CardEntity;
use App\Services\Common\Gateway\AbsTransport\Cards\CardService;
use App\Services\Common\Gateway\AbsTransport\Credits\CreditEntity;
use App\Services\Common\Gateway\AbsTransport\Credits\CreditService;
use App\Services\Common\Gateway\AbsTransport\TransfersLid\TransfersLidEntity;
use App\Services\Common\Gateway\AbsTransport\TransfersLid\TransfersLidService;
use App\Services\Common\Gateway\AbsTransport\TransfersSoniya\TransfersSoniyaEntity;
use App\Services\Common\Gateway\AbsTransport\TransfersSoniya\TransfersSoniyaService;
use App\Services\Common\Gateway\AbsTransport\Users\UserEntity;
use App\Services\Common\Gateway\AbsTransport\Users\UserService;

class AbsTransportService extends AbsTransportBaseService
{

    public function getCardService()
    {
        return new CardService($this, new CardEntity);
    }

    public function getUserService()
    {
        return new UserService($this, new UserEntity);
    }

    public function getAccountService()
    {
        return new AccountService($this, new AccountEntity);
    }

    public function getTransfersLidService()
    {
        return new TransfersLidService($this, new TransfersLidEntity);
    }

    public function getTransfersSoniyaService()
    {
        return new TransfersSoniyaService($this, new TransfersSoniyaEntity);
    }

    public function getCreditService()
    {
        return new CreditService($this, new CreditEntity);
    }

}
