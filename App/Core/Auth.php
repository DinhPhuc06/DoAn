<?php

namespace App\Core;

/**
 * Auth - Xác thực thống nhất: 1 session (user), phân quyền qua role_id.
 * role_id=1 => admin, còn lại => user.
 * Controller dùng AuthMiddleware / AdminMiddleware để bảo vệ route.
 */
class Auth
{
    private const USER_KEY = 'user';

    public static function setUser(array $user): void
    {
        Session::set(self::USER_KEY, $user);
    }

    public static function user(): ?array
    {
        return Session::get(self::USER_KEY);
    }

    /** Đã đăng nhập */
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

    /** ID người dùng hiện tại */
    public static function id(): ?int
    {
        $u = self::user();
        return ($u !== null && isset($u['id'])) ? (int) $u['id'] : null;
    }

    /** Role: 'admin' (role_id=1) hoặc 'user' */
    public static function role(): ?string
    {
        $u = self::user();
        if ($u === null) {
            return null;
        }
        $roleId = (int) ($u['role_id'] ?? 0);
        return $roleId === 1 ? 'admin' : 'user';
    }
}
