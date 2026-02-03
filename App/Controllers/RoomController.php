<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Service\RoomService;
use function App\Core\url;

/**
 * BOOKING FLOW - Bước 1 & 2 & 3:
 * Xem phòng (loại phòng) → Tìm phòng (lọc check-in/check-out, loại, giá) → Chọn phòng (room_id qua URL).
 * Controller chỉ điều phối; validate/tìm phòng nằm trong Service.
 */
class RoomController extends Controller
{
    private RoomService $roomService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->roomService = new RoomService();
    }

    /**
     * XEM PHÒNG: Danh sách loại phòng (hình ảnh, tên, sức chứa, addon, giá)
     */
    public function index(): void
    {
        $data = $this->roomService->getRoomTypesForDisplay();
        $this->useLayout = false;
        $this->render('Room/types', [
            'roomTypes' => $data['roomTypes'],
            'addons'    => $data['addons'],
        ]);
    }

    /**
     * TÌM PHÒNG: Form + kết quả phòng còn trống theo check-in/check-out, loại phòng, giá
     */
    public function search(): void
    {
        $checkIn = $this->input('check_in');
        $checkOut = $this->input('check_out');
        $roomTypeId = $this->input('room_type_id') !== null && $this->input('room_type_id') !== '' ? (int) $this->input('room_type_id') : null;
        $data = $this->roomService->searchAvailableRooms($checkIn, $checkOut, $roomTypeId);

        $this->useLayout = false;
        $this->render('Room/search', [
            'roomTypes'  => $data['roomTypes'],
            'rooms'      => $data['rooms'],
            'checkIn'    => $data['checkIn'],
            'checkOut'   => $data['checkOut'],
            'roomTypeId' => $data['roomTypeId'],
            'error'      => $data['error'],
        ]);
    }

    /**
     * CHỌN PHÒNG: Chi tiết phòng, truyền room_id qua URL → link tới form booking
     */
    public function detail(int $id): void
    {
        // Dùng model trực tiếp cho hiển thị đơn giản (không có transaction/validate phức tạp)
        $room = (new \App\Models\Room())->findById($id);
        if (!$room) {
            $this->redirect(url('/rooms'));
            return;
        }
        $roomType = (new \App\Models\RoomType())->findById($room['room_type_id'] ?? 0);
        $this->useLayout = false;
        $this->render('Room/detail', [
            'room'     => $room,
            'roomType' => $roomType,
        ]);
    }
}
