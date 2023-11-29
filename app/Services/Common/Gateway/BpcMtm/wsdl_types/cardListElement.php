<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class cardListElement
{

  /**
   * 
   * @var cardNumberType $cardNumber
   * @access public
   */
  public $cardNumber = null;

  /**
   * 
   * @var maskedCardNumberType $cardNumberMask
   * @access public
   */
  public $cardNumberMask = null;

  /**
   * 
   * @var cardExpDateType $expiryDate
   * @access public
   */
  public $expiryDate = null;

  /**
   * 
   * @var string $authenticationFlag
   * @access public
   */
  public $authenticationFlag = null;

  /**
   * 
   * @param cardNumberType $cardNumber
   * @param maskedCardNumberType $cardNumberMask
   * @param cardExpDateType $expiryDate
   * @param string $authenticationFlag
   * @access public
   */
  public function __construct($cardNumber, $cardNumberMask, $expiryDate, $authenticationFlag)
  {
    $this->cardNumber = $cardNumber;
    $this->cardNumberMask = $cardNumberMask;
    $this->expiryDate = $expiryDate;
    $this->authenticationFlag = $authenticationFlag;
  }

}
