<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class feeCalculationResponseType
{

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
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @access public
   */
  public function __construct($amount, $currency)
  {
    $this->amount = $amount;
    $this->currency = $currency;
  }

}
