<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class feeType
{

  /**
   * 
   * @var amountType $feeAmount
   * @access public
   */
  public $feeAmount = null;

  /**
   * 
   * @var currencyN3CodeType $feeCurrency
   * @access public
   */
  public $feeCurrency = null;

  /**
   * 
   * @param amountType $feeAmount
   * @param currencyN3CodeType $feeCurrency
   * @access public
   */
  public function __construct($feeAmount, $feeCurrency)
  {
    $this->feeAmount = $feeAmount;
    $this->feeCurrency = $feeCurrency;
  }

}
