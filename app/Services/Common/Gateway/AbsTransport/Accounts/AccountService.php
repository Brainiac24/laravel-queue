<?php

namespace App\Services\Common\Gateway\AbsTransport\Accounts;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\Accounts\AccountEntity;
use App\Services\Common\Gateway\AbsTransport\Accounts\Documents\DocumentEntity;
use App\Services\Common\Gateway\AbsTransport\Accounts\Documents\DocumentService;
use App\Services\Common\Gateway\AbsTransport\Accounts\Documents\DocumentServiceV2;

class AccountService
{
    public $accountEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, AccountEntity $accountEntity)
    {
        $this->accountEntity = $accountEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function getDocumentService()
    {
        return new DocumentService($this->transportService, new DocumentEntity);
    }
    public function getDocumentServiceV2()
    {
        return new DocumentServiceV2($this->transportService, new DocumentEntity);
    }

    public function DepositListRequest($sessionId, $user_id) {
        return $this->ListRequest($this->accountEntity::EO_R_DEPOSITS_LIST, $sessionId, $user_id);
    }

    public function AccountListRequest($sessionId, $user_id) {
        return $this->ListRequest($this->accountEntity::EO_R_ACCOUNTS_LIST, $sessionId, $user_id);
    }

    public function listRequest($type, $sessionId, $user_id) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($type);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $accs = $accountEntity->getAccounts();
        $acc = $accountEntity->getAccount();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function DepositTransactionListRequest($sessionId, $user_id, $acc_number, $date_start, $date_end) {

        return $this->TransactionListRequest($this->accountEntity::EO_R_DEPOSITS_ITEM_TRANSACTIONS, $sessionId, $user_id, $acc_number, $date_start, $date_end);
    }
    public function AccountTransactionListRequest($sessionId, $user_id, $acc_number, $date_start, $date_end) {

        return $this->TransactionListRequest($this->accountEntity::EO_R_ACCOUNTS_ITEM_TRANSACTIONS, $sessionId, $user_id, $acc_number, $date_start, $date_end);
    }

    public function TransactionListRequest($type, $sessionId, $user_id, $acc_number, $date_start, $date_end) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($type);
        $transportEntity->setDateStart($date_start);
        $transportEntity->setDateEnd($date_end);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $accs = $accountEntity->getAccounts();
        $acc = $accountEntity->getAccount();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $accs->child([
                        $acc->attr([
                            $accountEntity->getAccNumber($acc_number),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function CreateDeposit(
        $sessionId,
        $user_create_id,
        $client_id,
        $payer_id,
        $date_begin,
        $period,
        $time_interval,
        $vid_dog,
        $summa_dog,
        $fintool,
        $acc_return,
        $acc_enrol_prc,
        $period_calc_prc,
        $open_acc_enrol_prc
        ) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $accountEntity = $this->transportService->getAccountService()->accountEntity;


        $e = $transportEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('abs.protocol_version')),
                    $e->getType($this->accountEntity::R_CR_DOG_DEPN),
                    $accountEntity->getUser_create_id($user_create_id),
                    $accountEntity->getClient_id($client_id),
                    $accountEntity->getPayer_id($payer_id),
                    $accountEntity->getDate_begin($date_begin),
                    $accountEntity->getPeriod($period),
                    $accountEntity->getTime_interval($time_interval),
                    $accountEntity->getVid_dog($vid_dog),
                    $accountEntity->getSumma_dog($summa_dog),
                    $accountEntity->getFintool($fintool),
                    $accountEntity->getAcc_return($acc_return),
                    $accountEntity->getAcc_enrol_prc($acc_enrol_prc),
                    $accountEntity->getPeriod_calc_prc($period_calc_prc),
                    $accountEntity->getOpen_acc_enrol_prc($open_acc_enrol_prc),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res);
    }

    public function CloseDeposit(
        $sessionId,
        $on_date,
        $dog_id,
        $user_accept_id, 
        $rate, // 0-моновалютные проводки; кросс курс - мултивалютных проводках
        $act_type,
        $client_acc_abs_id,
        $com_client_acc_abs_id
        ) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $accountEntity = $this->transportService->getAccountService()->accountEntity;

        $e = $transportEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res = $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('abs.protocol_version')),
                    $e->getType($this->accountEntity::R_DEPN_CLS_CRASH),
                    $accountEntity->getOn_date($on_date),
                    $accountEntity->getDog_id($dog_id),
                    $accountEntity->getUser_accept_id($user_accept_id),
                    $accountEntity->getRate($rate),
                    $accountEntity->getAct_type($act_type),
                    $accountEntity->getPay_ways()->child([
                        $accountEntity->getPay_way_type("cashless"),
                        $accountEntity->getPw_cashless()->child([
                            $accountEntity->getType("our_client"),
                            $accountEntity->getPw_transfer_our_client()->child([
                                $accountEntity->getClient_acc_abs_id($client_acc_abs_id),
                            ]),
                        ])
                    ]),
                    $accountEntity->getPay_ways_com()->child([
                        $accountEntity->getType_com("cashless"),
                        $accountEntity->getCom_client_acc_abs_id($com_client_acc_abs_id),
                    ])
                   
                ])->toArray();

        return $this->transportService->sendRequest($res);
    }

    public function CreateAccount(
        $sessionId,
        $client_abs_id,
        $kind,
        $create_user,
        $fintool
        ) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $accountEntity = $this->transportService->getAccountService()->accountEntity;


        $e = $transportEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('abs.protocol_version')),
                    $e->getType($this->accountEntity::R_CR_SBERACC_CL_PRIV),
                    $accountEntity->getClient_abs_id($client_abs_id),
                    $accountEntity->getKind($kind),
                    $accountEntity->getCreate_user($create_user),
                    $accountEntity->getFintool($fintool),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res);
    }



    public function DepositCodecRequest($sessionId, $user_id, $contract_id) {
        return $this->CodecRequest($this->accountEntity::EO_R_DEPOSITS_ITEM_CODEC, $sessionId, $user_id, $contract_id);
    }

    public function AccountCodecRequest($sessionId, $user_id, $contract_id) {
        return $this->CodecRequest($this->accountEntity::EO_R_ACCOUNTS_ITEM_CODEC, $sessionId, $user_id, $contract_id);
    }

    public function CodecRequest($type, $sessionId, $user_id, $contract_id) {

        $accountEntity = $this->accountEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($type);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $accs = $accountEntity->getAccounts();
        $acc = $accountEntity->getAccount();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $accs->child([
                        $acc->attr([
                            $accountEntity->getContractId($contract_id)
                        ])
                    ])
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function ChangeDepositAccount($session_id, $depn_dog_abs_id, $prc_acc_abs_id)
    {
        $transportEntity = $this->transportService->transportEntity;

        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $head = $transportEntity->getHead();
        $request = $transportEntity->getRequest();

        $res =  $head->child([
                $transportEntity->getSessionId($session_id),
                $transportEntity->getCallbackUrl(),
            ])->toArray() +
            $request->child([
                $transportEntity->getProtocolVersion(config('abs.protocol_version')),
                $transportEntity->getType($this->accountEntity::R_ED_DEPN_DOG_CL_PRIV),
                $accountEntity->getDepnDogAbsId($depn_dog_abs_id),
                $accountEntity->getPrcAccAbsId($prc_acc_abs_id),

            ])->toArray();

        return $this->transportService->sendRequest($res);
    }


}
