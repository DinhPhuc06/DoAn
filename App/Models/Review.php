<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/** Model Review - Bảng reviews. CRUD: getAll, findById, create, update, delete. */
class Review extends Model
{
    protected string $table = 'reviews';

    protected array $fillable = [
        'user_id',
        'room_id',
        'rating',
        'comment',
    ];

    /**
     * Lấy reviews theo room_type_id (qua room_details)
     * @param int $roomTypeId
     * @return array
     */
    public function getByRoomTypeId(int $roomTypeId): array
    {
        $sql = "
            SELECT r.*, u.full_name as user_name, rd.room_number
            FROM `{$this->table}` r
            JOIN `room_details` rd ON r.room_id = rd.id
            JOIN `users` u ON r.user_id = u.id
            WHERE rd.room_type_id = ?
            ORDER BY r.created_at DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$roomTypeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Tính rating trung bình theo room_type_id
     * @param int $roomTypeId
     * @return float|null
     */
    public function getAverageByRoomTypeId(int $roomTypeId): ?float
    {
        $sql = "
            SELECT AVG(r.rating) as avg_rating
            FROM `{$this->table}` r
            JOIN `room_details` rd ON r.room_id = rd.id
            WHERE rd.room_type_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$roomTypeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['avg_rating'] !== null ? round((float) $result['avg_rating'], 1) : null;
    }

    /**
     * Đếm số reviews theo room_type_id
     * @param int $roomTypeId
     * @return int
     */
    public function countByRoomTypeId(int $roomTypeId): int
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM `{$this->table}` r
            JOIN `room_details` rd ON r.room_id = rd.id
            WHERE rd.room_type_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$roomTypeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    /**
     * Kiểm tra user đã review room_type này chưa
     * @param int $userId
     * @param int $roomTypeId
     * @return bool
     */
    public function hasUserReviewedRoomType(int $userId, int $roomTypeId): bool
    {
        $sql = "
            SELECT COUNT(*) as cnt
            FROM `{$this->table}` r
            JOIN `room_details` rd ON r.room_id = rd.id
            WHERE r.user_id = ? AND rd.room_type_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $roomTypeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ((int) ($result['cnt'] ?? 0)) > 0;
    }

    /**
     * Lấy một room_id bất kỳ thuộc room_type_id (để tạo review)
     * @param int $roomTypeId
     * @return int|null
     */
    public function getFirstRoomIdByType(int $roomTypeId): ?int
    {
        $sql = "SELECT id FROM `room_details` WHERE room_type_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$roomTypeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['id'] : null;
    }
}

