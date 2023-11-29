<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2AddressDataType
{

  /**
   * 
   * @var string255 $addressType
   * @access public
   */
  public $addressType = null;

  /**
   * 
   * @var string255 $addressTypeName
   * @access public
   */
  public $addressTypeName = null;

  /**
   * 
   * @var string255 $countryCode
   * @access public
   */
  public $countryCode = null;

  /**
   * 
   * @var string255 $countryName
   * @access public
   */
  public $countryName = null;

  /**
   * 
   * @var string255 $postalCode
   * @access public
   */
  public $postalCode = null;

  /**
   * 
   * @var string255 $region
   * @access public
   */
  public $region = null;

  /**
   * 
   * @var string255 $city
   * @access public
   */
  public $city = null;

  /**
   * 
   * @var string255 $street
   * @access public
   */
  public $street = null;

  /**
   * 
   * @var string255 $house
   * @access public
   */
  public $house = null;

  /**
   * 
   * @var string255 $apartment
   * @access public
   */
  public $apartment = null;

  /**
   * 
   * @param string255 $addressType
   * @param string255 $addressTypeName
   * @param string255 $countryCode
   * @param string255 $countryName
   * @param string255 $postalCode
   * @param string255 $region
   * @param string255 $city
   * @param string255 $street
   * @param string255 $house
   * @param string255 $apartment
   * @access public
   */
  public function __construct($addressType, $addressTypeName, $countryCode, $countryName, $postalCode, $region, $city, $street, $house, $apartment)
  {
    $this->addressType = $addressType;
    $this->addressTypeName = $addressTypeName;
    $this->countryCode = $countryCode;
    $this->countryName = $countryName;
    $this->postalCode = $postalCode;
    $this->region = $region;
    $this->city = $city;
    $this->street = $street;
    $this->house = $house;
    $this->apartment = $apartment;
  }

}
