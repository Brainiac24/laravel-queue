<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getTransactionsRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var transactionDateStrictPeriodType $period
   * @access public
   */
  public $period = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param transactionDateStrictPeriodType $period
   * @access public
   */
  public function __construct($cardIdentification, $period)
  {
    $this->cardIdentification = $cardIdentification;
    $this->period = $period;
  }

}
