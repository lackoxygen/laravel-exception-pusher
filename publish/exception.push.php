<?php

use Lackoxygen\ExceptionPush\Agents\Ding;
use Lackoxygen\ExceptionPush\Agents\Wx;

return [
    'agents' => [
        Wx::class => [
            'key' => '',
            'enable' => false
        ], Ding::class => [
            'token' => '',
            'secret' => '',
            'enable' => false
        ]
    ],

    'client' => [
        'timeout' => 5.00,
    ],

    'callbacks' => [
        'formatter' => null,
        'dispatcher' => '\Lackoxygen\ExceptionPush\Job\ExceptionPushJob::push'
    ]
];
