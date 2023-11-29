<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class changeCardStatusRequestType
{

  /**
   * 
   * @var cardIdentificationType $cardIdentification
   * @access public
   */
  public $cardIdentification = null;

  /**
   * 
   * @var hotCardStatusType $hotCardStatus
   * @access public
   */
  public $hotCardStatus = null;

    /**
     *
     * @var extIdType $currency
     * @access public
     */
    public $extId = null;
}
