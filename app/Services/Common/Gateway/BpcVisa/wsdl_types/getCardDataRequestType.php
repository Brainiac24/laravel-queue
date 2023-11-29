<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getCardDataRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var base64Binary $rsaPublicKey
   * @access public
   */
  public $rsaPublicKey = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param base64Binary $rsaPublicKey
   * @access public
   */
  public function __construct($cardIdentification, $rsaPublicKey)
  {
    $this->cardIdentification = $cardIdentification;
    $this->rsaPublicKey = $rsaPublicKey;
  }

}
