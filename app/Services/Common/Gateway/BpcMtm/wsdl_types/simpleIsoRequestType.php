<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class simpleIsoRequestType
{

  /**
   * 
   * @var extIdType $extId
   * @access public
   */
  public $extId = null;

  /**
   * 
   * @param extIdType $extId
   * @access public
   */
  public function __construct($extId)
  {
    $this->extId = $extId;
  }

}
