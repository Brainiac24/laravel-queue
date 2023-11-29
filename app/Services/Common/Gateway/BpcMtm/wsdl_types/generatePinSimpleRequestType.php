<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class generatePinSimpleRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var pinDeliveryMethodType $pinDeliveryMethod
   * @access public
   */
  public $pinDeliveryMethod = null;

  /**
   * 
   * @var pinValueType $pinValue
   * @access public
   */
  public $pinValue = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param pinDeliveryMethodType $pinDeliveryMethod
   * @param pinValueType $pinValue
   * @access public
   */
  public function __construct($cardIdentification, $pinDeliveryMethod, $pinValue)
  {
    $this->cardIdentification = $cardIdentification;
    $this->pinDeliveryMethod = $pinDeliveryMethod;
    $this->pinValue = $pinValue;
  }

}
