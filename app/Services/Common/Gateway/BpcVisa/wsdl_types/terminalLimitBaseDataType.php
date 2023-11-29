<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class terminalLimitBaseDataType
{

  /**
   * 
   * @var int $id
   * @access public
   */
  public $id = null;

  /**
   * 
   * @var merchantIdType $merchantId
   * @access public
   */
  public $merchantId = null;

  /**
   * 
   * @var terminalIdentificationType $terminalId
   * @access public
   */
  public $terminalId = null;

  /**
   * 
   * @var limitNameType $name
   * @access public
   */
  public $name = null;

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
   * @param int $id
   * @param merchantIdType $merchantId
   * @param terminalIdentificationType $terminalId
   * @param limitNameType $name
   * @param limitValueType $value
   * @param limitCycleTypeType $cycleType
   * @param limitCycleLengthType $cycleLength
   * @param currencyN3CodeType $currency
   * @param limitTdyType $currentValue
   * @access public
   */
  public function __construct($id, $merchantId, $terminalId, $name, $value, $cycleType, $cycleLength, $currency, $currentValue)
  {
    $this->id = $id;
    $this->merchantId = $merchantId;
    $this->terminalId = $terminalId;
    $this->name = $name;
    $this->value = $value;
    $this->cycleType = $cycleType;
    $this->cycleLength = $cycleLength;
    $this->currency = $currency;
    $this->currentValue = $currentValue;
  }

}
