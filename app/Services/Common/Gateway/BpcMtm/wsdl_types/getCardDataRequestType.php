<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

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
   * @param cardIdentificationType $cardIdentification
   * @access public
   */
  public function __construct($cardIdentification)
  {
    $this->cardIdentification = $cardIdentification;
  }

}
