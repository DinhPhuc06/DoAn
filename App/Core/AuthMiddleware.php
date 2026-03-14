<?php

namespace App\Core;

/**
 * Auth Middleware - Yêu cầu user đã đăng nhập.
 * Nếu chưa đăng nhập → redirect về trang login.
 * Dùng cho các route: profile, booking, ...
 */
class AuthMiddleware extends Middleware
{
    /**
     * Kiểm tra đăng nhập - gọi trong Controller khi cần bảo vệ thủ công.
     * Nếu chưa đăng nhập → redirect về /login và thoát.
     */
    public static function requireAuth(): void
    {
        if (Auth::check()) {
            return;
        }
        Session::flash('_intended', $_SERVER['REQUEST_URI'] ?? '/');
        header('Location: ' . \App\Core\url('/login'));
        exit;
    }
    /** URL redirect khi chưa đăng nhập */
    protected string $loginUrl = '/login';

    /** Query key lưu URL intended (sau khi login redirect về) */
    protected string $intendedKey = 'redirect';

    public function handle(\Closure $next): void
    {
        if (Auth::check()) {
            $next();
            return;
        }

        Session::flash('_intended', $this->getCurrentUrl());
        $url = defined('APP_URL') ? rtrim(APP_URL, '/') . $this->loginUrl : $this->loginUrl;
        header('Location: ' . $url);
        exit;
    }

    protected function getCurrentUrl(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }
}
