<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class limitExceptionType
{

  /**
   * 
   * @var limitNameType $limitName
   * @access public
   */
  public $limitName = null;

  /**
   * 
   * @var limitEdgeDateType $startDate
   * @access public
   */
  public $startDate = null;

  /**
   * 
   * @var limitEdgeDateType $endDate
   * @access public
   */
  public $endDate = null;

  /**
   * 
   * @var limitValueType $value
   * @access public
   */
  public $value = null;

  /**
   * 
   * @var limitCycleTypeType $cycleType
   * @access public
   */
  public $cycleType = null;

  /**
   * 
   * @var limitCycleLengthType $cycleLength
   * @access public
   */
  public $cycleLength = null;

  /**
   * 
   * @param limitNameType $limitName
   * @param limitEdgeDateType $startDate
   * @param limitEdgeDateType $endDate
   * @param limitValueType $value
   * @param limitCycleTypeType $cycleType
   * @param limitCycleLengthType $cycleLength
   * @access public
   */
  public function __construct($limitName, $startDate, $endDate, $value, $cycleType, $cycleLength)
  {
    $this->limitName = $limitName;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->value = $value;
    $this->cycleType = $cycleType;
    $this->cycleLength = $cycleLength;
  }

}
