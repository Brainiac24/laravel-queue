<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class serviceIdentificationType
{

  /**
   * 
   * @var serviceTypeType $serviceType
   * @access public
   */
  public $serviceType = null;

  /**
   * 
   * @var serviceIdType $serviceId
   * @access public
   */
  public $serviceId = null;

  /**
   * 
   * @var serviceObjectTypeType $serviceObjectType
   * @access public
   */
  public $serviceObjectType = null;

  /**
   * 
   * @param serviceTypeType $serviceType
   * @param serviceIdType $serviceId
   * @param serviceObjectTypeType $serviceObjectType
   * @access public
   */
  public function __construct($serviceType, $serviceId, $serviceObjectType)
  {
    $this->serviceType = $serviceType;
    $this->serviceId = $serviceId;
    $this->serviceObjectType = $serviceObjectType;
  }

}
