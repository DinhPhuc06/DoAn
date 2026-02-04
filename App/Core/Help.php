<?php

namespace App\Core;

/**
 * Helper Functions - Các hàm tiện ích dùng trong View và Controller
 */

/**
 * Lấy giá trị cũ của input (sau khi validation fail)
 */
function old(string $key, $default = null)
{
    return Session::getFlash('_old.' . $key, $default);
}

/**
 * Tạo CSRF token
 */
function csrf_token(): string
{
    if (!Session::get('_csrf_token')) {
        Session::set('_csrf_token', bin2hex(random_bytes(32)));
    }
    return Session::get('_csrf_token');
}

/**
 * Tạo input hidden CSRF token
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

/**
 * Kiểm tra CSRF token
 */
function verify_csrf_token(string $token): bool
{
    return hash_equals(Session::get('_csrf_token', ''), $token);
}

/**
 * Tạo URL asset (CSS, JS, images)
 */
function asset(string $path): string
{
    $baseUrl = defined('APP_URL') ? APP_URL : '';
    $path = ltrim($path, '/');
    return $baseUrl . '/assets/' . $path;
}

/**
 * Tạo URL route
 */
function url(string $path = ''): string
{
    $baseUrl = defined('APP_URL') ? APP_URL : '';
    $path = ltrim($path, '/');
    return $baseUrl . ($path ? '/' . $path : '');
}

/**
 * Tạo URL route (alias của url)
 */
function route(string $path = ''): string
{
    return url($path);
}

/**
 * Escape HTML (XSS protection)
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Format số tiền
 */
function money(float $amount, string $currency = 'VND'): string
{
    return number_format($amount, 0, ',', '.') . ' ' . $currency;
}

/**
 * Format ngày tháng
 */
function date_format_custom(string $date, string $format = 'd/m/Y'): string
{
    if (empty($date)) {
        return '';
    }
    $timestamp = strtotime($date);
    return $timestamp ? date($format, $timestamp) : '';
}
