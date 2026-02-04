<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Review extends Model
{
    protected string $table = 'reviews';

    protected array $fillable = [
        'user_id',
        'room_id',
        'rating',
        'comment',
    ];

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

    public function getFirstRoomIdByType(int $roomTypeId): ?int
    {
        $sql = "SELECT id FROM `room_details` WHERE room_type_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$roomTypeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['id'] : null;
    }
}

