<?php

namespace App\Services\Common\Helpers;

use App\Jobs\Processing\TransactionStatusDetail;
use App\Services\Common\Gateway\BpcMtm\BpcMtmStatus;
use App\Services\Common\Gateway\BpcVisa\BpcVisaStatus;
use App\Services\Common\Gateway\Rucard\Helpers\RucardStatus;

class TransactionStatusMaps
{
    static $rucard = [
        RucardStatus::OK => TransactionStatusDetail::OK,
        RucardStatus::ERROR_REFUSAL_CONTACT_YOUR_EMITENT => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        RucardStatus::ERROR_REFUSAL_CONTACT_YOUR_EMITENT2 => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        RucardStatus::ERROR_AMOUNT_IS_INCORRECT => TransactionStatusDetail::ERROR_AMOUNT,
        RucardStatus::ERROR_CARD_NOT_FOUND => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_PIN => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_EMITENT_NOT_FOUND => TransactionStatusDetail::ERROR_DIALER_NOT_FOUND,
        RucardStatus::ERROR_TRANSACTION_ORIG_NOT_FOUND => TransactionStatusDetail::ERROR_NOT_FOUND,
        RucardStatus::ERROR_ACCOUNT_NOT_FOUND25 => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::DUPLICATE_OPERATION => TransactionStatusDetail::ERROR_DUPLICATION,
        RucardStatus::ERROR_OPERATION_UNAVAILABLE => TransactionStatusDetail::ERROR_PROVIDER_TEMPORARILY_UNAVAILABLE,
        RucardStatus::ERROR_EMITENT_IS_DISABLED => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        RucardStatus::ERROR_ACCOUNT_NOT_FOUND42 => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_NO_ACCOUNT => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_SHORTAGE_OF_FUNDS => TransactionStatusDetail::SHORTAGE_OF_FUNDS,
        RucardStatus::ERROR_NO_ACCOUNT_CHECKING => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_CARD_EXPIRED => TransactionStatusDetail::ERROR_CARD_EXPIRED,
        RucardStatus::ERROR_CARD_UNKNOWN => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        RucardStatus::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,
        RucardStatus::ERROR_TRANSACTION_IS_NOT_AVAILABLE_FOR_TERMINAL => TransactionStatusDetail::ERROR_TRANSACTION_IS_NOT_AVAILABLE_FOR_TERMINAL,
        RucardStatus::ERROR_TRANSACTION_ORIG_NOT_FOUND2 => TransactionStatusDetail::ERROR_NOT_FOUND,
        RucardStatus::ERROR_WRONG_ACCOUNT_NUMBER => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT,
        RucardStatus::TRANSACTION_ALREADY_CANCELED => TransactionStatusDetail::TRANSACTION_ALREADY_CANCELED,
        RucardStatus::ERROR_CARD_TEMPORARILY_BLOCKED => TransactionStatusDetail::ERROR_CARD_TEMPORARILY_BLOCKED,
        RucardStatus::ERROR_EMITENT_UNAVAILABLE => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        RucardStatus::DUPLICATE_TRANSACTION => TransactionStatusDetail::ERROR_DUPLICATION,
    ];

