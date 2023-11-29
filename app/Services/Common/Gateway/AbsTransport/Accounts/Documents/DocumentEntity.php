<?php

namespace App\Services\Common\Gateway\AbsTransport\Accounts\Documents;

use App\Services\Common\Gateway\AbsTransport\TagEntity;

class DocumentEntity
{

    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE';

    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_V2 = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_V2';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE_V2 = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_LIQUIDATE_V2';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_V2 = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_V2';
    const EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE_V2 = 'EO_W_ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE_EXCHANGE_LIQUIDATE_V2';
    const EO_R_PAY_CREDIT = 'EO_R_PAY_CREDIT';
    const EO_R_PAY_OVERDRAFT = 'EO_R_PAY_OVERDRAFT';

    private $documents;
    private $document;
    private $doc_id;
    private $doc_num;
    private $doc_datetime;
    private $type;
    private $curr_code;
    private $curr_rate;
    private $amount;
    private $cont_amount;
    private $cont_acc;
    private $cont_acc_code;
    private $cont_pan;
    private $cont_user_id;
    private $cont_name;
    private $cont_curr_code;
    private $cont_inn;
    private $cont_bank_bic;
    private $cont_bank_corr_acc;
    private $cont_bank_name;
    private $cont_bank_id;
    private $purpose;
    private $delimiter_purpose;
    private $status;

    public function __construct()
    {
        $this->documents = TagEntity::new ('documents');
        $this->document = TagEntity::new ('document');
        $this->doc_id = TagEntity::new ('doc_id');
        $this->doc_num = TagEntity::new ('doc_num');
        $this->doc_datetime = TagEntity::new ('doc_datetime');
        $this->type = TagEntity::new ('type');
        $this->curr_code = TagEntity::new ('curr_code');
        $this->curr_rate = TagEntity::new ('curr_rate');
        $this->amount = TagEntity::new ('amount');
        $this->cont_amount = TagEntity::new ('cont_amount');
        $this->cont_acc = TagEntity::new ('cont_acc');
        $this->cont_acc_code = TagEntity::new ('cont_acc_code');
        $this->cont_pan = TagEntity::new ('cont_pan');
        $this->cont_user_id = TagEntity::new ('cont_user_id');
        $this->cont_name = TagEntity::new ('cont_name');
        $this->cont_curr_code = TagEntity::new ('cont_curr_code');
        $this->cont_inn = TagEntity::new ('cont_inn');
        $this->cont_bank_bic = TagEntity::new ('cont_bank_bic');
        $this->cont_bank_corr_acc = TagEntity::new ('cont_bank_corr_acc');
        $this->cont_bank_name = TagEntity::new ('cont_bank_name');
        $this->cont_bank_id = TagEntity::new ('cont_bank_id');
        $this->purpose = TagEntity::new ('purpose');
        $this->delimiter_purpose = TagEntity::new ('delimiter_purpose');
        $this->status = TagEntity::new ('status');
    }

    public function getDocuments($documents=null)
    {
        empty($documents)?:$this->documents->setValue($documents);
        return $this->documents;
    }

    public function setDocuments($documents)
    {
        $this->documents->setValue($documents);
    }

    public function getDocument($document=null)
    {
        empty($document)?:$this->document->setValue($document);
        return $this->document;
    }

    public function setDocument($document)
    {
        $this->document->setValue($document);
    }

    public function getDocId($doc_id=null)
    {
        empty($doc_id)?:$this->doc_id->setValue($doc_id);
        return $this->doc_id;
    }

    public function setDocId($doc_id)
    {
        $this->doc_id->setValue($doc_id);
    }

    public function getDocNum($doc_num=null)
    {
        empty($doc_num)?:$this->doc_num->setValue($doc_num);
        return $this->doc_num;
    }

    public function setDocNum($doc_num)
    {
        $this->doc_num->setValue($doc_num);
    }

    public function getDocDatetime($doc_datetime=null)
    {
        empty($doc_datetime)?:$this->doc_datetime->setValue($doc_datetime);
        return $this->doc_datetime;
    }

    public function setDocDatetime($doc_datetime)
    {
        $this->doc_datetime->setValue($doc_datetime);
    }

    public function getType($type=null)
    {
        empty($type)?:$this->type->setValue($type);
        return $this->type;
    }

    public function setType($type)
    {
        $this->type->setValue($type);
    }

    public function getCurrCode($curr_code=null)
    {
        empty($curr_code)?:$this->curr_code->setValue($curr_code);
        return $this->curr_code;
    }

    public function setCurrCode($curr_code)
    {
        $this->curr_code->setValue($curr_code);
    }

    public function getAmount($amount=null)
    {
        empty($amount)?:$this->amount->setValue($amount);
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount->setValue($amount);
    }

