<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class paginationSettingsType
{

  /**
   * 
   * @var int $pageSize
   * @access public
   */
  public $pageSize = null;

  /**
   * 
   * @var int $pageNum
   * @access public
   */
  public $pageNum = null;

  /**
   * 
   * @param int $pageSize
   * @param int $pageNum
   * @access public
   */
  public function __construct($pageSize, $pageNum)
  {
    $this->pageSize = $pageSize;
    $this->pageNum = $pageNum;
  }

}
