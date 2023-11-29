<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2CustodianDataType
{

  /**
   * 
   * @var string255 $personId
   * @access public
   */
  public $personId = null;

  /**
   * 
   * @var string255 $personName
   * @access public
   */
  public $personName = null;

  /**
   * 
   * @var string255 $citizenship
   * @access public
   */
  public $citizenship = null;

  /**
   * 
   * @var string255 $agentId
   * @access public
   */
  public $agentId = null;

  /**
   * 
   * @var string255 $agentNumber
   * @access public
   */
  public $agentNumber = null;

  /**
   * 
   * @var string255 $contactType
   * @access public
   */
  public $contactType = null;

  /**
   * 
   * @var string255 $contactDescription
   * @access public
   */
  public $contactDescription = null;

  /**
   * 
   * @param string255 $personId
   * @param string255 $personName
   * @param string255 $citizenship
   * @param string255 $agentId
   * @param string255 $agentNumber
   * @param string255 $contactType
   * @param string255 $contactDescription
   * @access public
   */
  public function __construct($personId, $personName, $citizenship, $agentId, $agentNumber, $contactType, $contactDescription)
  {
    $this->personId = $personId;
    $this->personName = $personName;
    $this->citizenship = $citizenship;
    $this->agentId = $agentId;
    $this->agentNumber = $agentNumber;
    $this->contactType = $contactType;
    $this->contactDescription = $contactDescription;
  }

}
