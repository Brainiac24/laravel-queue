<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class miniStatementRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public function __construct($cardIdentification, $cardAcceptorParameters)
  {
    $this->cardIdentification = $cardIdentification;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
  }

}
