<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class limitsType
{

  /**
   * 
   * @var limitFullDataType $limit
   * @access public
   */
  public $limit = null;

  /**
   * 
   * @param limitFullDataType $limit
   * @access public
   */
  public function __construct($limit)
  {
    $this->limit = $limit;
  }

}
