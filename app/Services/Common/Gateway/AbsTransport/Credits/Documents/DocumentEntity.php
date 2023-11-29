<?php

namespace App\Services\Common\Gateway\AbsTransport\Credits\Documents;

use App\Services\Common\Gateway\AbsTransport\TagEntity;

class DocumentEntity
{

    const EO_R_CREDITS_ITEM_TRANSACTIONS_PLAN = 'EO_R_CREDITS_ITEM_TRANSACTIONS_PLAN';
    const EO_R_CREDITS_ITEM_TRANSACTIONS_FACT = 'EO_R_CREDITS_ITEM_TRANSACTIONS_FACT';

    private $documents;
    private $document;
    private $doc_id;
    private $doc_datetime;
    private $curr_code;
    private $curr_iso_name;
    private $amount;
    private $amount_percentage;
    private $amount_overdue;
    private $amount_all;
    private $balance_all;

    public function __construct()
    {
        $this->documents = TagEntity::new ('documents');
        $this->document = TagEntity::new ('document');
        $this->doc_id = TagEntity::new ('doc_id');
        $this->doc_datetime = TagEntity::new ('doc_datetime');
        $this->curr_code = TagEntity::new ('curr_code');
        $this->curr_iso_name = TagEntity::new ('curr_iso_name');
        $this->amount = TagEntity::new ('amount');
        $this->amount_percentage = TagEntity::new ('amount_percentage');
        $this->amount_overdue = TagEntity::new ('amount_overdue');
        $this->amount_all = TagEntity::new ('amount_all');
        $this->balance_all = TagEntity::new ('balance_all');
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

    public function getDoc_datetime($doc_datetime=null)
    {
        empty($doc_datetime)?:$this->doc_datetime->setValue($doc_datetime);
        return $this->doc_datetime;
    }

    public function setDoc_datetime($doc_datetime)
    {
        $this->doc_datetime = $doc_datetime;
    }

    public function getCurr_code($curr_code=null)
    {
        empty($curr_code)?:$this->curr_code->setValue($curr_code);
        return $this->curr_code;
    }

    public function setCurr_code($curr_code)
    {
        $this->curr_code = $curr_code;
    }

    public function getCurr_iso_name($curr_iso_name=null)
    {
        empty($curr_iso_name)?:$this->curr_iso_name->setValue($curr_iso_name);
        return $this->curr_iso_name;
    }

    public function setCurr_iso_name($curr_iso_name)
    {
        $this->curr_iso_name = $curr_iso_name;
    }

    public function getAmount($amount=null)
    {
        empty($amount)?:$this->amount->setValue($amount);
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount_percentage($amount_percentage=null)
    {
        empty($amount_percentage)?:$this->amount_percentage->setValue($amount_percentage);
        return $this->amount_percentage;
    }

    public function setAmount_percentage($amount_percentage)
    {
        $this->amount_percentage = $amount_percentage;
    }

    public function getAmount_overdue($amount_overdue=null)
    {
        empty($amount_overdue)?:$this->amount_overdue->setValue($amount_overdue);
        return $this->amount_overdue;
    }

    public function setAmount_overdue($amount_overdue)
    {
        $this->amount_overdue = $amount_overdue;
    }

    public function getAmount_all($amount_all=null)
    {
        empty($amount_all)?:$this->amount_all->setValue($amount_all);
        return $this->amount_all;
    }

    public function setAmount_all($amount_all)
    {
        $this->amount_all = $amount_all;
    }

    public function getBalance_all($balance_all=null)
    {
        empty($balance_all)?:$this->balance_all->setValue($balance_all);
        return $this->balance_all;
    }

    public function setBalance_all($balance_all)
    {
        $this->balance_all = $balance_all;
    }
}
