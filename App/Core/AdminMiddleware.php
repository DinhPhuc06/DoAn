<<<<<<< HEAD
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
=======
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
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
