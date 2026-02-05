<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    private Room $roomModel;
    private RoomType $roomTypeModel;
    private \App\Models\RoomImage $roomImageModel;
    private \App\Service\CloudinaryService $cloudinaryService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
        $this->roomImageModel = new \App\Models\RoomImage();
        $this->cloudinaryService = new \App\Service\CloudinaryService();
    }

    public function index(): void
    {
        $rooms = $this->roomModel->getAllWithType();
        $this->useLayout = true;
        $this->render('Admin/rooms/index', [
            'title' => 'Quản lý phòng - Admin',
            'pageTitle' => 'Quản Lý Phòng',
            'currentPage' => 'rooms',
            'rooms' => $rooms,
        ]);
    }

    public function create(): void
    {
        $roomTypes = $this->roomTypeModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/rooms/form', [
            'title' => 'Thêm phòng - Admin',
            'pageTitle' => 'Thêm Phòng Mới',
            'currentPage' => 'rooms',
            'roomTypes' => $roomTypes,
            'room' => null,
        ]);
    }

    public function store(): void
    {
        $floorInput = $this->input('floor');
        $data = [
            'room_type_id' => $this->input('room_type_id'),
            'room_number' => $this->input('room_number'),
            'floor' => $floorInput !== '' ? (int) $floorInput : null,
            'status' => $this->input('status') ?? 'available',
        ];

        $id = $this->roomModel->create($data);

        // Handle multiple image uploads
        if ($id && !empty($_FILES['images']['tmp_name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if (empty($tmpName))
                    continue;

                $imageUrl = $this->cloudinaryService->upload($tmpName, 'rooms');
                if ($imageUrl) {
                    $this->roomImageModel->create([
                        'room_type_id' => $data['room_type_id'],
                        'room_id' => $id,
                        'image_path' => $imageUrl,
                        'is_primary' => ($index === 0) ? 1 : 0
                    ]);
                }
            }
        }

        $this->redirect('/admin/rooms');
    }

    public function edit(int $id): void
    {
        $room = $this->roomModel->findById($id);
        if ($room) {
            $room['images'] = $this->roomImageModel->getByRoomId($id);
        }
        $roomTypes = $this->roomTypeModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/rooms/form', [
            'title' => 'Sửa phòng - Admin',
            'pageTitle' => 'Chỉnh Sửa Phòng',
            'currentPage' => 'rooms',
            'roomTypes' => $roomTypes,
            'room' => $room,
        ]);
    }

    public function update(int $id): void
    {
        $floorInput = $this->input('floor');
        $data = [
            'room_type_id' => $this->input('room_type_id'),
            'room_number' => $this->input('room_number'),
            'floor' => $floorInput !== '' ? (int) $floorInput : null,
            'status' => $this->input('status'),
        ];

        $this->roomModel->update($id, $data);

        // Handle multiple image uploads
        if (!empty($_FILES['images']['tmp_name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if (empty($tmpName))
                    continue;

                $imageUrl = $this->cloudinaryService->upload($tmpName, 'rooms');
                if ($imageUrl) {
                    $existing = $this->roomImageModel->getByRoomId($id);
                    $this->roomImageModel->create([
                        'room_type_id' => $data['room_type_id'],
                        'room_id' => $id,
                        'image_path' => $imageUrl,
                        'is_primary' => empty($existing) ? 1 : 0
                    ]);
                }
            }
        }

        $this->redirect('/admin/rooms');
    }

    public function destroy(int $id): void
    {
        $this->roomModel->delete($id);
        $this->redirect('/admin/rooms');
    }
}
