<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class cardsType
{

  /**
   * 
   * @var cardDataType $cardData
   * @access public
   */
  public $cardData = null;

  /**
   * 
   * @param cardDataType $cardData
   * @access public
   */
  public function __construct($cardData)
  {
    $this->cardData = $cardData;
  }

}
