<style>
    .type-detail-hero {
        position: relative;
        height: 60vh;
        min-height: 400px;
        overflow: hidden;
    }

    .type-detail-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .type-detail-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
    }

    .type-detail-hero-content {
        position: absolute;
        bottom: 40px;
        left: 0;
        right: 0;
        z-index: 10;
        color: #fff;
    }

    .type-detail-gallery {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .type-detail-gallery img {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .type-detail-gallery img:hover,
    .type-detail-gallery img.active {
        border-color: var(--primary);
    }

    .type-info-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        margin-top: -80px;
        position: relative;
        z-index: 20;
    }

    .type-info-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .type-booking-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 0.95rem;
    }

    .amenity-item i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .type-specs {
        display: flex;
        gap: 30px;
        margin: 25px 0;
        padding: 20px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .type-spec {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .type-spec i {
        width: 45px;
        height: 45px;
        background: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
    }

    .type-spec-info span {
        display: block;
        font-size: 0.85rem;
        color: #666;
    }

    .type-spec-info strong {
        font-size: 1.1rem;
        color: var(--dark);
    }

    @media (max-width: 992px) {
        .type-info-grid {
            grid-template-columns: 1fr;
            margin-top: -40px;
        }

        .type-booking-card {
            position: static;
        }
    }
</style>

<?php
$primaryImage = '/assets/image/image.png';
if (!empty($roomType['images'])) {
    foreach ($roomType['images'] as $img) {
        if ($img['is_primary'])
            $primaryImage = $img['image_path'];
    }
}
?>

<!-- Hero Image -->
<div class="type-detail-hero">
    <img src="<?= htmlspecialchars($primaryImage) ?>" alt="<?= htmlspecialchars($roomType['name']) ?>" id="mainImage">
    <div class="type-detail-hero-content">
        <div class="container">
            <?php if ($roomType['base_price'] > 5000000): ?>
                <span
                    style="background: var(--secondary); color: var(--dark); padding: 8px 20px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; margin-bottom: 15px; display: inline-block;">Luxury</span>
            <?php elseif ($roomType['base_price'] > 2000000): ?>
                <span
                    style="background: var(--secondary); color: var(--dark); padding: 8px 20px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; margin-bottom: 15px; display: inline-block;">Premium</span>
            <?php endif; ?>
            <h1 style="font-size: 3rem; margin-bottom: 10px;">
                <?= htmlspecialchars($roomType['name']) ?>
            </h1>

            <!-- Gallery Thumbnails -->
            <?php if (!empty($roomType['images']) && count($roomType['images']) > 1): ?>
                <div class="type-detail-gallery">
                    <?php foreach ($roomType['images'] as $index => $img): ?>
                        <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="Gallery <?= $index + 1 ?>"
                            onclick="document.getElementById('mainImage').src = this.src; document.querySelectorAll('.type-detail-gallery img').forEach(i => i.classList.remove('active')); this.classList.add('active');"
                            class="<?= $img['is_primary'] ? 'active' : '' ?>">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container" style="padding-bottom: 80px;">
    <div class="type-info-grid">
        <!-- Left: Room Info -->
        <div class="type-info-card">
            <!-- Specs -->
            <div class="type-specs">
                <div class="type-spec">
                    <i class="fa-solid fa-users"></i>
                    <div class="type-spec-info">
                        <span>Sức chứa</span>
                        <strong>
                            <?= $roomType['capacity'] ?> Người
                        </strong>
                    </div>
                </div>
                <div class="type-spec">
                    <i class="fa-solid fa-expand"></i>
                    <div class="type-spec-info">
                        <span>Diện tích</span>
                        <strong>
                            <?= $roomType['size_m2'] ?> m²
                        </strong>
                    </div>
                </div>
                <div class="type-spec">
                    <i class="fa-solid fa-bed"></i>
                    <div class="type-spec-info">
                        <span>Giường</span>
                        <strong>
                            <?= $roomType['capacity'] > 2 ? '2 Beds' : ($roomType['capacity'] > 1 ? 'King Bed' : 'Single Bed') ?>
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; color: var(--dark);"><i class="fa-solid fa-info-circle"
                        style="color: var(--primary); margin-right: 10px;"></i>Mô Tả Phòng</h3>
                <p style="color: #666; line-height: 1.8; font-size: 1rem;">
                    <?= nl2br(htmlspecialchars($roomType['description'])) ?>
                </p>
            </div>

            <!-- Amenities -->
            <div>
                <h3 style="margin-bottom: 15px; color: var(--dark);"><i class="fa-solid fa-star"
                        style="color: var(--primary); margin-right: 10px;"></i>Tiện Nghi</h3>
                <?php if (!empty($roomType['amenities'])): ?>
                    <div class="amenities-grid">
                        <?php foreach ($roomType['amenities'] as $amenity): ?>
                            <div class="amenity-item">
                                <i class="fa-solid fa-check-circle"></i>
                                <?= htmlspecialchars($amenity['name']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: #666;">Thông tin tiện nghi đang được cập nhật.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Booking Card -->
        <div class="type-booking-card">
            <div style="text-align: center; margin-bottom: 25px;">
                <span style="font-size: 0.9rem; color: #666;">Giá chỉ từ</span>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">
                    <?= number_format($roomType['base_price'], 0, ',', '.') ?>đ
                </div>
                <span style="color: #666;">/ đêm</span>
            </div>

            <form action="/rooms/search" method="GET" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="hidden" name="room_type_id" value="<?= $roomType['id'] ?>">

                <div class="form-group">
                    <label><i class="fa-solid fa-calendar-check"
                            style="color: var(--primary); margin-right: 5px;"></i>Ngày nhận phòng</label>
                    <input type="date" name="check_in" required style="width: 100%;">
                </div>

                <div class="form-group">
                    <label><i class="fa-solid fa-calendar-xmark"
                            style="color: var(--primary); margin-right: 5px;"></i>Ngày trả phòng</label>
                    <input type="date" name="check_out" required style="width: 100%;">
                </div>

                <button type="submit" class="btn btn-primary"
                    style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 10px; margin-top: 10px;">
                    <i class="fa-solid fa-search"></i> Kiểm Tra Phòng Trống
                </button>
            </form>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <div
                    style="display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.9rem; margin-bottom: 10px;">
                    <i class="fa-solid fa-shield-check" style="color: #28a745;"></i>
                    Đặt phòng an toàn và bảo mật
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: #666; font-size: 0.9rem;">
                    <i class="fa-solid fa-clock" style="color: var(--primary);"></i>
                    Xác nhận đặt phòng ngay lập tức
                </div>
            </div>
        </div>
    </div>
</div>