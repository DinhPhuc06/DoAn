<?php
$error = $error ?? $_GET['error'] ?? '';
$errors = $error ? explode(',', $error) : [];
$old = function ($key, $def = '') {
    return \App\Core\old($key, $def) ?: ($_POST[$key] ?? $def);
};
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Booking Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= \App\Core\asset('css/auth.css') ?>">
</head>
<body>
    <div class="auth-page auth-page--register">
        <h1 class="auth-page-title">Đăng ký tài khoản</h1>
        <div class="auth-container auth-container--register">
            <div class="auth-visual">
                <span class="auth-visual-title">Booking Hotel</span>
                <p class="auth-visual-desc">Tạo tài khoản để đặt phòng nhanh chóng, theo dõi đặt phòng và nhận ưu đãi độc quyền từ chúng tôi.</p>
                <div class="auth-visual-badge"><i class="fa-solid fa-hotel"></i> Khách sạn 5 sao</div>
            </div>
            <div class="auth-form-panel auth-form-panel--register">
                <h2><i class="fa-solid fa-user-plus"></i> Thông tin đăng ký</h2>
                <?php if (in_array('email_exists', $errors)): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Email này đã được đăng ký. Vui lòng đăng nhập hoặc dùng email khác.</p>
                <?php endif; ?>
                <?php if (in_array('password_short', $errors)): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Mật khẩu phải có ít nhất 6 ký tự.</p>
                <?php endif; ?>
                <?php if (in_array('password_mismatch', $errors)): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Xác nhận mật khẩu không khớp.</p>
                <?php endif; ?>
                <?php if (in_array('create_failed', $errors)): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Không thể tạo tài khoản. Vui lòng thử lại sau.</p>
                <?php endif; ?>
                <form method="post" action="<?= \App\Core\url('/register') ?>" class="auth-form auth-form--register">
                    <div class="auth-form-row">
                        <div class="form-group">
                            <label for="full_name">Họ và tên</label>
                            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($old('full_name')) ?>" required placeholder="Nguyễn Văn A" autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($old('phone')) ?>" placeholder="0123 456 789" autocomplete="tel">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old('email')) ?>" required placeholder="mail@example.com" autocomplete="email">
                    </div>
                    <div class="auth-form-row">
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password" required placeholder="••••••••" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Xác nhận mật khẩu</label>
                            <input type="password" id="password_confirm" name="password_confirm" required placeholder="••••••••" autocomplete="new-password">
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Đăng ký</button>
                </form>
                <p class="auth-link">Đã có tài khoản? <a href="<?= \App\Core\url('/login') ?>">Đăng nhập ngay</a></p>
            </div>
        </div>
        <p class="auth-page-footer">© <?= date('Y') ?> Booking Hotel. All rights reserved.</p>
    </div>
</body>
</html>
