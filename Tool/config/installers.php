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
//    'unzip-example' => [
//        'installer' => \NormanHuth\VHostTool\Jobs\Unzip::class,
//        'file'      => storage_path('archives/my-project.zip'),
//    ],
//    'WordPress' => [
//        'installer' => \NormanHuth\VHostTool\Jobs\WordPress::class,
//        'file'      => storage_path('archives/wordpress.zip'),
//    ],
];
