<?php

namespace App\Core;

/**
 * Guest Middleware - Chỉ cho phép khi chưa đăng nhập (guest).
 * Nếu đã đăng nhập → redirect về trang chủ (hoặc intended).
 * Dùng cho trang login, register để tránh user đã login vào lại.
 */
class GuestMiddleware extends Middleware
{
    protected string $homeUrl = '/';

    public function handle(\Closure $next): void
    {
        if (!Auth::check()) {
            $next();
            return;
        }

        $url = defined('APP_URL') ? rtrim(APP_URL, '/') . $this->homeUrl : $this->homeUrl;
        header('Location: ' . $url);
        exit;
    }
}
