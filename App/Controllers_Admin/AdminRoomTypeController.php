<?php

namespace App\Controllers_Admin;

use App\Service\AdminRoomTypeService;

/**
 * Admin CRUD Loại phòng (room_types).
 * Controller chỉ điều phối; logic CRUD/validate nằm trong Service.
 */
class AdminRoomTypeController extends AdminBaseController
{
    private AdminRoomTypeService $roomTypeService;

    public function __construct()
    {
        parent::__construct();
        $this->roomTypeService = new AdminRoomTypeService();
    }

    /** GET: Danh sách */
    public function index(): void
    {
        $items = $this->roomTypeService->listRoomTypes();
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
        $result = $this->roomTypeService->createFromRequest([
            'name'       => $this->input('name'),
            'capacity'   => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
        ]);

        $this->redirect(
            $result['success']
                ? '/admin.php?page=room-type&message=created'
                : '/admin.php?page=room-type&action=create&error=1'
        );
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->roomTypeService->findRoomType($id);
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
        $result = $this->roomTypeService->updateFromRequest($id, [
            'name'       => $this->input('name'),
            'capacity'   => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
        ]);

        $this->redirect(
            $result['success']
                ? '/admin.php?page=room-type&message=updated'
                : '/admin.php?page=room-type&action=edit&id=' . $id . '&error=1'
        );
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->roomTypeService->deleteRoomType($id);
        $this->redirect('admin.php?page=room-type&message=deleted');
    }
}
