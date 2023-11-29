<?php

namespace App\Services\Common\Gateway\BpcMtm;

use App\Services\Common\Gateway\BpcMtm\wsdl_types\Apigate;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\cardIdentificationType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\changeCardStatusRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\creditCardRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\debitCardRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getCardBalanceRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getCardDataRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionDetailsBRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionsBRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionsRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionStatusRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\p2pTransferRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\reversalRequestType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\rowRangeType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateStrictPeriodType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateTimeLowerBoundedPeriodType;
use App\Services\Common\Gateway\BpcMtm\wsdl_types\validateCardRequestType;
use App\Services\Common\Helpers\Logger\Logger;
use Illuminate\Support\Facades\Log;


class BpcMtmTransport
{

    public $apigate;
    public $logger;

//    public function __construct() {
//        $this->logger = new Logger('gateways/bpc_mtm', 'BPC_MTM_TRANSPORT');
//        //$this->logger->info('-----LOG APIGATE 0.0: ');
//    }

    public function setApigate($typeHandler)
    {
        //$this->logger->info('-----LOG APIGATE 0.1: ');
        //$this->logger->info('-----LOG APIGATE 0: '. config('bpc_mtm.url'));
        //Log::info('-----LOG APIGATE 0' . config('bpc_mtm.url'));
        //file_put_contents("log-2021-03-19-1.txt",'-----LOG APIGATE 0: ' . config('bpc_mtm.url'),FILE_APPEND);
        $this->apigate = new Apigate([
            "connection_timeout" => config('bpc_mtm.connection_timeout'), 
            'trace' => 1,
            'keep_alive' => false
            /*'stream_context' => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    ]
                ]
            )*/
        ], config('bpc_mtm.url')); 
        $securityHeaderXML = <<<XML
<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"><wsse:UsernameToken wsu:Id="__TOKEN__"><wsse:Username>__LOGIN__</wsse:Username><wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">__PASSWORD__</wsse:Password></wsse:UsernameToken></wsse:Security>
XML;
        $securityHeaderXML=str_replace('__LOGIN__', config('bpc_mtm.'.$typeHandler.'.login'), $securityHeaderXML);
        $securityHeaderXML=str_replace('__PASSWORD__', config('bpc_mtm.'.$typeHandler.'.password'), $securityHeaderXML);
        $securityHeaderXML=str_replace('__TOKEN__', config('bpc_mtm.'.$typeHandler.'.token'), $securityHeaderXML);
        $objAuthVar = new \SoapVar($securityHeaderXML, XSD_ANYXML);
        $objAuthHeader = new \SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", 'Security', $objAuthVar, false);

        $this->apigate->__setSoapHeaders(array($objAuthHeader));
    }

