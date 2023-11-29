<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

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
   * @var currencyA3CodeType $currencyAlphaCode
   * @access public
   */
  public $currencyAlphaCode = null;

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
   * @var boolean $defaultAccount
   * @access public
   */
  public $defaultAccount = null;

  /**
   * 
   * @param accountNumberType $number
   * @param currencyN3CodeType $currency
   * @param currencyA3CodeType $currencyAlphaCode
   * @param amountType $balance
   * @param customerIdType $customerId
   * @param boolean $defaultAccount
   * @access public
   */
  public function __construct($number, $currency, $currencyAlphaCode, $balance, $customerId, $defaultAccount)
  {
    $this->number = $number;
    $this->currency = $currency;
    $this->currencyAlphaCode = $currencyAlphaCode;
    $this->balance = $balance;
    $this->customerId = $customerId;
    $this->defaultAccount = $defaultAccount;
  }

}
