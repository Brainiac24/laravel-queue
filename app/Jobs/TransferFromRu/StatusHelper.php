<?php

namespace App\Jobs\TransferFromRu;

class StatusHelper
{
    const OK = "0";
    const TEMPORARY_ERROR_RETRY = "1";
    const VALIDATION_ERROR = "2";
    const RECEIVER_NOT_FOUND = "3";
    const RECEIVER_WRONG_ID = "4";
    const RECEIVER_ACCOUNT_NOT_ACTIVE = "5";
    const VALIDATION_WRONG_PAY_ID = "6";
    const TECHNICAL_TRANSFER_ERROR = "7";
    const DUPLICATE_TRANSACTION = "8";
    const VALIDATION_AMOUNT_ERROR = "9";
    const VALIDATION_MIN_LIMIT_ERROR = "10";
    const VALIDATION_MAX_LIMIT_ERROR = "11";
    const VALIDATION_PAY_DATE_ERROR = "12";
    const CURRENCY_RATE_ERROR = "13";
    const UNKNOWN_ERROR = "300";





}