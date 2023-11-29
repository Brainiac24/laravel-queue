<?php

namespace App\Services\Common\Gateway\AbsTransport\Credits;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\Credits\Documents\DocumentEntity;
use App\Services\Common\Gateway\AbsTransport\Credits\Documents\DocumentService;
use App\Services\Common\Gateway\AbsTransport\Credits\CreditEntity;

class CreditService
{
    public $creditEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, CreditEntity $creditEntity)
    {
        $this->creditEntity = $creditEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function getDocumentService()
    {
        return new DocumentService($this->transportService, new DocumentEntity);
    }

    public function listRequest($sessionId, $userId) {

        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($this->creditEntity::EO_R_CREDITS_LIST);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($userId),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    
}
