<?php

namespace App\Service;

use App\Core\Database;
use App\Core\BookingStatus;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Room;
use App\Models\RoomType;
use PDO;


class BookingService
{
    private PDO $pdo;
    private Booking $bookingModel;
    private BookingDetail $bookingDetailModel;
    private Room $roomModel;
    private RoomType $roomTypeModel;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
        $this->bookingModel = new Booking();
        $this->bookingDetailModel = new BookingDetail();
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
    }


    public function getOverlappingBookings(
        int $room_id,
        string $check_in,
        string $check_out,
        ?int $exclude_booking_id = null,
        bool $forUpdate = false
    ): array {
        $blockStatuses = BookingStatus::statusesThatBlockRoom();
        $placeholders = implode(',', array_fill(0, count($blockStatuses), '?'));
        $sql = "
            SELECT b.*, bd.room_id, bd.price
            FROM bookings b
            JOIN booking_details bd ON b.id = bd.booking_id
            WHERE bd.room_id = ?
            AND b.status IN ($placeholders)
            AND NOT (b.check_out <= ? OR b.check_in >= ?)
        ";
        if ($exclude_booking_id !== null) {
            $sql .= " AND b.id != ?";
        }
        if ($forUpdate) {
            $sql .= " FOR UPDATE";
        }
        $bind = array_merge([$room_id], $blockStatuses, [$check_in, $check_out]);
        if ($exclude_booking_id !== null) {
            $bind[] = $exclude_booking_id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function isRoomAvailable(int $room_id, string $check_in, string $check_out, ?int $exclude_booking_id = null): bool
    {
        $overlaps = $this->getOverlappingBookings($room_id, $check_in, $check_out, $exclude_booking_id, false);
        return empty($overlaps);
    }

    /**
     * Parse datetime input từ UI/URL sang DB datetime.
     * Chấp nhận: `Y-m-d\TH:i` (datetime-local), `Y-m-d H:i`, `Y-m-d H:i:s`.
     * @return array{ok: bool, db: string, local: string}
     */
    private function parseDateTimeInput(string $value): array
    {
        $value = trim($value);
        if ($value === '') {
            return ['ok' => false, 'db' => '', 'local' => ''];
        }

        $formats = ['Y-m-d\TH:i', 'Y-m-d H:i:s', 'Y-m-d H:i'];
        foreach ($formats as $fmt) {
            $dt = \DateTimeImmutable::createFromFormat($fmt, $value);
            if ($dt instanceof \DateTimeImmutable) {
                return [
                    'ok'    => true,
                    'db'    => $dt->format('Y-m-d H:i:s'),
                    'local' => $dt->format('Y-m-d\TH:i'),
                ];
            }
        }

        $ts = strtotime($value);
        if ($ts === false) {
            return ['ok' => false, 'db' => '', 'local' => ''];
        }
        $dt = (new \DateTimeImmutable())->setTimestamp($ts);
        return [
            'ok'    => true,
            'db'    => $dt->format('Y-m-d H:i:s'),
            'local' => $dt->format('Y-m-d\TH:i'),
        ];
    }


    public function validateCreateInput(int $user_id, int $room_id, string $check_in, string $check_out): array
    {
        $in = $this->parseDateTimeInput($check_in);
        $out = $this->parseDateTimeInput($check_out);
        if (!$in['ok'] || !$out['ok']) {
            return ['valid' => false, 'error' => 'missing', 'data' => []];
        }
        if ($in['db'] >= $out['db']) {
            return ['valid' => false, 'error' => 'dates', 'data' => []];
        }
        if ($user_id <= 0) {
            return ['valid' => false, 'error' => 'unauthorized', 'data' => []];
        }
        $room = $this->roomModel->findById($room_id);
        if (!$room) {
            return ['valid' => false, 'error' => 'room_not_found', 'data' => []];
        }
        $roomType = $this->roomTypeModel->findById($room['room_type_id'] ?? 0);
        $basePrice = isset($roomType['base_price']) ? (float) $roomType['base_price'] : 0;
        $seconds = max(1, strtotime($out['db']) - strtotime($in['db']));
        $nights = max(1, (int) ceil($seconds / 86400)); // datetime chi tiết nhưng vẫn tính theo đêm
        $totalPrice = $basePrice * $nights;
        return [
            'valid'       => true,
            'error'       => null,
            'data'        => [
                'user_id'     => $user_id,
                'room_id'     => $room_id,
                'check_in'    => $in['db'],
                'check_out'   => $out['db'],
                'total_price' => $totalPrice,
                // giá trị để set lại input datetime-local nếu cần
                'check_in_local'  => $in['local'],
                'check_out_local' => $out['local'],
            ],
        ];
    }


    public function createBookingFromRequest(array $data): array
    {
        $user_id = (int) ($data['user_id'] ?? 0);
        $room_id = (int) ($data['room_id'] ?? 0);
        $check_in = trim((string) ($data['check_in'] ?? ''));
        $check_out = trim((string) ($data['check_out'] ?? ''));

        $validation = $this->validateCreateInput($user_id, $room_id, $check_in, $check_out);
        if (!$validation['valid']) {
            return [
                'success'    => false,
                'booking_id' => null,
                'error'      => $validation['error'],
            ];
        }

        $payload = $validation['data'];
        $check_in = $payload['check_in'];
        $check_out = $payload['check_out'];
        $total_price = $payload['total_price'];

        $this->pdo->beginTransaction();
        try {
            // 1) LOCK room row (chống race): mọi booking cùng room_id sẽ serialize
            $lockRoom = $this->pdo->prepare("SELECT id FROM room_details WHERE id = ? FOR UPDATE");
            $lockRoom->execute([$room_id]);
            $locked = $lockRoom->fetch(PDO::FETCH_ASSOC);
            if (!$locked) {
                $this->pdo->rollBack();
                return ['success' => false, 'booking_id' => null, 'error' => 'room_not_found'];
            }

            // 2) Check availability (interval overlap) theo datetime
            $overlaps = $this->getOverlappingBookings($room_id, $check_in, $check_out, null, false);
            if (!empty($overlaps)) {
                $this->pdo->rollBack();
                return ['success' => false, 'booking_id' => null, 'error' => 'unavailable'];
            }

            // 3. Insert booking (status theo luồng: mới tạo = pending, chờ thanh toán)
            $bookingId = $this->bookingModel->create([
                'user_id'     => $user_id,
                'check_in'    => $check_in,
                'check_out'   => $check_out,
                'total_price' => $total_price,
                'status'      => BookingStatus::defaultStatus(),
                'type'        => 'room',
            ]);
            if (!$bookingId) {
                $this->pdo->rollBack();
                return ['success' => false, 'booking_id' => null, 'error' => 'create_failed'];
            }

            // 4. Insert booking_details
            $detailId = $this->bookingDetailModel->create([
                'booking_id' => $bookingId,
                'room_id'    => $room_id,
                'price'      => $total_price,
            ]);
            if (!$detailId) {
                $this->pdo->rollBack();
                return ['success' => false, 'booking_id' => null, 'error' => 'create_failed'];
            }

            $this->pdo->commit();
            return ['success' => true, 'booking_id' => $bookingId, 'error' => null];
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }


    public function updateStatus(int $bookingId, string $newStatus, ?string $paymentMethod = null, ?string $paymentAt = null): bool
    {
        $booking = $this->bookingModel->findById($bookingId);
        if (!$booking) {
            return false;
        }
        $currentStatus = $booking['status'] ?? '';
        if (!BookingStatus::canTransitionTo($currentStatus, $newStatus)) {
            return false;
        }
        $data = ['status' => $newStatus];
        if ($paymentMethod !== null) {
            $data['payment_menthod'] = $paymentMethod;
        }
        if ($paymentAt !== null) {
            $data['payment_at'] = $paymentAt;
        }
        return $this->bookingModel->update($bookingId, $data);
    }
}
