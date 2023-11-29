<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class customerType
{

  /**
   * 
   * @var customerIdType $customerId
   * @access public
   */
  public $customerId = null;

  /**
   * 
   * @var addressType $address
   * @access public
   */
  public $address = null;

  /**
   * 
   * @var memorableWordType $memorableWord
   * @access public
   */
  public $memorableWord = null;

  /**
   * 
   * @var phoneNumberType $phone
   * @access public
   */
  public $phone = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

  /**
   * 
   * @param customerIdType $customerId
   * @param addressType $address
   * @param memorableWordType $memorableWord
   * @param phoneNumberType $phone
   * @param emailType $email
   * @access public
   */
  public function __construct($customerId, $address, $memorableWord, $phone, $email)
  {
    $this->customerId = $customerId;
    $this->address = $address;
    $this->memorableWord = $memorableWord;
    $this->phone = $phone;
    $this->email = $email;
  }

}
