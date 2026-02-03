<?php

namespace App\Core;


final class BookingStatus
{
    public const PENDING   = 'pending';
    public const CONFIRMED = 'confirmed';
    public const CANCELLED = 'cancelled';

    private static ?array $config = null;

    private static function config(): array
    {
        if (self::$config === null) {
            $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'booking_status.php';
            self::$config = is_file($path) ? require $path : [];
        }
        return self::$config;
    }

    /** Trạng thái mặc định khi tạo booking mới */
    public static function defaultStatus(): string
    {
        return self::config()['default'] ?? self::PENDING;
    }

    /** Nhãn hiển thị theo status */
    public static function label(string $status): string
    {
        $config = self::config();
        return $config[$status]['label'] ?? $status;
    }

    /** Có được chuyển sang trạng thái mới không */
    public static function canTransitionTo(string $currentStatus, string $newStatus): bool
    {
        $config = self::config();
        $allowed = $config['transitions'][$currentStatus] ?? [];
        return in_array($newStatus, $allowed, true);
    }

    /** Các trạng thái được coi là "giữ phòng" (overlap check) */
    public static function statusesThatBlockRoom(): array
    {
        return self::config()['blocks_room'] ?? [self::PENDING, self::CONFIRMED];
    }

    /** Danh sách tất cả status (value => label) */
    public static function allLabels(): array
    {
        $config = self::config();
        $out = [];
        foreach (['pending', 'confirmed', 'cancelled'] as $key) {
            if (isset($config[$key])) {
                $out[$config[$key]['value']] = $config[$key]['label'];
            }
        }
        return $out;
    }
}
