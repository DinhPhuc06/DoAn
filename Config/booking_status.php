<?php

/**
 * Booking Status Flow - Trạng thái đặt phòng (bảng bookings.status)
 * Phục vụ luồng: tạo mới → thanh toán → xác nhận / hủy
 */

return [
    // Giá trị trong DB (enum: pending, confirmed, cancelled)
    'pending'   => [
        'value'  => 'pending',
        'label'  => 'Chờ thanh toán',
        'label_en' => 'Pending payment',
        'description' => 'Đặt phòng vừa tạo, chưa thanh toán. Cần thanh toán để xác nhận.',
    ],
    'confirmed' => [
        'value'  => 'confirmed',
        'label'  => 'Đã xác nhận',
        'label_en' => 'Confirmed',
        'description' => 'Đã thanh toán thành công. Đặt phòng đã được xác nhận.',
    ],
    'cancelled' => [
        'value'  => 'cancelled',
        'label'  => 'Đã hủy',
        'label_en' => 'Cancelled',
        'description' => 'Đặt phòng đã bị hủy.',
    ],

    // Luồng chuyển trạng thái hợp lệ (phục vụ thanh toán)
    'transitions' => [
        'pending'   => ['confirmed', 'cancelled'],  // pending → confirmed (sau thanh toán) hoặc cancelled
        'confirmed' => [],                           // confirmed không chuyển nữa (hoặc mở rộng: refund)
        'cancelled' => [],                           // cancelled không chuyển
    ],

    // Trạng thái được coi là "giữ phòng" (tính overlap, không cho đặt trùng)
    'blocks_room' => ['pending', 'confirmed'],

    // Trạng thái mặc định khi tạo booking mới
    'default' => 'pending',
];
