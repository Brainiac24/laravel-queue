<?php

return [

    //'callback_url' => "http://192.168.88.47:8070/api/v1/callback/abs",
    'callback_url' => env("QUEUE_CALLBACK_ASPCORE_APP_URL","http://192.168.88.29:5002/api/v1/callback/queue")

];