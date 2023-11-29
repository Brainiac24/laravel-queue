<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class transactionSchemeAdditionType
{

  /**
   * 
   * @var int $id
   * @access public
   */
  public $id = null;

  /**
   * 
   * @var institutionIdType $domain
   * @access public
   */
  public $domain = null;

  /**
   * 
   * @var int $countryGroup
   * @access public
   */
  public $countryGroup = null;

  /**
   * 
   * @var int $mccGroup
   * @access public
   */
  public $mccGroup = null;

  /**
   * 
   * @var transactionTypeType $transactionType
   * @access public
   */
  public $transactionType = null;

  /**
   * 
   * @var posDataCodeType $posDataCode
   * @access public
   */
  public $posDataCode = null;

  /**
   * 
   * @param int $id
   * @param institutionIdType $domain
   * @param int $countryGroup
   * @param int $mccGroup
   * @param transactionTypeType $transactionType
   * @param posDataCodeType $posDataCode
   * @access public
   */
  public function __construct($id, $domain, $countryGroup, $mccGroup, $transactionType, $posDataCode)
  {
    $this->id = $id;
    $this->domain = $domain;
    $this->countryGroup = $countryGroup;
    $this->mccGroup = $mccGroup;
    $this->transactionType = $transactionType;
    $this->posDataCode = $posDataCode;
  }

}
