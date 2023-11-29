<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getCardDataResponseType
{

  /**
   * 
   * @var cardDataDetailedType $cardData
   * @access public
   */
  public $cardData = null;

  /**
   * 
   * @param cardDataDetailedType $cardData
   * @access public
   */
  public function __construct($cardData)
  {
    $this->cardData = $cardData;
  }

}
