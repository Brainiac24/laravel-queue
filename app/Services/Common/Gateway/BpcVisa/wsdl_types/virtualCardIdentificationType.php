<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class virtualCardIdentificationType
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
   * @var cardIdType $cardId
   * @access public
   */
  public $cardId = null;

  /**
   * 
   * @var cardExpDateType $expDate
   * @access public
   */
  public $expDate = null;

  /**
   * 
   * @var productTypeType $productType
   * @access public
   */
  public $productType = null;

  /**
   * 
   * @var barCodeType $barCode
   * @access public
   */
  public $barCode = null;

  /**
   * 
   * @var cvv2Type $cvv2
   * @access public
   */
  public $cvv2 = null;

  /**
   * 
   * @param cardNumberType $cardNumber
   * @param maskedCardNumberType $cardNumberMask
   * @param cardIdType $cardId
   * @param cardExpDateType $expDate
   * @param productTypeType $productType
   * @param barCodeType $barCode
   * @param cvv2Type $cvv2
   * @access public
   */
  public function __construct($cardNumber, $cardNumberMask, $cardId, $expDate, $productType, $barCode, $cvv2)
  {
    $this->cardNumber = $cardNumber;
    $this->cardNumberMask = $cardNumberMask;
    $this->cardId = $cardId;
    $this->expDate = $expDate;
    $this->productType = $productType;
    $this->barCode = $barCode;
    $this->cvv2 = $cvv2;
  }

}
