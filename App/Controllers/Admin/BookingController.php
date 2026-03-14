<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
<<<<<<< HEAD
use App\Core\BookingException;
use App\Service\BookingService;
use App\Models\Booking;
=======
use App\Models\Booking;
use PDO;
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3

class BookingController extends Controller
{
    private Booking $bookingModel;
<<<<<<< HEAD
    private BookingService $bookingService;
=======
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->bookingModel = new Booking();
<<<<<<< HEAD
        $this->bookingService = new BookingService();
=======
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
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
<<<<<<< HEAD
        $status = trim((string) $this->input('status'));
        try {
            $this->bookingService->updateStatus($id, $status);
            $this->redirect(\App\Core\url('/admin/bookings'));
        } catch (BookingException $e) {
            $this->redirect(\App\Core\url('/admin/bookings/' . $id . '?error=' . urlencode($e->getErrorCode())));
        }
    }
    //trang thanh toán
    public function payment()
    {
        $booking_id = $_GET['booking_id'];

        $bookingModel = new \App\Models\Booking();
        $booking = $bookingModel->find($booking_id);

        require '../App/Views/payment/payment.php';
    }
    //chuyển sang Vnpay
    public function vnpay()
    {
        $booking_id = $_POST['booking_id'];
        $amount = $_POST['amount'];

        $url = \App\Service\VnpayService::createPayment($amount, $booking_id);

        header("Location: ".$url);
        exit;
    }
    //Nhận kết quả Vnpay
    public function vnpayReturn()
    {
        if ($_GET['vnp_ResponseCode'] == '00') {
            echo "Thanh toán thành công";
        } else {
            echo "Thanh toán thất bại";
        }

        $paymentModel = new \App\Models\Payment();

        if ($_GET['vnp_ResponseCode'] == '00') {

            $paymentModel->updateStatus($_GET['vnp_TxnRef'], 'success');

            echo "Thanh toán thành công";

        } else {

            $paymentModel->updateStatus($_GET['vnp_TxnRef'], 'failed');

            echo "Thanh toán thất bại";
        }
=======
        $status = $this->input('status');
        $this->bookingModel->update($id, ['status' => $status]);
        $this->redirect('/admin/bookings');
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
    }
}
