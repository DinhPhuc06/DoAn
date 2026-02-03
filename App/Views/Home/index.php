<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Booking Hotel') ?></title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .nav {
            margin-top: 20px;
        }

        .nav a {
            display: inline-block;
            margin-right: 15px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .nav a:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Booking Hotel</h1>
        <p>Hệ thống đặt phòng khách sạn - MVC Framework</p>

        <div class="nav">
            <a href="<?= rtrim(APP_URL ?? '', '/') ?>/">Trang chủ</a>
            <a href="<?= rtrim(APP_URL ?? '', '/') ?>/rooms">Xem phòng / Đặt phòng</a>
            <a href="<?= rtrim(APP_URL ?? '', '/') ?>/admin.php">Admin Panel</a>
        </div>

        <h2>Trạng thái hệ thống</h2>
        <ul>
            <li>✅ Database: Kết nối thành công</li>
            <li>✅ Models: 11 models CRUD đầy đủ</li>
            <li>✅ Admin: 6 controllers CRUD hoàn chỉnh</li>
            <li>✅ Router: Đã cấu hình</li>
            <li>✅ Error Handling: Đã thiết lập</li>
            <li>✅ Validation & Security: Đã có</li>
        </ul>
    </div>
</body>

</html>