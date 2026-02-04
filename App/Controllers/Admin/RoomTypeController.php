<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\RoomType;
use PDO;

class RoomTypeController extends Controller
{
    private RoomType $roomTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->roomTypeModel = new RoomType();
    }

    public function index(): void
    {
        $roomTypes = $this->roomTypeModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/room-types/index', [
            'title' => 'Quản lý loại phòng - Admin',
            'pageTitle' => 'Quản Lý Loại Phòng',
            'currentPage' => 'room-types',
            'roomTypes' => $roomTypes,
        ]);
    }

    public function create(): void
    {
        $this->useLayout = true;
        $this->render('Admin/room-types/form', [
            'title' => 'Thêm loại phòng - Admin',
            'pageTitle' => 'Thêm Loại Phòng Mới',
            'currentPage' => 'room-types',
            'roomType' => null,
        ]);
    }

    public function store(): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'capacity' => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
            'size_m2' => $this->input('size_m2'),
        ];
        $this->roomTypeModel->create($data);
        $this->redirect('/admin/room-types');
    }

    public function edit(int $id): void
    {
        $roomType = $this->roomTypeModel->findById($id);
        $this->useLayout = true;
        $this->render('Admin/room-types/form', [
            'title' => 'Sửa loại phòng - Admin',
            'pageTitle' => 'Chỉnh Sửa Loại Phòng',
            'currentPage' => 'room-types',
            'roomType' => $roomType,
        ]);
    }

    public function update(int $id): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'capacity' => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
            'size_m2' => $this->input('size_m2'),
        ];
        $this->roomTypeModel->update($id, $data);
        $this->redirect('/admin/room-types');
    }

    public function destroy(int $id): void
    {
        $this->roomTypeModel->delete($id);
        $this->redirect('/admin/room-types');
    }
}
