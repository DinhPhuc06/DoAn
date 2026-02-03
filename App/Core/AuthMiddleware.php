<?php

namespace App\Core;


class AuthMiddleware extends Middleware
{
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
