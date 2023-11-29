<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionSchemeAdditionsType
{

  /**
   * 
   * @var transactionSchemeAdditionType $addition
   * @access public
   */
  public $addition = null;

  /**
   * 
   * @param transactionSchemeAdditionType $addition
   * @access public
   */
  public function __construct($addition)
  {
    $this->addition = $addition;
  }

}
