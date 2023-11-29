<?php

namespace App\Services\Common\Gateway\AbsTransport\TransfersSoniya;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;
use App\Services\Common\Gateway\AbsTransport\TransfersSoniya\TransfersSoniyaEntity;


class TransfersSoniyaService
{
    public $transfersLidEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, TransfersSoniyaEntity $transfersLidEntity)
    {
        $this->transfersLidEntity = $transfersLidEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function createRequest(
        $sessionId,
        $id_transaction,
        $family_cl,
        $name_cl,
        $sname_cl,
        $inn,
        $region_ref,
        $city_ref,
        $date_pers,
        $sex_ref,
        $type_ref,
        $date,
        $num,
        $ser,
        $who,
        $client_phone,
        $address,
        $citizen_id,
        $rec_family_cl,
        $rec_name_cl,
        $rec_sname_cl,
        $rec_receiver_phone,
        $rec_doc_num,
        $rec_doc_ser,
        $summa_pay,
        $summa,
        $summa_komis,
        $currency_code,
        $date_doc,
        $rate,
        $id_np
        ) {

        $e = $this->transfersLidEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('soniya.protocol_version')),
                    $e->getType($e::R_PAY_TRANSFER),
                    $e->getLogin(config('soniya.login')),
                    $e->getPassword(config('soniya.password')),
                    $e->getKey(config('soniya.key')),
                    $e->getIdTransaction($id_transaction),
                    $e->getFamilyCl($family_cl),
                    $e->getNameCl($name_cl),
                    $e->getSnameCl($sname_cl),
                    $e->getInn($inn),
                    $e->getRegionRef($region_ref),
                    $e->getCityRef($city_ref),
                    $e->getDatePers($date_pers),
                    $e->getSexRef($sex_ref),
                    $e->getDoc()->child([
                        $e->getTypeRef($type_ref),
                        $e->getDate($date),
                        $e->getNum($num),
                        $e->getSer($ser),
                        $e->getWho($who),
                    ]),
                    $e->getClientPhone($client_phone),
                    $e->getAddress($address),
                    $e->getCitizenId($citizen_id),
                    $e->getReceiver()->child([
                        $e->getRecFamilyCl($rec_family_cl),
                        $e->getRecNameCl($rec_name_cl),
                        $e->getRecSnameCl($rec_sname_cl),
                        $e->getRecReceiverPhone($rec_receiver_phone),
                        $e->getRecDocNum($rec_doc_num),
                        $e->getRecDocSer($rec_doc_ser),
                    ]),
                    $e->getSummaPay($summa_pay),
                    $e->getSumma($summa),
                    $e->getSummaKomis($summa_komis),
                    $e->getCurrencyCode($currency_code),
                    $e->getDateDoc($date_doc),
                    $e->getRate($rate),
                    $e->getIdNp($id_np),
                    $e->getUserId(config('soniya.user_id')),
                    $e->getPointId(config('soniya.point_id')),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_transfers_soniya_url'));
    }


    public function confirmRequest($sessionId, $id_transaction, $code_transfer, $date_doc) 
    {
        $e = $this->transfersLidEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('soniya.protocol_version')),
                    $e->getType($e::R_CONFIRM_SEND),
                    $e->getLogin(config('soniya.login')),
                    $e->getPassword(config('soniya.password')),
                    $e->getKey(config('soniya.key')),
                    $e->getIdTransaction($id_transaction),
                    $e->getCodeTransfer($code_transfer),
                    $e->getDateDoc($date_doc),
                    $e->getUserId(config('soniya.user_id')),
                    $e->getPointId(config('soniya.point_id')),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_transfers_soniya_url'));
    }

    public function createRequestV2(
        $sessionId,
        $id_transaction,
        $family_cl,
        $name_cl,
        $sname_cl,
        $inn,
        $region_ref,
        $city_ref,
        $date_pers,
        $sex_ref,
        $type_ref,
        $date,
        $num,
        $ser,
        $who,
        $client_phone,
        $address,
        $citizen_id,
        $rec_family_cl,
        $rec_name_cl,
        $rec_sname_cl,
        $rec_receiver_phone,
        $rec_doc_num,
        $rec_doc_ser,
        $summa_pay,
        $summa,
        $summa_komis,
        $currency_code,
        $date_doc,
        $rate,
        $id_np,
        $make_confirm
        ) {

        $e = $this->transfersLidEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('soniya.protocol_version')),
                    $e->getType($e::R_PAY_TRANSFER),
                    $e->getLogin(config('soniya.login')),
                    $e->getPassword(config('soniya.password')),
                    $e->getKey(config('soniya.key')),
                    $e->getIdTransaction($id_transaction),
                    $e->getFamilyCl($family_cl),
                    $e->getNameCl($name_cl),
                    $e->getSnameCl($sname_cl),
                    $e->getInn($inn),
                    $e->getRegionRef($region_ref),
                    $e->getCityRef($city_ref),
                    $e->getDatePers($date_pers),
                    $e->getSexRef($sex_ref),
                    $e->getDoc()->child([
                        $e->getTypeRef($type_ref),
                        $e->getDate($date),
                        $e->getNum($num),
                        $e->getSer($ser),
                        $e->getWho($who),
                    ]),
                    $e->getClientPhone($client_phone),
                    $e->getAddress($address),
                    $e->getCitizenId($citizen_id),
                    $e->getReceiver()->child([
                        $e->getRecFamilyCl($rec_family_cl),
                        $e->getRecNameCl($rec_name_cl),
                        $e->getRecSnameCl($rec_sname_cl),
                        $e->getRecReceiverPhone($rec_receiver_phone),
                        $e->getRecDocNum($rec_doc_num),
                        $e->getRecDocSer($rec_doc_ser),
                    ]),
                    $e->getSummaPay($summa_pay),
                    $e->getSumma($summa),
                    $e->getSummaKomis($summa_komis),
                    $e->getCurrencyCode($currency_code),
                    $e->getDateDoc($date_doc),
                    $e->getRate($rate),
                    $e->getIdNp($id_np),
                    $e->getUserId(config('soniya.user_id')),
                    $e->getPointId(config('soniya.point_id')),
                    $e->getMakeConfirm($make_confirm),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_transfers_soniya_url'));
    }

    public function checkStatusRequest($sessionId, $transaction_id, $code_transfer) 
    {
        $e = $this->transfersLidEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(config('soniya.protocol_version')),
                    $e->getType($e::R_CHECK_TRANSFER),
                    $e->getLogin(config('soniya.login')),
                    $e->getPassword(config('soniya.password')),
                    $e->getKey(config('soniya.key')),
                    $e->getTransactionId($transaction_id),
                    $e->getCodeTransfer($code_transfer),
                    $e->getUserId(config('soniya.user_id')),
                    $e->getPointId(config('soniya.point_id')),
                   
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_transfers_soniya_url'));
    }

}