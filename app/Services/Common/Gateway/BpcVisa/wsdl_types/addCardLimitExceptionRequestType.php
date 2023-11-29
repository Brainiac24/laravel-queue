<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class addCardLimitExceptionRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var limitExceptionType $limitException
   * @access public
   */
  public $limitException = null;

  /**
   * 
   * @var cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public $cardAcceptorParameters = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param limitExceptionType $limitException
   * @param cardAcceptorParametersType $cardAcceptorParameters
   * @access public
   */
  public function __construct($cardIdentification, $limitException, $cardAcceptorParameters)
  {
    $this->cardIdentification = $cardIdentification;
    $this->limitException = $limitException;
    $this->cardAcceptorParameters = $cardAcceptorParameters;
  }

}
