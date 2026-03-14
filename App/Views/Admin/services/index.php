<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Dịch Vụ</h2>
<<<<<<< HEAD
        <a href="<?= \App\Core\url('/admin/services/create') ?>" class="admin-btn admin-btn-primary">
=======
        <a href="/admin/services/create" class="admin-btn admin-btn-primary">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
            <i class="fa-solid fa-plus"></i> Thêm Mới
        </a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Dịch Vụ</th>
                    <th>Giá</th>
                    <th>Đơn Vị</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td>#
                                <?= $service['id'] ?>
                            </td>
                            <td><strong>
                                    <?= htmlspecialchars($service['name']) ?>
                                </strong></td>
                            <td style="font-weight: 600; color: var(--admin-primary);">
                                <?= number_format($service['price'] ?? 0, 0, ',', '.') ?>đ
                            </td>
                            <td>
                                <?= htmlspecialchars($service['unit'] ?? '-') ?>
                            </td>
                            <td>
                                <div class="action-btns">
<<<<<<< HEAD
                                    <a href="<?= \App\Core\url('/admin/services/' . $service['id'] . '/edit') ?>" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="<?= \App\Core\url('/admin/services/' . $service['id'] . '/delete') ?>" method="POST"
=======
                                    <a href="/admin/services/<?= $service['id'] ?>/edit" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="/admin/services/<?= $service['id'] ?>/delete" method="POST"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
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
                        <td colspan="5" style="text-align: center; padding: 30px; color: #666;">Chưa có dịch vụ nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>