    public function PayFromCard($extId, $cardNumber, float $amount, $currencyCode, $expDate)
    {
        //$this->logger->info('-----LOG APIGATE 3: '. json_encode($amount, JSON_UNESCAPED_UNICODE));
        $this->setApigate('pay_from_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $cardIdentificationType->expDate = $expDate;
        $debitCardRequestType = new debitCardRequestType();
        $debitCardRequestType->cardIdentification = $cardIdentificationType;
        $debitCardRequestType->amount = round($amount * 100);
        //$this->logger->info('-----LOG APIGATE 2: '. json_encode(floatval($debitCardRequestType->amount), JSON_UNESCAPED_UNICODE));
        $debitCardRequestType->extId =$extId;
        $debitCardRequestType->currency = $currencyCode;
        return $this->apigate->debitCard($debitCardRequestType);
        
    }

    public function FillCard($extId, $cardNumber, float $amount, $currencyCode)
    {
        //$this->logger->info('-----LOG APIGATE 3.1: '. json_encode($amount, JSON_UNESCAPED_UNICODE));
        $this->setApigate('fill_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $creditCardRequestType=new creditCardRequestType();
        $creditCardRequestType->amount = round($amount * 100);
        //$this->logger->info('-----LOG APIGATE 2.1: '. json_encode($creditCardRequestType->amount, JSON_UNESCAPED_UNICODE));
        $creditCardRequestType->currency=$currencyCode;
        $creditCardRequestType->extId=$extId;
        $creditCardRequestType->cardIdentification=$cardIdentificationType;

        return $this->apigate->creditCard($creditCardRequestType);
    }

    public function Card2Card($extId, $sourceCardNumber, $sourceCardExpDate, $destinationCardNumber, float $amount, $currencyCode)
    {
        $this->setApigate('card_2_card');
        $sourceCardIdentificationType = new cardIdentificationType();
        $sourceCardIdentificationType->cardNumber = $sourceCardNumber;
        $sourceCardIdentificationType->expDate = $sourceCardExpDate;
        $destinationCardIdentificationType = new cardIdentificationType();
        $destinationCardIdentificationType->cardNumber = $destinationCardNumber;
        $p2pTransferRequestType=new p2pTransferRequestType();
        $p2pTransferRequestType->amount = round($amount * 100);
        $p2pTransferRequestType->currency=$currencyCode;
        $p2pTransferRequestType->sourceCardIdentification=$sourceCardIdentificationType;
        $p2pTransferRequestType->destinationCardIdentification=$destinationCardIdentificationType;
        $p2pTransferRequestType->extId=$extId;

        return $this->apigate->p2pTransfer($p2pTransferRequestType);
    }

    public function GetTransactions($cardNumber, $dateTimeStart, $dateTimeEnd, $rowStart=1, $rowEnd=100)
    {
        $this->setApigate('get_transactions');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $rowRange=new rowRangeType($rowStart, $rowEnd);
        $transactionDateTimeLowerBoundedPeriodType=new transactionDateTimeLowerBoundedPeriodType($dateTimeStart, $dateTimeEnd);
        $getTransactionsBRequestType=new getTransactionsBRequestType();
        $getTransactionsBRequestType->rowRange=$rowRange;
        $getTransactionsBRequestType->period=$transactionDateTimeLowerBoundedPeriodType;
        $getTransactionsBRequestType->cardIdentification=$cardIdentificationType;

        return $this->apigate->getTransactionsB($getTransactionsBRequestType);
    }

    public function GetCardData($cardNumber, $expDate)
    {
        $this->setApigate('get_card_data');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $cardIdentificationType->expDate = $expDate;
        $getCardDataRequestType = new getCardDataRequestType($cardIdentificationType);

        return $this->apigate->getCardData($getCardDataRequestType);
    }

    public function GetTransactionStatus($extId, $isReversal=0)
    {
        $this->setApigate('get_transaction_status');
        $getTransactionStatusRequestType = new getTransactionStatusRequestType($extId, $isReversal);

        return $this->apigate->getTransactionStatus($getTransactionStatusRequestType);
    }


    public function GetTransactionDetails($utrnno,  $isReversal=false)
    {
        $this->setApigate('get_transaction_details');
        $getTransactionDetailsBRequestType = new getTransactionDetailsBRequestType();
        $getTransactionDetailsBRequestType->reversal=$isReversal;
        $getTransactionDetailsBRequestType->utrnno=$utrnno;

        return $this->apigate->getTransactionDetailsB($getTransactionDetailsBRequestType);
    }

    public function UnlockCard($extId, $cardNumber)
    {
        $this->setApigate('unlock_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $validateCardRequestType = new validateCardRequestType();
        $validateCardRequestType->cardIdentification=$cardIdentificationType;
        $validateCardRequestType->extId=$extId;
        return $this->apigate->validateCard($validateCardRequestType);

    }

    public function LockCard($extId, $cardNumber, $cardStatusCode)
    {
        $this->setApigate('lock_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $changeCardStatusRequestType = new changeCardStatusRequestType();
        $changeCardStatusRequestType->cardIdentification=$cardIdentificationType;
        $changeCardStatusRequestType->hotCardStatus=$cardStatusCode;
        $changeCardStatusRequestType->extId=$extId;
        return $this->apigate->blockCard($changeCardStatusRequestType);

    }

    public function Reversal($extId, $cardNumber, float $amount, $currencyCode, $processingCode, $transactionDate, $rrn, $authorizationIdResponse, $systemTraceAuditNumber)
    {
        $this->setApigate('reversal');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;

        $reversalRequestType=new reversalRequestType();
        $reversalRequestType->amount=round($amount * 100);
        $reversalRequestType->currency=$currencyCode;
        $reversalRequestType->processingCode=$processingCode;
        $reversalRequestType->transactionDate=$transactionDate;
        $reversalRequestType->rrn=$rrn;
        $reversalRequestType->authorizationIdResponse=$authorizationIdResponse;
        $reversalRequestType->cardIdentification=$cardIdentificationType;
        $reversalRequestType->systemTraceAuditNumber=$systemTraceAuditNumber;
        $reversalRequestType->extId=$extId;

        return $this->apigate->reversal($reversalRequestType);
    }

}
