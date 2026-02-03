<?php

/**
 * Cấu hình ứng dụng - MVC
 */

defined('BASE_PATH') || define('BASE_PATH', dirname(__DIR__));

$config = [
    'name'   => 'Booking Hotel',
    'url'    => 'http://localhost/Booking%20Hotel/Public',
    'debug'  => true,
    'locale' => 'vi',
];

// Định nghĩa constants từ config
defined('APP_NAME') || define('APP_NAME', $config['name']);
defined('APP_URL') || define('APP_URL', $config['url']);
defined('APP_DEBUG') || define('APP_DEBUG', $config['debug']);
defined('APP_LOCALE') || define('APP_LOCALE', $config['locale']);

return $config;
