<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class personMoneySendType
{

  /**
   * 
   * @var string $name
   * @access public
   */
  public $name = null;

  /**
   * 
   * @var string $street
   * @access public
   */
  public $street = null;

  /**
   * 
   * @var string $city
   * @access public
   */
  public $city = null;

  /**
   * 
   * @var string $country
   * @access public
   */
  public $country = null;

  /**
   * 
   * @var string $postalCode
   * @access public
   */
  public $postalCode = null;

  /**
   * 
   * @param string $name
   * @param string $street
   * @param string $city
   * @param string $country
   * @param string $postalCode
   * @access public
   */
  public function __construct($name, $street, $city, $country, $postalCode)
  {
    $this->name = $name;
    $this->street = $street;
    $this->city = $city;
    $this->country = $country;
    $this->postalCode = $postalCode;
  }

}
