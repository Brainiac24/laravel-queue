<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class serviceParametersType
{

  /**
   * 
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

  /**
   * 
   * @param phoneNumberType $phoneNumber
   * @param emailType $email
   * @access public
   */
  public function __construct($phoneNumber, $email)
  {
    $this->phoneNumber = $phoneNumber;
    $this->email = $email;
  }

}
