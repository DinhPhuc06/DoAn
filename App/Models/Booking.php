<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/** Model Booking - Bảng bookings. CRUD: getAll, findById, create, update, delete. */
class Booking extends Model
{
    protected string $table = 'bookings';

    protected array $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'type',
        'event_type',
        'payment_menthod',
        'payment_at',
    ];

    /**
     * Get recent bookings with user and room info
     */
    public function getRecent(int $limit = 5): array
    {
        $sql = "SELECT b.*, 
                       u.full_name as guest_name,
                       r.room_number
                FROM bookings b
                LEFT JOIN users u ON b.user_id = u.id
                LEFT JOIN booking_details bd ON bd.booking_id = b.id
                LEFT JOIN room_details r ON bd.room_id = r.id
                ORDER BY b.created_at DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Get all bookings with user info
     */
    public function getAllWithDetails(): array
    {
        $sql = "SELECT b.*, 
                       u.full_name as guest_name, u.email, u.phone
                FROM bookings b
                LEFT JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Get booking detail by ID
     */
    public function getDetailById(int $id): ?array
    {
        $sql = "SELECT b.*, 
                       u.full_name as guest_name, u.email, u.phone
                FROM bookings b
                LEFT JOIN users u ON b.user_id = u.id
                WHERE b.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        return $booking ?: null;
    }
}

