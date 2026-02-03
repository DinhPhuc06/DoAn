<?php

namespace App\Controllers_Admin;

use App\Models\Service;


class AdminServiceController extends AdminBaseController
{
    private Service $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Service();
    }

    /** GET: Danh sách */
    public function index(): void
    {
        $items = $this->model->getAll();
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
        $data = [
            'name'        => $this->input('name'),
            'price'       => $this->input('price') !== '' ? (float) $this->input('price') : null,
            'description' => $this->input('description'),
            'type'        => $this->input('type'),
            'is_active'   => (int) $this->input('is_active', 1),
        ];
        $id = $this->model->create($data);
        $this->redirect($id ? '/admin.php?page=service&message=created' : '/admin.php?page=service&action=create&error=1');
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->model->findById($id);
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
        $item = $this->model->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=service');
            return;
        }
        $data = [
            'name'        => $this->input('name'),
            'price'       => $this->input('price') !== '' ? (float) $this->input('price') : null,
            'description' => $this->input('description'),
            'type'        => $this->input('type'),
            'is_active'   => (int) $this->input('is_active', 1),
        ];
        $ok = $this->model->update($id, $data);
        $this->redirect($ok ? '/admin.php?page=service&message=updated' : '/admin.php?page=service&action=edit&id=' . $id . '&error=1');
    }

    /** Xóa */
    public function delete(int $id): void
    {
        $this->model->delete($id);
        $this->redirect('admin.php?page=service&message=deleted');
    }
}
