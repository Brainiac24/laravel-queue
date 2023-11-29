<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class serviceActionRequestType
{

  /**
   * 
   * @var serviceIdentificationType $serviceIdentification
   * @access public
   */
  public $serviceIdentification = null;

  /**
   * 
   * @var actionCodeType $actionCode
   * @access public
   */
  public $actionCode = null;

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var accountNumberType $accountNumber
   * @access public
   */
  public $accountNumber = null;

  /**
   * 
   * @var serviceParametersType $serviceParameters
   * @access public
   */
  public $serviceParameters = null;

  /**
   * 
   * @param serviceIdentificationType $serviceIdentification
   * @param actionCodeType $actionCode
   * @param cardIdentificationType $cardIdentification
   * @param accountNumberType $accountNumber
   * @param serviceParametersType $serviceParameters
   * @access public
   */
  public function __construct($serviceIdentification, $actionCode, $cardIdentification, $accountNumber, $serviceParameters)
  {
    $this->serviceIdentification = $serviceIdentification;
    $this->actionCode = $actionCode;
    $this->cardIdentification = $cardIdentification;
    $this->accountNumber = $accountNumber;
    $this->serviceParameters = $serviceParameters;
  }

}
