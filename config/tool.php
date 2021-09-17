<?php

return [
    'navigation' => [
        'top' => [
            '<i class="fas fa-network-wired fa-fw"></i> Hosts'  => 'hosts.index',
            '<i class="fas fa-plus-square fa-fw"></i> New Host' => 'hosts.create',
            '<i class="fas fa-magic fa-fw"></i> Create App'     => 'apps.create',
            '<i class="fab fa-php fa-fw"></i> PHP Versions'     => 'php.index',
        ],
    ],
    'options' => [
        'show-php-folder' => env('TOOL_SHOW_PHP_FOLDER', false),
    ],
    'paths' => [
        'xampp-path'        => env('XAMPP_PATH'),
        'httpd-xampp-conf'  => env('HTTPD_XAMPP_CONF_FILE'),
        'httpd-vhosts-conf' => env('HTTPD_VHOSTS_CONF_FILE'),
        'hosts'             => env('HOSTS_FILE'),
    ],
    'installers' => [
        'composer-command' => env('COMPOSER_COMMAND', 'composer'),
        'default-locale'   => env('INSTALLER_DEFAULT_LOCALE', 'en'),
        'default-timezone' => env('INSTALLER_DEFAULT_TIMEZONE', 'UTC'),
    ],
];
