<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class feeCalculationRequestType
{

  /**
   * 
   * @var cardIdentificationType $sourceCardIdentification
   * @access public
   */
  public $sourceCardIdentification = null;

  /**
   * 
   * @var cardIdentificationType $destinationCardIdentification
   * @access public
   */
  public $destinationCardIdentification = null;

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
   * @var accountNumberType $sourceAccountNumber
   * @access public
   */
  public $sourceAccountNumber = null;

  /**
   * 
   * @var accountNumberType $destinationAccountNumber
   * @access public
   */
  public $destinationAccountNumber = null;

  /**
   * 
   * @param cardIdentificationType $sourceCardIdentification
   * @param cardIdentificationType $destinationCardIdentification
   * @param amountType $amount
   * @param currencyN3CodeType $currency
   * @param accountNumberType $sourceAccountNumber
   * @param accountNumberType $destinationAccountNumber
   * @access public
   */
  public function __construct($sourceCardIdentification, $destinationCardIdentification, $amount, $currency, $sourceAccountNumber, $destinationAccountNumber)
  {
    $this->sourceCardIdentification = $sourceCardIdentification;
    $this->destinationCardIdentification = $destinationCardIdentification;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->sourceAccountNumber = $sourceAccountNumber;
    $this->destinationAccountNumber = $destinationAccountNumber;
  }

}
