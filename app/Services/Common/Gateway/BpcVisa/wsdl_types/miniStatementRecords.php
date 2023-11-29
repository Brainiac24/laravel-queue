<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class miniStatementRecords
{

  /**
   * 
   * @var miniStatementRecordType $miniStatementRecord
   * @access public
   */
  public $miniStatementRecord = null;

  /**
   * 
   * @param miniStatementRecordType $miniStatementRecord
   * @access public
   */
  public function __construct($miniStatementRecord)
  {
    $this->miniStatementRecord = $miniStatementRecord;
  }

}
