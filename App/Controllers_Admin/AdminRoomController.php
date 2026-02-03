<?php

namespace App\Controllers_Admin;

use App\Service\AdminRoomService;

/**
 * Admin CRUD Phòng (room_details).
 * Controller chỉ điều phối; validate/CRUD nằm trong Service.
 */
class AdminRoomController extends AdminBaseController
{
    private AdminRoomService $roomService;

    public function __construct()
    {
        parent::__construct();
        $this->roomService = new AdminRoomService();
    }

    /** GET: Danh sách phòng */
    public function index(): void
    {
        $items = $this->roomService->listRooms();
        $this->render('Room/index', ['items' => $items]);
    }

    /** GET: Form thêm */
    public function create(): void
    {
        $roomTypes = $this->roomService->listRoomTypes();
        $this->render('Room/create', ['roomTypes' => $roomTypes]);
    }

    /** POST: Lưu thêm */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room');
            return;
        }
        $result = $this->roomService->createFromRequest([
            'room_type_id' => $this->input('room_type_id'),
            'room_number'  => $this->input('room_number'),
            'status'       => $this->input('status', 'available'),
        ]);

        $this->redirect($result['success']
            ? '/admin.php?page=room&message=created'
            : '/admin.php?page=room&action=create&error=1'
        );
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->roomService->findRoom($id);
        if (!$item) {
            $this->redirect('admin.php?page=room');
            return;
        }
        $roomTypes = $this->roomService->listRoomTypes();
        $this->render('Room/edit', ['item' => $item, 'roomTypes' => $roomTypes]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=room&action=edit&id=' . $id);
            return;
        }
        $result = $this->roomService->updateFromRequest($id, [
            'room_type_id' => $this->input('room_type_id'),
            'room_number'  => $this->input('room_number'),
            'status'       => $this->input('status', 'available'),
        ]);

        $this->redirect($result['success']
            ? '/admin.php?page=room&message=updated'
            : '/admin.php?page=room&action=edit&id=' . $id . '&error=1'
        );
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->roomService->deleteRoom($id);
        $this->redirect('admin.php?page=room&message=deleted');
    }
}
