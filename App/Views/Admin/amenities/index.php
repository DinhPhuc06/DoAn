<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Tiện Nghi</h2>
        <a href="/admin/amenities/create" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm Mới
        </a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tiện Nghi</th>
                    <th>Icon</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($amenities)): ?>
                    <?php foreach ($amenities as $amenity): ?>
                        <tr>
                            <td>#
                                <?= $amenity['id'] ?>
                            </td>
                            <td><strong>
                                    <?= htmlspecialchars($amenity['name']) ?>
                                </strong></td>
                            <td><i class="<?= htmlspecialchars($amenity['icon'] ?? 'fa-solid fa-check') ?>"></i></td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/amenities/<?= $amenity['id'] ?>/edit" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="/admin/amenities/<?= $amenity['id'] ?>/delete" method="POST"
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
                        <td colspan="4" style="text-align: center; padding: 30px; color: #666;">Chưa có tiện nghi nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>