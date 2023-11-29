<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class parameterListType
{

  /**
   * 
   * @var parameterType $parameter
   * @access public
   */
  public $parameter = null;

  /**
   * 
   * @param parameterType $parameter
   * @access public
   */
  public function __construct($parameter)
  {
    $this->parameter = $parameter;
  }

}
