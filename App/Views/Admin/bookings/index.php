<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Đặt Phòng</h2>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#
                                <?= $booking['id'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($booking['guest_name'] ?? 'N/A') ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($booking['check_in'] ?? 'now')) ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($booking['check_out'] ?? 'now')) ?>
                            </td>
                            <td style="font-weight: 600; color: var(--admin-primary);">
                                <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?>đ
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
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="action-btn action-btn-view"
                                        title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="/admin/bookings/<?= $booking['id'] ?>/status" method="POST"
                                        style="display: inline;">
                                        <select name="status" onchange="this.form.submit()"
                                            style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; font-size: 0.8rem;">
                                            <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Chờ xử lý
                                            </option>
                                            <option value="confirmed" <?= $status === 'confirmed' ? 'selected' : '' ?>>Xác nhận
                                            </option>
                                            <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Hoàn thành
                                            </option>
                                            <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Hủy</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #666;">Chưa có đặt phòng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>