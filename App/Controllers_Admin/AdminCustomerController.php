<?php

namespace App\Controllers_Admin;

use App\Models\User;
use App\Models\Role;

/**
 * Admin CRUD Khách hàng (users). Chỉ điều phối request, dữ liệu xử lý ở Model.
 */
class AdminCustomerController extends AdminBaseController
{
    private User $userModel;
    private Role $roleModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    /** GET: Danh sách khách hàng */
    public function index(): void
    {
        $items = $this->userModel->getAll();
        $this->render('Customer/index', ['items' => $items]);
    }

    /** GET: Form thêm mới */
    public function create(): void
    {
        $roles = $this->roleModel->getAll();
        $this->render('Customer/create', ['roles' => $roles]);
    }

    /** POST: Lưu thêm mới */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $data = [
            'role_id'   => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email'     => $this->input('email'),
            'password'  => $this->input('password') ? password_hash($this->input('password'), PASSWORD_DEFAULT) : '',
            'phone'     => $this->input('phone'),
            'status'    => (int) $this->input('status', 1),
        ];
        if ($data['email'] && $data['password']) {
            $id = $this->userModel->create($data);
            if ($id) {
                $this->redirect('admin.php?page=customer&message=created');
                return;
            }
        }
        $this->redirect('admin.php?page=customer&action=create&error=1');
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->userModel->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $roles = $this->roleModel->getAll();
        $this->render('Customer/edit', ['item' => $item, 'roles' => $roles]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=customer&action=edit&id=' . $id);
            return;
        }
        $item = $this->userModel->findById($id);
        if (!$item) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $data = [
            'role_id'   => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email'     => $this->input('email'),
            'phone'     => $this->input('phone'),
            'status'    => (int) $this->input('status', 1),
        ];
        $password = $this->input('password');
        if ($password !== null && $password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $ok = $this->userModel->update($id, $data);
        $this->redirect($ok ? '/admin.php?page=customer&message=updated' : '/admin.php?page=customer&action=edit&id=' . $id . '&error=1');
    }

    /** POST/GET: Xóa */
    public function delete(int $id): void
    {
        $this->userModel->delete($id);
        $this->redirect('admin.php?page=customer&message=deleted');
    }
}
