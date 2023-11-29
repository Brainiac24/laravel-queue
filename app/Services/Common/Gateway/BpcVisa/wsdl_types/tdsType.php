<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class tdsType
{

  /**
   * 
   * @var string255 $xid
   * @access public
   */
  public $xid = null;

  /**
   * 
   * @var string255 $cavv
   * @access public
   */
  public $cavv = null;

  /**
   * 
   * @var string255 $ucaf
   * @access public
   */
  public $ucaf = null;

  /**
   * 
   * @var ecAuthenticationIndicator $authenticationIndicator
   * @access public
   */
  public $authenticationIndicator = null;

  /**
   * 
   * @param string255 $xid
   * @param string255 $cavv
   * @param string255 $ucaf
   * @param ecAuthenticationIndicator $authenticationIndicator
   * @access public
   */
  public function __construct($xid, $cavv, $ucaf, $authenticationIndicator)
  {
    $this->xid = $xid;
    $this->cavv = $cavv;
    $this->ucaf = $ucaf;
    $this->authenticationIndicator = $authenticationIndicator;
  }

}
