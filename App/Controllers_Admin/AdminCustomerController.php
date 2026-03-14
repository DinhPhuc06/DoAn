<?php

namespace App\Controllers_Admin;

use App\Service\AdminCustomerService;

/**
 * Admin CRUD Khách hàng (users).
 * Controller chỉ điều phối request, toàn bộ validate/hash/CRUD nằm trong Service.
 */
class AdminCustomerController extends AdminBaseController
{
    private AdminCustomerService $customerService;

    public function __construct()
    {
        parent::__construct();
        $this->customerService = new AdminCustomerService();
    }

    /** GET: Danh sách khách hàng */
    public function index(): void
    {
        $items = $this->customerService->listCustomers();
        $this->render('Customer/index', ['items' => $items]);
    }

    /** GET: Form thêm mới */
    public function create(): void
    {
        $roles = $this->customerService->listRoles();
        $this->render('Customer/create', ['roles' => $roles]);
    }

    /** POST: Lưu thêm mới */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $result = $this->customerService->createFromRequest([
            'role_id'   => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email'     => $this->input('email'),
            'password'  => $this->input('password'),
            'phone'     => $this->input('phone'),
            'status'    => $this->input('status', 1),
        ]);

        if ($result['success']) {
            $this->redirect('admin.php?page=customer&message=created');
            return;
        }

        $this->redirect('admin.php?page=customer&action=create&error=1');
    }

    /** GET: Form sửa */
    public function edit(int $id): void
    {
        $item = $this->customerService->findCustomer($id);
        if (!$item) {
            $this->redirect('admin.php?page=customer');
            return;
        }
        $roles = $this->customerService->listRoles();
        $this->render('Customer/edit', ['item' => $item, 'roles' => $roles]);
    }

    /** POST: Cập nhật */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('admin.php?page=customer&action=edit&id=' . $id);
            return;
        }
        $result = $this->customerService->updateFromRequest($id, [
            'role_id'   => $this->input('role_id'),
            'full_name' => $this->input('full_name'),
            'email'     => $this->input('email'),
            'phone'     => $this->input('phone'),
            'status'    => $this->input('status', 1),
            'password'  => $this->input('password'),
        ]);

        $this->redirect(
            $result['success']
                ? '/admin.php?page=customer&message=updated'
                : '/admin.php?page=customer&action=edit&id=' . $id . '&error=1'
        );
    }

    /** POST/GET: Xóa */
    public function delete(int $id): void
    {
        $this->customerService->deleteCustomer($id);
        $this->redirect('admin.php?page=customer&message=deleted');
    }
}
