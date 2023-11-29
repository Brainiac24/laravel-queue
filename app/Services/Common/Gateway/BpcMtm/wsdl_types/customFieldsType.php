<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class customFieldsType
{

  /**
   * 
   * @var customFieldsDataType $customFields
   * @access public
   */
  public $customFields = null;

  /**
   * 
   * @param customFieldsDataType $customFields
   * @access public
   */
  public function __construct($customFields)
  {
    $this->customFields = $customFields;
  }

}
