<?php

namespace App\Core;

/**
 * Auth - Xác thực người dùng.
 * Hai guard: user (frontend) và admin (khu vực admin).
 * Controller không tự check quyền; dùng AuthMiddleware / AdminMiddleware.
 */
class Auth
{
    private const USER_KEY = 'user';
    private const ADMIN_KEY = 'admin_user';

    // ---------- Frontend (user) ----------

    public static function setUser(array $user): void
    {
        Session::set(self::USER_KEY, $user);
    }

    public static function user(): ?array
    {
        return Session::get(self::USER_KEY);
    }

    /** Đã đăng nhập (frontend) */
    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout(): void
    {
        Session::forget(self::USER_KEY);
    }

    /** Chưa đăng nhập (guest) */
    public static function guest(): bool
    {
        return !self::check();
    }

    // ---------- Admin ----------

    public static function setAdmin(array $user): void
    {
        Session::set(self::ADMIN_KEY, $user);
    }

    public static function admin(): ?array
    {
        return Session::get(self::ADMIN_KEY);
    }

    /** Đã đăng nhập admin */
    public static function adminCheck(): bool
    {
        return self::admin() !== null;
    }

    public static function adminLogout(): void
    {
        Session::forget(self::ADMIN_KEY);
    }
}
