<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class personalDataType
{

  /**
   * 
   * @var firstNameType $firstName
   * @access public
   */
  public $firstName = null;

  /**
   * 
   * @var surnameType $lastName
   * @access public
   */
  public $lastName = null;

  /**
   * 
   * @param firstNameType $firstName
   * @param surnameType $lastName
   * @access public
   */
  public function __construct($firstName, $lastName)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
  }

}
