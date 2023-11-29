<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class agentListType
{

  /**
   * 
   * @var agentType $agent
   * @access public
   */
  public $agent = null;

  /**
   * 
   * @param agentType $agent
   * @access public
   */
  public function __construct($agent)
  {
    $this->agent = $agent;
  }

}
