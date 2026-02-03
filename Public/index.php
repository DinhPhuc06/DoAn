<?php

/**
 * Entry point Frontend - Bootstrap và Router
 * Middleware: AuthMiddleware (yêu cầu đăng nhập), GuestMiddleware (chỉ guest)
 */

require __DIR__ . '/../bootstrap.php';

use App\Core\Router;
use App\Core\AuthMiddleware;
use App\Core\GuestMiddleware;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\RoomController;
use App\Controllers\BookingController;

// Set base path cho router (nếu app nằm trong subfolder)
Router::setBasePath('/Booking Hotel/Public');

// Routes công khai (không cần đăng nhập)
Router::get('/', HomeController::class, 'index');
Router::get('/home', HomeController::class, 'index');

// BOOKING FLOW: Xem phòng → Tìm phòng → Chọn phòng → Form booking → Store
Router::get('/rooms', RoomController::class, 'index');
Router::get('/rooms/search', RoomController::class, 'search');
Router::get('/rooms/{id}', RoomController::class, 'detail');
Router::get('/booking/form', BookingController::class, 'form');
Router::get('/booking/success', BookingController::class, 'success');
Router::post('/booking/store', BookingController::class, 'store');

// Auth: login/logout (GuestMiddleware = đã login thì redirect về home)
Router::get('/login', AuthController::class, 'loginForm', [GuestMiddleware::class]);
Router::post('/login', AuthController::class, 'login', [GuestMiddleware::class]);
Router::get('/logout', AuthController::class, 'logout');
Router::post('/logout', AuthController::class, 'logout');

// Routes yêu cầu đăng nhập (AuthMiddleware)
Router::get('/profile', ProfileController::class, 'index', [AuthMiddleware::class]);

// Dispatch request
Router::dispatch();
