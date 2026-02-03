<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\Service\AuthService;
use function App\Core\url;

/**
 * AuthController - Đăng nhập/Đăng ký frontend.
 * Trang login/register dùng GuestMiddleware (đã login thì redirect về home).
 */
class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->authService = new AuthService();
    }

    /** GET: Form đăng nhập */
    public function loginForm(): void
    {
        $this->useLayout = false;
        $this->render('Auth/login');
    }

    /** POST: Xử lý đăng nhập */
    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('/login'));
            return;
        }
        $email = trim((string) $this->input('email'));
        $password = (string) $this->input('password');
        if ($email === '' || $password === '') {
            $this->redirect(url('/login?error=empty'));
            return;
        }
        $user = $this->authService->attemptFrontend($email, $password);
        if ($user) {
            Auth::setUser($user);
            $intended = Session::getFlash('_intended');
            $this->redirect($intended ?: url('/'));
            return;
        }
        $this->redirect(url('/login?error=invalid'));
    }

    /** POST/GET: Đăng xuất */
    public function logout(): void
    {
        Auth::logout();
        $this->redirect(url('/'));
    }
}
