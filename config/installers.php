<?php

return [
    'norman-huth/laravel' => [
        'installer' => \App\Jobs\AppInstaller\Laravel::class,
        'parameter' => 'norman-huth/laravel',
    ],
    'norman-huth/laravel-nova' => [
        'installer' => \App\Jobs\AppInstaller\Laravel::class,
        'parameter' => 'norman-huth/laravel-nova',
    ],
    'norman-huth/inertia-laravel' => [
        'installer' => \App\Jobs\AppInstaller\Laravel::class,
        'parameter' => 'norman-huth/inertia-laravel',
    ],
    'norman-huth/inertia-laravel-nova' => [
        'installer' => \App\Jobs\AppInstaller\Laravel::class,
        'parameter' => 'norman-huth/inertia-laravel-nova',
    ],
    'Laravel' => [
        'installer' => \App\Jobs\AppInstaller\Laravel::class,
        'parameter' => 'laravel/laravel',
    ],
];
