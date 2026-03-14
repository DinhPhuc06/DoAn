<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\Models\User;
use function App\Core\url;

/**
 * AuthController - Đăng nhập/Đăng ký frontend.
 * Trang login/register dùng GuestMiddleware (đã login thì redirect về home).
 */
class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->userModel = new User();
    }

    /** Redirect /admin/login → /login (trang đăng nhập thống nhất) */
    public function redirectToLogin(): void
    {
        $this->redirect(url('/login'));
    }

    /** GET: Form đăng nhập */
    public function loginForm(): void
    {
        $this->useLayout = false;
        $this->render('Auth/login', [
            'title' => 'Đăng nhập - Booking Hotel',
            'error' => $_GET['error'] ?? null,
        ]);
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
        $found = $this->userModel->findByEmail($email);
        if ($found && password_verify($password, $found['password'] ?? '')) {
            Auth::setUser($found);
            $intended = Session::getFlash('_intended');
            // Phân quyền redirect sau khi đăng nhập
            if (Auth::role() === 'admin') {
                $target = ($intended && strpos($intended, 'admin') !== false)
                    ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $intended)
                    : url('/admin');
                $this->redirect($target);
            } else {
                $target = $intended
                    ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $intended)
                    : url('/');
                $this->redirect($target);
            }
            return;
        }
        $this->redirect(url('/login?error=invalid'));
    }

    /** GET: Form đăng ký */
    public function registerForm(): void
    {
        $this->useLayout = false;
        $this->render('Auth/register', [
            'title' => 'Đăng ký - Booking Hotel',
            'error' => $_GET['error'] ?? null,
        ]);
    }

    /** POST: Xử lý đăng ký */
    public function register(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('/register'));
            return;
        }
        $fullName = trim((string) $this->input('full_name'));
        $email = trim((string) $this->input('email'));
        $phone = trim((string) $this->input('phone'));
        $password = (string) $this->input('password');
        $passwordConfirm = (string) $this->input('password_confirm');

        $errors = [];
        if ($fullName === '') {
            $errors[] = 'full_name';
        }
        if ($email === '') {
            $errors[] = 'email';
        } elseif ($this->userModel->findByEmail($email)) {
            $errors[] = 'email_exists';
        }
        if (strlen($password) < 6) {
            $errors[] = 'password_short';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'password_mismatch';
        }

        if (!empty($errors)) {
            Session::flash('_old.full_name', $fullName);
            Session::flash('_old.email', $email);
            Session::flash('_old.phone', $phone);
            $query = 'error=' . urlencode(implode(',', $errors));
            $this->redirect(url('/register?' . $query));
            return;
        }

        $userId = $this->userModel->create([
            'role_id' => 3,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone ?: null,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status' => 1,
        ]);

        if ($userId) {
            $user = $this->userModel->findById($userId);
            if ($user) {
                Auth::setUser($user);
            }
            $this->redirect(url('/'));
            return;
        }

        $this->redirect(url('/register?error=create_failed'));
    }

    /** POST/GET: Đăng xuất */
    public function logout(): void
    {
        Auth::logout();
        $this->redirect(url('/'));
    }
}
