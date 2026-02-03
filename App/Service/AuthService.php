<?php

namespace App\Service;

use App\Models\User;

/**
 * AuthService - gom logic đăng nhập để Controller mỏng, dễ debug.
 */
class AuthService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /** Login frontend: trả về user hoặc null */
    public function attemptFrontend(string $email, string $password): ?array
    {
        $email = trim($email);
        if ($email === '' || $password === '') {
            return null;
        }
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return null;
        }
        return password_verify($password, $user['password'] ?? '') ? $user : null;
    }

    /** Login admin: hiện tại giống frontend (có thể mở rộng check role sau) */
    public function attemptAdmin(string $email, string $password): ?array
    {
        return $this->attemptFrontend($email, $password);
    }
}

