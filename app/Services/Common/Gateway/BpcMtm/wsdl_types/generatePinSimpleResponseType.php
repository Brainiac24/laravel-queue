<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class generatePinSimpleResponseType
{

  /**
   * 
   * @var pinValueType $pinValue
   * @access public
   */
  public $pinValue = null;

  /**
   * 
   * @var base64Binary $encryptedPinValue
   * @access public
   */
  public $encryptedPinValue = null;

  /**
   * 
   * @param pinValueType $pinValue
   * @param base64Binary $encryptedPinValue
   * @access public
   */
  public function __construct($pinValue, $encryptedPinValue)
  {
    $this->pinValue = $pinValue;
    $this->encryptedPinValue = $encryptedPinValue;
  }

}
