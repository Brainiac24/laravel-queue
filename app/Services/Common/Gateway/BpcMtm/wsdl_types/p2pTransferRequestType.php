<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class p2pTransferRequestType
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
     * @var extIdType $currency
     * @access public
     */
    public $extId = null;
}
