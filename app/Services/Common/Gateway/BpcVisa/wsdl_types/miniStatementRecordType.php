<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class miniStatementRecordType
{

  /**
   * 
   * @var transactionDateType $transactionDate
   * @access public
   */
  public $transactionDate = null;

  /**
   * 
   * @var miniStatementTransactionTypeType $transactionType
   * @access public
   */
  public $transactionType = null;

  /**
   * 
   * @var debitCreditIndicatorType $debitCreditIndicator
   * @access public
   */
  public $debitCreditIndicator = null;

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
   * @var terminalIdentificationType $terminalIdentification
   * @access public
   */
  public $terminalIdentification = null;

  /**
   * 
   * @var cardAcceptorNameAndLocationType $cardAcceptorNameAndLocation
   * @access public
   */
  public $cardAcceptorNameAndLocation = null;

  /**
   * 
   * @var authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public $authorizationIdResponse = null;

  /**
   * 
   * @param transactionDateType $transactionDate
   * @param miniStatementTransactionTypeType $transactionType
   * @param debitCreditIndicatorType $debitCreditIndicator
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param terminalIdentificationType $terminalIdentification
   * @param cardAcceptorNameAndLocationType $cardAcceptorNameAndLocation
   * @param authorizationIdResponseType $authorizationIdResponse
   * @access public
   */
  public function __construct($transactionDate, $transactionType, $debitCreditIndicator, $amount, $currency, $terminalIdentification, $cardAcceptorNameAndLocation, $authorizationIdResponse)
  {
    $this->transactionDate = $transactionDate;
    $this->transactionType = $transactionType;
    $this->debitCreditIndicator = $debitCreditIndicator;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->terminalIdentification = $terminalIdentification;
    $this->cardAcceptorNameAndLocation = $cardAcceptorNameAndLocation;
    $this->authorizationIdResponse = $authorizationIdResponse;
  }

}
