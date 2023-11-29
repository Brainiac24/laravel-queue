<?php

namespace App\Services\Common\Gateway\BpcMtm;


class BpcMtmStatus
{
    const OK = '00';
    const CALL_ISSUER = '01';
    const INVALID_MERCHANT_ID = '03';
    const INVALID_CARD = '04';
    const DO_NOT_HONOR_TRANSACTION = '05';
    const APPROVE_WITH_IDENTIFICATION = '08';
    const INVALID_TRANSACTION_RETRY  = '12';
    const CANNOT_PROCESS_AMOUNT = '13';
    const INVALID_ACCOUNT_RETRY = '14';
    const CARD_IS_ALREADY_ACTIVE = '15';
    const MESSAGE_RECEIVED_WAS_NOT_STANDARDS = '30';
    const ISSUER_INOPERATIVE = '31';
    //CAPTURE_CARD
    const CARD_EXPIRED = '33';
    const ACCOUNT_RESTRICTED = '36';
    const CALL_SECURITY = '37';
    const LOST_CARD = '41';
    const STOLEN_CARD = '43';

    const INSUFFICIENT_FUNDS_RETRY = '51';
    const INCORRECT_PIN = '55';
    const TRANSACTION_NOT_PERMITTED = '57';
    const NEGATIVE_AUTH_USAGE_CYCLE_LIMIT_EXCEEDED = '61';
    const BAD_CARD = '62';
    const LIMIT_REACHED_FOR_TOTAL_NUMBER_TRANSACTION_IN_CYCLE = '65';
    const TIMER_TIME_OUT = '68';
    const EXCESSIVE_PIN_FAILURES = '75';
    const WRONG_PIN = '76';
    const CARD_HAS_NOT_ANY_ACCOUNTS = '77';
    const ORIGINAL_TRANSACTION_COULD_NOT_BE_FOUND = '78';
    const RESPONSE_STATUS_UNKNOWN = '90';
    const SERVICE_NOT_AVAILABLE = '91';
    const INVALID_PAYMENT_PARAMETER = '92';
    const SERVICE_BLOCKED = '93';
    const DUPLICATE_TRANSMISSION = '94';

    //This can mean several things i.e. did not receive a tx amount being reversed greater than orig.
    const DID_NOT_RECEIVE_A_TX_AMOUNT_GREATER_THAN_ORIG = '95';

    const ERROR = '96';
    const SERVICE_NOT_ALLOWED_FOR_CLIENT = '97';
    const INVALID_INSURANCE_NUMBER = '98';
    const SERVICE_IS_ALREADY_BINDED = 'A1';
    const SERVICE_IS_NOT_BINDED = 'A2';
    const INVALID_SERVICE_DATA = 'A3';
    const MAC_ERROR = 'A4';
    const DEBTS_ABSENCE = 'A5';
    const INVALID_PAYMENT_DATA = 'A6';
    const ADDITIONAL_INFORMATION_REQUIRED = 'A7';
    const NO_SUCH_OBJECT_IN_SYSTEM = 'A8';
    const OBJECT_IS_NOT_CREATED_IN_SYSTEM = 'A9';
    const OBJECT_IS_ALREADY_CREATED_IN_SYSTEM = 'AA';
    const INVALID_CVV2 = 'AB';
    const INVALID_PASSWORD = 'AC';
    const CARD_IS_RESTRICTED = 'AD';

    const DUPLICATED_TRANSACTION = '1008';
    const TRANSACTION_SUCCESS_RESPONSE_CODE = '-1';

}