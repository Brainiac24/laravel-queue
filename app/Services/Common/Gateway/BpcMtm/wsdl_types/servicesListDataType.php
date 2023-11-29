<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class servicesListDataType
{

  /**
   * 
   * @var serviceIdentificationType $serviceIdentificationType
   * @access public
   */
  public $serviceIdentificationType = null;

  /**
   * 
   * @var extNumberType $extNumber
   * @access public
   */
  public $extNumber = null;

  /**
   * 
   * @var serviceNumType $serviceNum
   * @access public
   */
  public $serviceNum = null;

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
   * @param serviceIdentificationType $serviceIdentificationType
   * @param extNumberType $extNumber
   * @param serviceNumType $serviceNum
   * @param notificationLimitAmountType $notificationLimitAmount
   * @param notificationLimitCurrencyType $notificationLimitCurrency
   * @access public
   */
  public function __construct($serviceIdentificationType, $extNumber, $serviceNum, $notificationLimitAmount, $notificationLimitCurrency)
  {
    $this->serviceIdentificationType = $serviceIdentificationType;
    $this->extNumber = $extNumber;
    $this->serviceNum = $serviceNum;
    $this->notificationLimitAmount = $notificationLimitAmount;
    $this->notificationLimitCurrency = $notificationLimitCurrency;
  }

}
