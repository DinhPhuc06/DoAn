<!-- Hero Slider Section -->
<section class="hero">
    <div class="hero-slide active">
        <img src="/assets/image/image.png" alt="Luxury Hotel" class="hero-image">
        <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
        <span class="hero-subtitle animate-fade-up">Chào mừng đến với</span>
        <h1 class="hero-title animate-fade-up delay-1">Trải Nghiệm Nghỉ Dưỡng<br>Đẳng Cấp 5 Sao</h1>
        <p class="hero-desc animate-fade-up delay-2">
            Khám phá không gian nghỉ dưỡng sang trọng với view biển tuyệt đẹp,
            dịch vụ hoàn hảo và những trải nghiệm không thể nào quên.
        </p>
        <div class="hero-buttons animate-fade-up delay-3">
            <a href="/rooms" class="btn hero-btn btn-white">Xem Phòng</a>
            <a href="/rooms/search" class="btn hero-btn btn-primary">Đặt Phòng Ngay</a>
        </div>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <form class="search-form" action="/rooms/search" method="GET">
            <div class="form-group">
                <label>Ngày nhận phòng</label>
                <input type="date" name="check_in" required>
            </div>
            <div class="form-group">
                <label>Ngày trả phòng</label>
                <input type="date" name="check_out" required>
            </div>
            <div class="form-group">
                <label>Số khách</label>
                <select name="guests">
                    <option value="1">1 Khách</option>
                    <option value="2" selected>2 Khách</option>
                    <option value="3">3 Khách</option>
                    <option value="4">4 Khách</option>
                </select>
            </div>
            <div class="form-group">
                <label>Loại phòng</label>
                <select name="room_type_id">
                    <option value="">Tất cả</option>
                    <?php foreach ($roomTypes as $rt): ?>
                        <option value="<?= $rt['id'] ?>">
                            <?= htmlspecialchars($rt['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary search-btn">Tìm Phòng</button>
        </form>
    </div>
</section>

<!-- Features Section -->
<section class="section" id="features" style="padding-top: 120px;">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Tại sao chọn chúng tôi</span>
            <h2 class="section-title">Dịch Vụ Đẳng Cấp</h2>
            <p class="section-desc">
                Chúng tôi cam kết mang đến cho bạn những trải nghiệm tuyệt vời nhất
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-swimming-pool"></i></div>
                <h3 class="feature-title">Hồ Bơi Vô Cực</h3>
                <p class="feature-desc">
                    Thư giãn tại hồ bơi vô cực với tầm nhìn ra đại dương xanh ngắt
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-utensils"></i></div>
                <h3 class="feature-title">Ẩm Thực 5 Sao</h3>
                <p class="feature-desc">
                    Thưởng thức những món ăn tinh tế từ các đầu bếp hàng đầu
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-spa"></i></div>
                <h3 class="feature-title">Spa & Wellness</h3>
                <p class="feature-desc">
                    Chăm sóc sức khỏe toàn diện với các liệu pháp thư giãn cao cấp
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shuttle-van"></i></div>
                <h3 class="feature-title">Đưa Đón Sân Bay</h3>
                <p class="feature-desc">
                    Dịch vụ đưa đón sân bay miễn phí với xe sang trọng
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Rooms Preview Section -->
<section class="section" style="background: #fff;">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Phòng nghỉ</span>
            <h2 class="section-title">Các Loại Phòng Nổi Bật</h2>
            <p class="section-desc">
                Lựa chọn không gian nghỉ ngơi phù hợp với nhu cầu của bạn
            </p>
        </div>

        <div class="rooms-grid">
            <?php
            $displayRooms = array_slice($roomTypes, 0, 8);
            foreach ($displayRooms as $rt):
                ?>
                <div class="room-card">
                    <a href="/room-types/<?= $rt['id'] ?>" class="room-image" style="display: block;">
                        <img src="<?= htmlspecialchars($rt['image_path'] ?? '/assets/image/image.png') ?>"
                            alt="<?= htmlspecialchars($rt['name']) ?>">
                        <?php if ($rt['base_price'] > 5000000): ?>
                            <span class="room-badge">Luxury</span>
                        <?php elseif ($rt['base_price'] > 2000000): ?>
                            <span class="room-badge">Premium</span>
                        <?php endif; ?>
                    </a>
                    <div class="room-content">
                        <a href="/room-types/<?= $rt['id'] ?>" style="text-decoration: none; color: inherit;">
                            <h3 class="room-title"><?= htmlspecialchars($rt['name']) ?></h3>
                        </a>
                        <div class="room-amenities">
                            <span><i class="fa-solid fa-users"></i> <?= $rt['capacity'] ?> Khách</span>
                            <span><i class="fa-solid fa-expand"></i> <?= $rt['size_m2'] ?? '?' ?>m²</span>
                            <span><i class="fa-solid fa-bed"></i>
                                <?= $rt['capacity'] > 1 ? 'King Bed' : 'Single Bed' ?></span>
                        </div>
                        <div class="room-price">
                            <span class="amount"><?= number_format($rt['base_price'], 0, ',', '.') ?>đ</span>
                            <span class="period">/ đêm</span>
                        </div>
                        <div style="margin-top: 15px;">
                            <a href="/rooms/search?room_type_id=<?= $rt['id'] ?>" class="btn btn-outline"
                                style="width: 100%; border-radius: 8px; padding: 10px;">Đặt Ngay</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($roomTypes) > 8): ?>
            <div style="text-align: center; margin-top: 50px;">
                <a href="/rooms" class="btn btn-primary">Xem Tất Cả Phòng</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="section"
    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Sẵn Sàng Cho Kỳ Nghỉ Của Bạn?</h2>
        <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 30px; opacity: 0.9;">
            Đặt phòng ngay hôm nay để nhận ưu đãi lên đến 30% cho lần đặt phòng đầu tiên
        </p>
        <a href="/rooms/search" class="btn hero-btn btn-white">Đặt Phòng Ngay</a>
    </div>
</section>