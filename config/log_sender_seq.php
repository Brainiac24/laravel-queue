<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 16:42
 */

return [
    'active' => env('LOG_SENDER_SEQ_ACTIVE', true),
    'url' => env('LOG_SENDER_SEQ_URL', 'localhost:5341/api/events/raw'),
    'api_key' => env('LOG_SENDER_SEQ_APP_KEY', '12345')
];