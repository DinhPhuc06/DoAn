<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .box {
            max-width: 600px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }

        a {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="box">
        <h1>Trang cá nhân</h1>
        <p>Bạn đã đăng nhập. Route này được bảo vệ bởi <strong>AuthMiddleware</strong> (controller không tự check).</p>
        <?php if (!empty($user)): ?>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['full_name'] ?? '') ?></p>
        <?php endif; ?>
        <p><a href="<?= rtrim(APP_URL ?? '', '/') ?>/logout">Đăng xuất</a> | <a href="<?= rtrim(APP_URL ?? '', '/') ?>/">Trang chủ</a></p>
    </div>
</body>

</html>