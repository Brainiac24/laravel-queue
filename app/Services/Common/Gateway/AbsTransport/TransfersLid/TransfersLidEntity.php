<?php

namespace App\Services\Common\Gateway\AbsTransport\TransfersLid;

use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\TagEntity;

class TransfersLidEntity extends AbsTransportEntity
{

    const R_TRANSFER_PAY_LID = 'R_TRANSFER_PAY_LID';

    private $pay_system;
    private $kdp;
    private $date_doc;
    private $country;
    private $summa;
    private $spr_val;
    private $contacts;
    private $doc_num;
    private $doc_seria;
    private $cer_type;
    private $who;
    private $sen_name;
    private $enroll_type;
    private $acc_pan;
    private $summa_po;
    private $rate;
    private $coment;
    private $sen_resid;
    private $rec_name;
    private $rec_citiz;
    private $rec_resid;
    private $rec_region;
    private $rec_address;
    private $rec_bdate;
    private $rec_date_v;
    private $user_id;
    private $spr_np;
    private $process_lid;
    private $resource;
    private $ip_address;

    public function __construct()
    {
        parent::__construct();
        $this->pay_system = TagEntity::new ('pay_system');
        $this->kdp = TagEntity::new ('kdp');
        $this->date_doc = TagEntity::new ('date_doc');
        $this->country = TagEntity::new ('country');
        $this->summa = TagEntity::new ('summa');
        $this->spr_val = TagEntity::new ('spr_val');
        $this->contacts = TagEntity::new ('contacts');
        $this->doc_num = TagEntity::new ('doc_num');
        $this->doc_seria = TagEntity::new ('doc_seria');
        $this->cer_type = TagEntity::new ('cer_type');
        $this->who = TagEntity::new ('who');
        $this->sen_name = TagEntity::new ('sen_name');
        $this->enroll_type = TagEntity::new ('enroll_type');
        $this->acc_pan = TagEntity::new ('acc_pan');
        $this->summa_po = TagEntity::new ('summa_po');
        $this->rate = TagEntity::new ('rate');
        $this->coment = TagEntity::new ('coment');
        $this->sen_resid = TagEntity::new ('sen_resid');
        $this->rec_name = TagEntity::new ('rec_name');
        $this->rec_citiz = TagEntity::new ('rec_citiz');
        $this->rec_resid = TagEntity::new ('rec_resid');
        $this->rec_region = TagEntity::new ('rec_region');
        $this->rec_address = TagEntity::new ('rec_address');
        $this->rec_bdate = TagEntity::new ('rec_bdate');
        $this->rec_date_v = TagEntity::new ('rec_date_v');
        $this->user_id = TagEntity::new ('user_id');
        $this->spr_np = TagEntity::new ('spr_np');
        $this->process_lid = TagEntity::new ('process_lid');
        $this->resource = TagEntity::new ('resource');
        $this->ip_address = TagEntity::new ('ip_address');

    }

    public function getPaySystem($pay_system = null)
    {
        $pay_system===null ?: $this->pay_system->setValue($pay_system);
        return $this->pay_system;
    }

    public function setPaySystem($pay_system)
    {
        $this->pay_system = $pay_system;

    }

    public function getKdp($kdp = null)
    {
        $kdp===null ?: $this->kdp->setValue($kdp);
        return $this->kdp;
    }

    public function setKdp($kdp)
    {
        $this->kdp = $kdp;

    }

    public function getDateDoc($date_doc = null)
    {
        $date_doc===null ?: $this->date_doc->setValue($date_doc);
        return $this->date_doc;
    }

    public function setDateDoc($date_doc)
    {
        $this->date_doc = $date_doc;

    }

    public function getCountry($country = null)
    {
        $country===null ?: $this->country->setValue($country);
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;

    }

    public function getSumma($summa = null)
    {
        $summa===null ?: $this->summa->setValue($summa);
        return $this->summa;
    }

    public function setSumma($summa)
    {
        $this->summa = $summa;

    }

    public function getSprVal($spr_val = null)
    {
        $spr_val===null ?: $this->spr_val->setValue($spr_val);
        return $this->spr_val;
    }

    public function setSprVal($spr_val)
    {
        $this->spr_val = $spr_val;

    }

    public function getContacts($contacts)
    {
        $contacts===null ?: $this->contacts->setValue($contacts);
        return $this->contacts;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

    }

    public function getDocNum($doc_num = null)
    {
        $doc_num===null ?: $this->doc_num->setValue($doc_num);
        return $this->doc_num;
    }

    public function setDocNum($doc_num)
    {
        $this->doc_num = $doc_num;

    }

    public function getDocSeria($doc_seria = null)
    {
        $doc_seria===null ?: $this->doc_seria->setValue($doc_seria);
        return $this->doc_seria;
    }

    public function setDocSeria($doc_seria)
    {
        $this->doc_seria = $doc_seria;

    }

