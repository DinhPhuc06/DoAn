<?php
$error = $error ?? $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin - Đăng nhập') ?></title>
    <link rel="stylesheet" href="<?= \App\Core\asset('css/admin.css') ?>">
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;">
    <div style="width:100%;max-width:400px;padding:2rem;border:1px solid #ddd;border-radius:8px;">
        <h1 style="margin-top:0;">Đăng nhập Admin</h1>
        <?php if ($error === 'empty'): ?><p style="color:red;">Vui lòng nhập email và mật khẩu.</p><?php endif; ?>
        <?php if ($error === 'invalid'): ?><p style="color:red;">Email hoặc mật khẩu sai.</p><?php endif; ?>
        <form method="post" action="<?= \App\Core\url('/admin/login') ?>">
            <p><label>Email: <input type="email" name="email" required style="width:100%;padding:8px;"></label></p>
            <p><label>Mật khẩu: <input type="password" name="password" required style="width:100%;padding:8px;"></label></p>
            <p><button type="submit">Đăng nhập</button></p>
        </form>
    </div>
</body>
</html>
