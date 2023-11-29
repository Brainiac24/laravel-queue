<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionDetailsBRequestType
{

  /**
   * 
   * @var utrnnoType $utrnno
   * @access public
   */
  public $utrnno = null;

  /**
   * 
   * @var reversalType $reversal
   * @access public
   */
  public $reversal = null;

  /**
   * 
   * @var boolean $maskCardNumber
   * @access public
   */
  public $maskCardNumber = null;

}
