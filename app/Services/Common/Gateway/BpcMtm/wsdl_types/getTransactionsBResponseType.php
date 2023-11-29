<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionsBResponseType
{

  /**
   * 
   * @var transactionsBType $transactions
   * @access public
   */
  public $transactions = null;

  /**
   * 
   * @param transactionsBType $transactions
   * @access public
   */
  public function __construct($transactions)
  {
    $this->transactions = $transactions;
  }

}