    static $bpcMtm = [
        BpcMtmStatus::OK => TransactionStatusDetail::OK,
        BpcMtmStatus::CALL_ISSUER => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        BpcMtmStatus::INVALID_MERCHANT_ID => TransactionStatusDetail::ERROR_DIALER_NOT_FOUND,
        BpcMtmStatus::INVALID_CARD => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        BpcMtmStatus::DO_NOT_HONOR_TRANSACTION => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::APPROVE_WITH_IDENTIFICATION => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::INVALID_TRANSACTION_RETRY => TransactionStatusDetail::ERROR_NOT_ACCEPTED,
        BpcMtmStatus::CANNOT_PROCESS_AMOUNT => TransactionStatusDetail::ERROR_AMOUNT,
        BpcMtmStatus::INVALID_ACCOUNT_RETRY => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT,
        BpcMtmStatus::CARD_IS_ALREADY_ACTIVE => TransactionStatusDetail::ACCOUNT_EXIST,
        BpcMtmStatus::MESSAGE_RECEIVED_WAS_NOT_STANDARDS => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::ISSUER_INOPERATIVE => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        BpcMtmStatus::CARD_EXPIRED => TransactionStatusDetail::ERROR_CARD_EXPIRED,
        BpcMtmStatus::ACCOUNT_RESTRICTED => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,
        BpcMtmStatus::CALL_SECURITY => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        BpcMtmStatus::LOST_CARD => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcMtmStatus::STOLEN_CARD => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcMtmStatus::INSUFFICIENT_FUNDS_RETRY => TransactionStatusDetail::ERROR_AMOUNT,
        BpcMtmStatus::INCORRECT_PIN => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::TRANSACTION_NOT_PERMITTED => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,
        BpcMtmStatus::NEGATIVE_AUTH_USAGE_CYCLE_LIMIT_EXCEEDED => TransactionStatusDetail::ERROR_LIMIT_IS_EXCEEDED,
        BpcMtmStatus::BAD_CARD => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT,
        BpcMtmStatus::LIMIT_REACHED_FOR_TOTAL_NUMBER_TRANSACTION_IN_CYCLE => TransactionStatusDetail::ERROR_LIMIT_IS_EXCEEDED,
        BpcMtmStatus::TIMER_TIME_OUT => TransactionStatusDetail::ERROR_NOT_ACCEPTED,
        BpcMtmStatus::EXCESSIVE_PIN_FAILURES => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::WRONG_PIN => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::CARD_HAS_NOT_ANY_ACCOUNTS => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        BpcMtmStatus::ORIGINAL_TRANSACTION_COULD_NOT_BE_FOUND => TransactionStatusDetail::ERROR_NOT_FOUND,
        BpcMtmStatus::RESPONSE_STATUS_UNKNOWN => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::SERVICE_NOT_AVAILABLE => TransactionStatusDetail::ERROR_PROVIDER_TEMPORARILY_UNAVAILABLE,
        BpcMtmStatus::INVALID_PAYMENT_PARAMETER => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::SERVICE_BLOCKED => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        BpcMtmStatus::DUPLICATE_TRANSMISSION => TransactionStatusDetail::ERROR_DUPLICATION,
        BpcMtmStatus::DID_NOT_RECEIVE_A_TX_AMOUNT_GREATER_THAN_ORIG => TransactionStatusDetail::ERROR_AMOUNT_IS_GREATER,
        BpcMtmStatus::ERROR => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::SERVICE_NOT_ALLOWED_FOR_CLIENT => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcMtmStatus::INVALID_INSURANCE_NUMBER => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::SERVICE_IS_ALREADY_BINDED => TransactionStatusDetail::ERROR_DUPLICATION,
        BpcMtmStatus::SERVICE_IS_NOT_BINDED => TransactionStatusDetail::ERROR_NOT_FOUND,
        BpcMtmStatus::INVALID_SERVICE_DATA => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::MAC_ERROR => TransactionStatusDetail::ERROR_ACCESS_DENIED_IP,
        BpcMtmStatus::DEBTS_ABSENCE => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::INVALID_PAYMENT_DATA => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::ADDITIONAL_INFORMATION_REQUIRED => TransactionStatusDetail::ERROR_REQUEST,
        BpcMtmStatus::NO_SUCH_OBJECT_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::OBJECT_IS_NOT_CREATED_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::OBJECT_IS_ALREADY_CREATED_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcMtmStatus::INVALID_CVV2 => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::INVALID_PASSWORD => TransactionStatusDetail::ERROR_AUTH,
        BpcMtmStatus::CARD_IS_RESTRICTED => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,

    ];

