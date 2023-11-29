<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class simpleResponseType
{

  /**
   * 
   * @var responseCodeType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @param responseCodeType $responseCode
   * @access public
   */
  public function __construct($responseCode)
  {
    $this->responseCode = $responseCode;
  }

}
