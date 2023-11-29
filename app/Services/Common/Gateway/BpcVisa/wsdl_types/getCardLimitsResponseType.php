<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getCardLimitsResponseType
{

  /**
   * 
   * @var limitsType $limits
   * @access public
   */
  public $limits = null;

  /**
   * 
   * @param limitsType $limits
   * @access public
   */
  public function __construct($limits)
  {
    $this->limits = $limits;
  }

}
