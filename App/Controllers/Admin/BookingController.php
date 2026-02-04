<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Booking;
use PDO;

class BookingController extends Controller
{
    private Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->bookingModel = new Booking();
    }

    public function index(): void
    {
        $bookings = $this->bookingModel->getAllWithDetails();
        $this->useLayout = true;
        $this->render('Admin/bookings/index', [
            'title' => 'Quản lý đặt phòng - Admin',
            'pageTitle' => 'Quản Lý Đặt Phòng',
            'currentPage' => 'bookings',
            'bookings' => $bookings,
        ]);
    }

    public function show(int $id): void
    {
        $booking = $this->bookingModel->getDetailById($id);
        $this->useLayout = true;
        $this->render('Admin/bookings/detail', [
            'title' => 'Chi tiết đặt phòng - Admin',
            'pageTitle' => 'Chi Tiết Đặt Phòng #' . $id,
            'currentPage' => 'bookings',
            'booking' => $booking,
        ]);
    }

    public function updateStatus(int $id): void
    {
        $status = $this->input('status');
        $this->bookingModel->update($id, ['status' => $status]);
        $this->redirect('/admin/bookings');
    }
}
