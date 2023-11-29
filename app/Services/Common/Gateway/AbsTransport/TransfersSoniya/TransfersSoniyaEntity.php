<?php

namespace App\Services\Common\Gateway\AbsTransport\TransfersSoniya;

use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\TagEntity;

class TransfersSoniyaEntity extends AbsTransportEntity
{

    const R_PAY_TRANSFER = 'R_PAY_TRANSFER';
    const R_CONFIRM_SEND = 'R_CONFIRM_SEND';
    const R_CHECK_TRANSFER = 'R_CHECK_TRANSFER';

    private $login;
    private $password;
    private $key;
    private $id_transaction;
    private $transaction_id;
    private $family_cl;
    private $name_cl;
    private $sname_cl;
    private $inn;
    private $region_ref;
    private $city_ref;
    private $date_pers;
    private $sex_ref;
    private $doc;
    private $type_ref;
    private $date;
    private $num;
    private $ser;
    private $who;
    private $client_phone;
    private $address;
    private $citizen_id;
    private $receiver;
    private $rec_family_cl;
    private $rec_name_cl;
    private $rec_sname_cl;
    private $rec_receiver_phone;
    private $rec_doc_num;
    private $rec_doc_ser;
    private $summa_pay;
    private $summa;
    private $summa_komis;
    private $currency_code;
    private $date_doc;
    private $rate;
    private $id_np;
    private $user_id;
    private $point_id;
    private $id_transfer;
    private $code_transfer;
    private $make_confirm;

    public function __construct()
    {
        parent::__construct();
        $this->login = TagEntity::new ('login');
        $this->password = TagEntity::new ('password');
        $this->key = TagEntity::new ('key');
        $this->id_transaction = TagEntity::new ('id_transaction');
        $this->transaction_id = TagEntity::new ('transaction_id');
        $this->family_cl = TagEntity::new ('family_cl');
        $this->name_cl = TagEntity::new ('name_cl');
        $this->sname_cl = TagEntity::new ('sname_cl');
        $this->inn = TagEntity::new ('inn');
        $this->region_ref = TagEntity::new ('region_ref');
        $this->city_ref = TagEntity::new ('city_ref');
        $this->date_pers = TagEntity::new ('date_pers');
        $this->sex_ref = TagEntity::new ('sex_ref');
        $this->doc = TagEntity::new ('doc');
        $this->type_ref = TagEntity::new ('type_ref');
        $this->date = TagEntity::new ('date');
        $this->num = TagEntity::new ('num');
        $this->ser = TagEntity::new ('ser');
        $this->who = TagEntity::new ('who');
        $this->client_phone = TagEntity::new ('client_phone');
        $this->address = TagEntity::new ('address');
        $this->citizen_id = TagEntity::new ('citizen_id');
        $this->receiver = TagEntity::new ('receiver');
        $this->rec_family_cl = TagEntity::new ('family_cl');
        $this->rec_name_cl = TagEntity::new ('name_cl');
        $this->rec_sname_cl = TagEntity::new ('sname_cl');
        $this->rec_receiver_phone = TagEntity::new ('receiver_phone');
        $this->rec_doc_num = TagEntity::new ('doc_num');
        $this->rec_doc_ser = TagEntity::new ('doc_ser');
        $this->summa_pay = TagEntity::new ('summa_pay');
        $this->summa = TagEntity::new ('summa');
        $this->summa_komis = TagEntity::new ('summa_komis');
        $this->currency_code = TagEntity::new ('currency_code');
        $this->date_doc = TagEntity::new ('date_doc');
        $this->rate = TagEntity::new ('rate');
        $this->id_np = TagEntity::new ('id_np');
        $this->user_id = TagEntity::new ('user_id');
        $this->point_id = TagEntity::new ('point_id');
        $this->id_transfer = TagEntity::new ('id_transfer');
        $this->code_transfer = TagEntity::new ('code_transfer');
        $this->make_confirm = TagEntity::new ('makeConfirm');

    }

    public function getLogin($login=null)
    {
        empty($login)?:$this->login->setValue($login);
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

    }

    public function getPassword($password=null)
    {
        empty($password)?:$this->password->setValue($password);
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

    }

    public function getKey($key=null)
    {
        empty($key)?:$this->key->setValue($key);
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;

    }

    public function getIdTransaction($id_transaction=null)
    {
        empty($id_transaction)?:$this->id_transaction->setValue($id_transaction);
        return $this->id_transaction;
    }

    public function setIdTransaction($id_transaction)
    {
        $this->id_transaction = $id_transaction;

    }

