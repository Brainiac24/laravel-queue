<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class limitFullDataType
{

  /**
   * 
   * @var limitExceptionsType $limitExceptions
   * @access public
   */
  public $limitExceptions = null;

  /**
   * 
   * @param limitExceptionsType $limitExceptions
   * @access public
   */
  public function __construct($limitExceptions)
  {
    $this->limitExceptions = $limitExceptions;
  }

}
