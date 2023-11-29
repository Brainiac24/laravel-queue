<?php
namespace App\Services\Common\Gateway\BpcMtm\wsdl_types;

use App\Services\Common\Helpers\Logger\Logger;
use Illuminate\Support\Facades\Log;



/**
 * Веб-сервис, предоставляющий интерфейс для взаимодействия внешних систем с системой SmartVista.
        
            Общий набор команд.
 * 
 */
class Apigate extends \SoapClient
{

  /**
   * 
   * @var array $classmap The defined classes
   * @access private
   */
  private static $classmap = array(
    'accountsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\accountsType',
    'cardsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardsType',
    'limitsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\limitsType',
    'cardListType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardListType',
    'limitExceptionsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\limitExceptionsType',
    'transactionsBType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionsBType',
    'transactionsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionsType',
    'transactionsBOType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionsBOType',
    'customFieldsType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\customFieldsType',
    'servicesListType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\servicesListType',
    'accountDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\accountDataType',
    'accountDataDetailedType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\accountDataDetailedType',
    'cardListElement' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardListElement',
    'cardDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardDataType',
    'cardDataDetailedType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardDataDetailedType',
    'cardIdentificationType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardIdentificationType',
    'changeCardStatusRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\changeCardStatusRequestType',
    'customFieldsDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\customFieldsDataType',
    'customerType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\customerType',
    'feeType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\feeType',
    'financialTransactionResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\financialTransactionResponseType',
    'limitBaseDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\limitBaseDataType',
    'limitExceptionType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\limitExceptionType',
    'limitFullDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\limitFullDataType',
    'originalTransactionParametersType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\originalTransactionParametersType',
    'cardAcceptorParametersType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\cardAcceptorParametersType',
    'personalDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\personalDataType',
    'personMoneySendType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\personMoneySendType',
    'personType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\personType',
    'rowRangeType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\rowRangeType',
    'serviceIdentificationType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\serviceIdentificationType',
    'serviceParametersType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\serviceParametersType',
    'servicesListDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\servicesListDataType',
    'simpleResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\simpleResponseType',
    'simpleIsoRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\simpleIsoRequestType',
    'transactionBDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionBDataType',
    'transactionDetailsBDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDetailsBDataType',
    'transactionDataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDataType',
    'transactionBODataType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionBODataType',
    'transactionDatePeriodType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDatePeriodType',
    'transactionDateStrictPeriodType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateStrictPeriodType',
    'transactionDateTimePeriodType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateTimePeriodType',
    'transactionDateTimeStrictPeriodType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateTimeStrictPeriodType',
    'transactionDateTimeLowerBoundedPeriodType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\transactionDateTimeLowerBoundedPeriodType',
    'virtualCardIdentificationType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\virtualCardIdentificationType',
    'generatePinSimpleRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\generatePinSimpleRequestType',
    'generatePinSimpleResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\generatePinSimpleResponseType',
    'terminalAddressType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\terminalAddressType',
    'serviceLevelFaultType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\serviceLevelFaultType',
    'svfeProcessingFaultType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\svfeProcessingFaultType',
    'changeCardLimitRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\changeCardLimitRequestType',
    'changePinRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\changePinRequestType',
    'createVirtualCardRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\createVirtualCardRequestType',
    'createVirtualCardResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\createVirtualCardResponseType',
    'creditCardRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\creditCardRequestType',
    'debitCardRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\debitCardRequestType',
    'feeCalculationRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\feeCalculationRequestType',
    'feeCalculationResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\feeCalculationResponseType',
    'getCardDataRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getCardDataRequestType',
    'getCardDataResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getCardDataResponseType',
    'getTransactionDetailsBRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionDetailsBRequestType',
    'getTransactionDetailsBResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionDetailsBResponseType',
    'getTransactionsBRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionsBRequestType',
    'getTransactionsBResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionsBResponseType',
    'getTransactionStatusRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionStatusRequestType',
    'getTransactionStatusResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\getTransactionStatusResponseType',
    'p2pTransferRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\p2pTransferRequestType',
    'reversalRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\reversalRequestType',
    'reversalResponseType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\reversalResponseType',
    'serviceActionRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\serviceActionRequestType',
    'validateCardRequestType' => 'App\Services\Common\Gateway\BpcMtm\wsdl_types\validateCardRequestType');

