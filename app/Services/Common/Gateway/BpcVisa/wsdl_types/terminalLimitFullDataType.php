<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class terminalLimitFullDataType
{

  /**
   * 
   * @var terminalLimitExceptionsType $limitExceptions
   * @access public
   */
  public $limitExceptions = null;

  /**
   * 
   * @param terminalLimitExceptionsType $limitExceptions
   * @access public
   */
  public function __construct($limitExceptions)
  {
    $this->limitExceptions = $limitExceptions;
  }

}
