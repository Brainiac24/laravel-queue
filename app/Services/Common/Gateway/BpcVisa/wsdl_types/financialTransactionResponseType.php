<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

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
   * @var string255 $uniqueReferenceNumber
   * @access public
   */
  public $uniqueReferenceNumber = null;

  /**
   * 
   * @var string255 $otp
   * @access public
   */
  public $otp = null;

  /**
   * 
   * @var feeAmountType $acquirerFeeAmount
   * @access public
   */
  public $acquirerFeeAmount = null;

  /**
   * 
   * @var feeAmountType $issuerFeeAmount
   * @access public
   */
  public $issuerFeeAmount = null;

  /**
   * 
   * @var paymentSpecificDataType $paymentSpecificData
   * @access public
   */
  public $paymentSpecificData = null;

  /**
   * 
   * @param responseCodeType $responseCode
   * @param processingCodeType $processingCode
   * @param systemTraceAuditNumberType $systemTraceAuditNumber
   * @param transactionDateType $localTransactionDate
   * @param rrnType $rrn
   * @param authorizationIdResponseType $authorizationIdResponse
   * @param string255 $uniqueReferenceNumber
   * @param string255 $otp
   * @param feeAmountType $acquirerFeeAmount
   * @param feeAmountType $issuerFeeAmount
   * @param paymentSpecificDataType $paymentSpecificData
   * @access public
   */
  public function __construct($responseCode, $processingCode, $systemTraceAuditNumber, $localTransactionDate, $rrn, $authorizationIdResponse, $uniqueReferenceNumber, $otp, $acquirerFeeAmount, $issuerFeeAmount, $paymentSpecificData)
  {
    $this->responseCode = $responseCode;
    $this->processingCode = $processingCode;
    $this->systemTraceAuditNumber = $systemTraceAuditNumber;
    $this->localTransactionDate = $localTransactionDate;
    $this->rrn = $rrn;
    $this->authorizationIdResponse = $authorizationIdResponse;
    $this->uniqueReferenceNumber = $uniqueReferenceNumber;
    $this->otp = $otp;
    $this->acquirerFeeAmount = $acquirerFeeAmount;
    $this->issuerFeeAmount = $issuerFeeAmount;
    $this->paymentSpecificData = $paymentSpecificData;
  }

}
