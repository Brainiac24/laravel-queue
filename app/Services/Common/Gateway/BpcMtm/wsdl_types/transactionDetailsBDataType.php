<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class transactionDetailsBDataType
{

  /**
   * 
   * @var string $cardAcceptorTerminalId
   * @access public
   */
  public $cardAcceptorTerminalId = null;

  /**
   * 
   * @var string $cardAcceptorCode
   * @access public
   */
  public $cardAcceptorCode = null;

  /**
   * 
   * @var string $cardAcceptorNameAndCode
   * @access public
   */
  public $cardAcceptorNameAndCode = null;

  /**
   * 
   * @param string $cardAcceptorTerminalId
   * @param string $cardAcceptorCode
   * @param string $cardAcceptorNameAndCode
   * @access public
   */
  public function __construct($cardAcceptorTerminalId, $cardAcceptorCode, $cardAcceptorNameAndCode)
  {
    $this->cardAcceptorTerminalId = $cardAcceptorTerminalId;
    $this->cardAcceptorCode = $cardAcceptorCode;
    $this->cardAcceptorNameAndCode = $cardAcceptorNameAndCode;
  }

}