    public function getFamilyCl($family_cl=null)
    {
        empty($family_cl)?:$this->family_cl->setValue($family_cl);
        return $this->family_cl;
    }

    public function setFamilyCl($family_cl)
    {
        $this->family_cl = $family_cl;

    }

    public function getNameCl($name_cl=null)
    {
        empty($name_cl)?:$this->name_cl->setValue($name_cl);
        return $this->name_cl;
    }

    public function setNameCl($name_cl)
    {
        $this->name_cl = $name_cl;

    }

    public function getSnameCl($sname_cl=null)
    {
        empty($sname_cl)?:$this->sname_cl->setValue($sname_cl);
        return $this->sname_cl;
    }

    public function setSnameCl($sname_cl)
    {
        $this->sname_cl = $sname_cl;

    }

    public function getInn($inn=null)
    {
        empty($inn)?:$this->inn->setValue($inn);
        return $this->inn;
    }

    public function setInn($inn)
    {
        $this->inn = $inn;

    }

    public function getRegionRef($region_ref=null)
    {
        empty($region_ref)?:$this->region_ref->setValue($region_ref);
        return $this->region_ref;
    }

    public function setRegionRef($region_ref)
    {
        $this->region_ref = $region_ref;

    }

    public function getCityRef($city_ref=null)
    {
        empty($city_ref)?:$this->city_ref->setValue($city_ref);
        return $this->city_ref;
    }

    public function setCityRef($city_ref)
    {
        $this->city_ref = $city_ref;

    }

    public function getDatePers($date_pers=null)
    {
        empty($date_pers)?:$this->date_pers->setValue($date_pers);
        return $this->date_pers;
    }

    public function setDatePers($date_pers)
    {
        $this->date_pers = $date_pers;

    }

    public function getSexRef($sex_ref=null)
    {
        empty($sex_ref)?:$this->sex_ref->setValue($sex_ref);
        return $this->sex_ref;
    }

    public function setSexRef($sex_ref)
    {
        $this->sex_ref = $sex_ref;

    }

    public function getDoc($doc=null)
    {
        empty($doc)?:$this->doc->setValue($doc);
        return $this->doc;
    }

    public function setDoc($doc)
    {
        $this->doc = $doc;

    }

    public function getTypeRef($type_ref=null)
    {
        empty($type_ref)?:$this->type_ref->setValue($type_ref);
        return $this->type_ref;
    }

    public function setTypeRef($type_ref)
    {
        $this->type_ref = $type_ref;

    }

    public function getDate($date=null)
    {
        empty($date)?:$this->date->setValue($date);
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

    }

    public function getNum($num=null)
    {
        empty($num)?:$this->num->setValue($num);
        return $this->num;
    }

    public function setNum($num)
    {
        $this->num = $num;

    }

    public function getSer($ser=null)
    {
        empty($ser)?:$this->ser->setValue($ser);
        return $this->ser;
    }

    public function setSer($ser)
    {
        $this->ser = $ser;

    }

    public function getWho($who=null)
    {
        empty($who)?:$this->who->setValue($who);
        return $this->who;
    }

    public function setWho($who)
    {
        $this->who = $who;

    }

    public function getClientPhone($client_phone=null)
    {
        empty($client_phone)?:$this->client_phone->setValue($client_phone);
        return $this->client_phone;
    }

    public function setClientPhone($client_phone)
    {
        $this->client_phone = $client_phone;

    }

    public function getAddress($address=null)
    {
        empty($address)?:$this->address->setValue($address);
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

    }

    public function getCitizenId($citizen_id=null)
    {
        empty($citizen_id)?:$this->citizen_id->setValue($citizen_id);
        return $this->citizen_id;
    }

    public function setCitizenId($citizen_id)
    {
        $this->citizen_id = $citizen_id;

    }

    public function getReceiver($receiver=null)
    {
        empty($receiver)?:$this->receiver->setValue($receiver);
        return $this->receiver;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

    }

    public function getRecFamilyCl($rec_family_cl=null)
    {
        empty($rec_family_cl)?:$this->rec_family_cl->setValue($rec_family_cl);
        return $this->rec_family_cl;
    }

    public function setRecFamilyCl($rec_family_cl)
    {
        $this->rec_family_cl = $rec_family_cl;

    }

    public function getRecNameCl($rec_name_cl=null)
    {
        empty($rec_name_cl)?:$this->rec_name_cl->setValue($rec_name_cl);
        return $this->rec_name_cl;
    }

