<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

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
   * @var secondNameType $middleName
   * @access public
   */
  public $middleName = null;

  /**
   * 
   * @var surnameType $lastName
   * @access public
   */
  public $lastName = null;

  /**
   * 
   * @var birthDateType $birthDate
   * @access public
   */
  public $birthDate = null;

  /**
   * 
   * @var string4096 $address
   * @access public
   */
  public $address = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

  /**
   * 
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

  /**
   * 
   * @var documentType $document
   * @access public
   */
  public $document = null;

  /**
   * 
   * @param firstNameType $firstName
   * @param secondNameType $middleName
   * @param surnameType $lastName
   * @param birthDateType $birthDate
   * @param string4096 $address
   * @param emailType $email
   * @param phoneNumberType $phoneNumber
   * @param documentType $document
   * @access public
   */
  public function __construct($firstName, $middleName, $lastName, $birthDate, $address, $email, $phoneNumber, $document)
  {
    $this->firstName = $firstName;
    $this->middleName = $middleName;
    $this->lastName = $lastName;
    $this->birthDate = $birthDate;
    $this->address = $address;
    $this->email = $email;
    $this->phoneNumber = $phoneNumber;
    $this->document = $document;
  }

}
