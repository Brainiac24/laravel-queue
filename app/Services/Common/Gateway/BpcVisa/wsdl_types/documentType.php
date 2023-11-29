<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class documentType
{

  /**
   * 
   * @var documentTypeType $type
   * @access public
   */
  public $type = null;

  /**
   * 
   * @var string255 $number
   * @access public
   */
  public $number = null;

  /**
   * 
   * @var string255 $series
   * @access public
   */
  public $series = null;

  /**
   * 
   * @param documentTypeType $type
   * @param string255 $number
   * @param string255 $series
   * @access public
   */
  public function __construct($type, $number, $series)
  {
    $this->type = $type;
    $this->number = $number;
    $this->series = $series;
  }

}
