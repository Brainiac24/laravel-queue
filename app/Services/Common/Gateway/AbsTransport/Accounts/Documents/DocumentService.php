<?php

namespace App\Services\Common\Gateway\AbsTransport\Accounts\Documents;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\Accounts\Documents\DocumentEntity;

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

    public function createTransactionRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status
    )
    {
        return $this->createRequest(
            $sessionId,
            $user_id,
            $acc_number,
            $acc_code,
            $pan,
            $doc_id,
            $doc_num,
            $doc_datetime,
            $type,
            $curr_code,
            $curr_rate,
            $amount,
            $cont_amount,
            $cont_acc,
            $cont_acc_code,
            $cont_pan,
            $cont_user_id,
            $cont_name,
            $cont_curr_code,
            $cont_inn,
            $cont_bank_bic,
            $cont_bank_corr_acc,
            $cont_bank_name,
            $cont_bank_id,
            $purpose,
            $delimiter_purpose,
            $status,
            $this->documentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE
        );
    }

    public function createExchangeRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status
    )
    {
        return $this->createRequest(
            $sessionId,
            $user_id,
            $acc_number,
            $acc_code,
            $pan,
            $doc_id,
            $doc_num,
            $doc_datetime,
            $type,
            $curr_code,
            $curr_rate,
            $amount,
            $cont_amount,
            $cont_acc,
            $cont_acc_code,
            $cont_pan,
            $cont_user_id,
            $cont_name,
            $cont_curr_code,
            $cont_inn,
            $cont_bank_bic,
            $cont_bank_corr_acc,
            $cont_bank_name,
            $cont_bank_id,
            $purpose,
            $delimiter_purpose,
            $status,
            $this->documentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE
        );
    }



    public function liquidateTransactionRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status
    )
    {
        return $this->liquidateRequest(
            $sessionId,
            $user_id,
            $acc_number,
            $acc_code,
            $pan,
            $doc_id,
            $doc_num,
            $doc_datetime,
            $type,
            $curr_code,
            $curr_rate,
            $amount,
            $cont_amount,
            $cont_acc,
            $cont_acc_code,
            $cont_pan,
            $cont_user_id,
            $cont_name,
            $cont_curr_code,
            $cont_inn,
            $cont_bank_bic,
            $cont_bank_corr_acc,
            $cont_bank_name,
            $cont_bank_id,
            $purpose,
            $delimiter_purpose,
            $status,
            $this->documentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE
        );
    }

    public function liquidateExchangeRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status
    )
    {
        return $this->liquidateRequest(
            $sessionId,
            $user_id,
            $acc_number,
            $acc_code,
            $pan,
            $doc_id,
            $doc_num,
            $doc_datetime,
            $type,
            $curr_code,
            $curr_rate,
            $amount,
            $cont_amount,
            $cont_acc,
            $cont_acc_code,
            $cont_pan,
            $cont_user_id,
            $cont_name,
            $cont_curr_code,
            $cont_inn,
            $cont_bank_bic,
            $cont_bank_corr_acc,
            $cont_bank_name,
            $cont_bank_id,
            $purpose,
            $delimiter_purpose,
            $status,
            $this->documentEntity::EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE
        );
    }



    public function createRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status,
        $request_type
        ) {

        $documentEntity = $this->documentEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($request_type);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $accs = $accountEntity->getAccounts();
        $acc = $accountEntity->getAccount();
        $docs = $documentEntity->getDocuments();
        $doc = $documentEntity->getDocument();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $accs->child([
                        $acc->attr([
                            $accountEntity->getAccNumber($acc_number),
                            $accountEntity->getAccCode($acc_code),
                            $accountEntity->getPan($pan),
                        ])->child([
                            $docs->child([
                                $doc->attr([
                                    $documentEntity->getDocId($doc_id),
                                    $documentEntity->getDocNum($doc_num),
                                    $documentEntity->getDocDatetime($doc_datetime),
                                    $documentEntity->getType($type),
                                    $documentEntity->getCurrCode($curr_code),
                                    $documentEntity->getCurrRate($curr_rate),
                                    $documentEntity->getAmount($amount),
                                    $documentEntity->getContAmount($cont_amount),
                                    $documentEntity->getContAcc($cont_acc),
                                    $documentEntity->getContAccCode($cont_acc_code),
                                    $documentEntity->getContPan($cont_pan),
                                    $documentEntity->getContUserId($cont_user_id),
                                    $documentEntity->getContName($cont_name),
                                    $documentEntity->getContCurrCode($cont_curr_code),
                                    $documentEntity->getContInn($cont_inn),
                                    $documentEntity->getContBankBic($cont_bank_bic),
                                    $documentEntity->getContBankCorrAcc($cont_bank_corr_acc),
                                    $documentEntity->getContBankName($cont_bank_name),
                                    $documentEntity->getContBankId($cont_bank_id),
                                    $documentEntity->getPurpose($purpose),
                                    $documentEntity->getDelimiterPurpose($delimiter_purpose),
                                    $documentEntity->getStatus($status),
                                ]),
                            ]),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

    public function liquidateRequest(
        $sessionId,
        $user_id,
        $acc_number,
        $acc_code,
        $pan,
        $doc_id,
        $doc_num,
        $doc_datetime,
        $type,
        $curr_code,
        $curr_rate,
        $amount,
        $cont_amount,
        $cont_acc,
        $cont_acc_code,
        $cont_pan,
        $cont_user_id,
        $cont_name,
        $cont_curr_code,
        $cont_inn,
        $cont_bank_bic,
        $cont_bank_corr_acc,
        $cont_bank_name,
        $cont_bank_id,
        $purpose,
        $delimiter_purpose,
        $status,
        $request_type) {

        $documentEntity = $this->documentEntity;
        $transportEntity = $this->transportService->transportEntity;

        $transportEntity->setSessionId($sessionId);
        $transportEntity->setType($request_type);

        $userEntity = $this->transportService->getUserService()->userEntity;
        $accountEntity = $this->transportService->getAccountService()->accountEntity;
        $users = $userEntity->getUsers();
        $user = $userEntity->getUser();
        $accs = $accountEntity->getAccounts();
        $acc = $accountEntity->getAccount();
        $docs = $documentEntity->getDocuments();
        $doc = $documentEntity->getDocument();

        $transportEntity->setData(
            $users->child([
                $user->attr([
                    $userEntity->getId($user_id),
                ])->child([
                    $accs->child([
                        $acc->attr([
                            $accountEntity->getAccNumber($acc_number),
                            $accountEntity->getAccCode($acc_code),
                            $accountEntity->getPan($pan),
                        ])->child([
                            $docs->child([
                                $doc->attr([
                                    $documentEntity->getDocId($doc_id),
                                    $documentEntity->getDocNum($doc_num),
                                    $documentEntity->getDocDatetime($doc_datetime),
                                    $documentEntity->getType($type),
                                    $documentEntity->getCurrCode($curr_code),
                                    $documentEntity->getCurrRate($curr_rate),
                                    $documentEntity->getAmount($amount),
                                    $documentEntity->getContAmount($cont_amount),
                                    $documentEntity->getContAcc($cont_acc),
                                    $documentEntity->getContAccCode($cont_acc_code),
                                    $documentEntity->getContPan($cont_pan),
                                    $documentEntity->getContUserId($cont_user_id),
                                    $documentEntity->getContName($cont_name),
                                    $documentEntity->getContCurrCode($cont_curr_code),
                                    $documentEntity->getContInn($cont_inn),
                                    $documentEntity->getContBankBic($cont_bank_bic),
                                    $documentEntity->getContBankCorrAcc($cont_bank_corr_acc),
                                    $documentEntity->getContBankName($cont_bank_name),
                                    $documentEntity->getContBankId($cont_bank_id),
                                    $documentEntity->getPurpose($purpose),
                                    $documentEntity->getDelimiterPurpose($delimiter_purpose),
                                    $documentEntity->getStatus($status),
                                ]),
                            ]),
                        ]),
                    ]),
                ]),
            ])->toArray()
        );

        return $this->transportService->sendRequest();
    }

}
