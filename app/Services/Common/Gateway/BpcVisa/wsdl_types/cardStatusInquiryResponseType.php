<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class cardStatusInquiryResponseType
{

  /**
   * 
   * @var hotCardStatusType $hotCardStatus
   * @access public
   */
  public $hotCardStatus = null;

  /**
   * 
   * @param hotCardStatusType $hotCardStatus
   * @access public
   */
  public function __construct($hotCardStatus)
  {
    $this->hotCardStatus = $hotCardStatus;
  }

}
