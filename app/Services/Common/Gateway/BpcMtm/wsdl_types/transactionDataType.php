<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class transactionDataType
{

  /**
   * 
   * @var dateTime $boWriteOffDate
   * @access public
   */
  public $boWriteOffDate = null;

  /**
   * 
   * @var dateTime $authorizationDate
   * @access public
   */
  public $authorizationDate = null;

  /**
   * 
   * @var transactionTypeType $transactionType
   * @access public
   */
  public $transactionType = null;

  /**
   * 
   * @var debitCreditIndicatorType $operationDirection
   * @access public
   */
  public $operationDirection = null;

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
   * @var amountType $amountInAccountCurrency
   * @access public
   */
  public $amountInAccountCurrency = null;

  /**
   * 
   * @var utrnnoType $utrnno
   * @access public
   */
  public $utrnno = null;

  /**
   * 
   * @var string $transactionDescription
   * @access public
   */
  public $transactionDescription = null;

  /**
   * 
   * @var debitCreditIndicatorType $feeDirection
   * @access public
   */
  public $feeDirection = null;

  /**
   * 
   * @var amountType $acquireFeeAmount
   * @access public
   */
  public $acquireFeeAmount = null;

  /**
   * 
   * @var amountType $feIssuerFeeAmount
   * @access public
   */
  public $feIssuerFeeAmount = null;

  /**
   * 
   * @var amountType $boIssuerFeeAmount
   * @access public
   */
  public $boIssuerFeeAmount = null;

  /**
   * 
   * @var mccType $mcc
   * @access public
   */
  public $mcc = null;

  /**
   * 
   * @var string $merchantCountry
   * @access public
   */
  public $merchantCountry = null;

  /**
   * 
   * @var string $merchantCity
   * @access public
   */
  public $merchantCity = null;

  /**
   * 
   * @var string $merchantName
   * @access public
   */
  public $merchantName = null;

  /**
   * 
   * @var merchantIdType $merchantId
   * @access public
   */
  public $merchantId = null;

  /**
   * 
   * @var string $terminalAddress
   * @access public
   */
  public $terminalAddress = null;

  /**
   * 
   * @var posDataCodeType $posDataCode
   * @access public
   */
  public $posDataCode = null;

  /**
   * 
   * @var authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public $authorizationIdResponse = null;

  /**
   * 
   * @var transactionDateType $reversalDate
   * @access public
   */
  public $reversalDate = null;

  /**
   * 
   * @param dateTime $boWriteOffDate
   * @param dateTime $authorizationDate
   * @param transactionTypeType $transactionType
   * @param debitCreditIndicatorType $operationDirection
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param amountType $amountInAccountCurrency
   * @param utrnnoType $utrnno
   * @param string $transactionDescription
   * @param debitCreditIndicatorType $feeDirection
   * @param amountType $acquireFeeAmount
   * @param amountType $feIssuerFeeAmount
   * @param amountType $boIssuerFeeAmount
   * @param mccType $mcc
   * @param string $merchantCountry
   * @param string $merchantCity
   * @param string $merchantName
   * @param merchantIdType $merchantId
   * @param string $terminalAddress
   * @param posDataCodeType $posDataCode
   * @param authorizationIdResponseType $authorizationIdResponse
   * @param transactionDateType $reversalDate
   * @access public
   */
  public function __construct($boWriteOffDate, $authorizationDate, $transactionType, $operationDirection, $amount, $currency, $amountInAccountCurrency, $utrnno, $transactionDescription, $feeDirection, $acquireFeeAmount, $feIssuerFeeAmount, $boIssuerFeeAmount, $mcc, $merchantCountry, $merchantCity, $merchantName, $merchantId, $terminalAddress, $posDataCode, $authorizationIdResponse, $reversalDate)
  {
    $this->boWriteOffDate = $boWriteOffDate;
    $this->authorizationDate = $authorizationDate;
    $this->transactionType = $transactionType;
    $this->operationDirection = $operationDirection;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->amountInAccountCurrency = $amountInAccountCurrency;
    $this->utrnno = $utrnno;
    $this->transactionDescription = $transactionDescription;
    $this->feeDirection = $feeDirection;
    $this->acquireFeeAmount = $acquireFeeAmount;
    $this->feIssuerFeeAmount = $feIssuerFeeAmount;
    $this->boIssuerFeeAmount = $boIssuerFeeAmount;
    $this->mcc = $mcc;
    $this->merchantCountry = $merchantCountry;
    $this->merchantCity = $merchantCity;
    $this->merchantName = $merchantName;
    $this->merchantId = $merchantId;
    $this->terminalAddress = $terminalAddress;
    $this->posDataCode = $posDataCode;
    $this->authorizationIdResponse = $authorizationIdResponse;
    $this->reversalDate = $reversalDate;
  }

}
