<?php

namespace App\Services\Common\Gateway\AbsTransport\Users;

use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\TagEntity;

class UserEntity extends AbsTransportEntity
{
    const R_FN_CL_PRIV = 'R_FN_CL_PRIV';
    const R_ADD_CHANGE_ESH_ONLINE = 'R_ADD_CHANGE_ESH_ONLINE';
    const R_CR_CL_PRIV = 'R_CR_CL_PRIV';
    const R_ED_CL_PRIV = 'R_ED_CL_PRIV';
    const R_GET_CL_PRIV = 'R_GET_CL_PRIV';

    private $users;
    private $user;
    private $id;
    private $msisdn;

    private $abs_id;
    private $family_cl;
    private $name_cl;
    private $sname_cl;
    private $inn;
    private $country_ref;
    private $is_resident;
    private $date_pers;
    private $sex_ref;
    private $marige_status_ref;
    private $born_ref;
    private $doc;
    private $type_ref;
    private $birth_place;
    private $date;
    private $date_end;
    private $num;
    private $ser;
    private $who;
    private $addresses;
    private $address;
    private $post_code;
    private $city_ref;
    private $street_str;
    private $house;
    private $korpus;
    private $flat;
    private $reg_date;
    private $imp_str;
    private $contacts;
    private $contact;
    private $numb;
    private $active;
    private $relatives;
    private $relative;
    private $name;
    private $date_birth;
    private $age;
    private $dependant;
    private $cognate_status;
    private $docs;
    private $okveds;
    private $okved;
    private $okved_ref;
    private $date_create;
    private $client_abs_id;
    private $create_user_id;
    private $client_state;
    private $filial_id;
    private $depart_id;
    private $client_phone;


    public function __construct()
    {
        parent::__construct();
        $this->users = TagEntity::new ('users');
        $this->user = TagEntity::new ('user');
        $this->id = TagEntity::new ('id');
        $this->msisdn = TagEntity::new ('msisdn');

        $this->abs_id = TagEntity::new ('abs_id');
        $this->family_cl = TagEntity::new ('family_cl');
        $this->name_cl = TagEntity::new ('name_cl');
        $this->sname_cl = TagEntity::new ('sname_cl');
        $this->inn = TagEntity::new ('inn');
        $this->country_ref = TagEntity::new ('country_ref');
        $this->is_resident = TagEntity::new ('is_resident');
        $this->date_pers = TagEntity::new ('date_pers');
        $this->sex_ref = TagEntity::new ('sex_ref');
        $this->marige_status_ref = TagEntity::new ('marige_status_ref');
        $this->born_ref = TagEntity::new ('born_ref');
        $this->doc = TagEntity::new ('doc');
        $this->type_ref = TagEntity::new ('type_ref');
        $this->birth_place = TagEntity::new ('birth_place');
        $this->date = TagEntity::new ('date');
        $this->date_end = TagEntity::new ('date_end');
        $this->num = TagEntity::new ('num');
        $this->ser = TagEntity::new ('ser');
        $this->who = TagEntity::new ('who');
        $this->addresses = TagEntity::new ('addresses');
        $this->address = TagEntity::new ('address');
        $this->post_code = TagEntity::new ('post_code');
        $this->city_ref = TagEntity::new ('city_ref');
        $this->street_str = TagEntity::new ('street_str');
        $this->house = TagEntity::new ('house');
        $this->korpus = TagEntity::new ('korpus');
        $this->flat = TagEntity::new ('flat');
        $this->reg_date = TagEntity::new ('reg_date');
        $this->imp_str = TagEntity::new ('imp_str');
        $this->contacts = TagEntity::new ('contacts');
        $this->contact = TagEntity::new ('contact');
        $this->numb = TagEntity::new ('numb');
        $this->active = TagEntity::new ('active');
        $this->relatives = TagEntity::new ('relatives');
        $this->relative = TagEntity::new ('relative');
        $this->name = TagEntity::new ('name');
        $this->date_birth = TagEntity::new ('date_birth');
        $this->age = TagEntity::new ('age');
        $this->dependant = TagEntity::new ('dependant');
        $this->cognate_status = TagEntity::new ('cognate_status');
        $this->docs = TagEntity::new ('docs');
        $this->okveds = TagEntity::new ('okveds');
        $this->okved = TagEntity::new ('okved');
        $this->okved_ref = TagEntity::new ('okved_ref');
        $this->date_create = TagEntity::new ('date_create');
        $this->client_abs_id = TagEntity::new ('client_abs_id');
        $this->create_user_id = TagEntity::new ('create_user_id');
        $this->client_state = TagEntity::new ('client_state');
        $this->filial_id = TagEntity::new ('filial_id');
        $this->depart_id = TagEntity::new ('depart_id');
        $this->client_phone = TagEntity::new ('client_phone');
    }


