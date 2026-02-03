<?php

namespace App\Controllers_Admin;

use App\Core\Controller;

/**
 * Controller nền cho khu vực Admin.
 * Set viewPath = Views_Admin, tất cả controller admin kế thừa từ đây.
 */
abstract class AdminBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views_Admin';
    }
}
