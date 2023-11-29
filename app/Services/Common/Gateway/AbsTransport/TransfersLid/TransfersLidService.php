<?php

namespace App\Services\Common\Gateway\AbsTransport\TransfersLid;

use App\Services\Common\Gateway\AbsTransport\AbsTransportService;

class TransfersLidService
{
    public $transfersLidEntity;
    public $transportService;
    public $log_name = 'ClassNotSet';

    public function __construct(AbsTransportService $transportService, TransfersLidEntity $transfersLidEntity)
    {
        $this->transfersLidEntity = $transfersLidEntity;
        $this->transportService = $transportService;
        $this->log_name = get_class($this);
    }

    public function createRequest(
        $sessionId,
        $pay_system,
        $kdp,
        $date_doc,
        $country,
        $summa,
        $spr_val,
        $contacts,
        $doc_num,
        $doc_seria,
        $cer_type,
        $who,
        $sen_name,
        $enroll_type,
        $acc_pan,
        $summa_po,
        $rate,
        $coment,
        $sen_resid,
        $rec_name,
        $rec_citiz,
        $rec_resid,
        $rec_region,
        $rec_address,
        $rec_bdate,
        $rec_date_v,
        $user_id,
        $spr_np,
        $process_lid,
        $resource,
        $ip_address
        ) {

        $e = $this->transfersLidEntity;
        
        $head = $e->getHead();
        $request = $e->getRequest();

        $res =  $head->child([
                    $e->getSessionId($sessionId),
                    $e->getCallbackUrl(),
                ])->toArray() +
                $request->child([
                    $e->getProtocolVersion(),
                    $e->getType($e::R_TRANSFER_PAY_LID),
                    $e->getStateCode(),
                    $e->getStateMsg(),
                    $e->getPaySystem($pay_system),
                    $e->getKdp($kdp),
                    $e->getDateDoc($date_doc),
                    $e->getCountry($country),
                    $e->getSumma($summa),
                    $e->getSprVal($spr_val),
                    $e->getContacts($contacts),
                    $e->getDocNum($doc_num),
                    $e->getDocSeria($doc_seria),
                    $e->getCerType($cer_type),
                    $e->getWho($who),
                    $e->getSenName($sen_name),
                    $e->getEnrollType($enroll_type),
                    $e->getAccPan($acc_pan),
                    $e->getSummaPo($summa_po),
                    $e->getRate($rate),
                    $e->getComent($coment),
                    $e->getSenResid($sen_resid),
                    $e->getRecName($rec_name),
                    $e->getRecCitiz($rec_citiz),
                    $e->getRecResid($rec_resid),
                    $e->getRecRegion($rec_region),
                    $e->getRecAddress($rec_address),
                    $e->getRecBdate($rec_bdate),
                    $e->getRecDateV($rec_date_v),
                    $e->getUserId($user_id),
                    $e->getSprNp($spr_np),
                    $e->getProcessLid($process_lid),
                    $e->getResource($resource),
                    $e->getIpAddress($ip_address),
                ])->toArray();

        return $this->transportService->sendRequest($res, config('abs.server_transfers_lid_url'));
    }

}