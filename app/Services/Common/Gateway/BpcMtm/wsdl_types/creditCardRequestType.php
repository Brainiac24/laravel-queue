<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class creditCardRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

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
   * @var extIdType $currency
   * @access public
   */
  public $extId = null;

}
