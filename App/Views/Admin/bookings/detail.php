<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Chi Tiết Đặt Phòng #
            <?= $booking['id'] ?? '' ?>
        </h2>
        <a href="/admin/bookings" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
        <?php if ($booking): ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h3 style="margin-bottom: 20px; color: var(--admin-text);"><i class="fa-solid fa-user"
                            style="margin-right: 10px; color: var(--admin-primary);"></i>Thông Tin Khách Hàng</h3>
                    <p><strong>Tên:</strong>
                        <?= htmlspecialchars($booking['guest_name'] ?? 'N/A') ?>
                    </p>
                    <p><strong>Email:</strong>
                        <?= htmlspecialchars($booking['email'] ?? 'N/A') ?>
                    </p>
                    <p><strong>Điện thoại:</strong>
                        <?= htmlspecialchars($booking['phone'] ?? 'N/A') ?>
                    </p>
                </div>
                <div>
                    <h3 style="margin-bottom: 20px; color: var(--admin-text);"><i class="fa-solid fa-calendar"
                            style="margin-right: 10px; color: var(--admin-primary);"></i>Thông Tin Đặt Phòng</h3>
                    <p><strong>Check-in:</strong>
                        <?= date('d/m/Y', strtotime($booking['check_in'] ?? 'now')) ?>
                    </p>
                    <p><strong>Check-out:</strong>
                        <?= date('d/m/Y', strtotime($booking['check_out'] ?? 'now')) ?>
                    </p>
                    <p><strong>Tổng tiền:</strong> <span
                            style="font-size: 1.3rem; font-weight: 700; color: var(--admin-primary);">
                            <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?>đ
                        </span></p>
                    <p><strong>Trạng thái:</strong>
                        <?php
                        $status = $booking['status'] ?? 'pending';
                        $badgeClass = match ($status) {
                            'confirmed' => 'badge-success',
                            'pending' => 'badge-warning',
                            'cancelled' => 'badge-danger',
                            'completed' => 'badge-info',
                            default => 'badge-primary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #666;">Không tìm thấy thông tin đặt phòng.</p>
        <?php endif; ?>
    </div>
</div>