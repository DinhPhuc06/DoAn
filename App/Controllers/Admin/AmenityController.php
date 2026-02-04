<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use PDO;

class AmenityController extends Controller
{
    private PDO $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function index(): void
    {
        $stmt = $this->pdo->query("SELECT * FROM amenities ORDER BY id DESC");
        $amenities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->useLayout = true;
        $this->render('Admin/amenities/index', [
            'title' => 'Quản lý tiện nghi - Admin',
            'pageTitle' => 'Quản Lý Tiện Nghi',
            'currentPage' => 'amenities',
            'amenities' => $amenities,
        ]);
    }

    public function create(): void
    {
        $this->useLayout = true;
        $this->render('Admin/amenities/form', [
            'title' => 'Thêm tiện nghi - Admin',
            'pageTitle' => 'Thêm Tiện Nghi Mới',
            'currentPage' => 'amenities',
            'amenity' => null,
        ]);
    }

    public function store(): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO amenities (name, icon) VALUES (?, ?)");
        $stmt->execute([$this->input('name'), $this->input('icon')]);
        $this->redirect('/admin/amenities');
    }

    public function edit(int $id): void
    {
        $stmt = $this->pdo->prepare("SELECT * FROM amenities WHERE id = ?");
        $stmt->execute([$id]);
        $amenity = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->useLayout = true;
        $this->render('Admin/amenities/form', [
            'title' => 'Sửa tiện nghi - Admin',
            'pageTitle' => 'Chỉnh Sửa Tiện Nghi',
            'currentPage' => 'amenities',
            'amenity' => $amenity,
        ]);
    }

    public function update(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE amenities SET name = ?, icon = ? WHERE id = ?");
        $stmt->execute([$this->input('name'), $this->input('icon'), $id]);
        $this->redirect('/admin/amenities');
    }

    public function destroy(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM amenities WHERE id = ?");
        $stmt->execute([$id]);
        $this->redirect('/admin/amenities');
    }
}
