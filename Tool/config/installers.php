<?php

return [
    'norman-huth/laravel' => [
        'installer' => \NormanHuth\VHostTool\Jobs\Laravel::class,
        'parameter' => 'norman-huth/laravel',
    ],
    'norman-huth/laravel-nova' => [
        'installer' => \NormanHuth\VHostTool\Jobs\Laravel::class,
        'parameter' => 'norman-huth/laravel-nova',
    ],
    'norman-huth/inertia-laravel' => [
        'installer' => \NormanHuth\VHostTool\Jobs\Laravel::class,
        'parameter' => 'norman-huth/inertia-laravel',
    ],
    'norman-huth/inertia-laravel-nova' => [
        'installer' => \NormanHuth\VHostTool\Jobs\Laravel::class,
        'parameter' => 'norman-huth/inertia-laravel-nova',
    ],
    'Laravel' => [
        'installer' => \NormanHuth\VHostTool\Jobs\Laravel::class,
        'parameter' => 'laravel/laravel',
    ],
];
