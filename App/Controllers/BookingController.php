<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\Models\Room;
use App\Models\RoomType;
use App\Service\BookingService;
use function App\Core\url;

/**
 * BOOKING FLOW - Controller chỉ: tiếp nhận request, gọi service, xử lý kết quả (redirect/render).
 * Validate và transaction nằm trong Service/BookingService.
 */
class BookingController extends Controller
{
    private Room $roomModel;
    private RoomType $roomTypeModel;
    private BookingService $bookingService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
        $this->bookingService = new BookingService();
    }

    /**
     * Form đặt phòng: room_id, check_in, check_out (từ URL)
     */
    public function form(): void
    {
        $roomId = (int) $this->input('room_id');
        $checkIn = $this->input('check_in');
        $checkOut = $this->input('check_out');

        if (!$roomId) {
            $this->redirect(url('/rooms/search'));
            return;
        }

        $room = $this->roomModel->findById($roomId);
        if (!$room) {
            $this->redirect(url('/rooms/search'));
            return;
        }

        $roomType = $this->roomTypeModel->findById($room['room_type_id'] ?? 0);
        $this->useLayout = false;
        $this->render('Booking/form', [
            'room'     => $room,
            'roomType' => $roomType,
            'checkIn'  => $checkIn,
            'checkOut' => $checkOut,
        ]);
    }

    /**
     * POST: Tiếp nhận request → gọi service → xử lý kết quả (redirect)
     */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect(url('/rooms'));
            return;
        }

        $userId = (Auth::user()['id'] ?? null);
        if (!$userId) {
            Session::flash('_intended', url('/booking/form?room_id=' . (int) $this->input('room_id') . '&check_in=' . $this->input('check_in') . '&check_out=' . $this->input('check_out')));
            $this->redirect(url('/login'));
            return;
        }

        $result = $this->bookingService->createBookingFromRequest([
            'user_id'   => $userId,
            'room_id'   => $this->input('room_id'),
            'check_in'  => $this->input('check_in'),
            'check_out' => $this->input('check_out'),
        ]);

        if ($result['success']) {
            $this->redirect(url('/booking/success?id=' . $result['booking_id']));
            return;
        }

        $roomId = (int) $this->input('room_id');
        $checkIn = $this->input('check_in');
        $checkOut = $this->input('check_out');
        $query = 'room_id=' . $roomId . '&error=' . $result['error'];
        if ($checkIn && $checkOut) {
            $query .= '&check_in=' . urlencode($checkIn) . '&check_out=' . urlencode($checkOut);
        }
        $this->redirect(url('/booking/form?' . $query));
    }

    /**
     * Trang thành công sau khi tạo booking (hiển thị status flow, bước thanh toán)
     */
    public function success(): void
    {
        $bookingId = (int) $this->input('id');
        $booking = $bookingId ? (new \App\Models\Booking())->findById($bookingId) : null;
        $this->useLayout = false;
        $this->render('Booking/success', [
            'bookingId' => $bookingId,
            'booking'   => $booking,
        ]);
    }
}
