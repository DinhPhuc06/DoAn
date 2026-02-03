<?php
$bookingId = $bookingId ?? 0;
$booking = $booking ?? null;
$baseUrl = rtrim(APP_URL ?? '', '/');
$statusLabel = 'Chờ thanh toán';
$statusValue = $booking['status'] ?? 'pending';
if (class_exists('\App\Core\BookingStatus')) {
    $statusLabel = \App\Core\BookingStatus::label($statusValue);
}
$isPending = ($statusValue === 'pending');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng thành công - Booking Hotel</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; padding: 20px; }
        .container { max-width: 520px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .success { color: #2d8a3e; font-size: 48px; margin-bottom: 16px; }
        .status { display: inline-block; margin: 12px 0; padding: 8px 16px; border-radius: 6px; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .btn { display: inline-block; margin: 8px; padding: 12px 24px; background: #007bff; color: #fff; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #0056b3; }
        .btn-pay { background: #28a745; }
        .btn-pay:hover { background: #218838; }
        .flow { text-align: left; margin: 16px 0; padding: 12px; background: #f8f9fa; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success">✓</div>
        <h1>Đặt phòng thành công</h1>
        <p>Mã đặt phòng: <strong>#<?= (int)$bookingId ?></strong></p>
        <p>Trạng thái: <span class="status status-<?= htmlspecialchars($statusValue) ?>"><?= htmlspecialchars($statusLabel) ?></span></p>

        <div class="flow">
            <strong>Luồng trạng thái:</strong><br>
            Chờ thanh toán → Thanh toán (Momo/COD) → Đã xác nhận
        </div>

        <?php if ($isPending): ?>
        <p>Vui lòng thanh toán để xác nhận đặt phòng. Thanh toán (Momo) sẽ mở rộng sau.</p>
        <a href="<?= $baseUrl ?>/booking/pay?id=<?= (int)$bookingId ?>" class="btn btn-pay">Thanh toán</a>
        <?php endif; ?>

        <a href="<?= $baseUrl ?>/rooms" class="btn">Xem thêm phòng</a>
        <a href="<?= $baseUrl ?>/" class="btn">Về trang chủ</a>
    </div>
</body>
</html>
