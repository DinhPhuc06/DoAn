<<<<<<< HEAD
<?php

namespace App\Core;

/**
 * Guest Middleware - Chỉ cho phép khi chưa đăng nhập.
 * Đã đăng nhập → redirect theo role: admin → /admin, user → / (hoặc intended).
 */
class GuestMiddleware extends Middleware
{
    public function handle(\Closure $next): void
    {
        if (!Auth::check()) {
            $next();
            return;
        }

        if (Auth::role() === 'admin') {
            $target = \App\Core\url('/admin');
        } else {
            $target = \App\Core\url('/');
        }
        header('Location: ' . $target);
        exit;
    }
}
=======
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
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
