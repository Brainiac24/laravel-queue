<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionDateStrictPeriodType
{

  /**
   * 
   * @var date $start
   * @access public
   */
  public $start = null;

  /**
   * 
   * @var date $end
   * @access public
   */
  public $end = null;

  /**
   * 
   * @param date $start
   * @param date $end
   * @access public
   */
  public function __construct($start, $end)
  {
    $this->start = $start;
    $this->end = $end;
  }

}
