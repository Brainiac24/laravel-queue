<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionsBType
{

  /**
   * 
   * @var transactionBDataType $transaction
   * @access public
   */
  public $transaction = null;

  /**
   * 
   * @param transactionBDataType $transaction
   * @access public
   */
  public function __construct($transaction)
  {
    $this->transaction = $transaction;
  }

}
