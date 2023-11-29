<?php

namespace App\Services\Common\Gateway\Rucard\Helpers;


class RucardStatus
{
    const OK = '00';
    const ERROR_REFUSAL_CONTACT_YOUR_EMITENT = '01';
    const ERROR_REFUSAL_CONTACT_YOUR_EMITENT2 = '02';
    const ERROR_AMOUNT_IS_INCORRECT = '13';
    const ERROR_CARD_NOT_FOUND = '14';
    const ERROR_EMITENT_NOT_FOUND = '15';
    const ERROR_TRANSACTION_ORIG_NOT_FOUND = '21';
    const ERROR_ACCOUNT_NOT_FOUND25 = '25';
    const DUPLICATE_OPERATION = '26';
    const ERROR_OPERATION_UNAVAILABLE = '28';
    const ERROR_EMITENT_IS_DISABLED = '31';
    const ERROR_ACCOUNT_NOT_FOUND42 = '42';
    const ERROR_NO_ACCOUNT = '44';
    const ERROR_SHORTAGE_OF_FUNDS = '51';
    const ERROR_NO_ACCOUNT_CHECKING = '52';
    const ERROR_CARD_EXPIRED = '54';
    const ERROR_PIN = '55';
    const ERROR_CARD_UNKNOWN = '56';
    const ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD = '57';
    const ERROR_TRANSACTION_IS_NOT_AVAILABLE_FOR_TERMINAL = '58';
    const ERROR_TIMEOUT = '68';
    const ERROR_TRANSACTION_ORIG_NOT_FOUND2 = '76';
    const ERROR_WRONG_ACCOUNT_NUMBER = '78';
    const TRANSACTION_ALREADY_CANCELED = '79';
    const ERROR_CARD_TEMPORARILY_BLOCKED = '80';
    const ERROR_EMITENT_UNAVAILABLE = '92';
    const DUPLICATE_TRANSACTION = '94';
    const ERROR_UNKNOWN = '99';
}