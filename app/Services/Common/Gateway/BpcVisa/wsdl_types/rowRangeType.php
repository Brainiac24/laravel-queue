<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class rowRangeType
{

  /**
   * 
   * @var int $start
   * @access public
   */
  public $start = null;

  /**
   * 
   * @var int $end
   * @access public
   */
  public $end = null;

  /**
   * 
   * @param int $start
   * @param int $end
   * @access public
   */
  public function __construct($start, $end)
  {
    $this->start = $start;
    $this->end = $end;
  }

}
