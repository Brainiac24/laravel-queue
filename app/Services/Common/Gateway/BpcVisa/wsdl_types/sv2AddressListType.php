<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2AddressListType
{

  /**
   * 
   * @var sv2AddressDataType $address
   * @access public
   */
  public $address = null;

  /**
   * 
   * @param sv2AddressDataType $address
   * @access public
   */
  public function __construct($address)
  {
    $this->address = $address;
  }

}
