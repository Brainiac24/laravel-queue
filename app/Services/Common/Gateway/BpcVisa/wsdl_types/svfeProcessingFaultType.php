<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class svfeProcessingFaultType
{

  /**
   * 
   * @var responseCodeType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @var string $message
   * @access public
   */
  public $message = null;

  /**
   * 
   * @param responseCodeType $responseCode
   * @param string $message
   * @access public
   */
  public function __construct($responseCode, $message)
  {
    $this->responseCode = $responseCode;
    $this->message = $message;
  }

}
