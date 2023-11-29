<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionsType
{

  /**
   * 
   * @var transactionDataType $transaction
   * @access public
   */
  public $transaction = null;

  /**
   * 
   * @param transactionDataType $transaction
   * @access public
   */
  public function __construct($transaction)
  {
    $this->transaction = $transaction;
  }

}