    public function setRecNameCl($rec_name_cl)
    {
        $this->rec_name_cl = $rec_name_cl;

    }

    public function getRecSnameCl($rec_sname_cl=null)
    {
        empty($rec_sname_cl)?:$this->rec_sname_cl->setValue($rec_sname_cl);
        return $this->rec_sname_cl;
    }

    public function setRecSnameCl($rec_sname_cl)
    {
        $this->rec_sname_cl = $rec_sname_cl;

    }

    public function getRecReceiverPhone($rec_receiver_phone=null)
    {
        empty($rec_receiver_phone)?:$this->rec_receiver_phone->setValue($rec_receiver_phone);
        return $this->rec_receiver_phone;
    }

    public function setRecReceiverPhone($rec_receiver_phone)
    {
        $this->rec_receiver_phone = $rec_receiver_phone;

    }

    public function getRecDocNum($rec_doc_num=null)
    {
        empty($rec_doc_num)?:$this->rec_doc_num->setValue($rec_doc_num);
        return $this->rec_doc_num;
    }

    public function setRecDocNum($rec_doc_num)
    {
        $this->rec_doc_num = $rec_doc_num;

    }

    public function getRecDocSer($rec_doc_ser=null)
    {
        empty($rec_doc_ser)?:$this->rec_doc_ser->setValue($rec_doc_ser);
        return $this->rec_doc_ser;
    }

    public function setRecDocSer($rec_doc_ser)
    {
        $this->rec_doc_ser = $rec_doc_ser;

    }

    public function getSummaPay($summa_pay=null)
    {
        empty($summa_pay)?:$this->summa_pay->setValue($summa_pay);
        return $this->summa_pay;
    }

    public function setSummaPay($summa_pay)
    {
        $this->summa_pay = $summa_pay;

    }

    public function getSumma($summa=null)
    {
        empty($summa)?:$this->summa->setValue($summa);
        return $this->summa;
    }

    public function setSumma($summa)
    {
        $this->summa = $summa;

    }

    public function getSummaKomis($summa_komis=null)
    {
        empty($summa_komis)?:$this->summa_komis->setValue($summa_komis);
        return $this->summa_komis;
    }

    public function setSummaKomis($summa_komis)
    {
        $this->summa_komis = $summa_komis;

    }

    public function getCurrencyCode($currency_code=null)
    {
        empty($currency_code)?:$this->currency_code->setValue($currency_code);
        return $this->currency_code;
    }

    public function setCurrencyCode($currency_code)
    {
        $this->currency_code = $currency_code;

    }

    public function getDateDoc($date_doc=null)
    {
        empty($date_doc)?:$this->date_doc->setValue($date_doc);
        return $this->date_doc;
    }

    public function setDateDoc($date_doc)
    {
        $this->date_doc = $date_doc;

    }

    public function getRate($rate=null)
    {
        empty($rate)?:$this->rate->setValue($rate);
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;

    }

    public function getIdNp($id_np=null)
    {
        empty($id_np)?:$this->id_np->setValue($id_np);
        return $this->id_np;
    }

    public function setIdNp($id_np)
    {
        $this->id_np = $id_np;

    }

    public function getUserId($user_id=null)
    {
        empty($user_id)?:$this->user_id->setValue($user_id);
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

    }

    public function getPointId($point_id=null)
    {
        empty($point_id)?:$this->point_id->setValue($point_id);
        return $this->point_id;
    }

    public function setPointId($point_id)
    {
        $this->point_id = $point_id;

    }
 
    public function getIdTransfer($id_transfer=null)
    {
        empty($id_transfer)?:$this->id_transfer->setValue($id_transfer);
        return $this->id_transfer;
    }

    public function setIdTransfer($id_transfer)
    {
        $this->id_transfer = $id_transfer;
    }

    public function getCodeTransfer($code_transfer=null)
    {
        empty($code_transfer)?:$this->code_transfer->setValue($code_transfer);
        return $this->code_transfer;
    }

    public function setCodeTransfer($code_transfer)
    {
        $this->code_transfer = $code_transfer;
    }
   
    public function getMakeConfirm($make_confirm=null)
    {
        empty($make_confirm)?:$this->make_confirm->setValue($make_confirm);
        return $this->make_confirm;
    }

    public function setMakeConfirm($make_confirm)
    {
        $this->make_confirm = $make_confirm;
    }

    public function getTransactionId($transaction_id=null)
    {
        empty($transaction_id)?:$this->transaction_id->setValue($transaction_id);
        return $this->transaction_id;
    }

    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }
}
