<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($title ?? 'Admin Panel') ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="<?= \App\Core\asset('css/admin.css') ?>">
=======
    <link rel="stylesheet" href="/assets/css/admin.css">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
<<<<<<< HEAD
                <a href="<?= \App\Core\url('/admin') ?>" class="admin-sidebar-logo">
=======
                <a href="/admin" class="admin-sidebar-logo">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                    <i class="fa-solid fa-hotel"></i>
                    <span>Admin Panel</span>
                </a>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-title">Menu</div>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin') ?>" class="admin-nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
=======
                    <a href="/admin" class="admin-nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Quản Lý</div>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/users') ?>"
=======
                    <a href="/admin/users"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'users' ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i>
                        <span>Người dùng</span>
                    </a>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/room-types') ?>"
=======
                    <a href="/admin/room-types"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'room-types' ? 'active' : '' ?>">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Loại phòng</span>
                    </a>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/rooms') ?>"
=======
                    <a href="/admin/rooms"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'rooms' ? 'active' : '' ?>">
                        <i class="fa-solid fa-door-open"></i>
                        <span>Phòng</span>
                    </a>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/bookings') ?>"
=======
                    <a href="/admin/bookings"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'bookings' ? 'active' : '' ?>">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Đặt phòng</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Cài Đặt</div>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/amenities') ?>"
=======
                    <a href="/admin/amenities"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'amenities' ? 'active' : '' ?>">
                        <i class="fa-solid fa-wifi"></i>
                        <span>Tiện nghi</span>
                    </a>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/services') ?>"
=======
                    <a href="/admin/services"
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        class="admin-nav-item <?= ($currentPage ?? '') === 'services' ? 'active' : '' ?>">
                        <i class="fa-solid fa-concierge-bell"></i>
                        <span>Dịch vụ</span>
                    </a>
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/admin/revenue') ?>"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'revenue' ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Doanh thu</span>
                    </a>
=======
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                </div>

                <div class="admin-nav-section"
                    style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
<<<<<<< HEAD
                    <a href="<?= \App\Core\url('/') ?>" class="admin-nav-item">
                        <i class="fa-solid fa-globe"></i>
                        <span>Xem Website</span>
                    </a>
                    <a href="<?= \App\Core\url('/logout') ?>" class="admin-nav-item">
=======
                    <a href="/" class="admin-nav-item">
                        <i class="fa-solid fa-globe"></i>
                        <span>Xem Website</span>
                    </a>
                    <a href="/logout" class="admin-nav-item">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1 class="admin-header-title">
                    <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>
                </h1>
                <div class="admin-header-actions">
                    <div class="admin-user-dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff" alt="Admin">
                        <span>Admin</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; color: #666;"></i>
                    </div>
                </div>
            </header>

            <div class="admin-content">
                <?= $content ?>
            </div>
        </main>
    </div>
</body>

</html>