<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    private Room $roomModel;
    private RoomType $roomTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
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
        $data = [
            'room_type_id' => $this->input('room_type_id'),
            'room_number' => $this->input('room_number'),
            'floor' => $this->input('floor'),
            'status' => $this->input('status') ?? 'available',
        ];
        $this->roomModel->create($data);
        $this->redirect('/admin/rooms');
    }

    public function edit(int $id): void
    {
        $room = $this->roomModel->findById($id);
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
        $data = [
            'room_type_id' => $this->input('room_type_id'),
            'room_number' => $this->input('room_number'),
            'floor' => $this->input('floor'),
            'status' => $this->input('status'),
        ];
        $this->roomModel->update($id, $data);
        $this->redirect('/admin/rooms');
    }

    public function destroy(int $id): void
    {
        $this->roomModel->delete($id);
        $this->redirect('/admin/rooms');
    }
}
