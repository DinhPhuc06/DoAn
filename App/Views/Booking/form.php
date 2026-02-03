<?php
$room = $room ?? null;
$roomType = $roomType ?? null;
$checkIn = $checkIn ?? '';
$checkOut = $checkOut ?? '';
$error = $_GET['error'] ?? '';
if (!$room) { echo 'Không tìm thấy phòng.'; return; }
$baseUrl = rtrim(APP_URL ?? '', '/');
$nights = 1;
if ($checkIn && $checkOut) {
    $nights = max(1, (strtotime($checkOut) - strtotime($checkIn)) / 86400);
}
$pricePerNight = (float)($roomType['base_price'] ?? 0);
$totalPrice = $pricePerNight * $nights;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng - Booking Hotel</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .nav a { color: #007bff; text-decoration: none; margin-right: 15px; }
        label { display: inline-block; min-width: 120px; }
        input[type="datetime-local"], input[type="text"] { padding: 8px; margin: 4px 0; width: 260px; }
        .error { color: #c00; margin-bottom: 10px; }
        .btn { padding: 12px 24px; background: #007bff; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .summary { margin: 16px 0; padding: 12px; background: #f0f0f0; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav" style="margin-bottom:16px">
            <a href="<?= $baseUrl ?>/rooms/search">← Tìm phòng</a>
        </div>
        <h1>Đặt phòng</h1>
        <p>Phòng: <strong><?= htmlspecialchars($room['room_number'] ?? '') ?></strong> - <?= htmlspecialchars($roomType['name'] ?? '') ?></p>

        <?php if ($error === 'missing'): ?><p class="error">Vui lòng nhập đầy đủ ngày check-in và check-out.</p><?php endif; ?>
        <?php if ($error === 'dates'): ?><p class="error">Ngày check-out phải sau check-in.</p><?php endif; ?>
        <?php if ($error === 'unavailable'): ?><p class="error">Phòng không còn trống trong khoảng thời gian này (hoặc đã bị đặt trùng). Vui lòng chọn ngày khác.</p><?php endif; ?>
        <?php if ($error === 'room_not_found'): ?><p class="error">Không tìm thấy phòng.</p><?php endif; ?>
        <?php if ($error === 'create_failed'): ?><p class="error">Không thể tạo đặt phòng. Vui lòng thử lại.</p><?php endif; ?>

        <form method="post" action="<?= $baseUrl ?>/booking/store">
            <input type="hidden" name="room_id" value="<?= (int)($room['id'] ?? 0) ?>">
            <p>
                <label>Check-in</label>
                <input type="datetime-local" name="check_in" value="<?= htmlspecialchars($checkIn) ?>" required>
            </p>
            <p>
                <label>Check-out</label>
                <input type="datetime-local" name="check_out" value="<?= htmlspecialchars($checkOut) ?>" required>
            </p>
            <div class="summary">
                <strong>Tạm tính:</strong> <?= $nights ?> đêm × <?= number_format($pricePerNight) ?> VND = <strong><?= number_format($totalPrice) ?> VND</strong>
            </div>
            <p>
                <button type="submit" class="btn">Xác nhận đặt phòng</button>
            </p>
        </form>
        <p style="color:#666;font-size:14px">Bạn cần đăng nhập để đặt phòng. Sau khi tạo, đặt phòng ở trạng thái <strong>Chờ thanh toán</strong>; thanh toán thành công sẽ chuyển sang <strong>Đã xác nhận</strong>.</p>
    </div>
</body>
</html>
