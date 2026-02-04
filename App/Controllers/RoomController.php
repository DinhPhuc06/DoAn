<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Service;

/**
 * BOOKING FLOW - Bước 1 & 2 & 3:
 * Xem phòng (loại phòng) → Tìm phòng (lọc check-in/check-out, loại, giá) → Chọn phòng (room_id qua URL).
 * Controller chỉ điều phối; dữ liệu từ Model.
 */
class RoomController extends Controller
{
    private RoomType $roomTypeModel;
    private Room $roomModel;
    private Service $serviceModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->roomTypeModel = new RoomType();
        $this->roomModel = new Room();
        $this->serviceModel = new Service();
    }

    public function index(): void
    {
        $roomTypes = $this->roomTypeModel->getAllWithImages();
        $addons = $this->serviceModel->getAddons();
        $this->useLayout = true;
        $this->render('Room/types', [
            'roomTypes' => $roomTypes,
            'addons' => $addons,
            'title' => 'Danh sách phòng - Booking Hotel',
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

        $roomTypes = $this->roomTypeModel->getAll();
        $rooms = [];

        if ($checkIn && $checkOut) {
            $checkIn = date('Y-m-d', strtotime($checkIn));
            $checkOut = date('Y-m-d', strtotime($checkOut));
            if ($checkIn < $checkOut) {
                $rooms = $this->roomModel->getAvailableInRange($checkIn, $checkOut, $roomTypeId);
            }
        }

        $this->useLayout = true;
        $this->render('Room/search', [
            'roomTypes' => $roomTypes,
            'rooms' => $rooms,
            'checkIn' => $checkIn ?? '',
            'checkOut' => $checkOut ?? '',
            'roomTypeId' => $roomTypeId,
            'title' => 'Tìm kiếm phòng - Booking Hotel',
        ]);
    }

    public function detail(int $id): void
    {
        $room = $this->roomModel->findById($id);
        if (!$room) {
            $this->redirect(url('/rooms'));
            return;
        }
        $roomType = $this->roomTypeModel->getFullDetail($room['room_type_id'] ?? 0);
        $checkIn = $this->input('check_in') ?? '';
        $checkOut = $this->input('check_out') ?? '';
        $this->useLayout = true;
        $this->render('Room/detail', [
            'room' => $room,
            'roomType' => $roomType,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'title' => 'Chi tiết phòng ' . ($room['room_number'] ?? ''),
        ]);
    }

    /**
     * Hiển thị chi tiết loại phòng (room type)
     */
    public function showType(int $id): void
    {
        $roomType = $this->roomTypeModel->getFullDetail($id);
        if (!$roomType) {
            $this->redirect(url('/rooms'));
            return;
        }

        $reviewService = new \App\Service\ReviewService();
        $reviews = $reviewService->getReviewsByRoomTypeId($id);
        $avgRating = $reviewService->getAverageRating($id);
        $reviewCount = count($reviews);

        $reviewModel = new \App\Models\Review();
        $defaultRoomId = $reviewModel->getFirstRoomIdByType($id);

        $userId = \App\Core\Auth::user()['id'] ?? null;
        $userHasReviewed = $userId ? $reviewService->hasUserReviewedRoomType($userId, $id) : false;

        $this->useLayout = true;
        $this->render('Room/type-detail', [
            'roomType' => $roomType,
            'reviews' => $reviews,
            'avgRating' => $avgRating,
            'reviewCount' => $reviewCount,
            'defaultRoomId' => $defaultRoomId,
            'userHasReviewed' => $userHasReviewed,
            'title' => $roomType['name'] . ' - Booking Hotel',
        ]);
    }
}
