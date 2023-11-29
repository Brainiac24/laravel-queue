<?php

return [
    'url' => env("BPC_VISA_SERVER_URL"),
    "connection_timeout" => 50,
    'pay_from_card' => [
        "login" => env("BPC_VISA_PAY_FROM_CARD_LOGIN"),
        "password" => env("BPC_VISA_PAY_FROM_CARD_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'fill_card' => [
        "login" => env("BPC_VISA_FILL_CARD_LOGIN"),
        "password" => env("BPC_VISA_FILL_CARD_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'card_2_card' => [
        "login" => env("BPC_VISA_CARD_2_CARD_LOGIN"),
        "password" => env("BPC_VISA_CARD_2_CARD_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'get_transactions' => [
        "login" => env("BPC_VISA_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_VISA_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'get_card_balance' => [
        "login" => env("BPC_VISA_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_VISA_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'get_card_data' => [
        "login" => env("BPC_VISA_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_VISA_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'change_card_status' => [
        "login" => env("BPC_VISA_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_VISA_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'validate_card' => [
        "login" => env("BPC_VISA_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_VISA_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ],
    'reversal' => [
        "login" => env("BPC_VISA_PAY_FROM_CARD_LOGIN"),
        "password" => env("BPC_VISA_PAY_FROM_CARD_PASSWORD"),
        "token" => env("BPC_VISA_USERNAME_TOKEN")
    ]
];