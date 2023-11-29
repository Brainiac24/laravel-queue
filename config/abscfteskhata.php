<?php
/**
 * Created by PhpStorm.
 * User: F_Kosimov
 * Date: 04.07.2018
 * Time: 13:33
 */

return [
    'server_url' => env('QUEUE_ABS_CFT_URL', 'http://10.10.2.53:9899'),
    'currencies'=>[
        'USD'=>['code_iso'=>'840','cur_iso'=>'USD'],
        'RUB'=>['code_iso'=>'643','cur_iso'=>'RUB'],
        'EUR'=>['code_iso'=>'978','cur_iso'=>'EUR'],
        'TJS'=>['code_iso'=>'972','cur_iso'=>'TJS'],
        'default'=>['code_iso'=>'840','cur_iso'=>'USD']
    ],
    'type_rate'=>['Eskhata'=>'esh','National Bank'=>'nbt'],
    'type_rate_default'=>'Eskhata',
    'server_method' => 'GET',
];