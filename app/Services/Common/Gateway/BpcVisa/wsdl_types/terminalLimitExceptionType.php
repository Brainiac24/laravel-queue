<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class terminalLimitExceptionType
{

  /**
   * 
   * @var int $id
   * @access public
   */
  public $id = null;

  /**
   * 
   * @var cardNumberType $cardNumber
   * @access public
   */
  public $cardNumber = null;

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
   * @var string255 $description
   * @access public
   */
  public $description = null;

  /**
   * 
   * @param int $id
   * @param cardNumberType $cardNumber
   * @param limitEdgeDateType $startDate
   * @param limitEdgeDateType $endDate
   * @param limitValueType $value
   * @param string255 $description
   * @access public
   */
  public function __construct($id, $cardNumber, $startDate, $endDate, $value, $description)
  {
    $this->id = $id;
    $this->cardNumber = $cardNumber;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->value = $value;
    $this->description = $description;
  }

}
