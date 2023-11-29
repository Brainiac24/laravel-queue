<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class limitBaseDataType
{

  /**
   * 
   * @var limitNameType $name
   * @access public
   */
  public $name = null;

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
   * @var limitValueType $currentValue
   * @access public
   */
  public $currentValue = null;

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
   * @var currencyN3CodeType $currency
   * @access public
   */
  public $currency = null;

  /**
   * 
   * @param limitNameType $name
   * @param limitEdgeDateType $startDate
   * @param limitEdgeDateType $endDate
   * @param limitValueType $value
   * @param limitValueType $currentValue
   * @param limitCycleTypeType $cycleType
   * @param limitCycleLengthType $cycleLength
   * @param currencyN3CodeType $currency
   * @access public
   */
  public function __construct($name, $startDate, $endDate, $value, $currentValue, $cycleType, $cycleLength, $currency)
  {
    $this->name = $name;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->value = $value;
    $this->currentValue = $currentValue;
    $this->cycleType = $cycleType;
    $this->cycleLength = $cycleLength;
    $this->currency = $currency;
  }

}
