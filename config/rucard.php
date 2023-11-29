<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 13:33
 */

return [
    //'url' => "https://www.lt.rucard.ru/mobterm-gate-ws/aspx/main.aspx",
    'url' => env("RUCARD_SERVER_URL", "http://192.168.88.47/server.php"),
    //'callback_url' => "queue.test/api/v3/callback/rucard",
    //'callback_url' => "http://192.168.88.43:5000/api/v1/callback/queue",
    'path_certificat' => storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'certs' . DIRECTORY_SEPARATOR . 'rucard' . DIRECTORY_SEPARATOR . 'EskhataMobTermTest.pem',
    'path_certificat_key' => storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'certs' . DIRECTORY_SEPARATOR . 'rucard' . DIRECTORY_SEPARATOR . 'EskhataMobTermTestKey.key',
    'certificat_key_password' => 'test',
    'nterm_balance' => '123110',
    'nterm_payment' => '123112',
    'nterm_fill' => '123140',
    'nterm_card2card' => '123111',
];
