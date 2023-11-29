<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class cardAcceptorParametersType
{

  /**
   * 
   * @var cardAcceptorTerminalIdentificationType $terminalIdentification
   * @access public
   */
  public $terminalIdentification = null;

  /**
   * 
   * @var merchantIdType $merchantIdentification
   * @access public
   */
  public $merchantIdentification = null;

  /**
   * 
   * @var merchantTypeType $merchantType
   * @access public
   */
  public $merchantType = null;

  /**
   * 
   * @var cardAcceptorNameAndLocationType $nameAndLocation
   * @access public
   */
  public $nameAndLocation = null;

  /**
   * 
   * @param cardAcceptorTerminalIdentificationType $terminalIdentification
   * @param merchantIdType $merchantIdentification
   * @param merchantTypeType $merchantType
   * @param cardAcceptorNameAndLocationType $nameAndLocation
   * @access public
   */
  public function __construct($terminalIdentification, $merchantIdentification, $merchantType, $nameAndLocation)
  {
    $this->terminalIdentification = $terminalIdentification;
    $this->merchantIdentification = $merchantIdentification;
    $this->merchantType = $merchantType;
    $this->nameAndLocation = $nameAndLocation;
  }

}
