<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class feeType
{

  /**
   * 
   * @var string $feeType
   * @access public
   */
  public $feeType = null;

  /**
   * 
   * @var float $feeValue
   * @access public
   */
  public $feeValue = null;

  /**
   * 
   * @param string $feeType
   * @param float $feeValue
   * @access public
   */
  public function __construct($feeType, $feeValue)
  {
    $this->feeType = $feeType;
    $this->feeValue = $feeValue;
  }

}
