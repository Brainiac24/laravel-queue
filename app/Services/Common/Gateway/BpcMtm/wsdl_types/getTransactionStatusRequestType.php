<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionStatusRequestType
{

  /**
   * 
   * @var utrnnoType $utrnno
   * @access public
   */
  public $utrnno = null;

  /**
   * 
   * @var extIdType $extId
   * @access public
   */
  public $extId = null;

  /**
   * 
   * @var reversalType $reversal
   * @access public
   */
  public $reversal = null;

  /**
   * 
   * @param utrnnoType $utrnno
   * @param extIdType $extId
   * @param reversalType $reversal
   * @access public
   */
  public function __construct($extId, $reversal)
  {
    $this->extId = $extId;
    $this->reversal = $reversal;
  }

}
