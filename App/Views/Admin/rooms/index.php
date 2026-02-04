<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Phòng</h2>
        <a href="/admin/rooms/create" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm Mới
        </a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Số Phòng</th>
                    <th>Loại Phòng</th>
                    <th>Tầng</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td>#
                                <?= $room['id'] ?>
                            </td>
                            <td><strong>
                                    <?= htmlspecialchars($room['room_number']) ?>
                                </strong></td>
                            <td>
                                <?= htmlspecialchars($room['room_type_name'] ?? '-') ?>
                            </td>
                            <td>Tầng
                                <?= $room['floor'] ?? '-' ?>
                            </td>
                            <td>
                                <?php
                                $status = $room['status'] ?? 'available';
                                $badgeClass = match ($status) {
                                    'available' => 'badge-success',
                                    'occupied' => 'badge-warning',
                                    'maintenance' => 'badge-danger',
                                    default => 'badge-info'
                                };
                                $statusText = match ($status) {
                                    'available' => 'Có sẵn',
                                    'occupied' => 'Đang sử dụng',
                                    'maintenance' => 'Bảo trì',
                                    default => ucfirst($status)
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/rooms/<?= $room['id'] ?>/edit" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="/admin/rooms/<?= $room['id'] ?>/delete" method="POST" style="display: inline;"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                        <button type="submit" class="action-btn action-btn-delete" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #666;">Chưa có phòng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>