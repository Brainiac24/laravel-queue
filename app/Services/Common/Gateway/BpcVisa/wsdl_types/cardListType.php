<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class cardListType
{

  /**
   * 
   * @var cardListElement $cardList
   * @access public
   */
  public $cardList = null;

  /**
   * 
   * @param cardListElement $cardList
   * @access public
   */
  public function __construct($cardList)
  {
    $this->cardList = $cardList;
  }

}
