<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class getTransactionsResponseType
{

  /**
   * 
   * @var transactionsType $transactions
   * @access public
   */
  public $transactions = null;

  /**
   * 
   * @param transactionsType $transactions
   * @access public
   */
  public function __construct($transactions)
  {
    $this->transactions = $transactions;
  }

}
