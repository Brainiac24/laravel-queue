<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class servicesListType
{

  /**
   * 
   * @var servicesListDataType $servicesList
   * @access public
   */
  public $servicesList = null;

  /**
   * 
   * @param servicesListDataType $servicesList
   * @access public
   */
  public function __construct($servicesList)
  {
    $this->servicesList = $servicesList;
  }

}
