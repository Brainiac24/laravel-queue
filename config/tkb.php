<?php

return [
    'url' => env('TKB_URL', 'https://paytest.online.tkbbank.ru'),
    'login' => env('TKB_LOGIN', 'T1966100966ID'),
    'key' =>  env('TKB_KEY', 'FreZEpHXCH00Vshrf5RmgXGto8QeJhXCmYDhuNDGjCpHqvNz1jr1eLoRUVMFJCpuUxO5Ya6BCkbOH8c2vrny04yLLVxHa67Qn4X2QRL1nZz3KKiVSTkrq0CY8dvcMyAEnuANmimNQvmbFEbaMMYrVQAwB72NwHpXy4QpiFKJGGL3OBtEbuzaJiSF2eknqJrhfxMLXW1gcpUpfFR8PyMbipppmjweuwt7qCXrYSQpCs6tyDAwwkG06p80ixyOzWWP'),
    'bind_card_url' => '/api/v1/card/unregistered/bind',
    'get_order_state_url' => '/api/v1/order/state',
    'pay_from_registered_card_url' => '/api/v1/card/registered/debit',
    'fill_registered_card_url' => '/api/v1/card/registered/credit',
];