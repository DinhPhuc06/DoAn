<?php

namespace App\Service;

use App\Core\BookingStatus;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;

/**
 * RoomService - gom toàn bộ logic tìm phòng/validate datetime để Controller mỏng.
 */
class RoomService
{
    private RoomType $roomTypeModel;
    private Room $roomModel;
    private Service $serviceModel;

    public function __construct()
    {
        $this->roomTypeModel = new RoomType();
        $this->roomModel = new Room();
        $this->serviceModel = new Service();
    }

    /** Xem loại phòng + addon services */
    public function getRoomTypesForDisplay(): array
    {
        return [
            'roomTypes' => $this->roomTypeModel->getAllForDisplay(),
            'addons'    => $this->serviceModel->getAddons(),
        ];
    }

    /**
     * Parse datetime input từ UI/URL sang DB datetime.
     * @return array{ok: bool, db: string, local: string}
     */
    public function parseDateTimeInput(string $value): array
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
     * Tìm phòng trống theo datetime (check-in/out), loại phòng.
     * Controller chỉ gọi method này và render kết quả.
     */
    public function searchAvailableRooms(?string $checkInRaw, ?string $checkOutRaw, ?int $roomTypeId): array
    {
        $roomTypes = $this->roomTypeModel->getAll();
        $rooms = [];

        $checkInRaw = (string) ($checkInRaw ?? '');
        $checkOutRaw = (string) ($checkOutRaw ?? '');

        $checkIn = $this->parseDateTimeInput($checkInRaw);
        $checkOut = $this->parseDateTimeInput($checkOutRaw);

        $error = null;
        if ($checkInRaw !== '' || $checkOutRaw !== '') {
            if (!$checkIn['ok'] || !$checkOut['ok']) {
                $error = 'missing';
            } elseif ($checkIn['db'] >= $checkOut['db']) {
                $error = 'dates';
            } else {
                $rooms = $this->roomModel->getAvailableInRange($checkIn['db'], $checkOut['db'], $roomTypeId);
            }
        }

        return [
            'roomTypes'  => $roomTypes,
            'rooms'      => $rooms,
            'checkIn'    => $checkIn['local'] ?: $checkInRaw,
            'checkOut'   => $checkOut['local'] ?: $checkOutRaw,
            'roomTypeId' => $roomTypeId,
            'error'      => $error,
        ];
    }
}
