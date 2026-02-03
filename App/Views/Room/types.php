<?php
$roomTypes = $roomTypes ?? [];
$addons = $addons ?? [];
$baseUrl = rtrim(APP_URL ?? '', '/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem phòng - Booking Hotel</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { color: #333; }
        .nav { margin-bottom: 20px; }
        .nav a { color: #007bff; text-decoration: none; margin-right: 15px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .card-img { height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px; }
        .card-body { padding: 16px; }
        .card-title { margin: 0 0 8px; font-size: 18px; }
        .card-meta { color: #666; font-size: 14px; margin-bottom: 8px; }
        .card-price { font-size: 20px; font-weight: bold; color: #2d8a3e; }
        .card-addons { font-size: 12px; color: #888; margin-top: 8px; }
        .btn { display: inline-block; margin-top: 12px; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #0056b3; }
        .addon-list { margin: 20px 0; padding: 15px; background: #e7f3ff; border-radius: 8px; }
        .addon-list h3 { margin-top: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="<?= $baseUrl ?>/">Trang chủ</a>
            <a href="<?= $baseUrl ?>/rooms/search">Tìm phòng</a>
        </div>
        <h1>Loại phòng</h1>
        <p>Chọn loại phòng và ngày ở để tìm phòng còn trống.</p>

        <?php if (!empty($addons)): ?>
        <div class="addon-list">
            <h3>Dịch vụ addon (đi kèm)</h3>
            <ul>
                <?php foreach ($addons as $a): ?>
                    <li><?= htmlspecialchars($a['name'] ?? '') ?> - <?= number_format((float)($a['price'] ?? 0)) ?> VND</li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="grid">
            <?php foreach ($roomTypes as $rt): ?>
            <div class="card">
                <div class="card-img" title="Hình ảnh loại phòng (có thể thêm cột image_url vào room_types)">🛏</div>
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($rt['name'] ?? '') ?></h2>
                    <div class="card-meta">Sức chứa: <?= (int)($rt['capacity'] ?? 0) ?> người</div>
                    <div class="card-price"><?= number_format((float)($rt['base_price'] ?? 0)) ?> VND / đêm</div>
                    <div class="card-addons">Dịch vụ addon: xem bảng trên</div>
                    <a href="<?= $baseUrl ?>/rooms/search?room_type_id=<?= (int)($rt['id'] ?? 0) ?>" class="btn">Tìm phòng trống</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($roomTypes)): ?>
            <p>Chưa có loại phòng.</p>
        <?php endif; ?>
    </div>
</body>
</html>
