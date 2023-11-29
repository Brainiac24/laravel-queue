<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class originalTransactionParametersType
{

  /**
   * 
   * @var systemTraceAuditNumberType $systemTraceAuditNumber
   * @access public
   */
  public $systemTraceAuditNumber = null;

  /**
   * 
   * @var transactionDateType $localTransactionDate
   * @access public
   */
  public $localTransactionDate = null;

  /**
   * 
   * @var rrnType $rrn
   * @access public
   */
  public $rrn = null;

  /**
   * 
   * @param systemTraceAuditNumberType $systemTraceAuditNumber
   * @param transactionDateType $localTransactionDate
   * @param rrnType $rrn
   * @access public
   */
  public function __construct($systemTraceAuditNumber, $localTransactionDate, $rrn)
  {
    $this->systemTraceAuditNumber = $systemTraceAuditNumber;
    $this->localTransactionDate = $localTransactionDate;
    $this->rrn = $rrn;
  }

}
