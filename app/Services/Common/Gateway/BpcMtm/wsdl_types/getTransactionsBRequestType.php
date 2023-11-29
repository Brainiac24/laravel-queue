<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class getTransactionsBRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var rowRangeType $rowRange
   * @access public
   */
  public $rowRange = null;

  /**
   * 
   * @var transactionDateTimeLowerBoundedPeriodType $period
   * @access public
   */
  public $period = null;

  /**
   * 
   * @var responseCodeInternalType $responseCode
   * @access public
   */
  public $responseCode = null;

  /**
   * 
   * @var boolean $maskCardNumber
   * @access public
   */
  public $maskCardNumber = null;

}
