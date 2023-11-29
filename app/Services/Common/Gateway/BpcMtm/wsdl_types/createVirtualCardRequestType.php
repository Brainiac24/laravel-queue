<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

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
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

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
   * @param cardIdentificationType $cardIdentification
   * @param virtualCardIdentificationType $virtualCardIdentification
   * @param amountType $amount
   * @param phoneNumberType $phoneNumber
   * @param currencyN3CodeType $currency
   * @param accountNumberType $accountNumber
   * @param virtualCardDataDeliveryMethodType $deliveryMethod
   * @access public
   */
  public function __construct($cardIdentification, $virtualCardIdentification, $amount, $phoneNumber, $currency, $accountNumber, $deliveryMethod)
  {
    $this->cardIdentification = $cardIdentification;
    $this->virtualCardIdentification = $virtualCardIdentification;
    $this->amount = $amount;
    $this->phoneNumber = $phoneNumber;
    $this->currency = $currency;
    $this->accountNumber = $accountNumber;
    $this->deliveryMethod = $deliveryMethod;
  }

}
