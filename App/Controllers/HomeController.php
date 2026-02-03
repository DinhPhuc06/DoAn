<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * HomeController - Trang chủ
 */
class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
    }

    public function index(): void
    {
        $this->render('Home/index', [
            'title' => 'Trang chủ - Booking Hotel',
        ]);
    }
}
