<?php

namespace App\Models;

use App\Core\Model;

/**
 * Model RoomType - Bảng room_types.
 * Dùng cho BOOKING FLOW: xem danh sách loại phòng (name, capacity, base_price, addon qua Service).
 */
class RoomType extends Model
{
    protected string $table = 'room_types';

    protected array $fillable = [
        'name',
        'description',
        'size_m2',
        'capacity',
        'base_price',
    ];

    /**
     * Lấy tất cả loại phòng kèm ảnh chính
     */
    public function getAllWithImages(): array
    {
        // Ưu tiên:
        // 1. Ảnh của RoomType (room_id IS NULL) có is_primary = 1
        // 2. Ảnh của Room bất kỳ thuộc Type đó có is_primary = 1
        // 3. Ảnh mới nhất của RoomType
        // 4. Ảnh mới nhất của Room bất kỳ thuộc Type đó
        $sql = "
            SELECT rt.*, 
                   COALESCE(
                       (SELECT image_path FROM room_images WHERE room_type_id = rt.id AND room_id IS NULL AND is_primary = 1 LIMIT 1),
                       (SELECT image_path FROM room_images WHERE room_type_id = rt.id AND room_id IS NOT NULL AND is_primary = 1 ORDER BY id DESC LIMIT 1),
                       (SELECT image_path FROM room_images WHERE room_type_id = rt.id AND room_id IS NULL ORDER BY id DESC LIMIT 1),
                       (SELECT image_path FROM room_images WHERE room_type_id = rt.id ORDER BY id DESC LIMIT 1)
                   ) as image_path
            FROM `{$this->table}` rt
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Lấy chi tiết loại phòng kèm tất cả ảnh và tiện nghi
     */
    public function getFullDetail(int $id): ?array
    {
        $roomType = $this->findById($id);
        if (!$roomType)
            return null;

        // Lấy ảnh: Ưu tiên ảnh của Loại phòng trước, sau đó đến ảnh của từng Phòng cụ thể
        $sqlImages = "
            SELECT image_path, is_primary, room_id 
            FROM `room_images` 
            WHERE room_type_id = ? 
            ORDER BY (room_id IS NULL) DESC, is_primary DESC, id DESC
        ";
        $stmtImages = $this->pdo->prepare($sqlImages);
        $stmtImages->execute([$id]);
        $roomType['images'] = $stmtImages->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        // Lấy tiện nghi
        $sqlAmenities = "
            SELECT a.* 
            FROM `amenities` a
            JOIN `room_type_amenities` rta ON a.id = rta.amenity_id
            WHERE rta.room_type_id = ?
        ";
        $stmtAmenities = $this->pdo->prepare($sqlAmenities);
        $stmtAmenities->execute([$id]);
        $roomType['amenities'] = $stmtAmenities->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        return $roomType;
    }
}
