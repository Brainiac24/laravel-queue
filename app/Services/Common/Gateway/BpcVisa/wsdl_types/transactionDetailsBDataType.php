<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionDetailsBDataType
{

  /**
   * 
   * @var string255 $cardAcceptorTerminalId
   * @access public
   */
  public $cardAcceptorTerminalId = null;

  /**
   * 
   * @var string255 $cardAcceptorCode
   * @access public
   */
  public $cardAcceptorCode = null;

  /**
   * 
   * @var string255 $cardAcceptorNameAndCode
   * @access public
   */
  public $cardAcceptorNameAndCode = null;

  /**
   * 
   * @param string255 $cardAcceptorTerminalId
   * @param string255 $cardAcceptorCode
   * @param string255 $cardAcceptorNameAndCode
   * @access public
   */
  public function __construct($cardAcceptorTerminalId, $cardAcceptorCode, $cardAcceptorNameAndCode)
  {
    $this->cardAcceptorTerminalId = $cardAcceptorTerminalId;
    $this->cardAcceptorCode = $cardAcceptorCode;
    $this->cardAcceptorNameAndCode = $cardAcceptorNameAndCode;
  }

}
