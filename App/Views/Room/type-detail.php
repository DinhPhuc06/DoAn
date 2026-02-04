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
                <?php if (isset($avgRating) && $avgRating !== null): ?>
                    <span style="font-size: 1.5rem; margin-left: 15px;">
                        <i class="fa-solid fa-star" style="color: #ffc107;"></i>
                        <?= $avgRating ?>/5
                        <span style="font-size: 0.9rem; opacity: 0.8;">(<?= $reviewCount ?? 0 ?> đánh giá)</span>
                    </span>
                <?php endif; ?>
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

    <!-- Reviews Section -->
    <div id="reviews" style="margin-top: 60px;">
        <div style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
            <h3 style="margin-bottom: 30px; color: var(--dark); font-size: 1.8rem;">
                <i class="fa-solid fa-comments" style="color: var(--primary); margin-right: 10px;"></i>
                Đánh Giá Từ Khách Hàng
                <?php if (isset($reviewCount) && $reviewCount > 0): ?>
                <span style="font-size: 1rem; color: #666; font-weight: normal;">(<?= $reviewCount ?> đánh giá)</span>
                <?php endif; ?>
            </h3>

            <?php if (isset($_GET['review']) && $_GET['review'] === 'success'): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px;">
                <i class="fa-solid fa-check-circle"></i> Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được ghi nhận.
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px;">
                <i class="fa-solid fa-exclamation-circle"></i>
                <?php
                $errorMsg = match($_GET['error'] ?? '') {
                    'unauthorized' => 'Vui lòng đăng nhập để đánh giá.',
                    'invalid_rating' => 'Vui lòng chọn số sao từ 1-5.',
                    'room_required' => 'Không tìm thấy phòng để đánh giá.',
                    default => 'Có lỗi xảy ra, vui lòng thử lại.'
                };
                echo $errorMsg;
                ?>
            </div>
            <?php endif; ?>

            <!-- Average Rating Summary -->
            <?php if (isset($avgRating) && $avgRating !== null): ?>
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 15px;">
                <div style="text-align: center;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary);"><?= $avgRating ?></div>
                    <div style="color: #ffc107; font-size: 1.2rem;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-<?= $i <= round($avgRating) ? 'solid' : 'regular' ?> fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <div style="color: #666; font-size: 0.9rem; margin-top: 5px;"><?= $reviewCount ?? 0 ?> đánh giá</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Reviews List -->
            <?php if (!empty($reviews)): ?>
            <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px;">
                <?php foreach ($reviews as $review): ?>
                <div style="padding: 20px; background: #f8f9fa; border-radius: 15px; border-left: 4px solid var(--primary);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <div>
                            <strong style="color: var(--dark);"><?= htmlspecialchars($review['user_name'] ?? 'Khách hàng') ?></strong>
                            <span style="color: #666; font-size: 0.85rem; margin-left: 10px;">
                                - Phòng <?= htmlspecialchars($review['room_number'] ?? '') ?>
                            </span>
                        </div>
                        <div style="color: #ffc107;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa-<?= $i <= ($review['rating'] ?? 0) ? 'solid' : 'regular' ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p style="color: #555; line-height: 1.6; margin: 0;"><?= nl2br(htmlspecialchars($review['comment'] ?? '')) ?></p>
                    <div style="color: #999; font-size: 0.8rem; margin-top: 10px;">
                        <i class="fa-regular fa-clock"></i>
                        <?= date('d/m/Y H:i', strtotime($review['created_at'] ?? 'now')) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fa-regular fa-comment-dots" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
            </div>
            <?php endif; ?>

            <!-- Review Form -->
            <div id="review-form" style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #eee;">
                <h4 style="margin-bottom: 20px; color: var(--dark);">
                    <i class="fa-solid fa-pen" style="color: var(--primary); margin-right: 10px;"></i>
                    Viết Đánh Giá
                </h4>

                <?php
                $isLoggedIn = \App\Core\Auth::check();
                $userHasReviewed = $userHasReviewed ?? false;
                ?>

                <?php if (!$isLoggedIn): ?>
                <div style="text-align: center; padding: 30px; background: #f8f9fa; border-radius: 15px;">
                    <p style="color: #666; margin-bottom: 15px;">Vui lòng đăng nhập để viết đánh giá.</p>
                    <a href="/login" class="btn btn-primary" style="padding: 12px 30px; border-radius: 10px; text-decoration: none;">
                        <i class="fa-solid fa-sign-in-alt"></i> Đăng Nhập
                    </a>
                </div>
                <?php elseif ($userHasReviewed): ?>
                <div style="text-align: center; padding: 30px; background: #d4edda; border-radius: 15px; color: #155724;">
                    <i class="fa-solid fa-check-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
                    <p>Bạn đã đánh giá loại phòng này rồi. Cảm ơn bạn!</p>
                </div>
                <?php else: ?>
                <form action="/reviews" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                    <input type="hidden" name="room_type_id" value="<?= $roomType['id'] ?? 0 ?>">
                    <input type="hidden" name="room_id" value="<?= $defaultRoomId ?? 0 ?>">

                    <div>
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--dark);">
                            Đánh giá của bạn <span style="color: #dc3545;">*</span>
                        </label>
                        <div class="star-rating" style="font-size: 2rem; cursor: pointer;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-regular fa-star star-icon" data-rating="<?= $i ?>" 
                               style="color: #ffc107; transition: all 0.2s;"
                               onclick="document.getElementById('rating-input').value = <?= $i ?>; updateStars(<?= $i ?>);"></i>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="" required>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--dark);">
                            Nhận xét của bạn
                        </label>
                        <textarea name="comment" rows="4" 
                            style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: vertical; font-family: inherit;"
                            placeholder="Chia sẻ trải nghiệm của bạn về phòng này..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" 
                        style="padding: 15px 30px; font-size: 1.1rem; border-radius: 10px; align-self: flex-start;">
                        <i class="fa-solid fa-paper-plane"></i> Gửi Đánh Giá
                    </button>
                </form>

                <script>
                function updateStars(rating) {
                    const stars = document.querySelectorAll('.star-icon');
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.remove('fa-regular');
                            star.classList.add('fa-solid');
                        } else {
                            star.classList.remove('fa-solid');
                            star.classList.add('fa-regular');
                        }
                    });
                }

                // Hover effect
                document.querySelectorAll('.star-icon').forEach((star, index) => {
                    star.addEventListener('mouseenter', () => {
                        const rating = parseInt(star.dataset.rating);
                        document.querySelectorAll('.star-icon').forEach((s, i) => {
                            s.style.transform = i < rating ? 'scale(1.2)' : 'scale(1)';
                        });
                    });
                    star.addEventListener('mouseleave', () => {
                        document.querySelectorAll('.star-icon').forEach(s => {
                            s.style.transform = 'scale(1)';
                        });
                    });
                });
                </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>