<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionBDataType
{

  /**
   * 
   * @var maskedCardNumberType $cardNumber
   * @access public
   */
  public $cardNumber = null;

  /**
   * 
   * @var date $expiryDate
   * @access public
   */
  public $expiryDate = null;

  /**
   * 
   * @var cardPlasticNumberType $cardSequenceNumber
   * @access public
   */
  public $cardSequenceNumber = null;

  /**
   * 
   * @var utrnnoType $utrnno
   * @access public
   */
  public $utrnno = null;

  /**
   * 
   * @var reversalType $reversal
   * @access public
   */
  public $reversal = null;

  /**
   * 
   * @var responseCodeInternalType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @var transactionTypeType $transactionType
   * @access public
   */
  public $transactionType = null;

  /**
   * 
   * @var transactionDateType $transmissionDate
   * @access public
   */
  public $transmissionDate = null;

  /**
   * 
   * @var traceType $trace
   * @access public
   */
  public $trace = null;

  /**
   * 
   * @var transactionDateType $localTransactionDate
   * @access public
   */
  public $localTransactionDate = null;

  /**
   * 
   * @var referenceNumberType $referenceNumber
   * @access public
   */
  public $referenceNumber = null;

  /**
   * 
   * @var authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public $authorizationIdResponse = null;

  /**
   * 
   * @var processingCodeType $processingCode
   * @access public
   */
  public $processingCode = null;

  /**
   * 
   * @var amountType $amount
   * @access public
   */
  public $amount = null;

  /**
   * 
   * @var currencyN3CodeType $currency
   * @access public
   */
  public $currency = null;

  /**
   * 
   * @var accountNumberType $accountNumber
   * @access public
   */
  public $accountNumber = null;

  /**
   * 
   * @param maskedCardNumberType $cardNumber
   * @param date $expiryDate
   * @param cardPlasticNumberType $cardSequenceNumber
   * @param utrnnoType $utrnno
   * @param reversalType $reversal
   * @param responseCodeInternalType $responseCode
   * @param transactionTypeType $transactionType
   * @param transactionDateType $transmissionDate
   * @param traceType $trace
   * @param transactionDateType $localTransactionDate
   * @param referenceNumberType $referenceNumber
   * @param authorizationIdResponseType $authorizationIdResponse
   * @param processingCodeType $processingCode
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountNumberType $accountNumber
   * @access public
   */
  public function __construct($cardNumber, $expiryDate, $cardSequenceNumber, $utrnno, $reversal, $responseCode, $transactionType, $transmissionDate, $trace, $localTransactionDate, $referenceNumber, $authorizationIdResponse, $processingCode, $amount, $currency, $accountNumber)
  {
    $this->cardNumber = $cardNumber;
    $this->expiryDate = $expiryDate;
    $this->cardSequenceNumber = $cardSequenceNumber;
    $this->utrnno = $utrnno;
    $this->reversal = $reversal;
    $this->responseCode = $responseCode;
    $this->transactionType = $transactionType;
    $this->transmissionDate = $transmissionDate;
    $this->trace = $trace;
    $this->localTransactionDate = $localTransactionDate;
    $this->referenceNumber = $referenceNumber;
    $this->authorizationIdResponse = $authorizationIdResponse;
    $this->processingCode = $processingCode;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->accountNumber = $accountNumber;
  }

}
