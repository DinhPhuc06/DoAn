<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <?= $amenity ? 'Chỉnh sửa' : 'Thêm mới' ?> Tiện Nghi
        </h2>
        <a href="/admin/amenities" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
        <form action="<?= $amenity ? '/admin/amenities/' . $amenity['id'] . '/update' : '/admin/amenities/store' ?>"
            method="POST">
            <div class="admin-form-group">
                <label>Tên Tiện Nghi <span style="color: red;">*</span></label>
                <input type="text" name="name" class="admin-form-control"
                    value="<?= htmlspecialchars($amenity['name'] ?? '') ?>" required>
            </div>

            <div class="admin-form-group">
                <label>Icon (Font Awesome class)</label>
                <input type="text" name="icon" class="admin-form-control"
                    value="<?= htmlspecialchars($amenity['icon'] ?? 'fa-solid fa-check') ?>"
                    placeholder="VD: fa-solid fa-wifi">
                <small style="color: #666;">Tham khảo: <a href="https://fontawesome.com/icons" target="_blank">Font
                        Awesome Icons</a></small>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="fa-solid fa-save"></i>
                    <?= $amenity ? 'Cập Nhật' : 'Thêm Mới' ?>
                </button>
            </div>
        </form>
    </div>
</div>