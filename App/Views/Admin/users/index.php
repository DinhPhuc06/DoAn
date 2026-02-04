<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Danh Sách Người Dùng</h2>
        <a href="/admin/users/create" class="admin-btn admin-btn-primary">
            <i class="fa-solid fa-plus"></i> Thêm Mới
        </a>
    </div>
    <div class="admin-card-body" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>Điện Thoại</th>
                    <th>Vai Trò</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#
                                <?= $user['id'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['full_name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['phone'] ?? '-') ?>
                            </td>
                            <td><span class="badge badge-primary">
                                    <?= $user['role_id'] == 1 ? 'Admin' : 'User' ?>
                                </span></td>
                            <td>
                                <?php $status = $user['status'] ?? 'active'; ?>
                                <span class="badge <?= $status === 'active' ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $status === 'active' ? 'Hoạt động' : 'Bị khóa' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/users/<?= $user['id'] ?>/edit" class="action-btn action-btn-edit"
                                        title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="/admin/users/<?= $user['id'] ?>/delete" method="POST" style="display: inline;"
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
                        <td colspan="7" style="text-align: center; padding: 30px; color: #666;">Chưa có người dùng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>