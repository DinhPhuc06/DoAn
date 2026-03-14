<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

/**
 * ProfileController - Trang cá nhân (yêu cầu đăng nhập).
 * Không tự check quyền; route đã gắn AuthMiddleware.
 */
class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
    }

    public function index(): void
    {
        $user = Auth::user();
        $this->render('Profile/index', ['user' => $user]);
    }
}
