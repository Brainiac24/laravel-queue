<?php

namespace App\Services\Common\Gateway\AbsTransport\Accounts;

use App\Services\Common\Gateway\AbsTransport\TagEntity;

class AccountEntity
{

    const EO_R_DEPOSITS_LIST = 'EO_R_DEPOSITS_LIST';
    const EO_R_DEPOSITS_ITEM_TRANSACTIONS = 'EO_R_DEPOSITS_ITEM_TRANSACTIONS';
    const EO_R_ACCOUNTS_LIST = 'EO_R_ACCOUNTS_LIST';
    const EO_R_ACCOUNTS_ITEM_TRANSACTIONS = 'EO_R_ACCOUNTS_ITEM_TRANSACTIONS';
    const R_CR_DOG_DEPN = 'R_CR_DOG_DEPN'; //Заявка на открытие депозита
    const R_DEPN_CLS_CRASH = 'R_DEPN_CLS_CRASH'; //Заявка на закрытие депозита
    const R_CR_SBERACC_CL_PRIV = 'R_CR_SBERACC_CL_PRIV'; //Заявка на открытие счёта
    const EO_R_DEPOSITS_ITEM_CODEC = 'EO_R_DEPOSITS_ITEM_CODEC';
    const EO_R_ACCOUNTS_ITEM_CODEC = 'EO_R_ACCOUNTS_ITEM_CODEC';
    const R_ED_DEPN_DOG_CL_PRIV = 'R_ED_DEPN_DOG_CL_PRIV'; //Заявка на изменения депозитного договора

    private $accounts;
    private $account;
    private $acc_number;
    private $acc_code;
    private $pan;
    private $contract_id;
    private $create_date;
    private $exp_date;
    private $income_start_date;
    private $income_end_date;
    private $min_limit_balance;
    private $min_fill_amount;
    private $balance;
    private $curr_code;
    private $status;
    private $type;
    private $percentage;
    private $bank_name;
    private $bank_bic;
    private $bank_corr_acc;
    private $user_create_id;
    private $client_id;
    private $payer_id;
    private $date_begin;
    private $period;
    private $time_interval;
    private $vid_dog;
    private $summa_dog;
    private $fintool;
    private $acc_return;
    private $acc_enrol_prc;
    private $period_calc_prc;
    private $open_acc_enrol_prc;
    private $on_date;
    private $dog_id;
    private $user_accept_id;
    private $act_type;
    private $rate;
    private $client_acc_abs_id;
    private $com_client_acc_abs_id;
    private $pay_ways;
    private $pay_way_type;
    private $pw_cashless;
    private $pw_transfer_our_client;
    private $pay_ways_com;
    private $type_com;
    private $client_abs_id;
    private $kind;
    private $create_user;
    private $sum_dog;
    private $depn_dog_abs_id;
    private $prc_acc_abs_id;

