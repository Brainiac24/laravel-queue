<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

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
   * @var cardExpDateType $expiryDate
   * @access public
   */
  public $expiryDate = null;

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
   * @var personIdType $personId
   * @access public
   */
  public $personId = null;

  /**
   * 
   * @var phoneNumberType $phoneNumber
   * @access public
   */
  public $phoneNumber = null;

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
   * @param cardNumberType $cardNumber
   * @param maskedCardNumberType $cardNumberMask
   * @param cardExpDateType $expiryDate
   * @param cardIdType $cardId
   * @param hotCardStatusType $hotCardStatus
   * @param cardTypeNameType $cardTypeName
   * @param embossedNameType $embossedName
   * @param customerIdType $customerId
   * @param personIdType $personId
   * @param phoneNumberType $phoneNumber
   * @param pinDenialCounterType $pinDenialCounter
   * @param cardPlasticNumberType $plasticNumber
   * @param hotCardStatusDescriptionType $hotCardStatusDescription
   * @param boolean $cardIsPrimary
   * @param boolean $cardBindToCustomer
   * @param boolean $customerIsCardholder
   * @access public
   */
  public function __construct($cardNumber, $cardNumberMask, $expiryDate, $cardId, $hotCardStatus, $cardTypeName, $embossedName, $customerId, $personId, $phoneNumber, $pinDenialCounter, $plasticNumber, $hotCardStatusDescription, $cardIsPrimary, $cardBindToCustomer, $customerIsCardholder)
  {
    $this->cardNumber = $cardNumber;
    $this->cardNumberMask = $cardNumberMask;
    $this->expiryDate = $expiryDate;
    $this->cardId = $cardId;
    $this->hotCardStatus = $hotCardStatus;
    $this->cardTypeName = $cardTypeName;
    $this->embossedName = $embossedName;
    $this->customerId = $customerId;
    $this->personId = $personId;
    $this->phoneNumber = $phoneNumber;
    $this->pinDenialCounter = $pinDenialCounter;
    $this->plasticNumber = $plasticNumber;
    $this->hotCardStatusDescription = $hotCardStatusDescription;
    $this->cardIsPrimary = $cardIsPrimary;
    $this->cardBindToCustomer = $cardBindToCustomer;
    $this->customerIsCardholder = $customerIsCardholder;
  }

}
