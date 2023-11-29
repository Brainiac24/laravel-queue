<?php

namespace App\Services\Common\Gateway\BpcVisa;

use App\Services\Common\Gateway\BpcVisa\wsdl_types\Apigate;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\cardIdentificationType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\changeCardStatusRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\creditCardRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\debitCardRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardBalanceRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardDataRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\getTransactionsRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\p2pTransferRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\reversalRequestType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateStrictPeriodType;
use App\Services\Common\Gateway\BpcVisa\wsdl_types\validateCardRequestType;


class BpcVisaTransport
{

    public $apigate;

    public function setApigate($typeHandler)
    {
        $this->apigate = new Apigate([
            "connection_timeout" => config('bpc_visa.connection_timeout'), 
            'trace' => 1,
            'keep_alive' => false
    ], config('bpc_visa.url'));
        $securityHeaderXML = <<<XML
<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"><wsse:UsernameToken wsu:Id="__TOKEN__"><wsse:Username>__LOGIN__</wsse:Username><wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">__PASSWORD__</wsse:Password></wsse:UsernameToken></wsse:Security>
XML;
        $securityHeaderXML=str_replace('__LOGIN__', config('bpc_visa.'.$typeHandler.'.login'), $securityHeaderXML);
        $securityHeaderXML=str_replace('__PASSWORD__', config('bpc_visa.'.$typeHandler.'.password'), $securityHeaderXML);
        $securityHeaderXML=str_replace('__TOKEN__', config('bpc_visa.'.$typeHandler.'.token'), $securityHeaderXML);
        $objAuthVar = new \SoapVar($securityHeaderXML, XSD_ANYXML);
        $objAuthHeader = new \SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", 'Security', $objAuthVar, false);

        $this->apigate->__setSoapHeaders(array($objAuthHeader));
    }
    
    public function PayFromCard($cardNumber, float $amount, $currencyCode, $expDate)
    {
        $this->setApigate('pay_from_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $cardIdentificationType->expDate = $expDate;
        $debitCardRequestType = new debitCardRequestType();
        $debitCardRequestType->cardIdentification = $cardIdentificationType;
        $debitCardRequestType->amount = round($amount * 100);
        $debitCardRequestType->currency = $currencyCode;
        return $this->apigate->debitCard($debitCardRequestType);
    }

    public function FillCard($cardNumber, float $amount, $currencyCode)
    {
        $this->setApigate('fill_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $creditCardRequestType=new creditCardRequestType();
        $creditCardRequestType->amount=round($amount * 100);
        $creditCardRequestType->currency=$currencyCode;
        $creditCardRequestType->cardIdentification=$cardIdentificationType;

        return $this->apigate->creditCard($creditCardRequestType);
    }
//TODO
    public function Card2Card($sourceCardNumber, $sourceCardExpDate, $destinationCardNumber, float $amount, $currencyCode)
    {
        $this->setApigate('card_2_card');
        $sourceCardIdentificationType = new cardIdentificationType();
        $sourceCardIdentificationType->cardNumber = $sourceCardNumber;
        $sourceCardIdentificationType->expDate = $sourceCardExpDate;
        $destinationCardIdentificationType = new cardIdentificationType();
        $destinationCardIdentificationType->cardNumber = $destinationCardNumber;
        $p2pTransferRequestType=new p2pTransferRequestType();
        $p2pTransferRequestType->amount=round($amount * 100);
        $p2pTransferRequestType->currency=$currencyCode;
        $p2pTransferRequestType->sourceCardIdentification=$sourceCardIdentificationType;
        $p2pTransferRequestType->destinationCardIdentification=$destinationCardIdentificationType;

        return $this->apigate->p2pTransfer($p2pTransferRequestType);
    }

    public function GetTransactions($cardNumber, $dateStart, $dateEnd)
    {
        $this->setApigate('get_transactions');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $transactionDateStrictPeriodType=new transactionDateStrictPeriodType($dateStart, $dateEnd);
        $getTransactionsRequestType=new getTransactionsRequestType($cardIdentificationType, $transactionDateStrictPeriodType);

        return $this->apigate->getTransactions($getTransactionsRequestType);
    }

    public function GetCardBalance($cardNumber)
    {
        $this->setApigate('get_card_balance');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $getCardBalanceRequestType = new getCardBalanceRequestType();
        $getCardBalanceRequestType->cardIdentification=$cardIdentificationType;

        return $this->apigate->getCardBalance($getCardBalanceRequestType);
    }

    public function GetCardData($cardNumber, $expDate)
    {
        $this->setApigate('get_card_data');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $cardIdentificationType->expDate = $expDate;
        $getCardDataRequestType = new getCardDataRequestType($cardIdentificationType, null);

        return $this->apigate->getCardData($getCardDataRequestType);
    }

    public function ChangeCardStatus($cardNumber, $cardStatusCode)
    {
        $this->setApigate('change_card_status');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $changeCardStatusRequestType = new changeCardStatusRequestType();
        $changeCardStatusRequestType->cardIdentification=$cardIdentificationType;
        $changeCardStatusRequestType->hotCardStatus=$cardStatusCode;
        return $this->apigate->changeCardStatus($changeCardStatusRequestType);

    }

    public function ValidateCard($cardNumber)
    {
        $this->setApigate('validate_card');
        $cardIdentificationType = new cardIdentificationType();
        $cardIdentificationType->cardNumber = $cardNumber;
        $validateCardRequestType = new validateCardRequestType();
        $validateCardRequestType->cardIdentification=$cardIdentificationType;
        return $this->apigate->validateCard($validateCardRequestType);

    }

    public function Reversal($cardNumber, float $amount, $currencyCode, $processingCode, $transactionDate, $rrn, $authorizationIdResponse, $systemTraceAuditNumber)
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
        $reversalRequestType->systemTraceAuditNumber =$systemTraceAuditNumber ;
        $reversalRequestType->cardIdentification=$cardIdentificationType;

        return $this->apigate->reversal($reversalRequestType);
    }

}
