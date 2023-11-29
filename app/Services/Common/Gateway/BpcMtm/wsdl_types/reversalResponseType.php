<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class reversalResponseType
{

  /**
   * 
   * @var responseCodeType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @var processingCodeType $processingCode
   * @access public
   */
  public $processingCode = null;

  /**
   * 
   * @var systemTraceAuditNumberType $systemTraceAuditNumber
   * @access public
   */
  public $systemTraceAuditNumber = null;

  /**
   * 
   * @var transactionDateType $transactionDate
   * @access public
   */
  public $transactionDate = null;

  /**
   * 
   * @param responseCodeType $responseCode
   * @param processingCodeType $processingCode
   * @param systemTraceAuditNumberType $systemTraceAuditNumber
   * @param transactionDateType $transactionDate
   * @access public
   */
  public function __construct($responseCode, $processingCode, $systemTraceAuditNumber, $transactionDate)
  {
    $this->responseCode = $responseCode;
    $this->processingCode = $processingCode;
    $this->systemTraceAuditNumber = $systemTraceAuditNumber;
    $this->transactionDate = $transactionDate;
  }

}
