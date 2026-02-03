<?php
$room = $room ?? null;
$roomType = $roomType ?? null;
if (!$room) { echo 'Không tìm thấy phòng.'; return; }
$checkIn = $_GET['check_in'] ?? '';
$checkOut = $_GET['check_out'] ?? '';
$baseUrl = rtrim(APP_URL ?? '', '/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn phòng <?= htmlspecialchars($room['room_number'] ?? '') ?> - Booking Hotel</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .nav a { color: #007bff; text-decoration: none; margin-right: 15px; }
        .price { font-size: 24px; color: #2d8a3e; font-weight: bold; }
        .btn { display: inline-block; margin-top: 16px; padding: 12px 24px; background: #007bff; color: #fff; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav" style="margin-bottom:16px">
            <a href="<?= $baseUrl ?>/rooms/search">← Tìm phòng</a>
        </div>
        <h1>Phòng <?= htmlspecialchars($room['room_number'] ?? '') ?></h1>
        <p><strong>Loại:</strong> <?= htmlspecialchars($roomType['name'] ?? '') ?></p>
        <p><strong>Sức chứa:</strong> <?= (int)($roomType['capacity'] ?? 0) ?> người</p>
        <p class="price"><?= number_format((float)($roomType['base_price'] ?? 0)) ?> VND / đêm</p>
        <p>Bạn đã chọn phòng này. Nhấn "Đặt phòng" để nhập thông tin và tạo booking.</p>
        <?php
        $query = http_build_query([
            'room_id' => $room['id'],
            'check_in' => $checkIn,
            'check_out' => $checkOut,
        ]);
        ?>
        <a href="<?= $baseUrl ?>/booking/form?<?= $query ?>" class="btn">Đặt phòng</a>
    </div>
</body>
</html>
