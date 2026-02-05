<?php

namespace App\Models;

use App\Core\Model;
use App\Core\BookingStatus;
use PDO;

/**
 * Model Room - Bảng room_details.
 * Dùng cho BOOKING FLOW: tìm phòng còn trống theo khoảng check-in/check-out, loại phòng.
 */
class Room extends Model
{
    protected string $table = 'room_details';

    protected array $fillable = [
        'room_type_id',
        'room_number',
        'floor',
        'status',
        'image_path',
    ];

    /**
     * Get all rooms with room type info
     */
    public function getAllWithType(): array
    {
        $sql = "
            SELECT r.*, rt.name AS room_type_name, rt.base_price
            FROM `{$this->table}` r
            LEFT JOIN `room_types` rt ON rt.id = r.room_type_id
            ORDER BY r.room_number ASC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Phòng còn trống trong khoảng [check_in, check_out] (không trùng lịch).
     * Chỉ lấy booking status theo BookingStatus::statusesThatBlockRoom(); cancelled không chặn.
     */
    public function getAvailableInRange(string $check_in, string $check_out, ?int $room_type_id = null): array
    {
        $blockStatuses = BookingStatus::statusesThatBlockRoom();
        $placeholders = implode(',', array_fill(0, count($blockStatuses), '?'));
        $sql = "
            SELECT r.*, rt.name AS room_type_name, rt.capacity, rt.base_price
            FROM `{$this->table}` r
            INNER JOIN `room_types` rt ON rt.id = r.room_type_id
            WHERE r.id NOT IN (
                SELECT bd.room_id
                FROM `bookings` b
                JOIN `booking_details` bd ON b.id = bd.booking_id
                WHERE b.status IN ($placeholders)
                AND NOT (b.check_out <= ? OR b.check_in >= ?)
            )
        ";
        $bind = array_merge($blockStatuses, [$check_in, $check_out]);
        if ($room_type_id !== null) {
            $sql .= " AND r.room_type_id = ?";
            $bind[] = $room_type_id;
        }
        $sql .= " ORDER BY rt.base_price ASC, r.room_number ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}

