<?php

namespace App\Controllers_Admin;

use App\Models\Payment;
use App\Models\Booking;

/**
 * Admin Doanh thu - Chỉ đọc dữ liệu từ Model (Payment, Booking), không CRUD.
 */
class AdminRevenueController extends AdminBaseController
{
    private Payment $paymentModel;
    private Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        $this->paymentModel = new Payment();
        $this->bookingModel = new Booking();
    }

    /** GET: Trang báo cáo doanh thu */
    public function index(): void
    {
        $payments = $this->paymentModel->getAll();
        $bookings = $this->bookingModel->getAll();
        $this->render('Renevue/index', [
            'payments' => $payments,
            'bookings' => $bookings,
        ]);
    }
}
