<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class sv2LimitListType
{

  /**
   * 
   * @var sv2LimitType $limit
   * @access public
   */
  public $limit = null;

  /**
   * 
   * @param sv2LimitType $limit
   * @access public
   */
  public function __construct($limit)
  {
    $this->limit = $limit;
  }

}
