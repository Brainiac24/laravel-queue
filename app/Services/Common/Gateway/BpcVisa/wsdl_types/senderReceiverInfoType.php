<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class senderReceiverInfoType
{

  /**
   * 
   * @var senderNameType $senderName
   * @access public
   */
  public $senderName = null;

  /**
   * 
   * @var senderAddressType $senderAddress
   * @access public
   */
  public $senderAddress = null;

  /**
   * 
   * @var senderCityType $senderCity
   * @access public
   */
  public $senderCity = null;

  /**
   * 
   * @var countryCodeType $senderCountry
   * @access public
   */
  public $senderCountry = null;

  /**
   * 
   * @var postalCodeType $senderPostalCode
   * @access public
   */
  public $senderPostalCode = null;

  /**
   * 
   * @var receiverNameType $receiverName
   * @access public
   */
  public $receiverName = null;

  /**
   * 
   * @param senderNameType $senderName
   * @param senderAddressType $senderAddress
   * @param senderCityType $senderCity
   * @param countryCodeType $senderCountry
   * @param postalCodeType $senderPostalCode
   * @param receiverNameType $receiverName
   * @access public
   */
  public function __construct($senderName, $senderAddress, $senderCity, $senderCountry, $senderPostalCode, $receiverName)
  {
    $this->senderName = $senderName;
    $this->senderAddress = $senderAddress;
    $this->senderCity = $senderCity;
    $this->senderCountry = $senderCountry;
    $this->senderPostalCode = $senderPostalCode;
    $this->receiverName = $receiverName;
  }

}
