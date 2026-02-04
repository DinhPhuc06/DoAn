<?php

namespace App\Core;

/**
 * Admin Middleware - Chỉ cho phép admin (session admin_user).
 * Chặn: guest và user frontend (session user) truy cập URL admin.
 * Đảm bảo user thường không truy cập được admin.php.
 */
class AdminMiddleware extends Middleware
{
    protected string $adminLoginUrl = '/admin.php';

    public function handle(\Closure $next): void
    {
        if (Auth::adminCheck()) {
            $next();
            return;
        }

        // User frontend (đã đăng nhập nhưng không phải admin): chặn, redirect về trang chủ
        if (Auth::check()) {
            $home = defined('APP_URL') ? rtrim(APP_URL, '/') . '/' : '/';
            header('Location: ' . $home);
            exit;
        }

        // Guest: redirect về trang đăng nhập admin
        $base = $this->getBaseUrl();
        header('Location: ' . $base . $this->adminLoginUrl);
        exit;
    }

    protected function getBaseUrl(): string
    {
        if (defined('APP_URL')) {
            return rtrim(APP_URL, '/') . '/';
        }
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        return dirname($script) . '/';
    }
}
