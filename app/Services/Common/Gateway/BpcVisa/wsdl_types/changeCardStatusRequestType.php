<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class changeCardStatusRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var hotCardStatusType $hotCardStatus
   * @access public
   */
  public $hotCardStatus = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

}
