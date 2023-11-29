<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class financialTransactionResponseType
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
   * @var authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public $authorizationIdResponse = null;

  /**
   * 
   * @param responseCodeType $responseCode
   * @param processingCodeType $processingCode
   * @param systemTraceAuditNumberType $systemTraceAuditNumber
   * @param transactionDateType $localTransactionDate
   * @param rrnType $rrn
   * @param authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public function __construct($responseCode, $processingCode, $systemTraceAuditNumber, $localTransactionDate, $rrn, $authorizationIdResponse)
  {
    $this->responseCode = $responseCode;
    $this->processingCode = $processingCode;
    $this->systemTraceAuditNumber = $systemTraceAuditNumber;
    $this->localTransactionDate = $localTransactionDate;
    $this->rrn = $rrn;
    $this->authorizationIdResponse = $authorizationIdResponse;
  }

}
