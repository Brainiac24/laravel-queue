<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class accountsType
{

  /**
   * 
   * @var accountDataType $accountData
   * @access public
   */
  public $accountData = null;

  /**
   * 
   * @param accountDataType $accountData
   * @access public
   */
  public function __construct($accountData)
  {
    $this->accountData = $accountData;
  }

}
