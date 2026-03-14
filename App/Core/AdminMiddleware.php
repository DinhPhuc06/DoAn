<?php

namespace App\Core;

/**
 * Admin Middleware - Chỉ cho phép role admin.
 * Guest → redirect /login + lưu intended.
 * User (role !== admin) → 403 Forbidden.
 */
class AdminMiddleware extends Middleware
{
    protected string $loginUrl = '/login';

    public function handle(\Closure $next): void
    {
        if (Auth::role() === 'admin') {
            $next();
            return;
        }

        if (!Auth::check()) {
            Session::flash('_intended', $_SERVER['REQUEST_URI'] ?? '/admin');
            header('Location: ' . \App\Core\url($this->loginUrl));
            exit;
        }

        http_response_code(403);
        exit('Forbidden');
    }
}