    public function getUsers($users=null)
    {
        empty($users)?:$this->users->setValue($users);
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users->setValue($users);
    }

    public function getUser($user=null)
    {
        empty($user)?:$this->user->setValue($user);
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user->setValue($user);
    }

    public function getId($id=null)
    {
        empty($id)?:$this->id->setValue($id);
        return $this->id;
    }

    public function setId($id)
    {
        $this->id->setValue($id);
    }

    public function getMsisdn($msisdn=null)
    {
        empty($msisdn)?:$this->msisdn->setValue($msisdn);
        return $this->msisdn;
    }


    public function setMsisdn($msisdn)
    {
        $this->msisdn->setValue($msisdn);
    }



    public function getFamily_cl($family_cl=null)
    {
        empty($family_cl)?:$this->family_cl->setValue($family_cl);
        return $this->family_cl;
    }
 
    public function setFamily_cl($family_cl)
    {
        $this->family_cl = $family_cl;
    }

    public function getName_cl($name_cl=null)
    {
        empty($name_cl)?:$this->name_cl->setValue($name_cl);
        return $this->name_cl;
    }

    public function setName_cl($name_cl)
    {
        $this->name_cl = $name_cl;
    }

    public function getSname_cl($sname_cl=null)
    {
        empty($sname_cl)?:$this->sname_cl->setValue($sname_cl);
        return $this->sname_cl;
    }

    public function setSname_cl($sname_cl)
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

    public function getCountry_ref($country_ref=null)
    {
        empty($country_ref)?:$this->country_ref->setValue($country_ref);
        return $this->country_ref;
    }

    public function setCountry_ref($country_ref)
    {
        $this->country_ref = $country_ref;
    }
 
    public function getIs_resident($is_resident=null)
    {
        empty($is_resident)?:$this->is_resident->setValue($is_resident);
        return $this->is_resident;
    }

    public function setIs_resident($is_resident)
    {
        $this->is_resident = $is_resident;
    }

    public function getDate_pers($date_pers=null)
    {
        empty($date_pers)?:$this->date_pers->setValue($date_pers);
        return $this->date_pers;
    }

    public function setDate_pers($date_pers)
    {
        $this->date_pers = $date_pers;
    }

    public function getSex_ref($sex_ref=null)
    {
        empty($sex_ref)?:$this->sex_ref->setValue($sex_ref);
        return $this->sex_ref;
    }

    public function setSex_ref($sex_ref)
    {
        $this->sex_ref = $sex_ref;
    }

    public function getMarige_status_ref($marige_status_ref=null)
    {
        empty($marige_status_ref)?:$this->marige_status_ref->setValue($marige_status_ref);
        return $this->marige_status_ref;
    }

    public function setMarige_status_ref($marige_status_ref)
    {
        $this->marige_status_ref = $marige_status_ref;
    }

    public function getBorn_ref($born_ref=null)
    {
        empty($born_ref)?:$this->born_ref->setValue($born_ref);
        return $this->born_ref;
    }

