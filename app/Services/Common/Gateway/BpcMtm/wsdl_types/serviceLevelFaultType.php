<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class serviceLevelFaultType
{

  /**
   * 
   * @var string $errorCode
   * @access public
   */
  public $errorCode = null;

  /**
   * 
   * @var string $errorDesc
   * @access public
   */
  public $errorDesc = null;

  /**
   * 
   * @param string $errorCode
   * @param string $errorDesc
   * @access public
   */
  public function __construct($errorCode, $errorDesc)
  {
    $this->errorCode = $errorCode;
    $this->errorDesc = $errorDesc;
  }

}
