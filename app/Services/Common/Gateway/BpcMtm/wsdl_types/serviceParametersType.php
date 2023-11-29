<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class serviceParametersType
{

  /**
   * 
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

  /**
   * 
   * @var extNumberType $extNumber
   * @access public
   */
  public $extNumber = null;

  /**
   * 
   * @var notificationLimitAmountType $notificationLimitAmount
   * @access public
   */
  public $notificationLimitAmount = null;

  /**
   * 
   * @var notificationLimitCurrencyType $notificationLimitCurrency
   * @access public
   */
  public $notificationLimitCurrency = null;

  /**
   * 
   * @param phoneNumberType $phoneNumber
   * @param emailType $email
   * @param extNumberType $extNumber
   * @param notificationLimitAmountType $notificationLimitAmount
   * @param notificationLimitCurrencyType $notificationLimitCurrency
   * @access public
   */
  public function __construct($phoneNumber, $email, $extNumber, $notificationLimitAmount, $notificationLimitCurrency)
  {
    $this->phoneNumber = $phoneNumber;
    $this->email = $email;
    $this->extNumber = $extNumber;
    $this->notificationLimitAmount = $notificationLimitAmount;
    $this->notificationLimitCurrency = $notificationLimitCurrency;
  }

}
