<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class createVirtualCardRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var virtualCardIdentificationType $virtualCardIdentification
   * @access public
   */
  public $virtualCardIdentification = null;

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
   * @var virtualCardDataDeliveryMethodType $deliveryMethod
   * @access public
   */
  public $deliveryMethod = null;

  /**
   * 
   * @var personalDataType $personalData
   * @access public
   */
  public $personalData = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param virtualCardIdentificationType $virtualCardIdentification
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountNumberType $accountNumber
   * @param virtualCardDataDeliveryMethodType $deliveryMethod
   * @param personalDataType $personalData
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public function __construct($cardIdentification, $virtualCardIdentification, $amount, $currency, $accountNumber, $deliveryMethod, $personalData, $cardAcceptorParameters)
  {
    $this->cardIdentification = $cardIdentification;
    $this->virtualCardIdentification = $virtualCardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountNumber = $accountNumber;
    $this->deliveryMethod = $deliveryMethod;
    $this->personalData = $personalData;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
  }

}
