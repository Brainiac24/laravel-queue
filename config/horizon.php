<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Horizon will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'prefix' => env('HORIZON_PREFIX', 'horizon:'),

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Time Thresholds
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure when the LongWaitDetected event
    | will be fired. Every connection / queue combination may have its
    | own, unique threshold (in seconds) before this event is fired.
    |
    */

    'waits' => [
        'redis:default' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Trimming Times
    |--------------------------------------------------------------------------
    |
    | Here you can configure for how long (in minutes) you desire Horizon to
    | persist the recent and failed jobs. Typically, recent jobs are kept
    | for one hour while all failed jobs are stored for an entire week.
    |
    */

    'trim' => [
        'recent' => 5760,
        'failed' => 14400,
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the queue worker settings used by your application
    | in all environments. These supervisors and settings handle all your
    | queued jobs and will be provisioned by Horizon during deployment.
    |
    */

    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default1'],
                'balance' => 'simple',
                'processes' => 1,
                'tries' => 3,
            ],
            'supervisor-2' => [
                'connection' => 'redis',
                'queue' => ['processing'],
                'balance' => 'simple',
                'processes' => 100,
                'tries' => 3,
            ],
            'supervisor-3' => [
                'connection' => 'redis',
                'queue' => ['notification'],
                'balance' => 'simple',
                'processes' => 80,
                'tries' => 3,
            ],
            'supervisor-4' => [
                'connection' => 'redis',
                'queue' => ['request'],
                'balance' => 'simple',
                'processes' => 100,
                'tries' => 3,
            ],
            'supervisor-5' => [
                'connection' => 'redis',
                'queue' => ['send_status_to_callback'],
                'balance' => 'auto',
                'processes' => 70,
                'tries' => 3,
            ],
            'supervisor-6' => [
                'connection' => 'redis',
                'queue' => ['sync'],
                'balance' => 'simple',
                'processes' => 40,
                'tries' => 3,
            ],
        ],

        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'processes' => 5,
                'tries' => 3,
            ],
            'supervisor-2' => [
                'connection' => 'redis',
                'queue' => ['processing'],
                'balance' => 'simple',
                'processes' => 10,
                'tries' => 3,
            ],
            'supervisor-3' => [
                'connection' => 'redis',
                'queue' => ['notification'],
                'balance' => 'simple',
                'processes' => 3,
                'tries' => 3,
            ],
            'supervisor-4' => [
                'connection' => 'redis',
                'queue' => ['request'],
                'balance' => 'simple',
                'processes' => 5,
                'tries' => 3,
            ],
            'supervisor-5' => [
                'connection' => 'redis',
                'queue' => ['send_status_to_callback'],
                'balance' => 'auto',
                'processes' => 5,
                'tries' => 3,
            ],
            'supervisor-6' => [
                'connection' => 'redis',
                'queue' => ['sync'],
                'balance' => 'simple',
                'processes' => 5,
                'tries' => 3,
            ],

        ],
    ],
];
