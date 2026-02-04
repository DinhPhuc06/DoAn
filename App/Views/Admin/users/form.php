<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">
            <?= $user ? 'Chỉnh sửa' : 'Thêm mới' ?> Người Dùng
        </h2>
        <a href="/admin/users" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="admin-card-body">
        <form action="<?= $user ? '/admin/users/' . $user['id'] . '/update' : '/admin/users/store' ?>" method="POST">
            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Họ Tên <span style="color: red;">*</span></label>
                    <input type="text" name="full_name" class="admin-form-control"
                        value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label>Email <span style="color: red;">*</span></label>
                    <input type="email" name="email" class="admin-form-control"
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Mật khẩu
                        <?= $user ? '(để trống nếu không đổi)' : '<span style="color: red;">*</span>' ?>
                    </label>
                    <input type="password" name="password" class="admin-form-control" <?= !$user ? 'required' : '' ?>>
                </div>
                <div class="admin-form-group">
                    <label>Điện Thoại</label>
                    <input type="text" name="phone" class="admin-form-control"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Vai Trò</label>
                    <select name="role_id" class="admin-form-control">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id'] ?>" <?= ($user['role_id'] ?? '') == $role['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label>Trạng Thái</label>
                    <select name="status" class="admin-form-control">
                        <option value="active" <?= ($user['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Hoạt
                            động</option>
                        <option value="inactive" <?= ($user['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Bị khóa
                        </option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="fa-solid fa-save"></i>
                    <?= $user ? 'Cập Nhật' : 'Thêm Mới' ?>
                </button>
            </div>
        </form>
    </div>
</div>