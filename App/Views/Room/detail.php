<div class="container" style="padding-top: 100px; max-width: 1100px;">
    <div class="nav" style="margin-bottom: 30px;">
        <a href="/rooms/search?check_in=<?= urlencode($checkIn) ?>&check_out=<?= urlencode($checkOut) ?>"
            style="color: var(--primary); font-weight: 500;">← Quay lại tìm kiếm</a>
    </div>

    <div
        style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <!-- Left: Images -->
        <div class="room-gallery">
            <div style="border-radius: 15px; overflow: hidden; margin-bottom: 20px; height: 400px;">
                <?php
                $primaryImage = '/assets/image/image.png';
                if (!empty($roomType['images'])) {
                    foreach ($roomType['images'] as $img) {
                        if ($img['is_primary'])
                            $primaryImage = $img['image_path'];
                    }
                }
                ?>
                <img src="<?= htmlspecialchars($primaryImage) ?>" alt="<?= htmlspecialchars($roomType['name']) ?>"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <?php if (!empty($roomType['images']) && count($roomType['images']) > 1): ?>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                    <?php foreach ($roomType['images'] as $img): ?>
                        <div style="height: 80px; border-radius: 8px; overflow: hidden; cursor: pointer;">
                            <img src="<?= htmlspecialchars($img['image_path']) ?>"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Info & Booking -->
        <div class="room-info">
            <span style="color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Phòng
                <?= htmlspecialchars($room['room_number']) ?></span>
            <h1 style="font-size: 2.5rem; margin: 10px 0 20px;"><?= htmlspecialchars($roomType['name']) ?></h1>

            <div class="room-amenities" style="margin-bottom: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <span><i class="fa-solid fa-users"></i> <strong>Sức chứa:</strong> <?= $roomType['capacity'] ?>
                        người</span>
                    <span><i class="fa-solid fa-expand"></i> <strong>Diện tích:</strong>
                        <?= $roomType['size_m2'] ?>m²</span>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h4 style="margin-bottom: 15px;">Mô tả phòng:</h4>
                <p style="color: #666; line-height: 1.6;"><?= nl2br(htmlspecialchars($roomType['description'])) ?></p>
            </div>

            <div style="margin-bottom: 30px;">
                <h4 style="margin-bottom: 15px;">Tiện nghi:</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php if (!empty($roomType['amenities'])): ?>
                        <?php foreach ($roomType['amenities'] as $amenity): ?>
                            <span
                                style="background: #f8f9fa; padding: 8px 15px; border-radius: 20px; font-size: 0.9rem; border: 1px solid #eee;">
                                <?= htmlspecialchars($amenity['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div style="background: #fdf8f4; padding: 25px; border-radius: 15px; border: 1px solid #ffe8d6;">
                <div class="room-price" style="margin-bottom: 20px; display: flex; align-items: baseline; gap: 5px;">
                    <span class="amount"
                        style="font-size: 2rem;"><?= number_format($roomType['base_price'], 0, ',', '.') ?>đ</span>
                    <span class="period">/ đêm</span>
                </div>

                <?php
                $query = http_build_query([
                    'room_id' => $room['id'],
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                ]);
                ?>
                <a href="/booking/form?<?= $query ?>" class="btn btn-primary"
                    style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 10px;">Tiếp Tục Đặt Phòng</a>
            </div>
        </div>
    </div>
</div>