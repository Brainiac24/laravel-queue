<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class miniStatementResponseType
{

  /**
   * 
   * @var miniStatementRecords $miniStatementRecords
   * @access public
   */
  public $miniStatementRecords = null;

  /**
   * 
   * @param miniStatementRecords $miniStatementRecords
   * @access public
   */
  public function __construct($miniStatementRecords)
  {
    $this->miniStatementRecords = $miniStatementRecords;
  }

}
