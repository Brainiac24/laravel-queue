<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

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
   * @var limitTdyType $currentValue
   * @access public
   */
  public $currentValue = null;

  /**
   * 
   * @param limitNameType $name
   * @param limitEdgeDateType $startDate
   * @param limitEdgeDateType $endDate
   * @param limitValueType $value
   * @param limitCycleTypeType $cycleType
   * @param limitCycleLengthType $cycleLength
   * @param currencyN3CodeType $currency
   * @param limitTdyType $currentValue
   * @access public
   */
  public function __construct($name, $startDate, $endDate, $value, $cycleType, $cycleLength, $currency, $currentValue)
  {
    $this->name = $name;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->value = $value;
    $this->cycleType = $cycleType;
    $this->cycleLength = $cycleLength;
    $this->currency = $currency;
    $this->currentValue = $currentValue;
  }

}
