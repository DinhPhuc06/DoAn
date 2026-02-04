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
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\RoomTypeController;
use App\Controllers\Admin\RoomController as AdminRoomController;
use App\Controllers\Admin\BookingController as AdminBookingController;
use App\Controllers\Admin\AmenityController;
use App\Controllers\Admin\ServiceController;

// Set base path cho router (nếu app nằm trong subfolder)
Router::setBasePath('');

// Routes công khai (không cần đăng nhập)
Router::get('/', HomeController::class, 'index');
Router::get('/home', HomeController::class, 'index');

// BOOKING FLOW: Xem phòng → Tìm phòng → Chọn phòng → Form booking → Store
Router::get('/rooms', RoomController::class, 'index');
Router::get('/room-types/{id}', RoomController::class, 'showType');
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

// ============ ADMIN ROUTES ============
Router::get('/admin', AdminController::class, 'dashboard');

// Admin Users
Router::get('/admin/users', UserController::class, 'index');
Router::get('/admin/users/create', UserController::class, 'create');
Router::post('/admin/users/store', UserController::class, 'store');
Router::get('/admin/users/{id}/edit', UserController::class, 'edit');
Router::post('/admin/users/{id}/update', UserController::class, 'update');
Router::post('/admin/users/{id}/delete', UserController::class, 'destroy');

// Admin Room Types
Router::get('/admin/room-types', RoomTypeController::class, 'index');
Router::get('/admin/room-types/create', RoomTypeController::class, 'create');
Router::post('/admin/room-types/store', RoomTypeController::class, 'store');
Router::get('/admin/room-types/{id}/edit', RoomTypeController::class, 'edit');
Router::post('/admin/room-types/{id}/update', RoomTypeController::class, 'update');
Router::post('/admin/room-types/{id}/delete', RoomTypeController::class, 'destroy');

// Admin Rooms
Router::get('/admin/rooms', AdminRoomController::class, 'index');
Router::get('/admin/rooms/create', AdminRoomController::class, 'create');
Router::post('/admin/rooms/store', AdminRoomController::class, 'store');
Router::get('/admin/rooms/{id}/edit', AdminRoomController::class, 'edit');
Router::post('/admin/rooms/{id}/update', AdminRoomController::class, 'update');
Router::post('/admin/rooms/{id}/delete', AdminRoomController::class, 'destroy');

// Admin Bookings
Router::get('/admin/bookings', AdminBookingController::class, 'index');
Router::get('/admin/bookings/{id}', AdminBookingController::class, 'show');
Router::post('/admin/bookings/{id}/status', AdminBookingController::class, 'updateStatus');

// Admin Amenities
Router::get('/admin/amenities', AmenityController::class, 'index');
Router::get('/admin/amenities/create', AmenityController::class, 'create');
Router::post('/admin/amenities/store', AmenityController::class, 'store');
Router::get('/admin/amenities/{id}/edit', AmenityController::class, 'edit');
Router::post('/admin/amenities/{id}/update', AmenityController::class, 'update');
Router::post('/admin/amenities/{id}/delete', AmenityController::class, 'destroy');

// Admin Services
Router::get('/admin/services', ServiceController::class, 'index');
Router::get('/admin/services/create', ServiceController::class, 'create');
Router::post('/admin/services/store', ServiceController::class, 'store');
Router::get('/admin/services/{id}/edit', ServiceController::class, 'edit');
Router::post('/admin/services/{id}/update', ServiceController::class, 'update');
Router::post('/admin/services/{id}/delete', ServiceController::class, 'destroy');

// Dispatch request
Router::dispatch();

