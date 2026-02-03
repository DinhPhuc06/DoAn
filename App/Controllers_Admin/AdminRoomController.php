<?php

namespace App\Controllers_Admin;

use App\Models\Room;
use App\Models\RoomType;

/**
 * Admin CRUD Phòng (room_details). Điều phối request, dữ liệu ở Model.
 */
class AdminRoomController extends AdminBaseController
{
    private Room $model;
    private RoomType $roomTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Room();
        $this->roomTypeModel = new RoomType();
    }

    /** GET: Danh sách phòng */
    public function index(): void
    {
        $items = $this->model->getAll();
        $this->render('Room/index', ['items' => $items]);
    }

    /** GET: Form thêm */
    public function create(): void
    {
        $roomTypes = $this->roomTypeModel->getAll();
        $this->render('Room/create', ['roomTypes' => $roomTypes]);
    }

    /** POST: Lưu thêm */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room');
            return;
        }
        $data = [
            'room_type_id' => (int) $this->input('room_type_id'),
            'room_number'  => $this->input('room_number'),
            'status'       => $this->input('status', 'available'),
        ];
        $id = $this->model->create($data);
        $this->redirect($id ? '/admin.php?page=room&message=created' : '/admin.php?page=room&action=create&error=1');
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->model->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=room');
            return;
        }
        $roomTypes = $this->roomTypeModel->getAll();
        $this->render('Room/edit', ['item' => $item, 'roomTypes' => $roomTypes]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room&action=edit&id=' . $id);
            return;
        }
        $item = $this->model->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=room');
            return;
        }
        $data = [
            'room_type_id' => (int) $this->input('room_type_id'),
            'room_number'  => $this->input('room_number'),
            'status'       => $this->input('status', 'available'),
        ];
        $ok = $this->model->update($id, $data);
        $this->redirect($ok ? '/admin.php?page=room&message=updated' : '/admin.php?page=room&action=edit&id=' . $id . '&error=1');
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->model->delete($id);
        $this->redirect('admin.php?page=room&message=deleted');
    }
}
