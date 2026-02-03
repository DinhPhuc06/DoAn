<?php

namespace App\Controllers_Admin;

use App\Service\AdminServiceService;

class AdminServiceController extends AdminBaseController
{
    private AdminServiceService $serviceService;

    public function __construct()
    {
        parent::__construct();
        $this->serviceService = new AdminServiceService();
    }

    /** GET: Danh sách */
    public function index(): void
    {
        $items = $this->serviceService->listServices();
        $this->render('Services/index', ['items' => $items]);
    }

    /** GET: Form thêm */
    public function create(): void
    {
        $this->render('Services/create');
    }

    /** POST: Lưu thêm */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=service');
            return;
        }
        $result = $this->serviceService->createFromRequest([
            'name'        => $this->input('name'),
            'price'       => $this->input('price'),
            'description' => $this->input('description'),
            'type'        => $this->input('type'),
            'is_active'   => $this->input('is_active', 1),
        ]);

        $this->redirect(
            $result['success']
                ? '/admin.php?page=service&message=created'
                : '/admin.php?page=service&action=create&error=1'
        );
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->serviceService->findService($id);
        if (!$item) {
            $this->redirect('admin.php?page=service');
            return;
        }
        $this->render('Services/edit', ['item' => $item]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=service&action=edit&id=' . $id);
            return;
        }
        $result = $this->serviceService->updateFromRequest($id, [
            'name'        => $this->input('name'),
            'price'       => $this->input('price'),
            'description' => $this->input('description'),
            'type'        => $this->input('type'),
            'is_active'   => $this->input('is_active', 1),
        ]);

        $this->redirect(
            $result['success']
                ? '/admin.php?page=service&message=updated'
                : '/admin.php?page=service&action=edit&id=' . $id . '&error=1'
        );
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->serviceService->deleteService($id);
        $this->redirect('admin.php?page=service&message=deleted');
    }
}
