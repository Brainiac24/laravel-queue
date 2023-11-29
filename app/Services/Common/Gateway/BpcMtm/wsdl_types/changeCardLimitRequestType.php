<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class changeCardLimitRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var limitBaseDataType $limit
   * @access public
   */
  public $limit = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param limitBaseDataType $limit
   * @access public
   */
  public function __construct($cardIdentification, $limit)
  {
    $this->cardIdentification = $cardIdentification;
    $this->limit = $limit;
  }

}
