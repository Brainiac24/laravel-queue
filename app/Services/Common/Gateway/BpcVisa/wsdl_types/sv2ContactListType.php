<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2ContactListType
{

  /**
   * 
   * @var sv2ContactDataType $contact
   * @access public
   */
  public $contact = null;

  /**
   * 
   * @param sv2ContactDataType $contact
   * @access public
   */
  public function __construct($contact)
  {
    $this->contact = $contact;
  }

}
