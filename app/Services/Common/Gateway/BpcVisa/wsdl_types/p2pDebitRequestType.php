<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class p2pDebitRequestType
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
   * @var cardNumberType $creditedCardNumber
   * @access public
   */
  public $creditedCardNumber = null;

  /**
   * 
   * @var rrnType $externalRRN
   * @access public
   */
  public $externalRRN = null;

  /**
   * 
   * @var originalTransactionParametersType $originalTransactionParameters
   * @access public
   */
  public $originalTransactionParameters = null;

  /**
   * 
   * @var posCardholderPresenceType $posCardholderPresence
   * @access public
   */
  public $posCardholderPresence = null;

  /**
   * 
   * @var businessApplicationIdentifierType $businessApplicationIdentifier
   * @access public
   */
  public $businessApplicationIdentifier = null;

  /**
   * 
   * @var mcTransactionTypeIndicatorType $mcTransactionTypeIndicator
   * @access public
   */
  public $mcTransactionTypeIndicator = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountNumberType $accountNumber
   * @param tdsType $tds
   * @param senderReceiverInfoType $senderReceiverInfo
   * @param pointOfServiceDataCodeType $pointOfServiceDataCode
   * @param pointOfServiceConditionCodeType $pointOfServiceConditionCode
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @param securityLevelIndicatorType $securityLevelIndicator
   * @param cardNumberType $creditedCardNumber
   * @param rrnType $externalRRN
   * @param originalTransactionParametersType $originalTransactionParameters
   * @param posCardholderPresenceType $posCardholderPresence
   * @param businessApplicationIdentifierType $businessApplicationIdentifier
   * @param mcTransactionTypeIndicatorType $mcTransactionTypeIndicator
   * @access public
   */
  public function __construct($cardIdentification, $amount, $currency, $accountNumber, $tds, $senderReceiverInfo, $pointOfServiceDataCode, $pointOfServiceConditionCode, $cardAcceptorParameters, $securityLevelIndicator, $creditedCardNumber, $externalRRN, $originalTransactionParameters, $posCardholderPresence, $businessApplicationIdentifier, $mcTransactionTypeIndicator)
  {
    $this->cardIdentification = $cardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountNumber = $accountNumber;
    $this->tds = $tds;
    $this->senderReceiverInfo = $senderReceiverInfo;
    $this->pointOfServiceDataCode = $pointOfServiceDataCode;
    $this->pointOfServiceConditionCode = $pointOfServiceConditionCode;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
    $this->securityLevelIndicator = $securityLevelIndicator;
    $this->creditedCardNumber = $creditedCardNumber;
    $this->externalRRN = $externalRRN;
    $this->originalTransactionParameters = $originalTransactionParameters;
    $this->posCardholderPresence = $posCardholderPresence;
    $this->businessApplicationIdentifier = $businessApplicationIdentifier;
    $this->mcTransactionTypeIndicator = $mcTransactionTypeIndicator;
  }

}
