<?php
$error = $error ?? $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Booking Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= \App\Core\asset('css/auth.css') ?>">
</head>

<body>
    <div class="auth-page">
        <h1 class="auth-page-title">Đăng nhập</h1>
        <div class="auth-container">
            <div class="auth-visual">
                <span class="auth-visual-title">Booking Hotel</span>
                <p class="auth-visual-desc">Đăng nhập để đặt phòng và quản lý tài khoản. Trải nghiệm dịch vụ khách sạn đẳng cấp.</p>
                <div class="auth-visual-badge"><i class="fa-solid fa-hotel"></i> Khách sạn 5 sao</div>
            </div>
            <div class="auth-form-panel">
                <h2><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</h2>
                <?php if ($error === 'empty'): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Vui lòng nhập email và mật khẩu.</p>
                <?php endif; ?>
                <?php if ($error === 'invalid'): ?>
                    <p class="auth-error"><i class="fa-solid fa-circle-exclamation"></i> Email hoặc mật khẩu không đúng.</p>
                <?php endif; ?>
                <form method="post" action="<?= \App\Core\url('/login') ?>" class="auth-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="mail@example.com" autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" required placeholder="••••••••" autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn-submit">Đăng nhập</button>
                </form>
                <p class="auth-link">Chưa có tài khoản? <a href="<?= \App\Core\url('/register') ?>">Đăng ký ngay</a></p>
            </div>
        </div>
        <p class="auth-page-footer">© <?= date('Y') ?> Booking Hotel. All rights reserved.</p>
    </div>
</body>

</html>