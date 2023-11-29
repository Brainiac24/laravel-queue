<?php
namespace App\Services\Common\Gateway\BpcVisa\wsdl_types;

use App\Services\Common\Helpers\Logger\Logger;
use Illuminate\Support\Facades\Log;

/**
 * Веб-сервис, предоставляющий интерфейс для взаимодействия внешних систем с системой SmartVista.
      Web-service provides an interface to communicate external systems with SmartVista.
    
    

        Общий набор команд.
        General command set.
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
    'accountsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\accountsType',
    'agentType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\agentType',
    'agentListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\agentListType',
    'cardsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardsType',
    'limitsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\limitsType',
    'cardListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardListType',
    'parameterListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\parameterListType',
    'limitExceptionsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\limitExceptionsType',
    'senderReceiverInfoType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\senderReceiverInfoType',
    'tdsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\tdsType',
    'terminalLimitsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\terminalLimitsType',
    'transactionsBType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionsBType',
    'transactionsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionsType',
    'accountDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\accountDataType',
    'accountDataDetailedType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\accountDataDetailedType',
    'cardAcceptorParametersType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardAcceptorParametersType',
    'cardListElement' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardListElement',
    'cardDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardDataType',
    'cardDataDetailedType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardDataDetailedType',
    'cardIdentificationType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardIdentificationType',
    'changeCardStatusRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\changeCardStatusRequestType',
    'customerType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\customerType',
    'feeType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\feeType',
    'financialTransactionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\financialTransactionRequestType',
    'financialTransactionResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\financialTransactionResponseType',
    'limitBaseDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\limitBaseDataType',
    'limitExceptionType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\limitExceptionType',
    'limitFullDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\limitFullDataType',
    'originalTransactionParametersType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\originalTransactionParametersType',
    'paginationSettingsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\paginationSettingsType',
    'parameterType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\parameterType',
    'paymentSpecificDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\paymentSpecificDataType',
    'personalDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\personalDataType',
    'personType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\personType',
    'rowRangeType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\rowRangeType',
    'serviceIdentificationType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\serviceIdentificationType',
    'serviceParametersType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\serviceParametersType',
    'simpleResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\simpleResponseType',
    'sv2ContactDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2ContactDataType',
    'sv2ContactListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2ContactListType',
    'sv2AddressDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2AddressDataType',
    'sv2AddressListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2AddressListType',
    'sv2CustodianDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2CustodianDataType',
    'sv2LimitType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2LimitType',
    'sv2LimitListType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\sv2LimitListType',
    'terminalLimitBaseDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\terminalLimitBaseDataType',
    'terminalLimitExceptionsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\terminalLimitExceptionsType',
    'terminalLimitExceptionType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\terminalLimitExceptionType',
    'terminalLimitFullDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\terminalLimitFullDataType',
    'transactionBDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionBDataType',
    'transactionDetailsBDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDetailsBDataType',
    'transactionDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDataType',
    'transactionDatePeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDatePeriodType',
    'transactionDateStrictPeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateStrictPeriodType',
    'transactionDateLowerBoundedPeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateLowerBoundedPeriodType',
    'transactionDateTimePeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateTimePeriodType',
    'transactionDateTimeStrictPeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateTimeStrictPeriodType',
    'transactionDateTimeLowerBoundedPeriodType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionDateTimeLowerBoundedPeriodType',
    'transactionSchemeAdditionsType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionSchemeAdditionsType',
    'transactionSchemeAdditionType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\transactionSchemeAdditionType',
    'virtualCardIdentificationType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\virtualCardIdentificationType',
    'preAuthorizationRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\preAuthorizationRequestType',
    'serviceLevelFaultType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\serviceLevelFaultType',
    'svfeProcessingFaultType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\svfeProcessingFaultType',
    'addCardLimitExceptionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\addCardLimitExceptionRequestType',
    'cardStatusInquiryRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardStatusInquiryRequestType',
    'cardStatusInquiryResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\cardStatusInquiryResponseType',
    'changeCardLimitRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\changeCardLimitRequestType',
    'changeCardLimitExceptionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\changeCardLimitExceptionRequestType',
    'completionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\completionRequestType',
    'createVirtualCardRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\createVirtualCardRequestType',
    'personalDataType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\personalDataType',
    'documentType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\documentType',
    'createVirtualCardResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\createVirtualCardResponseType',
    'creditCardRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\creditCardRequestType',
    'debitCardRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\debitCardRequestType',
    'deleteCardLimitRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\deleteCardLimitRequestType',
    'deleteCardLimitExceptionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\deleteCardLimitExceptionRequestType',
    'getCardBalanceRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardBalanceRequestType',
    'getCardBalanceResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardBalanceResponseType',
    'getCardDataRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardDataRequestType',
    'getCardDataResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardDataResponseType',
    'getCardLimitsRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardLimitsRequestType',
    'getCardLimitsResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getCardLimitsResponseType',
    'miniStatementRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\miniStatementRequestType',
    'miniStatementResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\miniStatementResponseType',
    'miniStatementRecords' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\miniStatementRecords',
    'miniStatementRecordType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\miniStatementRecordType',
    'getTransactionsRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getTransactionsRequestType',
    'getTransactionsResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\getTransactionsResponseType',
    'p2pCreditRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\p2pCreditRequestType',
    'p2pDebitRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\p2pDebitRequestType',
    'p2pTransferRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\p2pTransferRequestType',
    'reversalRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\reversalRequestType',
    'reversalResponseType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\reversalResponseType',
    'serviceActionRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\serviceActionRequestType',
    'validateCardRequestType' => 'App\Services\Common\Gateway\BpcVisa\wsdl_types\validateCardRequestType');

  /**
   * 
   * @param array $options A array of config values
   * @param string $wsdl The wsdl file to use
   * @access public
   */
  public function __construct(array $options = array(), $wsdl)
  {
    //Log::info('-----LOG APIGATE' . $wsdl);
    foreach (self::$classmap as $key => $value) {
    if (!isset($options['classmap'][$key])) {
      $options['classmap'][$key] = $value;
    }
  }
  //Log::info('-----LOG APIGATE 2' . $wsdl);
  parent::__construct($wsdl, $options);
  }

  /**
   * Добавить исключение для лимита уровня карты.
        Add an exception for a card-level limit.
   * 
   * @param addCardLimitExceptionRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function addCardLimitException(addCardLimitExceptionRequestType $parameters)
  {
    return $this->__soapCall('addCardLimitException', array($parameters));
  }

  /**
   * Запросить статус карты.
        Get the current status of a card.
   * 
   * @param cardStatusInquiryRequestType $parameters
   * @access public
   * @return cardStatusInquiryResponseType
   */
  public function cardStatusInquiry(cardStatusInquiryRequestType $parameters)
  {
    return $this->__soapCall('cardStatusInquiry', array($parameters));
  }

  /**
   * Изменить значение лимита уровня карты.
        Change a card limit.
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
   * Изменить значение исключения лимита уровня карты.
        Change a card's limit exception.
   * 
   * @param changeCardLimitExceptionRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function changeCardLimitException(changeCardLimitExceptionRequestType $parameters)
  {
    return $this->__soapCall('changeCardLimitException', array($parameters));
  }

  /**
   * Изменить статус карты.
        Change a card status.
   * 
   * @param changeCardStatusRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function changeCardStatus(changeCardStatusRequestType $parameters)
  {
    return $this->__soapCall('changeCardStatus', array($parameters));
  }

  /**
   * Завершить предварительно-авторизованную транзакцию.
        Complete a pre-authorized transaction.
   * 
   * @param completionRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function completion(completionRequestType $parameters)
  {
    return $this->__soapCall('completion', array($parameters));
  }

  /**
   * Создать виртуальную карту.
        Create a virtual card.
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
   * Зачислить средства на карту.
        Credit a card (add funds to a card).
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
        Debit a card (remove funds from a card).
   * 
   * @param debitCardRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function debitCard(debitCardRequestType $parameters)
  {
    return $this->__soapCall('debitCard', array($parameters));
  }

  /**
   * Удалить лимит уровня карты.
        Delete a card limit.
   * 
   * @param deleteCardLimitRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function deleteCardLimit(deleteCardLimitRequestType $parameters)
  {
    return $this->__soapCall('deleteCardLimit', array($parameters));
  }

  /**
   * Удалить исключение лимита уровня карты.
        Delete a card's limit exception.
   * 
   * @param deleteCardLimitExceptionRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function deleteCardLimitException(deleteCardLimitExceptionRequestType $parameters)
  {
    return $this->__soapCall('deleteCardLimitException', array($parameters));
  }

  /**
   * Получить баланс карты.
        Get card balance.
   * 
   * @param getCardBalanceRequestType $parameters
   * @access public
   * @return getCardBalanceResponseType
   */
  public function getCardBalance(getCardBalanceRequestType $parameters)
  {
    return $this->__soapCall('getCardBalance', array($parameters));
  }

  /**
   * Получить информацию по карте.
        Get card parameters.
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
   * Получить лимиты уровня карты.
        Get card-level limits.
   * 
   * @param getCardLimitsRequestType $parameters
   * @access public
   * @return getCardLimitsResponseType
   */
  public function getCardLimits(getCardLimitsRequestType $parameters)
  {
    return $this->__soapCall('getCardLimits', array($parameters));
  }

  /**
   * Получить мини-выписку.
        Get a mini-statement.
   * 
   * @param miniStatementRequestType $parameters
   * @access public
   * @return miniStatementResponseType
   */
  public function miniStatement(miniStatementRequestType $parameters)
  {
    return $this->__soapCall('miniStatement', array($parameters));
  }

  /**
   * Получить транзакционную историю.
        Get a list of transactions.
   * 
   * @param getTransactionsRequestType $parameters
   * @access public
   * @return getTransactionsResponseType
   */
  public function getTransactions(getTransactionsRequestType $parameters)
  {
    return $this->__soapCall('getTransactions', array($parameters));
  }

  /**
   * Выполнить пополнение счета карты.
        Credit a card account.
   * 
   * @param p2pCreditRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function p2pCredit(p2pCreditRequestType $parameters)
  {
    return $this->__soapCall('p2pCredit', array($parameters));
  }

  /**
   * Выполнить снятие со счета карты.
        Debit a card account.
   * 
   * @param p2pDebitRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function p2pDebit(p2pDebitRequestType $parameters)
  {
    return $this->__soapCall('p2pDebit', array($parameters));
  }

  /**
   * Выполнить перевод между счетами двух карт.
        Transfer funds between two cards' accounts.
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
   * Выполнить предавторизацию транзакции.
        Pre-authorize a transaction.
   * 
   * @param preAuthorizationRequestType $parameters
   * @access public
   * @return financialTransactionResponseType
   */
  public function preAuthorization(preAuthorizationRequestType $parameters)
  {
    return $this->__soapCall('preAuthorization', array($parameters));
  }

  /**
   * Отменить операцию.
        Make a reversal.
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
        Execute some action with a service.
   * 
   * @param serviceActionRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function serviceAction(serviceActionRequestType $parameters)
  {
    return $this->__soapCall('serviceAction', array($parameters));
  }

  /**
   * Разблокировать карту.
        Validate a card.
   * 
   * @param validateCardRequestType $parameters
   * @access public
   * @return simpleResponseType
   */
  public function validateCard(validateCardRequestType $parameters)
  {
    return $this->__soapCall('validateCard', array($parameters));
  }

}
