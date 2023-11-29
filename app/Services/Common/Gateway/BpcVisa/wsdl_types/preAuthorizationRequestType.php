<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class preAuthorizationRequestType
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
   * @param tdsType $tds
   * @param senderReceiverInfoType $senderReceiverInfo
   * @param pointOfServiceDataCodeType $pointOfServiceDataCode
   * @param pointOfServiceConditionCodeType $pointOfServiceConditionCode
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @param securityLevelIndicatorType $securityLevelIndicator
   * @param posCardholderPresenceType $posCardholderPresence
   * @access public
   */
  public function __construct($cardIdentification, $amount, $currency, $accountType, $accountNumber, $tds, $senderReceiverInfo, $pointOfServiceDataCode, $pointOfServiceConditionCode, $cardAcceptorParameters, $securityLevelIndicator, $posCardholderPresence)
  {
    $this->cardIdentification = $cardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountType = $accountType;
    $this->accountNumber = $accountNumber;
    $this->tds = $tds;
    $this->senderReceiverInfo = $senderReceiverInfo;
    $this->pointOfServiceDataCode = $pointOfServiceDataCode;
    $this->pointOfServiceConditionCode = $pointOfServiceConditionCode;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
    $this->securityLevelIndicator = $securityLevelIndicator;
    $this->posCardholderPresence = $posCardholderPresence;
  }

}
