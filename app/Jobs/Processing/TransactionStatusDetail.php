<?php

namespace App\Jobs\Processing;

class TransactionStatusDetail
{
    const OK = '514368cf-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_PS = '73c76b7b-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_AUTH = '767d48d5-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_UNKNOWN = '7908cef3-867b-11e8-90c7-b06ebfbfa715';
    const ACCOUNT_EXIST = '7bcca9d9-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_ACCOUNT_NOT_EXIST = '7f259e66-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_DUPLICATION = 'c087f54e-a9e8-11e8-904b-b06ebfbfa715';
    const ERROR_NOT_FOUND = '8cea0090-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_DIALER_NOT_FOUND = '918865f2-867b-11e8-90c7-b06ebfbfa715';
    const SHORTAGE_OF_FUNDS = 'a1df8292-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_CAN_NOT_CANCEL =  'a60f63e2-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_AMOUNT_IS_LESS =  'a857a9b8-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_AMOUNT_IS_GREATER =  'aa4c9db6-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_AMOUNT =  'b57f0ff1-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_ACCESS_DENIED_IP =  'b8addc0e-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_ACCOUNT_FORMAT =  'bb5ffa16-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_DAILY_LIMIT_EXCEEDED =  'be4fca6f-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_WEEKLY_LIMIT_EXCEEDED =  'c05e57fb-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_MONTHLY_LIMIT_EXCEEDED =  'c29858f6-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_WALLET_LIMIT_EXCEEDED =  'c57d8185-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_PROVIDER_TEMPORARILY_UNAVAILABLE =  'c797c063-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_REQUEST =  'c9afb9be-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_CURRENCY_IS_INCORRECT =  'cc39cdb7-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_LIMIT_IS_EXCEEDED =  'ce5bd6b4-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_ACCEPTED_IS_FORBIDDEN =  'd0d6e8bb-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_ACCOUNT_IS_NOT_ACTIVE =  'd313baf6-867b-11e8-90c7-b06ebfbfa715';
    const IN_PROCESSING =  'd5a98cb2-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_NOT_ACCEPTED =  'd82f69ca-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_CONTACT_YOUR_EMITENT =  'da5b1055-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_DIALER_UNAVAILABLE =  'dc6de87a-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_CARD_EXPIRED =  'de596e2c-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_TRANSACTION_IS_PROHIBITED_FOR_CARD =  'e048ad22-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_TRANSACTION_IS_NOT_AVAILABLE_FOR_TERMINAL =  'e419b7b7-867b-11e8-90c7-b06ebfbfa715';
    const TRANSACTION_ALREADY_CANCELED =  'e63f8ec7-867b-11e8-90c7-b06ebfbfa715';
    const ERROR_CARD_TEMPORARILY_BLOCKED =  'e93f7d66-867b-11e8-90c7-b06ebfbfa715';
}