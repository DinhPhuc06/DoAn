<?php
/**
 * Header Layout - Modern Design
 */
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
?>
<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
            <a href="/" class="logo">
                <div class="logo-icon"><i class="fa-solid fa-hotel"></i></div>
                <span>Booking Hotel</span>
            </a>

            <nav class="nav">
                <a href="/" class="nav-link">Trang chủ</a>
                <a href="/rooms" class="nav-link">Phòng</a>
                <a href="/rooms/search" class="nav-link">Tìm phòng</a>
                <a href="/login" class="btn btn-outline">Đăng nhập</a>
            </nav>
        </div>
    </div>
</header>