<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Loại Phòng</h2>
        <a href="/admin/room-types/create" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm Mới
        </a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Loại Phòng</th>
                    <th>Sức Chứa</th>
                    <th>Diện Tích</th>
                    <th>Giá Cơ Bản</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($roomTypes)): ?>
                    <?php foreach ($roomTypes as $rt): ?>
                        <tr>
                            <td>#
                                <?= $rt['id'] ?>
                            </td>
                            <td><strong>
                                    <?= htmlspecialchars($rt['name']) ?>
                                </strong></td>
                            <td>
                                <?= $rt['capacity'] ?> người
                            </td>
                            <td>
                                <?= $rt['size_m2'] ?? '-' ?> m²
                            </td>
                            <td style="font-weight: 600; color: var(--admin-primary);">
                                <?= number_format($rt['base_price'], 0, ',', '.') ?>đ
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/room-types/<?= $rt['id'] ?>/edit" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="/admin/room-types/<?= $rt['id'] ?>/delete" method="POST"
                                        style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                        <td colspan="6" style="text-align: center; padding: 30px; color: #666;">Chưa có loại phòng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>