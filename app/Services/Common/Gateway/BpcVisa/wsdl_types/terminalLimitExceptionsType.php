<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class terminalLimitExceptionsType
{

  /**
   * 
   * @var terminalLimitExceptionType $exception
   * @access public
   */
  public $exception = null;

  /**
   * 
   * @param terminalLimitExceptionType $exception
   * @access public
   */
  public function __construct($exception)
  {
    $this->exception = $exception;
  }

}
