<?php
$payments = $payments ?? [];
$bookings = $bookings ?? [];

$totalRevenue = 0;

foreach ($payments as $p) {
    if (($p['status'] ?? '') === 'success') {
        $totalRevenue += $p['amount'];
    }
}
?>
<div class="admin-revenue">
    <h2>Thanh toán</h2>
    <table class="admin-table" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking ID</th>
                <th>Phương thức</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $row): ?>
                <tr>
                    <td><?= (int)($row['id'] ?? 0) ?></td>
                    <td><?= (int)($row['booking_id'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($row['method'] ?? '') ?></td>
                    <td><?= \App\Core\money((float)($row['amount'] ?? 0)) ?></td>
                    <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['paid_at'] ?? $row['created_at'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($payments)): ?>
                <tr><td colspan="6">Chưa có dữ liệu.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2 style="margin-top: 2rem;">Đặt phòng</h2>
    <table class="admin-table" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $row): ?>
                <tr>
                    <td><?= (int)($row['id'] ?? 0) ?></td>
                    <td><?= (int)($row['user_id'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($row['check_in'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['check_out'] ?? '') ?></td>
                    <td><?= \App\Core\money((float)($row['total_price'] ?? 0)) ?></td>
                    <td><?= \App\Core\BookingStatus::label($row['status'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($bookings)): ?>
                <tr><td colspan="6">Chưa có dữ liệu.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div style="margin-bottom:20px; padding:15px; background:#f2f2f2;">
    <h3>Tổng doanh thu</h3>
    <p style="font-size:24px;color:green;">
        <?= \App\Core\money($totalRevenue) ?>
    </p>
</div>
