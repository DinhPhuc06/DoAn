<?php
$roomTypes = $roomTypes ?? [];
$rooms = $rooms ?? [];
$checkIn = $checkIn ?? '';
$checkOut = $checkOut ?? '';
$roomTypeId = $roomTypeId ?? null;
$error = $error ?? null;
$baseUrl = rtrim(APP_URL ?? '', '/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm phòng - Booking Hotel</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .nav a { color: #007bff; text-decoration: none; margin-right: 15px; }
        .form-box { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-box label { display: inline-block; min-width: 100px; }
        .form-box input, .form-box select { padding: 8px; margin: 4px 0; }
        .btn { padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #333; color: #fff; }
        .link-booking { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav" style="margin-bottom:20px">
            <a href="<?= $baseUrl ?>/">Trang chủ</a>
            <a href="<?= $baseUrl ?>/rooms">Loại phòng</a>
        </div>
        <h1>Tìm phòng trống</h1>
        <p>Chọn ngày/giờ check-in, check-out và loại phòng để xem phòng còn trống (tránh đặt trùng).</p>

        <?php if ($error === 'missing'): ?><p style="color:#c00">Vui lòng nhập đầy đủ check-in/check-out.</p><?php endif; ?>
        <?php if ($error === 'dates'): ?><p style="color:#c00">Check-out phải sau check-in.</p><?php endif; ?>

        <div class="form-box">
            <form method="get" action="<?= $baseUrl ?>/rooms/search">
                <p>
                    <label>Check-in</label>
                    <input type="datetime-local" name="check_in" value="<?= htmlspecialchars($checkIn) ?>" required>
                </p>
                <p>
                    <label>Check-out</label>
                    <input type="datetime-local" name="check_out" value="<?= htmlspecialchars($checkOut) ?>" required>
                </p>
                <p>
                    <label>Loại phòng</label>
                    <select name="room_type_id">
                        <option value="">Tất cả</option>
                        <?php foreach ($roomTypes as $rt): ?>
                            <option value="<?= (int)($rt['id'] ?? 0) ?>" <?= $roomTypeId === (int)($rt['id'] ?? 0) ? 'selected' : '' ?>><?= htmlspecialchars($rt['name'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p><button type="submit" class="btn">Tìm phòng</button></p>
            </form>
        </div>

        <?php if ($checkIn && $checkOut): ?>
        <h2>Phòng còn trống (<?= count($rooms) ?> kết quả)</h2>
        <?php if (empty($rooms)): ?>
            <p>Không có phòng trống trong khoảng thời gian này.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr><th>Số phòng</th><th>Loại phòng</th><th>Sức chứa</th><th>Giá / đêm</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['room_number'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['room_type_name'] ?? '') ?></td>
                    <td><?= (int)($r['capacity'] ?? 0) ?></td>
                    <td><?= number_format((float)($r['base_price'] ?? 0)) ?> VND</td>
                    <td>
                        <a class="link-booking" href="<?= $baseUrl ?>/rooms/<?= (int)($r['id'] ?? 0) ?>?check_in=<?= urlencode($checkIn) ?>&check_out=<?= urlencode($checkOut) ?>">Chọn phòng</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
