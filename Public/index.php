<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);
/**
 * Entry point Frontend - Bootstrap và Router
 * Middleware: AuthMiddleware (yêu cầu đăng nhập), GuestMiddleware (chỉ guest)
 */

require __DIR__ . '/bootstrap.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/doan/public', '', $uri);

if ($uri === '') {
    $uri = '/';
}

use App\Core\Router;
use App\Core\AuthMiddleware;
use App\Core\GuestMiddleware;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\RoomController;
use App\Controllers\BookingController;
use App\Core\AdminMiddleware;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\RoomTypeController;
use App\Controllers\Admin\RoomController as AdminRoomController;
use App\Controllers\Admin\BookingController as AdminBookingController;
use App\Controllers\Admin\AmenityController;
use App\Controllers\Admin\ServiceController;
use App\Controllers\Admin\RevenueController;
use App\Controllers\ReviewController;

// Set base path cho router (nếu app nằm trong subfolder)
Router::setBasePath('/doan/public');


// Routes công khai (không cần đăng nhập)
Router::get('/', HomeController::class, 'index');
Router::get('/home', HomeController::class, 'index');

// BOOKING FLOW: Xem phòng → Tìm phòng → Chọn phòng → Form booking → Store (yêu cầu đăng nhập)
Router::get('/rooms', RoomController::class, 'index');
Router::get('/room-types/{id}', RoomController::class, 'showType');
Router::get('/rooms/search', RoomController::class, 'search');
Router::get('/rooms/{id}', RoomController::class, 'detail');
Router::get('/booking/form', BookingController::class, 'form', [AuthMiddleware::class]);
Router::get('/booking/success', BookingController::class, 'success', [AuthMiddleware::class]);
Router::post('/booking/store', BookingController::class, 'store', [AuthMiddleware::class]);

// Reviews (yêu cầu đăng nhập)
Router::post('/reviews', ReviewController::class, 'store', [AuthMiddleware::class]);

// Auth: login/register/logout (GuestMiddleware = đã login thì redirect về home)
Router::get('/login', AuthController::class, 'loginForm', [GuestMiddleware::class]);
Router::post('/login', AuthController::class, 'login', [GuestMiddleware::class]);
Router::get('/register', AuthController::class, 'registerForm', [GuestMiddleware::class]);
Router::post('/register', AuthController::class, 'register', [GuestMiddleware::class]);
Router::get('/logout', AuthController::class, 'logout');
Router::post('/logout', AuthController::class, 'logout');

// Routes yêu cầu đăng nhập (AuthMiddleware)
Router::get('/profile', ProfileController::class, 'index', [AuthMiddleware::class]);

// ============ ADMIN ROUTES ============
// Redirect /admin/login → /login (1 trang đăng nhập duy nhất)
Router::get('/admin/login', AuthController::class, 'redirectToLogin');

// Admin protected (AdminMiddleware - kiểm tra role)
$adminMw = [AdminMiddleware::class];
Router::get('/admin', AdminController::class, 'dashboard', $adminMw);

// Admin Users
Router::get('/admin/users', UserController::class, 'index', $adminMw);
Router::get('/admin/users/create', UserController::class, 'create', $adminMw);
Router::post('/admin/users/store', UserController::class, 'store', $adminMw);
Router::get('/admin/users/{id}/edit', UserController::class, 'edit', $adminMw);
Router::post('/admin/users/{id}/update', UserController::class, 'update', $adminMw);
Router::post('/admin/users/{id}/delete', UserController::class, 'destroy', $adminMw);

// Admin Room Types
Router::get('/admin/room-types', RoomTypeController::class, 'index', $adminMw);
Router::get('/admin/room-types/create', RoomTypeController::class, 'create', $adminMw);
Router::post('/admin/room-types/store', RoomTypeController::class, 'store', $adminMw);
Router::get('/admin/room-types/{id}/edit', RoomTypeController::class, 'edit', $adminMw);
Router::post('/admin/room-types/{id}/update', RoomTypeController::class, 'update', $adminMw);
Router::post('/admin/room-types/{id}/delete', RoomTypeController::class, 'destroy', $adminMw);

// Admin Rooms
Router::get('/admin/rooms', AdminRoomController::class, 'index', $adminMw);
Router::get('/admin/rooms/create', AdminRoomController::class, 'create', $adminMw);
Router::post('/admin/rooms/store', AdminRoomController::class, 'store', $adminMw);
Router::get('/admin/rooms/{id}/edit', AdminRoomController::class, 'edit', $adminMw);
Router::post('/admin/rooms/{id}/update', AdminRoomController::class, 'update', $adminMw);
Router::post('/admin/rooms/{id}/delete', AdminRoomController::class, 'destroy', $adminMw);

// Admin Bookings
Router::get('/admin/bookings', AdminBookingController::class, 'index', $adminMw);
Router::get('/admin/bookings/{id}', AdminBookingController::class, 'show', $adminMw);
Router::post('/admin/bookings/{id}/status', AdminBookingController::class, 'updateStatus', $adminMw);

// Admin Amenities
Router::get('/admin/amenities', AmenityController::class, 'index', $adminMw);
Router::get('/admin/amenities/create', AmenityController::class, 'create', $adminMw);
Router::post('/admin/amenities/store', AmenityController::class, 'store', $adminMw);
Router::get('/admin/amenities/{id}/edit', AmenityController::class, 'edit', $adminMw);
Router::post('/admin/amenities/{id}/update', AmenityController::class, 'update', $adminMw);
Router::post('/admin/amenities/{id}/delete', AmenityController::class, 'destroy', $adminMw);

// Admin Services
Router::get('/admin/services', ServiceController::class, 'index', $adminMw);
Router::get('/admin/services/create', ServiceController::class, 'create', $adminMw);
Router::post('/admin/services/store', ServiceController::class, 'store', $adminMw);
Router::get('/admin/services/{id}/edit', ServiceController::class, 'edit', $adminMw);
Router::post('/admin/services/{id}/update', ServiceController::class, 'update', $adminMw);
Router::post('/admin/services/{id}/delete', ServiceController::class, 'destroy', $adminMw);

// Admin Revenue
Router::get('/admin/revenue', RevenueController::class, 'index', $adminMw);

// Payments
Router::get('/payment', BookingController::class,'payment');
Router::post('/payment/vnpay', BookingController::class,'vnpay');
Router::get('/payment-return', BookingController::class,'vnpayReturn');
// Dispatch request
Router::dispatch();
