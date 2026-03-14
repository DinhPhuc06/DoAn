<?php
/**
 * Header Layout - Modern Design
 */
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
?>
<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
<<<<<<< HEAD
            <a href="<?= \App\Core\url('/') ?>" class="logo">
=======
            <a href="/" class="logo">
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
                <div class="logo-icon"><i class="fa-solid fa-hotel"></i></div>
                <span>Booking Hotel</span>
            </a>

            <nav class="nav">
<<<<<<< HEAD
                <a href="<?= \App\Core\url('') ?>" class="nav-link">Trang chủ</a>
                <a href="<?= \App\Core\url('rooms') ?>" class="nav-link">Phòng</a>
                <a href="<?= \App\Core\url('rooms/search') ?>" class="nav-link">Tìm phòng</a>
                <?php if (\App\Core\Auth::check()): ?>
                    <?php if (\App\Core\Auth::role() === 'admin'): ?>
                        <a href="<?= \App\Core\url('admin') ?>" class="nav-link">Quản trị</a>
                    <?php endif; ?>
                    <a href="<?= \App\Core\url('profile') ?>" class="nav-link">Tài khoản</a>
                    <a href="<?= \App\Core\url('logout') ?>" class="btn btn-outline">Đăng xuất</a>
                <?php else: ?>
                    <a href="<?= \App\Core\url('register') ?>" class="nav-link">Đăng ký</a>
                    <a href="<?= \App\Core\url('login') ?>" class="btn btn-outline">Đăng nhập</a>
                <?php endif; ?>
=======
                <a href="/" class="nav-link">Trang chủ</a>
                <a href="/rooms" class="nav-link">Phòng</a>
                <a href="/rooms/search" class="nav-link">Tìm phòng</a>
                <a href="/login" class="btn btn-outline">Đăng nhập</a>
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
            </nav>
        </div>
    </div>
</header>