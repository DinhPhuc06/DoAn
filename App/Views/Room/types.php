<div class="container" style="padding-top: 120px;">
    <div class="section-header">
        <span class="section-subtitle">Phòng nghỉ</span>
        <h2 class="section-title">Các Loại Phòng Của Chúng Tôi</h2>
        <p class="section-desc">Khám phá không gian nghỉ dưỡng đa dạng hỗ trợ đầy đủ tiện nghi hiện đại</p>
    </div>

    <!-- Addons Info -->
    <?php if (!empty($addons)): ?>
        <div
            style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #eee; display: flex; align-items: center; gap: 20px;">
            <div style="font-size: 1.5rem;"><i class="fa-solid fa-gift"></i></div>
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <?php foreach ($addons as $a): ?>
                    <span style="font-size: 0.9rem; color: #666;">
                        <strong><?= htmlspecialchars($a['name']) ?>:</strong> <?= number_format($a['price'], 0, ',', '.') ?>đ
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="rooms-grid">
        <?php foreach ($roomTypes as $rt): ?>
            <div class="room-card">
                <div class="room-image">
                    <img src="<?= htmlspecialchars($rt['image_path'] ?? '/assets/image/image.png') ?>"
                        alt="<?= htmlspecialchars($rt['name']) ?>">
                    <?php if ($rt['base_price'] > 5000000): ?>
                        <span class="room-badge">Luxury</span>
                    <?php elseif ($rt['base_price'] > 2000000): ?>
                        <span class="room-badge">Premium</span>
                    <?php endif; ?>
                </div>
                <div class="room-content">
                    <h2 class="room-title"><?= htmlspecialchars($rt['name']) ?></h2>
                    <p
                        style="color: #666; font-size: 0.9rem; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.7rem;">
                        <?= htmlspecialchars($rt['description']) ?>
                    </p>
                    <div class="room-amenities">
                        <span><i class="fa-solid fa-users"></i> <?= $rt['capacity'] ?> Khách</span>
                        <span><i class="fa-solid fa-expand"></i> <?= $rt['size_m2'] ?>m²</span>
                        <span><i class="fa-solid fa-bed"></i> <?= $rt['capacity'] > 1 ? 'King Bed' : 'Single Bed' ?></span>
                    </div>
                    <div class="room-price">
                        <span class="amount"><?= number_format($rt['base_price'], 0, ',', '.') ?>đ</span>
                        <span class="period">/ đêm</span>
                    </div>
                    <div style="margin-top: 15px;">
                        <a href="/rooms/search?room_type_id=<?= $rt['id'] ?>" class="btn btn-primary"
                            style="width: 100%; border-radius: 8px;">Tìm Phòng Trống</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($roomTypes)): ?>
        <div style="text-align: center; padding: 50px; background: #fff; border-radius: 15px; border: 1px solid #eee;">
            <p style="font-size: 1.2rem; color: #666;">Hiện tại chưa có loại phòng nào được đăng ký.</p>
        </div>
    <?php endif; ?>
</div>