<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class financialTransactionRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var amountType $amount
   * @access public
   */
  public $amount = null;

  /**
   * 
   * @var currencyN3CodeType $currency
   * @access public
   */
  public $currency = null;

  /**
   * 
   * @var accountTypeType $accountType
   * @access public
   */
  public $accountType = null;

  /**
   * 
   * @var accountIndexType $accountIndex
   * @access public
   */
  public $accountIndex = null;

  /**
   * 
   * @var accountNumberType $accountNumber
   * @access public
   */
  public $accountNumber = null;

  /**
   * 
   * @var accountTypeType $account2Type
   * @access public
   */
  public $account2Type = null;

  /**
   * 
   * @var accountIndexType $account2Index
   * @access public
   */
  public $account2Index = null;

  /**
   * 
   * @var accountNumberType $account2Number
   * @access public
   */
  public $account2Number = null;

  /**
   * 
   * @var tdsType $tds
   * @access public
   */
  public $tds = null;

  /**
   * 
   * @var senderReceiverInfoType $senderReceiverInfo
   * @access public
   */
  public $senderReceiverInfo = null;

  /**
   * 
   * @var pointOfServiceDataCodeType $pointOfServiceDataCode
   * @access public
   */
  public $pointOfServiceDataCode = null;

  /**
   * 
   * @var pointOfServiceConditionCodeType $pointOfServiceConditionCode
   * @access public
   */
  public $pointOfServiceConditionCode = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @var securityLevelIndicatorType $securityLevelIndicator
   * @access public
   */
  public $securityLevelIndicator = null;

  /**
   * 
   * @var fundingSourceType $fundingSource
   * @access public
   */
  public $fundingSource = null;

  /**
   * 
   * @var externalTransactionIdType $externalTransactionId
   * @access public
   */
  public $externalTransactionId = null;

  /**
   * 
   * @var posCardholderPresenceType $posCardholderPresence
   * @access public
   */
  public $posCardholderPresence = null;

  /**
   * 
   * @var string255 $uniqueReferenceNumber
   * @access public
   */
  public $uniqueReferenceNumber = null;

  /**
   * 
   * @var string255 $otp
   * @access public
   */
  public $otp = null;

  /**
   * 
   * @var serviceIdType $serviceId
   * @access public
   */
  public $serviceId = null;

  /**
   * 
   * @var paymentSpecificDataType $paymentSpecificData
   * @access public
   */
  public $paymentSpecificData = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountTypeType $accountType
   * @param accountIndexType $accountIndex
   * @param accountNumberType $accountNumber
   * @param accountTypeType $account2Type
   * @param accountIndexType $account2Index
   * @param accountNumberType $account2Number
   * @param tdsType $tds
   * @param senderReceiverInfoType $senderReceiverInfo
   * @param pointOfServiceDataCodeType $pointOfServiceDataCode
   * @param pointOfServiceConditionCodeType $pointOfServiceConditionCode
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @param securityLevelIndicatorType $securityLevelIndicator
   * @param fundingSourceType $fundingSource
   * @param externalTransactionIdType $externalTransactionId
   * @param posCardholderPresenceType $posCardholderPresence
   * @param string255 $uniqueReferenceNumber
   * @param string255 $otp
   * @param serviceIdType $serviceId
   * @param paymentSpecificDataType $paymentSpecificData
   * @access public
   */
  public function __construct($cardIdentification, $amount, $currency, $accountType, $accountIndex, $accountNumber, $account2Type, $account2Index, $account2Number, $tds, $senderReceiverInfo, $pointOfServiceDataCode, $pointOfServiceConditionCode, $cardAcceptorParameters, $securityLevelIndicator, $fundingSource, $externalTransactionId, $posCardholderPresence, $uniqueReferenceNumber, $otp, $serviceId, $paymentSpecificData)
  {
    $this->cardIdentification = $cardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountType = $accountType;
    $this->accountIndex = $accountIndex;
    $this->accountNumber = $accountNumber;
    $this->account2Type = $account2Type;
    $this->account2Index = $account2Index;
    $this->account2Number = $account2Number;
    $this->tds = $tds;
    $this->senderReceiverInfo = $senderReceiverInfo;
    $this->pointOfServiceDataCode = $pointOfServiceDataCode;
    $this->pointOfServiceConditionCode = $pointOfServiceConditionCode;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
    $this->securityLevelIndicator = $securityLevelIndicator;
    $this->fundingSource = $fundingSource;
    $this->externalTransactionId = $externalTransactionId;
    $this->posCardholderPresence = $posCardholderPresence;
    $this->uniqueReferenceNumber = $uniqueReferenceNumber;
    $this->otp = $otp;
    $this->serviceId = $serviceId;
    $this->paymentSpecificData = $paymentSpecificData;
  }

}
