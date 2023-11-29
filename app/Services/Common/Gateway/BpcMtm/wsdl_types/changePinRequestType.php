<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class changePinRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var encryptedPinDataType $newPinData
   * @access public
   */
  public $newPinData = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param encryptedPinDataType $newPinData
   * @access public
   */
  public function __construct($cardIdentification, $newPinData)
  {
    $this->cardIdentification = $cardIdentification;
    $this->newPinData = $newPinData;
  }

}
