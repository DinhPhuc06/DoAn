<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    private User $userModel;
    private Role $roleModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    public function index(): void
    {
        $users = $this->userModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/users/index', [
            'title' => 'Quản lý người dùng - Admin',
            'pageTitle' => 'Quản Lý Người Dùng',
            'currentPage' => 'users',
            'users' => $users,
        ]);
    }

    public function create(): void
    {
        $roles = $this->roleModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/users/form', [
            'title' => 'Thêm người dùng - Admin',
            'pageTitle' => 'Thêm Người Dùng Mới',
            'currentPage' => 'users',
            'roles' => $roles,
            'user' => null,
        ]);
    }

    public function store(): void
    {
        $data = [
            'role_id' => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email' => $this->input('email'),
            'password' => password_hash($this->input('password'), PASSWORD_DEFAULT),
            'phone' => $this->input('phone'),
            'status' => $this->input('status') ?? 'active',
        ];
        $this->userModel->create($data);
        $this->redirect('/admin/users');
    }

    public function edit(int $id): void
    {
        $user = $this->userModel->findById($id);
        $roles = $this->roleModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/users/form', [
            'title' => 'Sửa người dùng - Admin',
            'pageTitle' => 'Chỉnh Sửa Người Dùng',
            'currentPage' => 'users',
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(int $id): void
    {
        $data = [
            'role_id' => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'status' => $this->input('status'),
        ];
        if ($this->input('password')) {
            $data['password'] = password_hash($this->input('password'), PASSWORD_DEFAULT);
        }
        $this->userModel->update($id, $data);
        $this->redirect('/admin/users');
    }

    public function destroy(int $id): void
    {
        $this->userModel->delete($id);
        $this->redirect('/admin/users');
    }
}
