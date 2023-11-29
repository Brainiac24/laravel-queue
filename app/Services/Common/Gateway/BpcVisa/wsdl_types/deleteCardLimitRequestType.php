<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class deleteCardLimitRequestType
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
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param limitBaseDataType $limit
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public function __construct($cardIdentification, $limit, $cardAcceptorParameters)
  {
    $this->cardIdentification = $cardIdentification;
    $this->limit = $limit;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
  }

}
