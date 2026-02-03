<?php

namespace App\Service;

use App\Core\Database;
use App\Core\BookingStatus;
use App\Core\BookingException;
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


    /**
     * Validate input tạo booking.
     * Thành công: trả về payload chuẩn hoá.
     * Lỗi: ném BookingException với errorCode chuẩn ('missing', 'dates', 'unauthorized', 'room_not_found').
     *
     * @return array{
     *   user_id:int,
     *   room_id:int,
     *   check_in:string,
     *   check_out:string,
     *   total_price:float,
     *   check_in_local:string,
     *   check_out_local:string
     * }
     */
    public function validateCreateInput(int $user_id, int $room_id, string $check_in, string $check_out): array
    {
        $in = $this->parseDateTimeInput($check_in);
        $out = $this->parseDateTimeInput($check_out);
        if (!$in['ok'] || !$out['ok']) {
            throw new BookingException('missing', 'Missing or invalid datetime input');
        }
        if ($in['db'] >= $out['db']) {
            throw new BookingException('dates', 'Check-in must be before check-out');
        }
        if ($user_id <= 0) {
            throw new BookingException('unauthorized', 'User must be logged in to create booking');
        }
        $room = $this->roomModel->findById($room_id);
        if (!$room) {
            throw new BookingException('room_not_found', 'Room not found');
        }
        $roomType = $this->roomTypeModel->findById($room['room_type_id'] ?? 0);
        $basePrice = isset($roomType['base_price']) ? (float) $roomType['base_price'] : 0;
        $seconds = max(1, strtotime($out['db']) - strtotime($in['db']));
        $nights = max(1, (int) ceil($seconds / 86400)); // datetime chi tiết nhưng vẫn tính theo đêm
        $totalPrice = $basePrice * $nights;
        return [
            'user_id'     => $user_id,
            'room_id'     => $room_id,
            'check_in'    => $in['db'],
            'check_out'   => $out['db'],
            'total_price' => $totalPrice,
            // giá trị để set lại input datetime-local nếu cần
            'check_in_local'  => $in['local'],
            'check_out_local' => $out['local'],
        ];
    }


    /**
     * Tạo booking từ request.
     * - Thành công: trả về booking_id (int).
     * - Lỗi validate/business: ném BookingException với errorCode chuẩn hoá.
     * - Lỗi hệ thống: ném Throwable như cũ (để global handler xử lý).
     */
    public function createBookingFromRequest(array $data): int
    {
        $user_id = (int) ($data['user_id'] ?? 0);
        $room_id = (int) ($data['room_id'] ?? 0);
        $check_in = trim((string) ($data['check_in'] ?? ''));
        $check_out = trim((string) ($data['check_out'] ?? ''));

        // Validate & chuẩn hoá dữ liệu – ném BookingException nếu lỗi
        $payload = $this->validateCreateInput($user_id, $room_id, $check_in, $check_out);
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
                throw new BookingException('room_not_found', 'Room not found for locking');
            }

            // 2) Check availability (interval overlap) theo datetime
            $overlaps = $this->getOverlappingBookings($room_id, $check_in, $check_out, null, false);
            if (!empty($overlaps)) {
                $this->pdo->rollBack();
                throw new BookingException('unavailable', 'Room is not available in selected range');
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
                throw new BookingException('create_failed', 'Failed to create booking');
            }

            // 4. Insert booking_details
            $detailId = $this->bookingDetailModel->create([
                'booking_id' => $bookingId,
                'room_id'    => $room_id,
                'price'      => $total_price,
            ]);
            if (!$detailId) {
                $this->pdo->rollBack();
                throw new BookingException('create_failed', 'Failed to create booking detail');
            }

            $this->pdo->commit();
            return $bookingId;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }


    /**
     * Chuẩn hoá flow thay đổi status booking.
     * - Mọi thay đổi status phải đi qua đây.
     * - Lỗi: ném BookingException với errorCode ('not_found', 'invalid_transition').
     */
    public function updateStatus(int $bookingId, string $newStatus, ?string $paymentMethod = null, ?string $paymentAt = null): bool
    {
        $booking = $this->bookingModel->findById($bookingId);
        if (!$booking) {
            throw new BookingException('not_found', 'Booking not found');
        }
        $currentStatus = $booking['status'] ?? '';
        if (!BookingStatus::canTransitionTo($currentStatus, $newStatus)) {
            throw new BookingException('invalid_transition', "Cannot transition from {$currentStatus} to {$newStatus}");
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
