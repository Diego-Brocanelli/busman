<?php

return [

    /*
    |--------------------------------------------------------------------------------
    | ElasticSearch config
    |--------------------------------------------------------------------------------
    |
    |
    */
    'routes' => [
        'prefix' => 'api',
        'global_search_url' => 'g-search'
    ],

    'config' => [
        'host' => env('ES_HOST', 'localhost'),
        'port' => env('ES_PORT', '9200'),
        'scheme' => env('ES_SCHEME', 'http'),
        'user' => env('ES_USER', 'user'),
        'pass' => env('ES_PASS', 'pass')
    ],

    'indexable' => [
        \Busman\Jobs\Models\Job::class,
        \Busman\Jobs\Models\Epic::class,
        \Busman\Jobs\Models\JobMaterial::class,
        \Busman\Jobs\Models\Task::class,
        \Busman\Jobs\Models\Ticket::class,

        \Busman\People\Models\Customer::class,
        \Busman\People\Models\Employee::class,

        \Busman\Warehouse\Models\Lease::class,
        \Busman\Warehouse\Models\Material::class,
        \Busman\Warehouse\Models\Tool::class,
    ]
];
