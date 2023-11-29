<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

class customFieldsDataType
{

  /**
   * 
   * @var customFieldNameType $fieldName
   * @access public
   */
  public $fieldName = null;

  /**
   * 
   * @var customFieldDescriptionType $fieldDescription
   * @access public
   */
  public $fieldDescription = null;

  /**
   * 
   * @var customFieldDataTypeType $dataType
   * @access public
   */
  public $dataType = null;

  /**
   * 
   * @var customFieldValueType $value
   * @access public
   */
  public $value = null;

  /**
   * 
   * @param customFieldNameType $fieldName
   * @param customFieldDescriptionType $fieldDescription
   * @param customFieldDataTypeType $dataType
   * @param customFieldValueType $value
   * @access public
   */
  public function __construct($fieldName, $fieldDescription, $dataType, $value)
  {
    $this->fieldName = $fieldName;
    $this->fieldDescription = $fieldDescription;
    $this->dataType = $dataType;
    $this->value = $value;
  }

}
