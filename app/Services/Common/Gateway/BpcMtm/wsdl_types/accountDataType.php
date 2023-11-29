<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class accountDataType
{

  /**
   * 
   * @var accountNumberType $number
   * @access public
   */
  public $number = null;

  /**
   * 
   * @var currencyN3CodeType $currency
   * @access public
   */
  public $currency = null;

  /**
   * 
   * @var amountType $balance
   * @access public
   */
  public $balance = null;

  /**
   * 
   * @var customerIdType $customerId
   * @access public
   */
  public $customerId = null;

  /**
   * 
   * @var cardAccountSequentialNumberType $cardAccountSequentialNumber
   * @access public
   */
  public $cardAccountSequentialNumber = null;

  /**
   * 
   * @param accountNumberType $number
   * @param currencyN3CodeType $currency
   * @param amountType $balance
   * @param customerIdType $customerId
   * @param cardAccountSequentialNumberType $cardAccountSequentialNumber
   * @access public
   */
  public function __construct($number, $currency, $balance, $customerId, $cardAccountSequentialNumber)
  {
    $this->number = $number;
    $this->currency = $currency;
    $this->balance = $balance;
    $this->customerId = $customerId;
    $this->cardAccountSequentialNumber = $cardAccountSequentialNumber;
  }

}
