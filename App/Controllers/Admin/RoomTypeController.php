<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\RoomType;
use PDO;

class RoomTypeController extends Controller
{
    private RoomType $roomTypeModel;
    private \App\Models\RoomImage $roomImageModel;
    private \App\Service\CloudinaryService $cloudinaryService;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->roomTypeModel = new RoomType();
        $this->roomImageModel = new \App\Models\RoomImage();
        $this->cloudinaryService = new \App\Service\CloudinaryService();
    }

    public function index(): void
    {
        $roomTypes = $this->roomTypeModel->getAll();
        $this->useLayout = true;
        $this->render('Admin/room-types/index', [
            'title' => 'Quản lý loại phòng - Admin',
            'pageTitle' => 'Quản Lý Loại Phòng',
            'currentPage' => 'room-types',
            'roomTypes' => $roomTypes,
        ]);
    }

    public function create(): void
    {
        $this->useLayout = true;
        $this->render('Admin/room-types/form', [
            'title' => 'Thêm loại phòng - Admin',
            'pageTitle' => 'Thêm Loại Phòng Mới',
            'currentPage' => 'room-types',
            'roomType' => null,
        ]);
    }

    public function store(): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'capacity' => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
            'size_m2' => $this->input('size_m2'),
        ];
        $id = $this->roomTypeModel->create($data);

        // Handle image uploads
        if ($id && !empty($_FILES['images']['tmp_name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if (empty($tmpName))
                    continue;

                $imageUrl = $this->cloudinaryService->upload($tmpName);
                if ($imageUrl) {
                    $this->roomImageModel->create([
                        'room_type_id' => $id,
                        'image_path' => $imageUrl,
                        'is_primary' => ($index === 0) ? 1 : 0
                    ]);
                }
            }
        }

        $this->redirect('/admin/room-types');
    }

    public function edit(int $id): void
    {
        $roomType = $this->roomTypeModel->getFullDetail($id);

        // Use the primary image path if available for the form view
        if (!empty($roomType['images'])) {
            foreach ($roomType['images'] as $img) {
                if ($img['is_primary']) {
                    $roomType['image_path'] = $img['image_path'];
                    break;
                }
            }
        }

        $this->useLayout = true;
        $this->render('Admin/room-types/form', [
            'title' => 'Sửa loại phòng - Admin',
            'pageTitle' => 'Chỉnh Sửa Loại Phòng',
            'currentPage' => 'room-types',
            'roomType' => $roomType,
        ]);
    }

    public function update(int $id): void
    {
        $data = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'capacity' => $this->input('capacity'),
            'base_price' => $this->input('base_price'),
            'size_m2' => $this->input('size_m2'),
        ];
        $this->roomTypeModel->update($id, $data);

        // Handle image uploads
        if (!empty($_FILES['images']['tmp_name'][0])) {
            // Optional: delete old images if user wants a complete refresh, or keep them.
            // For simplicity, we'll keep existing and just add new ones here.
            // If the user wants to clear, they'd need a delete button per image.

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if (empty($tmpName))
                    continue;

                $imageUrl = $this->cloudinaryService->upload($tmpName);
                if ($imageUrl) {
                    // Check if there are any existing images to decide on is_primary
                    $existing = $this->roomImageModel->getByRoomTypeId($id);
                    $this->roomImageModel->create([
                        'room_type_id' => $id,
                        'image_path' => $imageUrl,
                        'is_primary' => empty($existing) ? 1 : 0
                    ]);
                }
            }
        }

        $this->redirect('/admin/room-types');
    }

    public function destroy(int $id): void
    {
        $this->roomTypeModel->delete($id);
        $this->redirect('/admin/room-types');
    }
}
