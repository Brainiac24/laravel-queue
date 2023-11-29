<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class transactionDateTimePeriodType
{

  /**
   * 
   * @var dateTime $start
   * @access public
   */
  public $start = null;

  /**
   * 
   * @var dateTime $end
   * @access public
   */
  public $end = null;

  /**
   * 
   * @param dateTime $start
   * @param dateTime $end
   * @access public
   */
  public function __construct($start, $end)
  {
    $this->start = $start;
    $this->end = $end;
  }

}
