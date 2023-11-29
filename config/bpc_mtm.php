<?php

return [
    'url' => env("BPC_MTM_SERVER_URL"),
    "connection_timeout" => 50,
    'pay_from_card' => [
        "login" => env("BPC_MTM_PAY_FROM_CARD_LOGIN"),
        "password" => env("BPC_MTM_PAY_FROM_CARD_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'fill_card' => [
        "login" => env("BPC_MTM_FILL_CARD_LOGIN"),
        "password" => env("BPC_MTM_FILL_CARD_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'card_2_card' => [
        "login" => env("BPC_MTM_CARD_2_CARD_LOGIN"),
        "password" => env("BPC_MTM_CARD_2_CARD_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'get_transactions' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'get_card_data' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'get_transaction_status' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'get_transaction_details' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'unlock_card' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'lock_card' => [
        "login" => env("BPC_MTM_GET_CARD_DATA_LOGIN"),
        "password" => env("BPC_MTM_GET_CARD_DATA_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
    'reversal' => [
        "login" => env("BPC_MTM_PAY_FROM_CARD_LOGIN"),
        "password" => env("BPC_MTM_PAY_FROM_CARD_PASSWORD"),
        "token" => env("BPC_MTM_USERNAME_TOKEN"),
    ],
];