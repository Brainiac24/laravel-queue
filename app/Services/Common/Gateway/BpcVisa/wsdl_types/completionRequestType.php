<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class completionRequestType
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
   * @var accountNumberType $accountNumber
   * @access public
   */
  public $accountNumber = null;

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
   * @var rrnType $rrn
   * @access public
   */
  public $rrn = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @var posCardholderPresenceType $posCardholderPresence
   * @access public
   */
  public $posCardholderPresence = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountTypeType $accountType
   * @param accountNumberType $accountNumber
   * @param senderReceiverInfoType $senderReceiverInfo
   * @param pointOfServiceDataCodeType $pointOfServiceDataCode
   * @param pointOfServiceConditionCodeType $pointOfServiceConditionCode
   * @param rrnType $rrn
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @param posCardholderPresenceType $posCardholderPresence
   * @access public
   */
  public function __construct($cardIdentification, $amount, $currency, $accountType, $accountNumber, $senderReceiverInfo, $pointOfServiceDataCode, $pointOfServiceConditionCode, $rrn, $cardAcceptorParameters, $posCardholderPresence)
  {
    $this->cardIdentification = $cardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountType = $accountType;
    $this->accountNumber = $accountNumber;
    $this->senderReceiverInfo = $senderReceiverInfo;
    $this->pointOfServiceDataCode = $pointOfServiceDataCode;
    $this->pointOfServiceConditionCode = $pointOfServiceConditionCode;
    $this->rrn = $rrn;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
    $this->posCardholderPresence = $posCardholderPresence;
  }

}
