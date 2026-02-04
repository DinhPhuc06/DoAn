<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <?= $roomType ? 'Chỉnh sửa' : 'Thêm mới' ?> Loại Phòng
        </h2>
        <a href="/admin/room-types" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
        <form action="<?= $roomType ? '/admin/room-types/' . $roomType['id'] . '/update' : '/admin/room-types/store' ?>"
            method="POST">
            <div class="admin-form-group">
                <label>Tên Loại Phòng <span style="color: red;">*</span></label>
                <input type="text" name="name" class="admin-form-control"
                    value="<?= htmlspecialchars($roomType['name'] ?? '') ?>" required>
            </div>

            <div class="admin-form-group">
                <label>Mô Tả</label>
                <textarea name="description" class="admin-form-control"
                    rows="4"><?= htmlspecialchars($roomType['description'] ?? '') ?></textarea>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Sức Chứa (người) <span style="color: red;">*</span></label>
                    <input type="number" name="capacity" class="admin-form-control"
                        value="<?= $roomType['capacity'] ?? 2 ?>" min="1" required>
                </div>
                <div class="admin-form-group">
                    <label>Diện Tích (m²)</label>
                    <input type="number" name="size_m2" class="admin-form-control"
                        value="<?= $roomType['size_m2'] ?? '' ?>" min="1">
                </div>
            </div>

            <div class="admin-form-group">
                <label>Giá Cơ Bản (VNĐ/đêm) <span style="color: red;">*</span></label>
                <input type="number" name="base_price" class="admin-form-control"
                    value="<?= $roomType['base_price'] ?? '' ?>" min="0" required>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="fa-solid fa-save"></i>
                    <?= $roomType ? 'Cập Nhật' : 'Thêm Mới' ?>
                </button>
            </div>
        </form>
    </div>
</div>