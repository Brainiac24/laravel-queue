<?php

namespace App\Services\Common\Gateway\AbsTransport\Users;

class UserService
{
    public $userEntity;
    public $transportService;

    public function __construct($transportService, UserEntity $userEntity)
    {
        $this->userEntity = $userEntity;
        $this->transportService = $transportService;
    }

    public function searchClient($sessionId, $family_cl, $name_cl, $sname_cl, $inn, $num, $ser) 
    {
        $e = $this->userEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();


        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_FN_CL_PRIV),
                    $e->getFamily_cl($family_cl),
                    $e->getName_cl($name_cl),
                    $e->getSname_cl($sname_cl),
                    $e->getInn($inn),
                    $e->getNum($num),
                    $e->getSer($ser),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_url'));
    }

    public function getClientInfo($sessionId, $abs_id) 
    {
        $e = $this->userEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();


        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_GET_CL_PRIV),
                    $e->getAbs_id($abs_id),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_url'));
    }
    
    public function registerClient($sessionId, 
                                    $date_create, 
                                    $client_abs_id, 
                                    $create_user_id, 
                                    $client_state, 
                                    $filial_id, 
                                    $depart_id,
                                    $client_phone
    ) 
    {
        $e = $this->userEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_ADD_CHANGE_ESH_ONLINE),
                    $e->getDate_create($date_create),
                    $e->getClient_abs_id($client_abs_id),
                    $e->getCreate_user_id($create_user_id),
                    $e->getClient_state($client_state),
                    $e->getFilial_id($filial_id),
                    $e->getDepart_id($depart_id),
                    $e->getClient_phone($client_phone),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_url'));
    }

    public function createClient(
        $sessionId, 
        $family_cl, 
        $name_cl, 
        $sname_cl, 
        $inn, 
        $country_ref, 
        $is_resident, 
        $date_pers,
        $sex_ref,
        $doc_type_ref,
        $doc_date,
        $doc_date_end,
        $doc_num,
        $doc_ser,
        $doc_who,
        $address_type_ref,
        $address_city_ref,
        $address_street_str,
        $address_house,
        $address_korpus,
        $address_flat,
        $address_reg_date,
        $address_imp_str,
        $contact_type_ref,
        $contact_numb,
        $contact_active
    ) 
    {
        $e = $this->userEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();


        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_CR_CL_PRIV),
                    $e->getFamily_cl($family_cl),
                    $e->getName_cl($name_cl),
                    $e->getSname_cl($sname_cl),
                    $e->getInn($inn),
                    $e->getCountry_ref($country_ref),
                    $e->getIs_resident($is_resident),
                    $e->getDate_pers($date_pers),
                    $e->getSex_ref($sex_ref),
                    $e->getMarige_status_ref(),
                    $e->getBorn_ref(),
                    $e->getDoc()->child([
                        $e->getType_ref($doc_type_ref),
                        $e->getBirth_place(),
                        $e->getDate($doc_date),
                        $e->getDate_end($doc_date_end),
                        $e->getNum($doc_num),
                        $e->getSer($doc_ser),
                        $e->getWho($doc_who),
                    ]) ,
                    $e->getAddresses()->child([
                        $e->getAddress()->child([
                            $e->getType_ref($address_type_ref),
                            $e->getPost_code(),
                            $e->getCity_ref($address_city_ref),
                            $e->getStreet_str($address_street_str),
                            $e->getHouse($address_house),
                            $e->getKorpus($address_korpus),
                            $e->getFlat($address_flat),
                            $e->getReg_date($address_reg_date),
                            $e->getImp_str($address_imp_str),
                        ]) ,
                    ]) ,
                    $e->getContacts()->child([
                        $e->getContact()->child([
                            $e->getType_ref($contact_type_ref),
                            $e->getNumb($contact_numb),
                            $e->getActive($contact_active),
                        ]) ,
                    ]) ,
                    $e->getRelatives(),
                    $e->getDocs(),
                    $e->getOkveds(),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_url'));
    }


    public function updateClient(
        $sessionId, 
        $abs_id, 
        $family_cl, 
        $name_cl, 
        $sname_cl, 
        $inn, 
        $country_ref, 
        $is_resident, 
        $date_pers,
        $sex_ref,
        $doc_type_ref,
        $doc_date,
        $doc_date_end,
        $doc_num,
        $doc_ser,
        $doc_who,
        $address_type_ref,
        $address_city_ref,
        $address_street_str,
        $address_house,
        $address_korpus,
        $address_flat,
        $address_reg_date,
        $address_imp_str,
        $contact_type_ref,
        $contact_numb,
        $contact_active
    ) 
    {
        $e = $this->userEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();


        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_ED_CL_PRIV),
                    $e->getAbs_id($abs_id),
                    $e->getFamily_cl($family_cl),
                    $e->getName_cl($name_cl),
                    $e->getSname_cl($sname_cl),
                    $e->getInn($inn),
                    $e->getCountry_ref($country_ref),
                    $e->getIs_resident($is_resident),
                    $e->getDate_pers($date_pers),
                    $e->getSex_ref($sex_ref),
                    $e->getMarige_status_ref(),
                    $e->getBorn_ref(),
                    $e->getDoc()->child([
                        $e->getType_ref($doc_type_ref),
                        $e->getBirth_place(),
                        $e->getDate($doc_date),
                        $e->getDate_end($doc_date_end),
                        $e->getNum($doc_num),
                        $e->getSer($doc_ser),
                        $e->getWho($doc_who),
                    ]) ,
                    $e->getAddresses()->child([
                        $e->getAddress()->child([
                            $e->getType_ref($address_type_ref),
                            $e->getPost_code(),
                            $e->getCity_ref($address_city_ref),
                            $e->getStreet_str($address_street_str),
                            $e->getHouse($address_house),
                            $e->getKorpus($address_korpus),
                            $e->getFlat($address_flat),
                            $e->getReg_date($address_reg_date),
                            $e->getImp_str($address_imp_str),
                        ]) ,
                    ]) ,
                    $e->getContacts()->child([
                        $e->getContact()->child([
                            $e->getType_ref($contact_type_ref),
                            $e->getNumb($contact_numb),
                            $e->getActive($contact_active),
                        ]) ,
                    ]) ,
                    $e->getRelatives(),
                    $e->getDocs(),
                    $e->getOkveds(),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_url'));
    }

}