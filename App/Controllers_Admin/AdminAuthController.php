<?php

namespace App\Controllers_Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Service\AuthService;

/**
 * Admin Auth - Login/Logout. Điều phối request, kiểm tra đăng nhập qua Model User.
 */
class AdminAuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views_Admin';
        $this->authService = new AuthService();
    }

    /** GET: Form đăng nhập (không qua AdminMiddleware) */
    public function loginForm(): void
    {
        if (Auth::adminCheck()) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $this->useLayout = false;
        $this->render('Auth/login');
    }

    /** POST: Xử lý đăng nhập */
    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php');
            return;
        }
        $email = trim((string) $this->input('email'));
        $password = (string) $this->input('password');
        if ($email === '' || $password === '') {
            $this->redirect('admin.php?error=empty');
            return;
        }
        $admin = $this->authService->attemptAdmin($email, $password);
        if ($admin) {
            Auth::setAdmin($admin);
            $this->redirect('admin.php?page=customer');
            return;
        }
        $this->redirect('admin.php?error=invalid');
    }

    /** GET/POST: Đăng xuất admin */
    public function logout(): void
    {
        Auth::adminLogout();
        $this->redirect('admin.php');
    }
}
