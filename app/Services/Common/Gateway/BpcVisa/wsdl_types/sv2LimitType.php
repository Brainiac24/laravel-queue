<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2LimitType
{

  /**
   * 
   * @var string200 $productId
   * @access public
   */
  public $productId = null;

  /**
   * 
   * @var int $serviceId
   * @access public
   */
  public $serviceId = null;

  /**
   * 
   * @var string200 $serviceNumber
   * @access public
   */
  public $serviceNumber = null;

  /**
   * 
   * @var string200 $serviceLabel
   * @access public
   */
  public $serviceLabel = null;

  /**
   * 
   * @var int $serviceTypeId
   * @access public
   */
  public $serviceTypeId = null;

  /**
   * 
   * @var institutionIdType $institutionId
   * @access public
   */
  public $institutionId = null;

  /**
   * 
   * @var string255 $status
   * @access public
   */
  public $status = null;

  /**
   * 
   * @var string255 $attributeId
   * @access public
   */
  public $attributeId = null;

  /**
   * 
   * @var string255 $attributeName
   * @access public
   */
  public $attributeName = null;

  /**
   * 
   * @var string255 $attributeLabel
   * @access public
   */
  public $attributeLabel = null;

  /**
   * 
   * @var string255 $limitType
   * @access public
   */
  public $limitType = null;

  /**
   * 
   * @var int $sum
   * @access public
   */
  public $sum = null;

  /**
   * 
   * @var int $count
   * @access public
   */
  public $count = null;

  /**
   * 
   * @param string200 $productId
   * @param int $serviceId
   * @param string200 $serviceNumber
   * @param string200 $serviceLabel
   * @param int $serviceTypeId
   * @param institutionIdType $institutionId
   * @param string255 $status
   * @param string255 $attributeId
   * @param string255 $attributeName
   * @param string255 $attributeLabel
   * @param string255 $limitType
   * @param int $sum
   * @param int $count
   * @access public
   */
  public function __construct($productId, $serviceId, $serviceNumber, $serviceLabel, $serviceTypeId, $institutionId, $status, $attributeId, $attributeName, $attributeLabel, $limitType, $sum, $count)
  {
    $this->productId = $productId;
    $this->serviceId = $serviceId;
    $this->serviceNumber = $serviceNumber;
    $this->serviceLabel = $serviceLabel;
    $this->serviceTypeId = $serviceTypeId;
    $this->institutionId = $institutionId;
    $this->status = $status;
    $this->attributeId = $attributeId;
    $this->attributeName = $attributeName;
    $this->attributeLabel = $attributeLabel;
    $this->limitType = $limitType;
    $this->sum = $sum;
    $this->count = $count;
  }

}
