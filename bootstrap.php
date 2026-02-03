<?php

/**
 * Bootstrap - Load cấu hình và autoload cho MVC
 * Gọi từ Public/index.php và Public/admin.php
 */

defined('BASE_PATH') || define('BASE_PATH', __DIR__);

// Autoload class theo namespace App\
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR;

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

// Load config và set error handler
require BASE_PATH . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'app.php';

// Set error handler
set_exception_handler(function (\Throwable $e) {
    \App\Core\ErrorHandler::handleException($e);
});

// Set error reporting dựa trên APP_DEBUG
error_reporting(defined('APP_DEBUG') && APP_DEBUG ? E_ALL : 0);
ini_set('display_errors', defined('APP_DEBUG') && APP_DEBUG ? '1' : '0');
