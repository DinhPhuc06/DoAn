<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <?= $service ? 'Chỉnh sửa' : 'Thêm mới' ?> Dịch Vụ
        </h2>
<<<<<<< HEAD
        <a href="<?= \App\Core\url('/admin/services') ?>" class="admin-btn admin-btn-outline">
=======
        <a href="/admin/services" class="admin-btn admin-btn-outline">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
<<<<<<< HEAD
        <form action="<?= \App\Core\url($service ? '/admin/services/' . $service['id'] . '/update' : '/admin/services/store') ?>"
=======
        <form action="<?= $service ? '/admin/services/' . $service['id'] . '/update' : '/admin/services/store' ?>"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
            method="POST">
            <div class="admin-form-group">
                <label>Tên Dịch Vụ <span style="color: red;">*</span></label>
                <input type="text" name="name" class="admin-form-control"
                    value="<?= htmlspecialchars($service['name'] ?? '') ?>" required>
            </div>

            <div class="admin-form-group">
                <label>Mô Tả</label>
                <textarea name="description" class="admin-form-control"
                    rows="3"><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Giá (VNĐ) <span style="color: red;">*</span></label>
                    <input type="number" name="price" class="admin-form-control" value="<?= $service['price'] ?? '' ?>"
                        min="0" required>
                </div>
                <div class="admin-form-group">
                    <label>Đơn Vị</label>
                    <input type="text" name="unit" class="admin-form-control"
                        value="<?= htmlspecialchars($service['unit'] ?? '') ?>" placeholder="VD: lần, giờ, ngày">
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="fa-solid fa-save"></i>
                    <?= $service ? 'Cập Nhật' : 'Thêm Mới' ?>
                </button>
            </div>
        </form>
    </div>
</div>