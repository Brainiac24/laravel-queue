<?php

namespace App\Services\Common\Gateway\AbsTransport\Credits;

use App\Services\Common\Gateway\AbsTransport\TagEntity;

class CreditEntity
{

    const EO_R_CREDITS_LIST = 'EO_R_CREDITS_LIST';

    private $credits;
    private $credit;
    private $id;
    private $create_date;
    private $exp_date;
    private $curr_code;
    private $percentage;
    private $balance;
    private $balance_percentage;
    private $balance_overdue;
    private $balance_all;
    private $acc_number;
    private $loan_number;
    private $type;

    public function __construct()
    {
        $this->credits = TagEntity::new('credits');
        $this->credit = TagEntity::new('credit');
        $this->id = TagEntity::new('id');
        $this->create_date = TagEntity::new('create_date');
        $this->exp_date = TagEntity::new('exp_date');
        $this->curr_code = TagEntity::new('curr_code');
        $this->percentage = TagEntity::new('percentage');
        $this->balance = TagEntity::new('balance');
        $this->balance_percentage = TagEntity::new('balance_percentage');
        $this->balance_overdue = TagEntity::new('balance_overdue');
        $this->balance_all = TagEntity::new('balance_all');
        $this->acc_number = TagEntity::new('acc_number');
        $this->loan_number = TagEntity::new('loan_number');
        $this->type = TagEntity::new('type');
    }


    public function getCredits($credits=null)
    {
        empty($credits)?:$this->credits->setValue($credits);
        return $this->credits;
    }

    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    public function getCredit($credit=null)
    {
        empty($credit)?:$this->credit->setValue($credit);
        return $this->credit;
    }

    public function setCredit($credit)
    {
        $this->credit = $credit;
    }

    public function getId($id=null)
    {
        empty($id)?:$this->id->setValue($id);
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreate_date($create_date=null)
    {
        empty($create_date)?:$this->create_date->setValue($create_date);
        return $this->create_date;
    }

    public function setCreate_date($create_date)
    {
        $this->create_date = $create_date;
    }

    public function getExp_date($exp_date=null)
    {
        empty($exp_date)?:$this->exp_date->setValue($exp_date);
        return $this->exp_date;
    }

    public function setExp_date($exp_date)
    {
        $this->exp_date = $exp_date;
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

    public function getPercentage($percentage=null)
    {
        empty($percentage)?:$this->percentage->setValue($percentage);
        return $this->percentage;
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    public function getBalance($balance=null)
    {
        empty($balance)?:$this->balance->setValue($balance);
        return $this->balance;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getBalance_percentage($balance_percentage=null)
    {
        empty($balance_percentage)?:$this->balance_percentage->setValue($balance_percentage);
        return $this->balance_percentage;
    }

    public function setBalance_percentage($balance_percentage)
    {
        $this->balance_percentage = $balance_percentage;
    }

    public function getBalance_overdue($balance_overdue=null)
    {
        empty($balance_overdue)?:$this->balance_overdue->setValue($balance_overdue);
        return $this->balance_overdue;
    }

    public function setBalance_overdue($balance_overdue)
    {
        $this->balance_overdue = $balance_overdue;
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

    public function getAcc_number($acc_number=null)
    {
        empty($acc_number)?:$this->acc_number->setValue($acc_number);
        return $this->acc_number;
    }

    public function setAcc_number($acc_number)
    {
        $this->acc_number = $acc_number;
    }

    public function getLoan_number($loan_number=null)
    {
        empty($loan_number)?:$this->loan_number->setValue($loan_number);
        return $this->loan_number;
    }

    public function setLoan_number($loan_number)
    {
        $this->loan_number = $loan_number;
    }

    public function getType($type=null)
    {
        empty($type)?:$this->type->setValue($type);
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}