    static $bpcVisa = [
        BpcVisaStatus::OK => TransactionStatusDetail::OK,
        BpcVisaStatus::CALL_ISSUER => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        BpcVisaStatus::INVALID_MERCHANT_ID => TransactionStatusDetail::ERROR_DIALER_NOT_FOUND,
        BpcVisaStatus::INVALID_CARD => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        BpcVisaStatus::DO_NOT_HONOR_TRANSACTION => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::APPROVE_WITH_IDENTIFICATION => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::INVALID_TRANSACTION_RETRY => TransactionStatusDetail::ERROR_NOT_ACCEPTED,
        BpcVisaStatus::CANNOT_PROCESS_AMOUNT => TransactionStatusDetail::ERROR_AMOUNT,
        BpcVisaStatus::INVALID_ACCOUNT_RETRY => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT,
        BpcVisaStatus::CARD_IS_ALREADY_ACTIVE => TransactionStatusDetail::ACCOUNT_EXIST,
        BpcVisaStatus::MESSAGE_RECEIVED_WAS_NOT_STANDARDS => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::ISSUER_INOPERATIVE => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        BpcVisaStatus::CARD_EXPIRED => TransactionStatusDetail::ERROR_CARD_EXPIRED,
        BpcVisaStatus::ACCOUNT_RESTRICTED => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,
        BpcVisaStatus::CALL_SECURITY => TransactionStatusDetail::ERROR_CONTACT_YOUR_EMITENT,
        BpcVisaStatus::LOST_CARD => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcVisaStatus::STOLEN_CARD => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcVisaStatus::INSUFFICIENT_FUNDS_RETRY => TransactionStatusDetail::ERROR_AMOUNT,
        BpcVisaStatus::INCORRECT_PIN => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::TRANSACTION_NOT_PERMITTED => TransactionStatusDetail::ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD,
        BpcVisaStatus::NEGATIVE_AUTH_USAGE_CYCLE_LIMIT_EXCEEDED => TransactionStatusDetail::ERROR_LIMIT_IS_EXCEEDED,
        BpcVisaStatus::BAD_CARD => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT,
        BpcVisaStatus::LIMIT_REACHED_FOR_TOTAL_NUMBER_TRANSACTION_IN_CYCLE => TransactionStatusDetail::ERROR_LIMIT_IS_EXCEEDED,
        BpcVisaStatus::TIMER_TIME_OUT => TransactionStatusDetail::ERROR_NOT_ACCEPTED,
        BpcVisaStatus::EXCESSIVE_PIN_FAILURES => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::WRONG_PIN => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::CARD_HAS_NOT_ANY_ACCOUNTS => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST,
        BpcVisaStatus::ORIGINAL_TRANSACTION_COULD_NOT_BE_FOUND => TransactionStatusDetail::ERROR_NOT_FOUND,
        BpcVisaStatus::CVV_CVC_PROCESSING_ERROR => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::INVALID_CVV_CVC => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::RESPONSE_STATUS_UNKNOWN => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::SERVICE_NOT_AVAILABLE => TransactionStatusDetail::ERROR_PROVIDER_TEMPORARILY_UNAVAILABLE,
        BpcVisaStatus::INVALID_PAYMENT_PARAMETER => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::SERVICE_BLOCKED => TransactionStatusDetail::ERROR_DIALER_UNAVAILABLE,
        BpcVisaStatus::DUPLICATE_TRANSMISSION => TransactionStatusDetail::ERROR_DUPLICATION,
        BpcVisaStatus::DID_NOT_RECEIVE_A_TX_AMOUNT_GREATER_THAN_ORIG => TransactionStatusDetail::ERROR_AMOUNT_IS_GREATER,
        BpcVisaStatus::ERROR => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::SERVICE_NOT_ALLOWED_FOR_CLIENT => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN,
        BpcVisaStatus::INVALID_INSURANCE_NUMBER => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::SERVICE_IS_ALREADY_BINDED => TransactionStatusDetail::ERROR_DUPLICATION,
        BpcVisaStatus::SERVICE_IS_NOT_BINDED => TransactionStatusDetail::ERROR_NOT_FOUND,
        BpcVisaStatus::INVALID_SERVICE_DATA => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::MAC_ERROR => TransactionStatusDetail::ERROR_ACCESS_DENIED_IP,
        BpcVisaStatus::DEBTS_ABSENCE => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::INVALID_PAYMENT_DATA => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::ADDITIONAL_INFORMATION_REQUIRED => TransactionStatusDetail::ERROR_REQUEST,
        BpcVisaStatus::NO_SUCH_OBJECT_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::OBJECT_IS_NOT_CREATED_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::OBJECT_IS_ALREADY_CREATED_IN_SYSTEM => TransactionStatusDetail::ERROR_UNKNOWN,
        BpcVisaStatus::INVALID_CVV2 => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::CVV2_CVC2_PROCESSING_ERROR => TransactionStatusDetail::ERROR_AUTH,
        BpcVisaStatus::INCORRECT_PARAMETERS_REENTER_REQUIRED => TransactionStatusDetail::ERROR_REQUEST,
    ];

}