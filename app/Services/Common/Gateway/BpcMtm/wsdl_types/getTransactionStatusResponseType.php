<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionStatusResponseType
{

  /**
   * 
   * @var utrnnoType $utrnno
   * @access public
   */
  public $utrnno = null;

  /**
   * 
   * @var responseCodeType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @var responseCodeDescription $responseCodeDescription
   * @access public
   */
  public $responseCodeDescription = null;

  /**
   * 
   * @param utrnnoType $utrnno
   * @param responseCodeType $responseCode
   * @param responseCodeDescription $responseCodeDescription
   * @access public
   */
  public function __construct($utrnno, $responseCode, $responseCodeDescription)
  {
    $this->utrnno = $utrnno;
    $this->responseCode = $responseCode;
    $this->responseCodeDescription = $responseCodeDescription;
  }

}
