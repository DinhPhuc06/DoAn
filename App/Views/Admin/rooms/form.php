<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <?= $room ? 'Chỉnh sửa' : 'Thêm mới' ?> Phòng
        </h2>
        <a href="/admin/rooms" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
        <form action="<?= $room ? '/admin/rooms/' . $room['id'] . '/update' : '/admin/rooms/store' ?>" 
            method="POST" enctype="multipart/form-data">
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Số Phòng <span style="color: red;">*</span></label>
                    <input type="text" name="room_number" class="admin-form-control"
                        value="<?= htmlspecialchars($room['room_number'] ?? '') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label>Loại Phòng <span style="color: red;">*</span></label>
                    <select name="room_type_id" class="admin-form-control" required>
                        <option value="">-- Chọn loại phòng --</option>
                        <?php foreach ($roomTypes as $rt): ?>
                            <option value="<?= $rt['id'] ?>" <?= ($room['room_type_id'] ?? '') == $rt['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($rt['name']) ?> -
                                <?= number_format($rt['base_price'], 0, ',', '.') ?>đ
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Tầng</label>
                    <input type="number" name="floor" class="admin-form-control" value="<?= $room['floor'] ?? '' ?>"
                        min="1">
                </div>
                <div class="admin-form-group">
                    <label>Trạng Thái</label>
                    <select name="status" class="admin-form-control">
                        <option value="available" <?= ($room['status'] ?? 'available') === 'available' ? 'selected' : '' ?>>Có sẵn</option>
                        <option value="booked" <?= ($room['status'] ?? '') === 'booked' ? 'selected' : '' ?>>Đã đặt</option>
                        <option value="maintenance" <?= ($room['status'] ?? '') === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
                    </select>
                </div>
            </div>

            <div class="admin-form-group">
                <label>Ảnh Phòng (Chọn được nhiều ảnh - Tùy chọn)</label>
                <input type="file" name="images[]" class="admin-form-control" accept="image/*" multiple>
                <?php if (!empty($room['images'])): ?>
                    <div style="margin-top: 15px; display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
                        <?php foreach ($room['images'] as $img): ?>
                            <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                                <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="Room Image" style="width: 100%; height: 120px; object-fit: cover;">
                                <?php if ($img['is_primary']): ?>
                                    <span style="position: absolute; top: 5px; left: 5px; background: var(--primary); color: #fff; padding: 2px 6px; font-size: 0.75rem; border-radius: 4px;">Chính</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="fa-solid fa-save"></i>
                    <?= $room ? 'Cập Nhật' : 'Thêm Mới' ?>
                </button>
            </div>
        </form>
    </div>
</div>