    public function getContAmount($cont_amount=null)
    {
        empty($cont_amount)?:$this->cont_amount->setValue($cont_amount);
        return $this->cont_amount;
    }

    public function setContAmount($cont_amount)
    {
        $this->cont_amount->setValue($cont_amount);
    }

    public function getContAcc($cont_acc=null)
    {
        $cont_acc===null?:$this->cont_acc->setValue($cont_acc);
        return $this->cont_acc;
    }

    public function setContAcc($cont_acc)
    {
        $this->cont_acc->setValue($cont_acc);
    }

    public function getContName($cont_name=null)
    {
        empty($cont_name)?:$this->cont_name->setValue($cont_name);
        return $this->cont_name;
    }

    public function setContName($cont_name)
    {
        $this->cont_name->setValue($cont_name);
    }

    public function getContInn($cont_inn=null)
    {
        empty($cont_inn)?:$this->cont_inn->setValue($cont_inn);
        return $this->cont_inn;
    }

    public function setContInn($cont_inn)
    {
        $this->cont_inn->setValue($cont_inn);
    }

    public function getContBankBic($cont_bank_bic=null)
    {
        empty($cont_bank_bic)?:$this->cont_bank_bic->setValue($cont_bank_bic);
        return $this->cont_bank_bic;
    }

    public function setContBankBic($cont_bank_bic)
    {
        $this->cont_bank_bic->setValue($cont_bank_bic);
    }

    public function getContBankCorrAcc($cont_bank_corr_acc=null)
    {
        empty($cont_bank_corr_acc)?:$this->cont_bank_corr_acc->setValue($cont_bank_corr_acc);
        return $this->cont_bank_corr_acc;
    }

    public function setContBankCorrAcc($cont_bank_corr_acc)
    {
        $this->cont_bank_corr_acc->setValue($cont_bank_corr_acc);
    }

    public function getContBankName($cont_bank_name=null)
    {
        empty($cont_bank_name)?:$this->cont_bank_name->setValue($cont_bank_name);
        return $this->cont_bank_name;
    }

    public function setContBankName($cont_bank_name)
    {
        $this->cont_bank_name->setValue($cont_bank_name);
    }

    public function getContBankId($cont_bank_id=null)
    {
        $cont_bank_id===null?:$this->cont_bank_id->setValue($cont_bank_id);
        return $this->cont_bank_id;
    }

    public function setContBankId($cont_bank_id)
    {
        $this->cont_bank_id->setValue($cont_bank_id);
    }

    public function getPurpose($purpose=null)
    {
        empty($purpose)?:$this->purpose->setValue($purpose);
        return $this->purpose;
    }

    public function setPurpose($purpose)
    {
        $this->purpose->setValue($purpose);
    }

    public function getStatus($status=null)
    {
        empty($status)?:$this->status->setValue($status);
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status->setValue($status);
    }

    public function getCurrRate($curr_rate=null)
    {
        empty($curr_rate)?:$this->curr_rate->setValue($curr_rate);
        return $this->curr_rate;
    }

    public function setCurrRate($curr_rate)
    {
        $this->curr_rate->setValue($curr_rate);
    }

    public function getContAccCode($cont_acc_code=null)
    {
        empty($cont_acc_code)?:$this->cont_acc_code->setValue($cont_acc_code);
        return $this->cont_acc_code;
    }

    public function setContAccCode($cont_acc_code)
    {
        $this->cont_acc_code = $cont_acc_code;
    }

    public function getContCurrCode($cont_curr_code=null)
    {
        empty($cont_curr_code)?:$this->cont_curr_code->setValue($cont_curr_code);
        return $this->cont_curr_code;
    }

    public function setContCurrCode($cont_curr_code)
    {
        $this->cont_curr_code = $cont_curr_code;
    }

    public function getContPan($cont_pan=null)
    {
        empty($cont_pan)?:$this->cont_pan->setValue($cont_pan);
        return $this->cont_pan;
    }

    public function setContPan($cont_pan)
    {
        $this->cont_pan = $cont_pan;
    }

    public function getContUserId($cont_user_id=null)
    {
        empty($cont_user_id)?:$this->cont_user_id->setValue($cont_user_id);
        return $this->cont_user_id;
    }

    public function setContUserId($cont_user_id)
    {
        $this->cont_user_id = $cont_user_id;
    }

    public function getDelimiterPurpose($delimiter_purpose=null)
    {
        empty($delimiter_purpose)?:$this->delimiter_purpose->setValue($delimiter_purpose);
        return $this->delimiter_purpose;
    }

    public function setDelimiterPurpose($delimiter_purpose)
    {
        $this->delimiter_purpose = $delimiter_purpose;
    }
}
