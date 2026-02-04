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
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <a href="/admin" class="admin-sidebar-logo">
                    <i class="fa-solid fa-hotel"></i>
                    <span>Admin Panel</span>
                </a>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-title">Menu</div>
                    <a href="/admin" class="admin-nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Quản Lý</div>
                    <a href="/admin/users"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'users' ? 'active' : '' ?>">
                        <i class="fa-solid fa-users"></i>
                        <span>Người dùng</span>
                    </a>
                    <a href="/admin/room-types"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'room-types' ? 'active' : '' ?>">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Loại phòng</span>
                    </a>
                    <a href="/admin/rooms"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'rooms' ? 'active' : '' ?>">
                        <i class="fa-solid fa-door-open"></i>
                        <span>Phòng</span>
                    </a>
                    <a href="/admin/bookings"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'bookings' ? 'active' : '' ?>">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Đặt phòng</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Cài Đặt</div>
                    <a href="/admin/amenities"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'amenities' ? 'active' : '' ?>">
                        <i class="fa-solid fa-wifi"></i>
                        <span>Tiện nghi</span>
                    </a>
                    <a href="/admin/services"
                        class="admin-nav-item <?= ($currentPage ?? '') === 'services' ? 'active' : '' ?>">
                        <i class="fa-solid fa-concierge-bell"></i>
                        <span>Dịch vụ</span>
                    </a>
                </div>

                <div class="admin-nav-section"
                    style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="/" class="admin-nav-item">
                        <i class="fa-solid fa-globe"></i>
                        <span>Xem Website</span>
                    </a>
                    <a href="/logout" class="admin-nav-item">
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