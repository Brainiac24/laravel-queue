<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getCardBalanceResponseType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var amountType $balance
   * @access public
   */
  public $balance = null;

  /**
   * 
   * @var currencyN3CodeType $currency
   * @access public
   */
  public $currency = null;

  /**
   * 
   * @var amountType $availableExceedLimit
   * @access public
   */
  public $availableExceedLimit = null;

  /**
   * 
   * @var currencyN3CodeType $availableExceedLimitCurrency
   * @access public
   */
  public $availableExceedLimitCurrency = null;

  /**
   * 
   * @var amountType $ownFunds
   * @access public
   */
  public $ownFunds = null;

  /**
   * 
   * @var currencyN3CodeType $ownFundsCurrency
   * @access public
   */
  public $ownFundsCurrency = null;

  /**
   * 
   * @var amountType $totalAmountDue
   * @access public
   */
  public $totalAmountDue = null;

  /**
   * 
   * @var amountType $minimumAmountDue
   * @access public
   */
  public $minimumAmountDue = null;

  /**
   * 
   * @var date $dueDate
   * @access public
   */
  public $dueDate = null;

  /**
   * 
   * @param cardIdentificationType $cardIdentification
   * @param amountType $balance
   * @param currencyN3CodeType $currency
   * @param amountType $availableExceedLimit
   * @param currencyN3CodeType $availableExceedLimitCurrency
   * @param amountType $ownFunds
   * @param currencyN3CodeType $ownFundsCurrency
   * @param amountType $totalAmountDue
   * @param amountType $minimumAmountDue
   * @param date $dueDate
   * @access public
   */
  public function __construct($cardIdentification, $balance, $currency, $availableExceedLimit, $availableExceedLimitCurrency, $ownFunds, $ownFundsCurrency, $totalAmountDue, $minimumAmountDue, $dueDate)
  {
    $this->cardIdentification = $cardIdentification;
    $this->balance = $balance;
    $this->currency = $currency;
    $this->availableExceedLimit = $availableExceedLimit;
    $this->availableExceedLimitCurrency = $availableExceedLimitCurrency;
    $this->ownFunds = $ownFunds;
    $this->ownFundsCurrency = $ownFundsCurrency;
    $this->totalAmountDue = $totalAmountDue;
    $this->minimumAmountDue = $minimumAmountDue;
    $this->dueDate = $dueDate;
  }

}
