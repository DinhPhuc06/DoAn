<?php

namespace App\Controllers_Admin;

use App\Models\RoomType;

/**
 * Admin CRUD Loại phòng (room_types). Điều phối request, dữ liệu ở Model.
 */
class AdminRoomTypeController extends AdminBaseController
{
    private RoomType $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new RoomType();
    }

    /** GET: Danh sách */
    public function index(): void
    {
        $items = $this->model->getAll();
        $this->render('Room_Types/index', ['items' => $items]);
    }

    /** GET: Form thêm */
    public function create(): void
    {
        $this->render('Room_Types/create');
    }

    /** POST: Lưu thêm */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room-type');
            return;
        }
        $data = [
            'name'       => $this->input('name'),
            'capacity'   => (int) $this->input('capacity'),
            'base_price' => $this->input('base_price') !== '' ? (float) $this->input('base_price') : null,
        ];
        $id = $this->model->create($data);
        $this->redirect($id ? '/admin.php?page=room-type&message=created' : '/admin.php?page=room-type&action=create&error=1');
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->model->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=room-type');
            return;
        }
        $this->render('Room_Types/edit', ['item' => $item]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room-type&action=edit&id=' . $id);
            return;
        }
        $item = $this->model->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=room-type');
            return;
        }
        $data = [
            'name'       => $this->input('name'),
            'capacity'   => (int) $this->input('capacity'),
            'base_price' => $this->input('base_price') !== '' ? (float) $this->input('base_price') : null,
        ];
        $ok = $this->model->update($id, $data);
        $this->redirect($ok ? '/admin.php?page=room-type&message=updated' : '/admin.php?page=room-type&action=edit&id=' . $id . '&error=1');
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->model->delete($id);
        $this->redirect('admin.php?page=room-type&message=deleted');
    }
}
