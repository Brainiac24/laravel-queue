<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class limitExceptionsType
{

  /**
   * 
   * @var limitExceptionType $exception
   * @access public
   */
  public $exception = null;

  /**
   * 
   * @param limitExceptionType $exception
   * @access public
   */
  public function __construct($exception)
  {
    $this->exception = $exception;
  }

}
