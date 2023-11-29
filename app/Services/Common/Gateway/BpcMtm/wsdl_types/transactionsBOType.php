<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class transactionsBOType
{

  /**
   * 
   * @var transactionBODataType $transaction
   * @access public
   */
  public $transaction = null;

  /**
   * 
   * @param transactionBODataType $transaction
   * @access public
   */
  public function __construct($transaction)
  {
    $this->transaction = $transaction;
  }

}
