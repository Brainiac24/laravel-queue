<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class accountDataDetailedType
{

  /**
   * 
   * @var cardsType $cards
   * @access public
   */
  public $cards = null;

  /**
   * 
   * @param cardsType $cards
   * @access public
   */
  public function __construct($cards)
  {
    $this->cards = $cards;
  }

}
