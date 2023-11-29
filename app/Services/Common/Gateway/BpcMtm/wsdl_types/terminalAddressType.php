<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class terminalAddressType
{

  /**
   * 
   * @var string $terminalId
   * @access public
   */
  public $terminalId = null;

  /**
   * 
   * @var string $terminalCountry
   * @access public
   */
  public $terminalCountry = null;

  /**
   * 
   * @var string $terminalState
   * @access public
   */
  public $terminalState = null;

  /**
   * 
   * @var string $terminalPostalCode
   * @access public
   */
  public $terminalPostalCode = null;

  /**
   * 
   * @var string $terminalCity
   * @access public
   */
  public $terminalCity = null;

  /**
   * 
   * @var string $terminalStreet
   * @access public
   */
  public $terminalStreet = null;

  /**
   * 
   * @var string $terminalName
   * @access public
   */
  public $terminalName = null;

  /**
   * 
   * @param string $terminalId
   * @param string $terminalCountry
   * @param string $terminalState
   * @param string $terminalPostalCode
   * @param string $terminalCity
   * @param string $terminalStreet
   * @param string $terminalName
   * @access public
   */
  public function __construct($terminalId, $terminalCountry, $terminalState, $terminalPostalCode, $terminalCity, $terminalStreet, $terminalName)
  {
    $this->terminalId = $terminalId;
    $this->terminalCountry = $terminalCountry;
    $this->terminalState = $terminalState;
    $this->terminalPostalCode = $terminalPostalCode;
    $this->terminalCity = $terminalCity;
    $this->terminalStreet = $terminalStreet;
    $this->terminalName = $terminalName;
  }

}