  /**
   * 
   * @param array $options A array of config values
   * @param string $wsdl The wsdl file to use
   * @access public
   */

   
  private $logger;
  public function __construct(array $options = array(), $wsdl)
  {
    //$this->logger = new Logger('gateways/bpc_mtm', 'BPC_MTM_TRANSPORT');
    //$this->logger->info('-----LOG APIGATE 1: '. $wsdl);
    //Log::info('-----LOG APIGATE 1' . $wsdl);
    //file_put_contents("log-2021-03-19-1.txt",'-----LOG APIGATE 1: ' . $wsdl,FILE_APPEND);
    foreach (self::$classmap as $key => $value) {
    if (!isset($options['classmap'][$key])) {
      $options['classmap'][$key] = $value;
    }
  }
  //$this->logger->info('-----LOG APIGATE 2: '. $wsdl);
  //Log::info('-----LOG APIGATE 2' . $wsdl);
  //file_put_contents("log-2021-03-19-1.txt",'-----LOG APIGATE 2: ' . $wsdl,FILE_APPEND);
  parent::__construct($wsdl, $options);
  }

  /**
   * Блокировать карту.
   * 
   * @param changeCardStatusRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function blockCard(changeCardStatusRequestType $parameters)
  {
    return $this->__soapCall('blockCard', array($parameters));
  }

  /**
   * Рассчитать эквайринговую комиссию для P2P операции.
   * 
   * @param feeCalculationRequestType $parameters
   * @access public
   * @return feeCalculationResponseType
   */
  public function feeCalculation(feeCalculationRequestType $parameters)
  {
    return $this->__soapCall('feeCalculation', array($parameters));
  }

  /**
   * Получить транзакционную историю.
   * 
   * @param getTransactionsBRequestType $parameters
   * @access public
   * @return getTransactionsBResponseType
   */
  public function getTransactionsB(getTransactionsBRequestType $parameters)
  {
    return $this->__soapCall('getTransactionsB', array($parameters));
  }

  /**
   * Получить транзакционную историю.
   * 
   * @param getTransactionStatusRequestType $parameters
   * @access public
   * @return getTransactionStatusResponseType
   */
  public function getTransactionStatus(getTransactionStatusRequestType $parameters)
  {
    return $this->__soapCall('getTransactionStatus', array($parameters));
  }

  /**
   * Создать виртуальную карту.
   * 
   * @param createVirtualCardRequestType $parameters
   * @access public
   * @return createVirtualCardResponseType
   */
  public function createVirtualCard(createVirtualCardRequestType $parameters)
  {
    return $this->__soapCall('createVirtualCard', array($parameters));
  }

  /**
   * Получить информацию по карте.
   * 
   * @param getCardDataRequestType $parameters
   * @access public
   * @return getCardDataResponseType
   */
  public function getCardData(getCardDataRequestType $parameters)
  {
    return $this->__soapCall('getCardData', array($parameters));
  }

  /**
   * �?зменить значение лимита уровня карты.
   * 
   * @param changeCardLimitRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function changeCardLimit(changeCardLimitRequestType $parameters)
  {
    return $this->__soapCall('changeCardLimit', array($parameters));
  }

  /**
   * Получить подробную информацию о транзакции.
   * 
   * @param getTransactionDetailsBRequestType $parameters
   * @access public
   * @return getTransactionDetailsBResponseType
   */
  public function getTransactionDetailsB(getTransactionDetailsBRequestType $parameters)
  {
    return $this->__soapCall('getTransactionDetailsB', array($parameters));
  }

  /**
   * Разблокировать карту.
   * 
   * @param validateCardRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function validateCard(validateCardRequestType $parameters)
  {
    return $this->__soapCall('validateCard', array($parameters));
  }

  /**
   * Зачислить средства на карту.
   * 
   * @param creditCardRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function creditCard(creditCardRequestType $parameters)
  {
    return $this->__soapCall('creditCard', array($parameters));
  }

  /**
   * Списать средства с карты.
   * 
   * @param debitCardRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function debitCard(debitCardRequestType $parameters)
  {
    //$this->logger->info('-----LOG APIGATE 1: '. json_encode($parameters, JSON_UNESCAPED_UNICODE));
    return $this->__soapCall('debitCard', array($parameters));
  }

  /**
   * Выполнить перевод между счетами двух карт.
   * 
   * @param p2pTransferRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function p2pTransfer(p2pTransferRequestType $parameters)
  {
    return $this->__soapCall('p2pTransfer', array($parameters));
  }

  /**
   * �?зменить PIN-код.
   * 
   * @param changePinRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function changePin(changePinRequestType $parameters)
  {
    return $this->__soapCall('changePin', array($parameters));
  }

  /**
   * Отменить операцию.
   * 
   * @param reversalRequestType $parameters
   * @access public
   * @return reversalResponseType
   */
  public function reversal(reversalRequestType $parameters)
  {
    return $this->__soapCall('reversal', array($parameters));
  }

  /**
   * Выполнить действие над сервисом.
   * 
   * @param serviceActionRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function serviceAction(serviceActionRequestType $parameters)
  {
    return $this->__soapCall('serviceAction', array($parameters));
  }

}
