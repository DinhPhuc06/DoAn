<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Payment;
use App\Models\Booking;

/**
 * Admin Revenue - Báo cáo doanh thu (chỉ đọc).
 */
class RevenueController extends Controller
{
    private Payment $paymentModel;
    private Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->paymentModel = new Payment();
        $this->bookingModel = new Booking();
    }

    public function index(): void
    {
        $payments = $this->paymentModel->getAll();
        $bookings = $this->bookingModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/revenue/index', [
            'title' => 'Doanh thu - Admin',
            'pageTitle' => 'Báo cáo Doanh thu',
            'currentPage' => 'revenue',
            'payments' => $payments,
            'bookings' => $bookings,
        ]);
    }

    public function getRevenue()
    {

        $sql="SELECT 
        DATE(paid_at) as date,
        SUM(amount) as revenue
        FROM payments
        WHERE status='success'
        GROUP BY DATE(paid_at)
        ORDER BY date DESC";

        $stmt=$this->pdo->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
}
