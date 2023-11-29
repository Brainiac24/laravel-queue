<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 13:33
 */

return [
    'server_url' => env('QUEUE_BUS_CFT_URL', 'http://10.10.2.53:9892/'),
    'server_transfers_lid_url' => env('QUEUE_BUS_SONIYA_LID_URL', 'http://10.10.2.53:9889/'),
    'server_transfers_soniya_url' => env('QUEUE_BUS_SONIYA_TRANSFER_URL', 'http://10.10.2.53:5556/'),
    //'callback_url' => env('QUEUE_ABS_CALLBACK_URL', '192.168.88.42:5000/api/v1/callback/abs##'),
    'callback_url' => env('QUEUE_ABS_CALLBACK_URL', '192.168.88.47:8070/api/v1/callback/abs##'),
    'protocol_version' => '1.7',
    'callback_self_url' => "192.168.88.47/laravel-queue/public/api/v1/callback/asp",
];