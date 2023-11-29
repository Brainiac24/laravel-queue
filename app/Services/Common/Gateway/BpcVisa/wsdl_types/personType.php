<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class personType
{

  /**
   * 
   * @var personIdType $personId
   * @access public
   */
  public $personId = null;

  /**
   * 
   * @var firstNameType $firstName
   * @access public
   */
  public $firstName = null;

  /**
   * 
   * @var secondNameType $secondName
   * @access public
   */
  public $secondName = null;

  /**
   * 
   * @var surnameType $surname
   * @access public
   */
  public $surname = null;

  /**
   * 
   * @var birthDateType $birthDate
   * @access public
   */
  public $birthDate = null;

  /**
   * 
   * @param personIdType $personId
   * @param firstNameType $firstName
   * @param secondNameType $secondName
   * @param surnameType $surname
   * @param birthDateType $birthDate
   * @access public
   */
  public function __construct($personId, $firstName, $secondName, $surname, $birthDate)
  {
    $this->personId = $personId;
    $this->firstName = $firstName;
    $this->secondName = $secondName;
    $this->surname = $surname;
    $this->birthDate = $birthDate;
  }

}
