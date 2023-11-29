<?php

namespace App\Services\Common\Gateway\AbsTransport\Credits\Documents;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\Credits\Documents\DocumentEntity;

class DocumentService
{
    public $documentEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, DocumentEntity $documentEntity)
    {
        $this->documentEntity = $documentEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function factListRequest($sessionId, $user_id, $credit_id) {

        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($this->documentEntity::EO_R_CREDITS_ITEM_TRANSACTIONS_FACT);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $creditEntity = $this->transportService->getCreditService()->creditEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $credits = $creditEntity->getCredits();
        $credit = $creditEntity->getCredit();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $credits->child([
                        $credit->attr([
                            $creditEntity->getId($credit_id),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function planListRequest($sessionId, $user_id, $credit_id) {

        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($this->documentEntity::EO_R_CREDITS_ITEM_TRANSACTIONS_PLAN);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $creditEntity = $this->transportService->getCreditService()->creditEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $credits = $creditEntity->getCredits();
        $credit = $creditEntity->getCredit();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $credits->child([
                        $credit->attr([
                            $creditEntity->getId($credit_id),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    

}
