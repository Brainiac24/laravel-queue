<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class p2pTransferRequestType
{

  /**
   * 
   * @var boolean $preAuthorization
   * @access public
   */
  public $preAuthorization = null;

  /**
   * 
   * @var cardIdentificationType $sourceCardIdentification
   * @access public
   */
  public $sourceCardIdentification = null;

  /**
   * 
   * @var cardIdentificationType $destinationCardIdentification
   * @access public
   */
  public $destinationCardIdentification = null;

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
   * @var accountNumberType $sourceAccountNumber
   * @access public
   */
  public $sourceAccountNumber = null;

  /**
   * 
   * @var accountNumberType $destinationAccountNumber
   * @access public
   */
  public $destinationAccountNumber = null;

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

}
