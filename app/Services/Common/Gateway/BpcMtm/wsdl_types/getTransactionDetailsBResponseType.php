<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionDetailsBResponseType
{

  /**
   * 
   * @var transactionDetailsBDataType $transaction
   * @access public
   */
  public $transaction = null;

  /**
   * 
   * @param transactionDetailsBDataType $transaction
   * @access public
   */
  public function __construct($transaction)
  {
    $this->transaction = $transaction;
  }

}
