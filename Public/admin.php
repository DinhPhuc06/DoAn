<?php

/**
 * Entry point Admin - Bootstrap và điều phối request đến Controllers_Admin
 * Quyền truy cập: AdminMiddleware (trừ page=auth). Controller không tự check.
 * Cú pháp: ?page=customer|room-type|room|service|revenue|auth&action=...&id=...
 */

require __DIR__ . '/../bootstrap.php';

use App\Core\Auth;
use App\Core\AdminMiddleware;
use App\Controllers_Admin\AdminAuthController;
use App\Controllers_Admin\AdminCustomerController;
use App\Controllers_Admin\AdminRoomTypeController;
use App\Controllers_Admin\AdminRoomController;
use App\Controllers_Admin\AdminServiceController;
use App\Controllers_Admin\AdminRevenueController;

$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Chỉ trang auth (login, logout) không cần đăng nhập admin; còn lại chạy AdminMiddleware
if ($page !== 'auth') {
    AdminMiddleware::run(function () use ($page, $action, $id) {
        runAdminRoutes($page, $action, $id);
    }, AdminMiddleware::class);
    exit;
}

// page = auth: login form, login POST, logout
$controller = new AdminAuthController();
if ($action === 'logout') {
    $controller->logout();
    exit;
}
if ($action === 'login' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
    exit;
}
$controller->loginForm();
exit;

/**
 * Chạy route admin (sau khi AdminMiddleware đã cho qua)
 */
function runAdminRoutes(string $page, string $action, int $id): void
{
    $controller = null;
    switch ($page) {
        case 'customer':
            $controller = new AdminCustomerController();
            break;
        case 'room-type':
            $controller = new AdminRoomTypeController();
            break;
        case 'room':
            $controller = new AdminRoomController();
            break;
        case 'service':
            $controller = new AdminServiceController();
            break;
        case 'revenue':
            $controller = new AdminRevenueController();
            $action = 'index';
            break;
        default:
            header('Location: admin.php?page=customer');
            exit;
    }

    $method = $action;
    if (!method_exists($controller, $method)) {
        $method = 'index';
    }

    if (in_array($method, ['edit', 'update', 'delete'], true) && $id > 0) {
        $controller->{$method}($id);
    } else {
        $controller->{$method}();
    }
}