    public function setBorn_ref($born_ref)
    {
        $this->born_ref = $born_ref;
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

    public function getType_ref($type_ref=null)
    {
        empty($type_ref)?:$this->type_ref->setValue($type_ref);
        return $this->type_ref;
    }

    public function setType_ref($type_ref)
    {
        $this->type_ref = $type_ref;
    }

    public function getBirth_place($birth_place=null)
    {
        empty($birth_place)?:$this->birth_place->setValue($birth_place);
        return $this->birth_place;
    }

    public function setBirth_place($birth_place)
    {
        $this->birth_place = $birth_place;
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

    public function getDate_end($date_end=null)
    {
        empty($date_end)?:$this->date_end->setValue($date_end);
        return $this->date_end;
    }

    public function setDate_end($date_end)
    {
        $this->date_end = $date_end;
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

    public function getAddresses($addresses=null)
    {
        empty($addresses)?:$this->addresses->setValue($addresses);
        return $this->addresses;
    }

    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
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

    public function getPost_code($post_code=null)
    {
        empty($post_code)?:$this->post_code->setValue($post_code);
        return $this->post_code;
    }

    public function setPost_code($post_code)
    {
        $this->post_code = $post_code;
    }

    public function getCity_ref($city_ref=null)
    {
        empty($city_ref)?:$this->city_ref->setValue($city_ref);
        return $this->city_ref;
    }

    public function setCity_ref($city_ref)
    {
        $this->city_ref = $city_ref;
    }

    public function getStreet_str($street_str=null)
    {
        empty($street_str)?:$this->street_str->setValue($street_str);
        return $this->street_str;
    }

    public function setStreet_str($street_str)
    {
        $this->street_str = $street_str;
    }

    public function getHouse($house=null)
    {
        empty($house)?:$this->house->setValue($house);
        return $this->house;
    }

    public function setHouse($house)
    {
        $this->house = $house;
    }

    public function getKorpus($korpus=null)
    {
        empty($korpus)?:$this->korpus->setValue($korpus);
        return $this->korpus;
    }

    public function setKorpus($korpus)
    {
        $this->korpus = $korpus;
    }

    public function getFlat($flat=null)
    {
        empty($flat)?:$this->flat->setValue($flat);
        return $this->flat;
    }

    public function setFlat($flat)
    {
        $this->flat = $flat;
    }

    public function getReg_date($reg_date=null)
    {
        empty($reg_date)?:$this->reg_date->setValue($reg_date);
        return $this->reg_date;
    }

    public function setReg_date($reg_date)
    {
        $this->reg_date = $reg_date;
    }

    public function getImp_str($imp_str=null)
    {
        empty($imp_str)?:$this->imp_str->setValue($imp_str);
        return $this->imp_str;
    }

    public function setImp_str($imp_str)
    {
        $this->imp_str = $imp_str;
    }

    public function getContacts($contacts=null)
    {
        empty($contacts)?:$this->contacts->setValue($contacts);
        return $this->contacts;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    public function getContact($contact=null)
    {
        empty($contact)?:$this->contact->setValue($contact);
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function getNumb($numb=null)
    {
        empty($numb)?:$this->numb->setValue($numb);
        return $this->numb;
    }

    public function setNumb($numb)
    {
        $this->numb = $numb;
    }

    public function getActive($active=null)
    {
        empty($active)?:$this->active->setValue($active);
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getRelatives($relatives=null)
    {
        empty($relatives)?:$this->relatives->setValue($relatives);
        return $this->relatives;
    }

    public function setRelatives($relatives)
    {
        $this->relatives = $relatives;
    }

    public function getRelative($relative=null)
    {
        empty($relative)?:$this->relative->setValue($relative);
        return $this->relative;
    }

    public function setRelative($relative)
    {
        $this->relative = $relative;
    }

    public function getName($name=null)
    {
        empty($name)?:$this->name->setValue($name);
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDate_birth($date_birth=null)
    {
        empty($date_birth)?:$this->date_birth->setValue($date_birth);
        return $this->date_birth;
    }

    public function setDate_birth($date_birth)
    {
        $this->date_birth = $date_birth;
    }

    public function getAge($age=null)
    {
        empty($age)?:$this->age->setValue($age);
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getDependant($dependant=null)
    {
        empty($dependant)?:$this->dependant->setValue($dependant);
        return $this->dependant;
    }

    public function setDependant($dependant)
    {
        $this->dependant = $dependant;
    }

    public function getCognate_status($cognate_status=null)
    {
        empty($cognate_status)?:$this->cognate_status->setValue($cognate_status);
        return $this->cognate_status;
    }

    public function setCognate_status($cognate_status)
    {
        $this->cognate_status = $cognate_status;
    }

    public function getDocs($docs=null)
    {
        empty($docs)?:$this->docs->setValue($docs);
        return $this->docs;
    }

    public function setDocs($docs)
    {
        $this->docs = $docs;
    }

    public function getOkveds($okveds=null)
    {
        empty($okveds)?:$this->okveds->setValue($okveds);
        return $this->okveds;
    }
 
    public function setOkveds($okveds)
    {
        $this->okveds = $okveds;
    }

    public function getOkved($okved=null)
    {
        empty($okved)?:$this->okved->setValue($okved);
        return $this->okved;
    }

    public function setOkved($okved)
    {
        $this->okved = $okved;
    }

    public function getOkved_ref($okved_ref=null)
    {
        empty($okved_ref)?:$this->okved_ref->setValue($okved_ref);
        return $this->okved_ref;
    }

    public function setOkved_ref($okved_ref)
    {
        $this->okved_ref = $okved_ref;
    }

    public function getDate_create($date_create=null)
    {
        empty($date_create)?:$this->date_create->setValue($date_create);
        return $this->date_create;
    }

    public function setDate_create($date_create)
    {
        $this->date_create = $date_create;
    }

    public function getClient_abs_id($client_abs_id=null)
    {
        empty($client_abs_id)?:$this->client_abs_id->setValue($client_abs_id);
        return $this->client_abs_id;
    }

    public function setClient_abs_id($client_abs_id)
    {
        $this->client_abs_id = $client_abs_id;
    }

    public function getCreate_user_id($create_user_id=null)
    {
        empty($create_user_id)?:$this->create_user_id->setValue($create_user_id);
        return $this->create_user_id;
    }

    public function setCreate_user_id($create_user_id)
    {
        $this->create_user_id = $create_user_id;
    }

    public function getClient_state($client_state=null)
    {
        empty($client_state)?:$this->client_state->setValue($client_state);
        return $this->client_state;
    }

    public function setClient_state($client_state)
    {
        $this->client_state = $client_state;
    }

    public function getFilial_id($filial_id=null)
    {
        empty($filial_id)?:$this->filial_id->setValue($filial_id);
        return $this->filial_id;
    }

    public function setFilial_id($filial_id)
    {
        $this->filial_id = $filial_id;
    }

    public function getDepart_id($depart_id=null)
    {
        empty($depart_id)?:$this->depart_id->setValue($depart_id);
        return $this->depart_id;
    }

    public function setDepart_id($depart_id)
    {
        $this->depart_id = $depart_id;
    }

    public function getClient_phone($client_phone=null)
    {
        empty($client_phone)?:$this->client_phone->setValue($client_phone);
        return $this->client_phone;
    }

    public function setClient_phone($client_phone)
    {
        $this->client_phone = $client_phone;
    }

    public function getAbs_id($abs_id=null)
    {
        empty($abs_id)?:$this->abs_id->setValue($abs_id);
        return $this->abs_id;
    }

    public function setAbs_id($abs_id)
    {
        $this->abs_id = $abs_id;
    }
}