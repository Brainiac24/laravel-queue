<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class parameterType
{

  /**
   * 
   * @var string255 $name
   * @access public
   */
  public $name = null;

  /**
   * 
   * @var string255 $value
   * @access public
   */
  public $value = null;

  /**
   * 
   * @param string255 $name
   * @param string255 $value
   * @access public
   */
  public function __construct($name, $value)
  {
    $this->name = $name;
    $this->value = $value;
  }

}
