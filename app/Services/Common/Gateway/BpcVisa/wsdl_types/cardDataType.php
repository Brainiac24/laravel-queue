<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class cardDataType
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
   * @var base64Binary $encryptedCardNumber
   * @access public
   */
  public $encryptedCardNumber = null;

  /**
   * 
   * @var cardExpDateType $expiryDate
   * @access public
   */
  public $expiryDate = null;

  /**
   * 
   * @var string200 $formattedExpiryDate
   * @access public
   */
  public $formattedExpiryDate = null;

  /**
   * 
   * @var cardIdType $cardId
   * @access public
   */
  public $cardId = null;

  /**
   * 
   * @var hotCardStatusType $hotCardStatus
   * @access public
   */
  public $hotCardStatus = null;

  /**
   * 
   * @var cardTypeNameType $cardTypeName
   * @access public
   */
  public $cardTypeName = null;

  /**
   * 
   * @var embossedNameType $embossedName
   * @access public
   */
  public $embossedName = null;

  /**
   * 
   * @var customerIdType $customerId
   * @access public
   */
  public $customerId = null;

  /**
   * 
   * @var string255 $customerName
   * @access public
   */
  public $customerName = null;

  /**
   * 
   * @var personIdType $personId
   * @access public
   */
  public $personId = null;

  /**
   * 
   * @var pinDenialCounterType $pinDenialCounter
   * @access public
   */
  public $pinDenialCounter = null;

  /**
   * 
   * @var cardPlasticNumberType $plasticNumber
   * @access public
   */
  public $plasticNumber = null;

  /**
   * 
   * @var hotCardStatusDescriptionType $hotCardStatusDescription
   * @access public
   */
  public $hotCardStatusDescription = null;

  /**
   * 
   * @var boolean $cardIsPrimary
   * @access public
   */
  public $cardIsPrimary = null;

  /**
   * 
   * @var boolean $cardBindToCustomer
   * @access public
   */
  public $cardBindToCustomer = null;

  /**
   * 
   * @var boolean $customerIsCardholder
   * @access public
   */
  public $customerIsCardholder = null;

  /**
   * 
   * @var cardContractIdType $cardContractId
   * @access public
   */
  public $cardContractId = null;

  /**
   * 
   * @var cardPlasticIdType $cardPlasticId
   * @access public
   */
  public $cardPlasticId = null;

  /**
   * 
   * @var cardPlasticDescriptionType $cardPlasticDescription
   * @access public
   */
  public $cardPlasticDescription = null;

  /**
   * 
   * @var memorableWordType $memorableWord
   * @access public
   */
  public $memorableWord = null;

  /**
   * 
   * @var emailType $email
   * @access public
   */
  public $email = null;

  /**
   * 
   * @var dateTime $lastWrongPinDate
   * @access public
   */
  public $lastWrongPinDate = null;

  /**
   * 
   * @var date $cardCreationDate
   * @access public
   */
  public $cardCreationDate = null;

  /**
   * 
   * @var dateTime $cardBlockingDate
   * @access public
   */
  public $cardBlockingDate = null;

  /**
   * 
   * @var string200 $directDebitAccount
   * @access public
   */
  public $directDebitAccount = null;

  /**
   * 
   * @var phoneNumberType $cardholderMobilePhoneNumber
   * @access public
   */
  public $cardholderMobilePhoneNumber = null;

  /**
   * 
   * @param cardNumberType $cardNumber
   * @param maskedCardNumberType $cardNumberMask
   * @param base64Binary $encryptedCardNumber
   * @param cardExpDateType $expiryDate
   * @param string200 $formattedExpiryDate
   * @param cardIdType $cardId
   * @param hotCardStatusType $hotCardStatus
   * @param cardTypeNameType $cardTypeName
   * @param embossedNameType $embossedName
   * @param customerIdType $customerId
   * @param string255 $customerName
   * @param personIdType $personId
   * @param pinDenialCounterType $pinDenialCounter
   * @param cardPlasticNumberType $plasticNumber
   * @param hotCardStatusDescriptionType $hotCardStatusDescription
   * @param boolean $cardIsPrimary
   * @param boolean $cardBindToCustomer
   * @param boolean $customerIsCardholder
   * @param cardContractIdType $cardContractId
   * @param cardPlasticIdType $cardPlasticId
   * @param cardPlasticDescriptionType $cardPlasticDescription
   * @param memorableWordType $memorableWord
   * @param emailType $email
   * @param dateTime $lastWrongPinDate
   * @param date $cardCreationDate
   * @param dateTime $cardBlockingDate
   * @param string200 $directDebitAccount
   * @param phoneNumberType $cardholderMobilePhoneNumber
   * @access public
   */
  public function __construct($cardNumber, $cardNumberMask, $encryptedCardNumber, $expiryDate, $formattedExpiryDate, $cardId, $hotCardStatus, $cardTypeName, $embossedName, $customerId, $customerName, $personId, $pinDenialCounter, $plasticNumber, $hotCardStatusDescription, $cardIsPrimary, $cardBindToCustomer, $customerIsCardholder, $cardContractId, $cardPlasticId, $cardPlasticDescription, $memorableWord, $email, $lastWrongPinDate, $cardCreationDate, $cardBlockingDate, $directDebitAccount, $cardholderMobilePhoneNumber)
  {
    $this->cardNumber = $cardNumber;
    $this->cardNumberMask = $cardNumberMask;
    $this->encryptedCardNumber = $encryptedCardNumber;
    $this->expiryDate = $expiryDate;
    $this->formattedExpiryDate = $formattedExpiryDate;
    $this->cardId = $cardId;
    $this->hotCardStatus = $hotCardStatus;
    $this->cardTypeName = $cardTypeName;
    $this->embossedName = $embossedName;
    $this->customerId = $customerId;
    $this->customerName = $customerName;
    $this->personId = $personId;
    $this->pinDenialCounter = $pinDenialCounter;
    $this->plasticNumber = $plasticNumber;
    $this->hotCardStatusDescription = $hotCardStatusDescription;
    $this->cardIsPrimary = $cardIsPrimary;
    $this->cardBindToCustomer = $cardBindToCustomer;
    $this->customerIsCardholder = $customerIsCardholder;
    $this->cardContractId = $cardContractId;
    $this->cardPlasticId = $cardPlasticId;
    $this->cardPlasticDescription = $cardPlasticDescription;
    $this->memorableWord = $memorableWord;
    $this->email = $email;
    $this->lastWrongPinDate = $lastWrongPinDate;
    $this->cardCreationDate = $cardCreationDate;
    $this->cardBlockingDate = $cardBlockingDate;
    $this->directDebitAccount = $directDebitAccount;
    $this->cardholderMobilePhoneNumber = $cardholderMobilePhoneNumber;
  }

}
