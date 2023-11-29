<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class terminalLimitsType
{

  /**
   * 
   * @var terminalLimitFullDataType $limit
   * @access public
   */
  public $limit = null;

  /**
   * 
   * @param terminalLimitFullDataType $limit
   * @access public
   */
  public function __construct($limit)
  {
    $this->limit = $limit;
  }

}
