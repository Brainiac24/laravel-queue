<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class cardDataDetailedType
{

  /**
   * 
   * @var accountsType $accounts
   * @access public
   */
  public $accounts = null;

  /**
   * 
   * @param accountsType $accounts
   * @access public
   */
  public function __construct($accounts)
  {
    $this->accounts = $accounts;
  }

}
