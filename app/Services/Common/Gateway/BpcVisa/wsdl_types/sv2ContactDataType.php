<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2ContactDataType
{

  /**
   * 
   * @var string255 $contactType
   * @access public
   */
  public $contactType = null;

  /**
   * 
   * @var string255 $contactTypeName
   * @access public
   */
  public $contactTypeName = null;

  /**
   * 
   * @var string255 $communicationMethod
   * @access public
   */
  public $communicationMethod = null;

  /**
   * 
   * @var string255 $communicationMethodName
   * @access public
   */
  public $communicationMethodName = null;

  /**
   * 
   * @var string4096 $address
   * @access public
   */
  public $address = null;

  /**
   * 
   * @var string255 $personName
   * @access public
   */
  public $personName = null;

  /**
   * 
   * @var string200 $idType
   * @access public
   */
  public $idType = null;

  /**
   * 
   * @var string200 $identificationNumber
   * @access public
   */
  public $identificationNumber = null;

  /**
   * 
   * @param string255 $contactType
   * @param string255 $contactTypeName
   * @param string255 $communicationMethod
   * @param string255 $communicationMethodName
   * @param string4096 $address
   * @param string255 $personName
   * @param string200 $idType
   * @param string200 $identificationNumber
   * @access public
   */
  public function __construct($contactType, $contactTypeName, $communicationMethod, $communicationMethodName, $address, $personName, $idType, $identificationNumber)
  {
    $this->contactType = $contactType;
    $this->contactTypeName = $contactTypeName;
    $this->communicationMethod = $communicationMethod;
    $this->communicationMethodName = $communicationMethodName;
    $this->address = $address;
    $this->personName = $personName;
    $this->idType = $idType;
    $this->identificationNumber = $identificationNumber;
  }

}
