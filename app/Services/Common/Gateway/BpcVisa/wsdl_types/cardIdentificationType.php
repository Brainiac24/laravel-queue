<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class cardIdentificationType
{

  /**
   * 
   * @var cardNumberType $cardNumber
   * @access public
   */
  public $cardNumber = null;

  /**
   * 
   * @var cardLastDigitMaskType $cardLastDigitMask
   * @access public
   */
  public $cardLastDigitMask = null;

  /**
   * 
   * @var string255 $cardNumberMask
   * @access public
   */
  public $cardNumberMask = null;

  /**
   * 
   * @var string $encryptedCardNumber
   * @access public
   */
  public $encryptedCardNumber = null;

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
   * @var cardPlasticNumberType $plasticNumber
   * @access public
   */
  public $plasticNumber = null;

  /**
   * 
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

  /**
   * 
   * @var cardholderIdType $cardholderId
   * @access public
   */
  public $cardholderId = null;

  /**
   * 
   * @var customerIdType $customerId
   * @access public
   */
  public $customerId = null;

  /**
   * 
   * @var string200 $customerNumber
   * @access public
   */
  public $customerNumber = null;

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
   * @var string255 $externalCardId
   * @access public
   */
  public $externalCardId = null;

  /**
   * 
   * @var string255 $token
   * @access public
   */
  public $token = null;

  /**
   * 
   * @var cardTypeCodeType $cardTypeCode
   * @access public
   */
  public $cardTypeCode = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

}