    public function getCerType($cer_type = null)
    {
        $cer_type===null ?: $this->cer_type->setValue($cer_type);
        return $this->cer_type;
    }

    public function setCerType($cer_type)
    {
        $this->cer_type = $cer_type;

    }

    public function getWho($who = null)
    {
        $who===null ?: $this->who->setValue($who);
        return $this->who;
    }

    public function setWho($who)
    {
        $this->who = $who;

    }

    public function getSenName($sen_name = null)
    {
        $sen_name===null ?: $this->sen_name->setValue($sen_name);
        return $this->sen_name;
    }

    public function setSenName($sen_name)
    {
        $this->sen_name = $sen_name;

    }

    public function getEnrollType($enroll_type = null)
    {
        $enroll_type===null ?: $this->enroll_type->setValue($enroll_type);
        return $this->enroll_type;
    }

    public function setEnrollType($enroll_type)
    {
        $this->enroll_type = $enroll_type;

    }

    public function getAccPan($acc_pan = null)
    {
        $acc_pan===null ?: $this->acc_pan->setValue($acc_pan);
        return $this->acc_pan;
    }

    public function setAccPan($acc_pan)
    {
        $this->acc_pan = $acc_pan;

    }

    public function getSummaPo($summa_po = null)
    {
        $summa_po===null ?: $this->summa_po->setValue($summa_po);
        return $this->summa_po;
    }

    public function setSummaPo($summa_po)
    {
        $this->summa_po = $summa_po;

    }

    public function getRate($rate = null)
    {
        $rate===null ?: $this->rate->setValue($rate);
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;

    }

    public function getComent($coment = null)
    {
        $coment===null ?: $this->coment->setValue($coment);
        return $this->coment;
    }

    public function setComent($coment)
    {
        $this->coment = $coment;

    }

    public function getSenResid($sen_resid = null)
    {
        $sen_resid===null ?: $this->sen_resid->setValue($sen_resid);
        return $this->sen_resid;
    }

    public function setSenResid($sen_resid)
    {
        $this->sen_resid = $sen_resid;

    }

    public function getRecName($rec_name = null)
    {
        $rec_name===null ?: $this->rec_name->setValue($rec_name);
        return $this->rec_name;
    }

    public function setRecName($rec_name)
    {
        $this->rec_name = $rec_name;

    }

    public function getRecCitiz($rec_citiz = null)
    {
        $rec_citiz===null ?: $this->rec_citiz->setValue($rec_citiz);
        return $this->rec_citiz;
    }

    public function setRecCitiz($rec_citiz)
    {
        $this->rec_citiz = $rec_citiz;

    }

    public function getRecResid($rec_resid = null)
    {
        $rec_resid===null ?: $this->rec_resid->setValue($rec_resid);
        return $this->rec_resid;
    }

    public function setRecResid($rec_resid)
    {
        $this->rec_resid = $rec_resid;

    }

    public function getRecRegion($rec_region = null)
    {
        $rec_region===null ?: $this->rec_region->setValue($rec_region);
        return $this->rec_region;
    }

    public function setRecRegion($rec_region)
    {
        $this->rec_region = $rec_region;

    }

    public function getRecAddress($rec_address = null)
    {
        $rec_address===null ?: $this->rec_address->setValue($rec_address);
        return $this->rec_address;
    }

    public function setRecAddress($rec_address)
    {
        $this->rec_address = $rec_address;

    }

    public function getRecBdate($rec_bdate = null)
    {
        $rec_bdate===null ?: $this->rec_bdate->setValue($rec_bdate);
        return $this->rec_bdate;
    }

    public function setRecBdate($rec_bdate)
    {
        $this->rec_bdate = $rec_bdate;

    }

    public function getRecDateV($rec_date_v = null)
    {
        $rec_date_v===null ?: $this->rec_date_v->setValue($rec_date_v);
        return $this->rec_date_v;
    }

    public function setRecDateV($rec_date_v)
    {
        $this->rec_date_v = $rec_date_v;

    }

    public function getUserId($user_id = null)
    {
        $user_id===null ?: $this->user_id->setValue($user_id);
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

    }

    public function getSprNp($spr_np = null)
    {
        $spr_np===null ?: $this->spr_np->setValue($spr_np);
        return $this->spr_np;
    }

    public function setSprNp($spr_np)
    {
        $this->spr_np = $spr_np;

    }

    public function getProcessLid($process_lid = null)
    {
        $process_lid===null ?: $this->process_lid->setValue($process_lid);
        return $this->process_lid;
    }

    public function setProcessLid($process_lid)
    {
        $this->process_lid = $process_lid;

    }

    public function getResource($resource = null)
    {
        $resource===null ?: $this->resource->setValue($resource);
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;

    }

    public function getIpAddress($ip_address = null)
    {
        $ip_address===null ?: $this->ip_address->setValue($ip_address);
        return $this->ip_address;
    }

    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;

    }
}
