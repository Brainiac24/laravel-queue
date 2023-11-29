<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class createVirtualCardResponseType
{

  /**
   * 
   * @var virtualCardIdentificationType $virtualCardIdentification
   * @access public
   */
  public $virtualCardIdentification = null;

  /**
   * 
   * @param virtualCardIdentificationType $virtualCardIdentification
   * @access public
   */
  public function __construct($virtualCardIdentification)
  {
    $this->virtualCardIdentification = $virtualCardIdentification;
  }

}
