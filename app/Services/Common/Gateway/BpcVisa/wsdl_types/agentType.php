<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

class agentType
{

  /**
   * 
   * @var string255 $id
   * @access public
   */
  public $id = null;

  /**
   * 
   * @var string255 $number
   * @access public
   */
  public $number = null;

  /**
   * 
   * @var string255 $name
   * @access public
   */
  public $name = null;

  /**
   * 
   * @var agentListType $agents
   * @access public
   */
  public $agents = null;

  /**
   * 
   * @var sv2ContactListType $contacts
   * @access public
   */
  public $contacts = null;

  /**
   * 
   * @var sv2AddressListType $addresses
   * @access public
   */
  public $addresses = null;

  /**
   * 
   * @param string255 $id
   * @param string255 $number
   * @param string255 $name
   * @param agentListType $agents
   * @param sv2ContactListType $contacts
   * @param sv2AddressListType $addresses
   * @access public
   */
  public function __construct($id, $number, $name, $agents, $contacts, $addresses)
  {
    $this->id = $id;
    $this->number = $number;
    $this->name = $name;
    $this->agents = $agents;
    $this->contacts = $contacts;
    $this->addresses = $addresses;
  }

}