    public function __construct()
    {
        $this->accounts = TagEntity::new('accounts');
        $this->account = TagEntity::new('account');
        $this->acc_number = TagEntity::new('acc_number');
        $this->acc_code = TagEntity::new('acc_code');
        $this->pan = TagEntity::new('pan');
        $this->contract_id = TagEntity::new('contract_id');
        $this->create_date = TagEntity::new('create_date');
        $this->exp_date = TagEntity::new('exp_date');
        $this->income_start_date = TagEntity::new('income_start_date');
        $this->income_end_date = TagEntity::new('income_end_date');
        $this->min_limit_balance = TagEntity::new('min_limit_balance');
        $this->min_fill_amount = TagEntity::new('min_fill_amount');
        $this->balance = TagEntity::new('balance');
        $this->curr_code = TagEntity::new('curr_code');
        $this->status = TagEntity::new('status');
        $this->type = TagEntity::new('type');
        $this->percentage = TagEntity::new('percentage');
        $this->bank_name = TagEntity::new('bank_name');
        $this->bank_bic = TagEntity::new('bank_bic');
        $this->bank_corr_acc = TagEntity::new('bank_corr_acc');
        $this->user_create_id = TagEntity::new('user_create_id');
        $this->client_id = TagEntity::new('client_id');
        $this->payer_id = TagEntity::new('payer_id');
        $this->date_begin = TagEntity::new('date_begin');
        $this->period = TagEntity::new('period');
        $this->time_interval = TagEntity::new('time_interval');
        $this->vid_dog = TagEntity::new('vid_dog');
        $this->summa_dog = TagEntity::new('summa_dog');
        $this->fintool = TagEntity::new('fintool');
        $this->acc_return = TagEntity::new('acc_return');
        $this->acc_enrol_prc = TagEntity::new('acc_enrol_prc');
        $this->period_calc_prc = TagEntity::new('period_calc_prc');
        $this->open_acc_enrol_prc = TagEntity::new('open_acc_enrol_prc');
        $this->on_date = TagEntity::new('on_date');
        $this->dog_id = TagEntity::new('dog_id');
        $this->user_accept_id = TagEntity::new('user_accept_id');
        $this->act_type = TagEntity::new('act_type');
        $this->rate = TagEntity::new('rate');
        $this->client_acc_abs_id = TagEntity::new('client_acc_abs_id');
        $this->com_client_acc_abs_id = TagEntity::new('com_client_acc_abs_id');
        $this->pay_ways = TagEntity::new('pay_ways');
        $this->pay_way_type = TagEntity::new('pay_way_type');
        $this->pw_cashless = TagEntity::new('pw_cashless');
        $this->pw_transfer_our_client = TagEntity::new('pw_transfer_our_client');
        $this->pay_ways_com = TagEntity::new('pay_ways_com');
        $this->type_com = TagEntity::new('type_com');
        $this->client_abs_id = TagEntity::new('client_abs_id');
        $this->kind = TagEntity::new('kind');
        $this->create_user = TagEntity::new('create_user');
        $this->sum_dog = TagEntity::new('sum_dog');
        $this->depn_dog_abs_id = TagEntity::new('depn_dog_abs_id');
        $this->prc_acc_abs_id = TagEntity::new('prc_acc_abs_id');
    }

    public function getAccounts($accounts=null)
    {
        empty($accounts)?:$this->accounts->setValue($accounts);
        return $this->accounts;
    }

    public function setAccounts($accounts)
    {
        $this->accounts->setValue($accounts);
    }

    public function getAccount($account=null)
    {
        empty($account)?:$this->account->setValue($account);
        return $this->account;
    }

    public function setAccount($account)
    {
        $this->account->setValue($account);
    }

    public function getAccNumber($acc_number=null)
    {
        empty($acc_number)?:$this->acc_number->setValue($acc_number);
        return $this->acc_number;
    }

    public function setAccNumber($acc_number)
    {
        $this->acc_number->setValue($acc_number);
    }

    public function getContractId($contract_id=null)
    {
        empty($contract_id)?:$this->contract_id->setValue($contract_id);
        return $this->contract_id;
    }

    public function setContractId($contract_id)
    {
        $this->contract_id = $contract_id;
    }

    public function getCreateDate($create_date=null)
    {
        empty($create_date)?:$this->create_date->setValue($create_date);
        return $this->create_date;
    }

    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    public function getExpDate($exp_date=null)
    {
        empty($exp_date)?:$this->exp_date->setValue($exp_date);
        return $this->exp_date;
    }

    public function setExpDate($exp_date)
    {
        $this->exp_date = $exp_date;
    }

    public function getIncomeStartDate($income_start_date=null)
    {
        empty($income_start_date)?:$this->income_start_date->setValue($income_start_date);
        return $this->income_start_date;
    }

    public function setIncomeStartDate($income_start_date)
    {
        $this->income_start_date = $income_start_date;
    }

    public function getIncomeEndDate($income_end_date=null)
    {
        empty($income_end_date)?:$this->income_end_date->setValue($income_end_date);
        return $this->income_end_date;
    }

