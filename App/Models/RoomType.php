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
        $sql = "
            SELECT rt.*, ri.image_path 
            FROM `{$this->table}` rt
            LEFT JOIN `room_images` ri ON rt.id = ri.room_type_id AND ri.is_primary = 1
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

        // Lấy ảnh
        $sqlImages = "SELECT image_path, is_primary FROM `room_images` WHERE room_type_id = ?";
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
