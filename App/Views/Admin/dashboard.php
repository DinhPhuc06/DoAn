<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>
                <?= number_format($totalUsers) ?>
            </h3>
            <p>Người dùng</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="stat-info">
            <h3>
                <?= number_format($totalRoomTypes) ?>
            </h3>
            <p>Loại phòng</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fa-solid fa-door-open"></i>
        </div>
        <div class="stat-info">
            <h3>
                <?= number_format($totalRooms) ?>
            </h3>
            <p>Phòng</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>
                <?= number_format($totalBookings) ?>
            </h3>
            <p>Đặt phòng</p>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><i class="fa-solid fa-clock-rotate-left"
                style="margin-right: 10px; color: var(--admin-primary);"></i>Đặt Phòng Gần Đây</h2>
        <a href="/admin/bookings" class="admin-btn admin-btn-outline admin-btn-sm">Xem tất cả</a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Phòng</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentBookings)): ?>
                    <?php foreach ($recentBookings as $booking): ?>
                        <tr>
                            <td>#
                                <?= $booking['id'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($booking['guest_name'] ?? 'N/A') ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($booking['room_number'] ?? 'N/A') ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($booking['check_in'])) ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($booking['check_out'])) ?>
                            </td>
                            <td>
                                <?php
                                $status = $booking['status'] ?? 'pending';
                                $badgeClass = match ($status) {
                                    'confirmed' => 'badge-success',
                                    'pending' => 'badge-warning',
                                    'cancelled' => 'badge-danger',
                                    'completed' => 'badge-info',
                                    default => 'badge-primary'
                                };
                                $statusText = match ($status) {
                                    'confirmed' => 'Đã xác nhận',
                                    'pending' => 'Chờ xử lý',
                                    'cancelled' => 'Đã hủy',
                                    'completed' => 'Hoàn thành',
                                    default => ucfirst($status)
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: var(--admin-primary);">
                                <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?>đ
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #666; padding: 30px;">Chưa có đặt phòng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><i class="fa-solid fa-bolt"
                style="margin-right: 10px; color: var(--admin-warning);"></i>Thao Tác Nhanh</h2>
    </div>
    <div class="admin-card-body">
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="/admin/users/create" class="admin-btn admin-btn-primary">
                <i class="fa-solid fa-user-plus"></i> Thêm người dùng
            </a>
            <a href="/admin/room-types/create" class="admin-btn admin-btn-success">
                <i class="fa-solid fa-plus"></i> Thêm loại phòng
            </a>
            <a href="/admin/rooms/create" class="admin-btn admin-btn-outline">
                <i class="fa-solid fa-door-open"></i> Thêm phòng
            </a>
            <a href="/admin/services/create" class="admin-btn admin-btn-outline">
                <i class="fa-solid fa-concierge-bell"></i> Thêm dịch vụ
            </a>
        </div>
    </div>
</div>