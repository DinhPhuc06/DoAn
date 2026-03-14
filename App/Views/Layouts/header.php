<?php
/**
 * Header Layout - Modern Design
 */
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
?>
<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
            <a href="<?= \App\Core\url('/') ?>" class="logo">
                <div class="logo-icon"><i class="fa-solid fa-hotel"></i></div>
                <span>Booking Hotel</span>
            </a>

            <nav class="nav">
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
            </nav>
        </div>
    </div>
</header>