    public function setIncomeEndDate($income_end_date)
    {
        $this->income_end_date = $income_end_date;
    }

    public function getMinLimitBalance($min_limit_balance=null)
    {
        empty($min_limit_balance)?:$this->min_limit_balance->setValue($min_limit_balance);
        return $this->min_limit_balance;
    }

    public function setMinLimitBalance($min_limit_balance)
    {
        $this->min_limit_balance = $min_limit_balance;
    }

    public function getMinFillAmount($min_fill_amount=null)
    {
        empty($min_fill_amount)?:$this->min_fill_amount->setValue($min_fill_amount);
        return $this->min_fill_amount;
    }

    public function setMinFillAmount($min_fill_amount)
    {
        $this->min_fill_amount = $min_fill_amount;
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

    public function getCurrCode($curr_code=null)
    {
        empty($curr_code)?:$this->curr_code->setValue($curr_code);
        return $this->curr_code;
    }

    public function setCurrCode($curr_code)
    {
        $this->curr_code = $curr_code;
    }

    public function getStatus($status=null)
    {
        empty($status)?:$this->status->setValue($status);
        return $this->status;
    }
 
    public function setStatus($status)
    {
        $this->status = $status;
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

    public function getPercentage($percentage=null)
    {
        empty($percentage)?:$this->percentage->setValue($percentage);
        return $this->percentage;
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    public function getBankName($bank_name=null)
    {
        empty($bank_name)?:$this->bank_name->setValue($bank_name);
        return $this->bank_name;
    }

    public function setBankName($bank_name)
    {
        $this->bank_name = $bank_name;
    }

    public function getBankBic($bank_bic=null)
    {
        empty($bank_bic)?:$this->bank_bic->setValue($bank_bic);
        return $this->bank_bic;
    }

    public function setBankBic($bank_bic)
    {
        $this->bank_bic = $bank_bic;
    }

    public function getBankCorrAcc($bank_corr_acc=null)
    {
        empty($bank_corr_acc)?:$this->bank_corr_acc->setValue($bank_corr_acc);
        return $this->bank_corr_acc;
    }

    public function setBankCorrAcc($bank_corr_acc)
    {
        $this->bank_corr_acc = $bank_corr_acc;
    }

    public function getAccCode($acc_code=null)
    {
        empty($acc_code)?:$this->acc_code->setValue($acc_code);
        return $this->acc_code;
    }

    public function setAccCode($acc_code)
    {
        $this->acc_code = $acc_code;
    }

    public function getPan($pan=null)
    {
        empty($pan)?:$this->pan->setValue($pan);
        return $this->pan;
    }

    public function setPan($pan)
    {
        $this->pan = $pan;
    }

    public function getUser_create_id($user_create_id=null)
    {
        empty($user_create_id)?:$this->user_create_id->setValue($user_create_id);
        return $this->user_create_id;
    }

    public function setUser_create_id($user_create_id)
    {
        $this->user_create_id = $user_create_id;
    }

    public function getClient_id($client_id=null)
    {
        $client_id===null?:$this->client_id->setValue($client_id);
        return $this->client_id;
    }

    public function setClient_id($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getPayer_id($payer_id=null)
    {
        $payer_id===null?:$this->payer_id->setValue($payer_id);
        return $this->payer_id;
    }

    public function setPayer_id($payer_id)
    {
        $this->payer_id = $payer_id;
    }

    public function getDate_begin($date_begin=null)
    {
        $date_begin===null?:$this->date_begin->setValue($date_begin);
        return $this->date_begin;
    }

    public function setDate_begin($date_begin)
    {
        $this->date_begin = $date_begin;
    }

    public function getPeriod($period=null)
    {
        $period===null?:$this->period->setValue($period);
        return $this->period;
    }

    public function setPeriod($period)
    {
        $this->period = $period;
    }

    public function getTime_interval($time_interval=null)
    {
        $time_interval===null?:$this->time_interval->setValue($time_interval);
        return $this->time_interval;
    }

    public function setTime_interval($time_interval)
    {
        $this->time_interval = $time_interval;
    }

    public function getVid_dog($vid_dog=null)
    {
        $vid_dog===null?:$this->vid_dog->setValue($vid_dog);
        return $this->vid_dog;
    }

    public function setVid_dog($vid_dog)
    {
        $this->vid_dog = $vid_dog;
    }

    public function getSumma_dog($summa_dog=null)
    {
        $summa_dog===null?:$this->summa_dog->setValue($summa_dog);
        return $this->summa_dog;
    }

    public function setSumma_dog($summa_dog)
    {
        $this->summa_dog = $summa_dog;
    }

    public function getFintool($fintool=null)
    {
        $fintool===null?:$this->fintool->setValue($fintool);
        return $this->fintool;
    }

    public function setFintool($fintool)
    {
        $this->fintool = $fintool;
    }

    public function getAcc_return($acc_return=null)
    {
        $acc_return===null?:$this->acc_return->setValue($acc_return);
        return $this->acc_return;
    }

    public function setAcc_return($acc_return)
    {
        $this->acc_return = $acc_return;
    }

    public function getAcc_enrol_prc($acc_enrol_prc=null)
    {
        $acc_enrol_prc===null?:$this->acc_enrol_prc->setValue($acc_enrol_prc);
        return $this->acc_enrol_prc;
    }

    public function setAcc_enrol_prc($acc_enrol_prc)
    {
        $this->acc_enrol_prc = $acc_enrol_prc;
    }

    public function getPeriod_calc_prc($period_calc_prc=null)
    {
        $period_calc_prc===null?:$this->period_calc_prc->setValue($period_calc_prc);
        return $this->period_calc_prc;
    }
 
    public function setPeriod_calc_prc($period_calc_prc)
    {
        $this->period_calc_prc = $period_calc_prc;
    }

    public function getOpen_acc_enrol_prc($open_acc_enrol_prc=null)
    {
        $open_acc_enrol_prc===null?:$this->open_acc_enrol_prc->setValue($open_acc_enrol_prc);
        return $this->open_acc_enrol_prc;
    }

    public function setOpen_acc_enrol_prc($open_acc_enrol_prc)
    {
        $this->open_acc_enrol_prc = $open_acc_enrol_prc;
    }

    public function getOn_date($on_date=null)
    {
        $on_date===null?:$this->on_date->setValue($on_date);
        return $this->on_date;
    }

    public function setOn_date($on_date)
    {
        $this->on_date = $on_date;
    }

    public function getDog_id($dog_id=null)
    {
        $dog_id===null?:$this->dog_id->setValue($dog_id);
        return $this->dog_id;
    }

    public function setDog_id($dog_id)
    {
        $this->dog_id = $dog_id;
    }

    public function getUser_accept_id($user_accept_id=null)
    {
        $user_accept_id===null?:$this->user_accept_id->setValue($user_accept_id);
        return $this->user_accept_id;
    }

    public function setUser_accept_id($user_accept_id)
    {
        $this->user_accept_id = $user_accept_id;
    }

    public function getAct_type($act_type=null)
    {
        $act_type===null?:$this->act_type->setValue($act_type);
        return $this->act_type;
    }

    public function setAct_type($act_type)
    {
        $this->act_type = $act_type;
    }

    public function getClient_acc_abs_id($client_acc_abs_id=null)
    {
        $client_acc_abs_id===null?:$this->client_acc_abs_id->setValue($client_acc_abs_id);
        return $this->client_acc_abs_id;
    }

    public function setClient_acc_abs_id($client_acc_abs_id)
    {
        $this->client_acc_abs_id = $client_acc_abs_id;
    }

    public function getCom_client_acc_abs_id($com_client_acc_abs_id=null)
    {
        $com_client_acc_abs_id===null?:$this->com_client_acc_abs_id->setValue($com_client_acc_abs_id);
        return $this->com_client_acc_abs_id;
    }

    public function setCom_client_acc_abs_id($com_client_acc_abs_id)
    {
        $this->com_client_acc_abs_id = $com_client_acc_abs_id;
    }

    public function getRate($rate=null)
    {
        $rate===null?:$this->rate->setValue($rate);
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getPay_ways($pay_ways=null)
    {
        $pay_ways===null?:$this->pay_ways->setValue($pay_ways);
        return $this->pay_ways;
    }

    public function setPay_ways($pay_ways)
    {
        $this->pay_ways = $pay_ways;
    }

    public function getPay_way_type($pay_way_type=null)
    {
        $pay_way_type===null?:$this->pay_way_type->setValue($pay_way_type);
        return $this->pay_way_type;
    }

    public function setPay_way_type($pay_way_type)
    {
        $this->pay_way_type = $pay_way_type;
    }

    public function getPw_cashless($pw_cashless=null)
    {
        $pw_cashless===null?:$this->pw_cashless->setValue($pw_cashless);
        return $this->pw_cashless;
    }

    public function setPw_cashless($pw_cashless)
    {
        $this->pw_cashless = $pw_cashless;
    }

    public function getPw_transfer_our_client($pw_transfer_our_client=null)
    {
        $pw_transfer_our_client===null?:$this->pw_transfer_our_client->setValue($pw_transfer_our_client);
        return $this->pw_transfer_our_client;
    }

    public function setPw_transfer_our_client($pw_transfer_our_client)
    {
        $this->pw_transfer_our_client = $pw_transfer_our_client;
    }

    public function getPay_ways_com($pay_ways_com=null)
    {
        $pay_ways_com===null?:$this->pay_ways_com->setValue($pay_ways_com);
        return $this->pay_ways_com;
    }

    public function setPay_ways_com($pay_ways_com)
    {
        $this->pay_ways_com = $pay_ways_com;
    }

    public function getType_com($type_com=null)
    {
        $type_com===null?:$this->type_com->setValue($type_com);
        return $this->type_com;
    }

    public function setType_com($type_com)
    {
        $this->type_com = $type_com;
    }

    public function getClient_abs_id($client_abs_id=null)
    {
        $client_abs_id===null?:$this->client_abs_id->setValue($client_abs_id);
        return $this->client_abs_id;
    }

    public function setClient_abs_id($client_abs_id)
    {
        $this->client_abs_id = $client_abs_id;
    }

    public function getKind($kind=null)
    {
        $kind===null?:$this->kind->setValue($kind);
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getCreate_user($create_user=null)
    {
        $create_user===null?:$this->create_user->setValue($create_user);
        return $this->create_user;
    }

    public function setCreate_user($create_user)
    {
        $this->create_user = $create_user;
    }

    public function getSum_dog($sum_dog=null)
    {
        $sum_dog===null?:$this->sum_dog->setValue($sum_dog);
        return $this->sum_dog;
    }

    public function setSum_dog($sum_dog)
    {
        $this->sum_dog = $sum_dog;
    }

    public function getDepnDogAbsId($depn_dog_abs_id = null)
    {
        $depn_dog_abs_id === null ? : $this->depn_dog_abs_id->setValue($depn_dog_abs_id);

        return $this->depn_dog_abs_id;
    }

    public function setDepnDogAbsId($depn_dog_abs_id)
    {
        $this->depn_dog_abs_id = $depn_dog_abs_id;
    }

    public function getPrcAccAbsId($prc_acc_abs_id = null)
    {
        $prc_acc_abs_id===null ? : $this->depn_dog_abs_id->setValue($prc_acc_abs_id);

        return $this->prc_acc_abs_id;
    }

    public function setPrcAccAbsId($prc_acc_abs_id)
    {
        $this->prc_acc_abs_id = $prc_acc_abs_id;
    }
}