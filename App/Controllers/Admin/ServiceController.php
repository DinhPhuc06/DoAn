<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    private Service $serviceModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->serviceModel = new Service();
    }

    public function index(): void
    {
        $services = $this->serviceModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/services/index', [
            'title' => 'Quản lý dịch vụ - Admin',
            'pageTitle' => 'Quản Lý Dịch Vụ',
            'currentPage' => 'services',
            'services' => $services,
        ]);
    }

    public function create(): void
    {
        $this->useLayout = true;
        $this->render('Admin/services/form', [
            'title' => 'Thêm dịch vụ - Admin',
            'pageTitle' => 'Thêm Dịch Vụ Mới',
            'currentPage' => 'services',
            'service' => null,
        ]);
    }

    public function store(): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'price' => $this->input('price'),
            'unit' => $this->input('unit'),
        ];
        $this->serviceModel->create($data);
        $this->redirect('/admin/services');
    }

    public function edit(int $id): void
    {
        $service = $this->serviceModel->findById($id);
        $this->useLayout = true;
        $this->render('Admin/services/form', [
            'title' => 'Sửa dịch vụ - Admin',
            'pageTitle' => 'Chỉnh Sửa Dịch Vụ',
            'currentPage' => 'services',
            'service' => $service,
        ]);
    }

    public function update(int $id): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'price' => $this->input('price'),
            'unit' => $this->input('unit'),
        ];
        $this->serviceModel->update($id, $data);
        $this->redirect('/admin/services');
    }

    public function destroy(int $id): void
    {
        $this->serviceModel->delete($id);
        $this->redirect('/admin/services');
    }
}
