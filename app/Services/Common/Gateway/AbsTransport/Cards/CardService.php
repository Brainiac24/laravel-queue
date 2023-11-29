<?php

namespace App\Services\Common\Gateway\AbsTransport\Cards;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;

class CardService
{
    public $cardEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, CardEntity $cardEntity)
    {
        $this->cardEntity = $cardEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function searchRequest($sessionId, $pan, $exp_date)
    {
        //dd($this->transportService);
        $cardEntity = $this->cardEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($cardEntity::EO_R_CARDS_ITEM_SEARCH);

        $cardEntity->setPan($pan);
        $cardEntity->setExpDate($exp_date);

        $cards = $cardEntity->getCards();
        $card = $cardEntity->getCard();

        $transportEntity->setData(
            $cards->child([
                $card->attr([
                    $cardEntity->getPan(),
                    $cardEntity->getExpDate(),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function listRequest($sessionId, $userId)
    {
        $cardEntity = $this->cardEntity;
        $transportEntity = $this->transportService->transportEntity;
        //dd($this->transportService->getUserService());
        $userEntity = $this->transportService->getUserService()->userEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($cardEntity::EO_R_CARDS_LIST);

        $userEntity->setId($userId);

        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId(),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function listTransactionsRequest($sessionId, $userId, $date_start, $date_end)
    {
        $cardEntity = $this->cardEntity;
        $transportEntity = $this->transportService->transportEntity;
        $userEntity = $this->transportService->getUserService()->userEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($cardEntity::EO_R_CARDS_LIST_TRANSACTIONS);
        $transportEntity->setDateStart($date_start);
        $transportEntity->setDateEnd($date_end);

        $userEntity->setId($userId);

        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId(),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();

    }

    public function itemTransactionsRequest($sessionId, $userId, $card_pan, $date_start, $date_end)
    {

        $cardEntity = $this->cardEntity;
        $transportEntity = $this->transportService->transportEntity;
        $userEntity = $this->transportService->getUserService()->userEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($cardEntity::EO_R_CARDS_ITEM_TRANSACTIONS);
        $transportEntity->setDateStart($date_start);
        $transportEntity->setDateEnd($date_end);

        $userEntity->setId($userId);
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $cards = $cardEntity->getCards();
        $card = $cardEntity->getCard();
        $cardEntity->setPan($card_pan);

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId(),
                ])->child([
                    $cards->child([
                        $card->attr([
                            $cardEntity->getPan(),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();

    }

    public function createInsuranceAccountRequest($sessionId, $client_abs_id, $kind, $create_user, $fintool, $sum_dog)
    {
        $cardEntity = $this->cardEntity;
        $e = $this->transportService->transportEntity;

        $head = $e->getHead();
        $request = $e->getRequest();

        $res = $head->child([
            $e->getSessionId($sessionId),
            $e->getCallbackUrl(),
        ])->toArray() +
        $request->child([
            $e->getProtocolVersion(),
            $e->getType($cardEntity::R_CR_SBERACC_CL_PRIV),
            $cardEntity->getClientAbsId($client_abs_id),
            $cardEntity->getKind($kind),
            $cardEntity->getCreateUser($create_user),
            $cardEntity->getFintool($fintool),
            $cardEntity->getSumDog($sum_dog),
        ])->toArray();

        return $this->transportService->sendRequest($res);
    }

    public function orderCardRequest(
        $sessionId,
        $user_create_id,
        $client_id,
        $date_begin,
        $card_type_id,
        $emb_family,
        $emb_name,
        $secret_word,
        $card_product_id,
        $delivery_branch_id,
        $tariff_id,
        $vid_dog_id,
        $fintool_id
    ) {
        $cardEntity = $this->cardEntity;
        $e = $this->transportService->transportEntity;

        $head = $e->getHead();
        $request = $e->getRequest();

        $res = $head->child([
            $e->getSessionId($sessionId),
            $e->getCallbackUrl(),
        ])->toArray() +
        $request->child([
            $e->getProtocolVersion(),
            $e->getType($cardEntity::R_CR_PS_CARD),
            $cardEntity->getUserCreateId($user_create_id),
            $cardEntity->getClientId($client_id),
            $cardEntity->getDateBegin($date_begin),
            $cardEntity->getCardTypeId($card_type_id),
            $cardEntity->getEmbFamily($emb_family),
            $cardEntity->getEmbName($emb_name),
            $cardEntity->getSecretWord($secret_word),
            $cardEntity->getCardProductId($card_product_id),
            $cardEntity->getDeliveryBranchId($delivery_branch_id),
            $cardEntity->getTariffId($tariff_id),
            $cardEntity->getDepn()->child([
                $cardEntity->getDepnId(),
                $cardEntity->getVidDogId($vid_dog_id),
                $cardEntity->getFintoolId($fintool_id),
            ]),
            $cardEntity->getCardPan(),
        ])->toArray();

        return $this->transportService->sendRequest($res);
    }

    public function checkCardStatusRequest($sessionId, $card_id)
    {
        $cardEntity = $this->cardEntity;
        $e = $this->transportService->transportEntity;

        $head = $e->getHead();
        $request = $e->getRequest();

        $res = $head->child([
            $e->getSessionId($sessionId),
            $e->getCallbackUrl(),
        ])->toArray() +
        $request->child([
            $e->getProtocolVersion(),
            $e->getType($cardEntity::R_GET_INFO_PS_CARD),
            $cardEntity->getCardId($card_id),
        ])->toArray();

        return $this->transportService->sendRequest($res);
    }

}
