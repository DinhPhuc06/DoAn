<?php

namespace App\Service;

use App\Models\Review;
use PDO;

/**
 * ReviewService - Xử lý logic nghiệp vụ cho đánh giá phòng
 */
class ReviewService
{
    private Review $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review();
    }

    /**
     * Lấy danh sách reviews theo room_type_id
     * @param int $roomTypeId
     * @return array
     */
    public function getReviewsByRoomTypeId(int $roomTypeId): array
    {
        return $this->reviewModel->getByRoomTypeId($roomTypeId);
    }

    /**
     * Tính rating trung bình theo room_type_id
     * @param int $roomTypeId
     * @return float|null
     */
    public function getAverageRating(int $roomTypeId): ?float
    {
        return $this->reviewModel->getAverageByRoomTypeId($roomTypeId);
    }

    /**
     * Tạo review mới
     * @param array $data [user_id, room_id, rating, comment]
     * @return array{success: bool, error?: string, review_id?: int}
     */
    public function createReview(array $data): array
    {
        // Validate required fields
        if (empty($data['user_id'])) {
            return ['success' => false, 'error' => 'unauthorized'];
        }
        if (empty($data['room_id'])) {
            return ['success' => false, 'error' => 'room_required'];
        }
        if (!isset($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
            return ['success' => false, 'error' => 'invalid_rating'];
        }

        // Create review
        $reviewId = $this->reviewModel->create([
            'user_id' => (int) $data['user_id'],
            'room_id' => (int) $data['room_id'],
            'rating' => (int) $data['rating'],
            'comment' => trim($data['comment'] ?? ''),
        ]);

        if ($reviewId) {
            return ['success' => true, 'review_id' => $reviewId];
        }

        return ['success' => false, 'error' => 'create_failed'];
    }

    /**
     * Kiểm tra user đã review room_type này chưa
     * @param int $userId
     * @param int $roomTypeId
     * @return bool
     */
    public function hasUserReviewedRoomType(int $userId, int $roomTypeId): bool
    {
        return $this->reviewModel->hasUserReviewedRoomType($userId, $roomTypeId);
    }
}
