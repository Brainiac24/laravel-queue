<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getCardLimitsRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @access public
   */
  public function __construct($cardIdentification)
  {
    $this->cardIdentification = $cardIdentification;
  }

}
