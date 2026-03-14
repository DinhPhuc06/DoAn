

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
create database booking_hotel;
use booking_hotel;

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `type` enum('room','event') DEFAULT 'room',
  `event_type` varchar(50) DEFAULT NULL,
  `payment_menthod` varchar(50) DEFAULT NULL,
  `payment_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `price` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `booking_service` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_time` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `result_code` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `room_details` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `status` enum('available','booked','maintenance') DEFAULT 'available',
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `size_m2` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `room_images` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `room_type_amenities` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `discount_value` decimal(12,2) NOT NULL,
  `min_order_value` decimal(12,2) DEFAULT 0,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('addon','standalone') DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`);


ALTER TABLE `booking_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `service_id` (`service_id`);


ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);


ALTER TABLE `room_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_type_id` (`room_type_id`);


ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `room_id` (`room_id`);

ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `room_type_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_type_id` (`room_type_id`),
  ADD KEY `amenity_id` (`amenity_id`);

ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);


ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `booking_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `room_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `room_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `room_type_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);


ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room_details` (`id`);


ALTER TABLE `booking_service`
  ADD CONSTRAINT `booking_service_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `booking_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);


ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);


ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room_details` (`id`);


ALTER TABLE `room_details`
  ADD CONSTRAINT `room_details_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`);


ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`),
  ADD CONSTRAINT `room_images_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room_details` (`id`);

ALTER TABLE `room_type_amenities`
  ADD CONSTRAINT `rta_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`),
  ADD CONSTRAINT `rta_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`);
-- --------------------------------------------------------
-- DỮ LIỆU MẪU (SAMPLE DATA)
-- --------------------------------------------------------

-- 1. Roles
INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'Customer');

-- 2. Users
-- Mật khẩu mặc định là 'password' (đã hash hoặc để nguyên tùy project xử lý, ở đây để text cho dễ test nếu chưa có hàm hash)
INSERT INTO `users` (`id`, `role_id`, `full_name`, `email`, `password`, `phone`) VALUES
(1, 1, 'Hệ thống Admin', 'admin@bookinghotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0901234567'),
(2, 2, 'Nguyễn Văn Quản Lý', 'manager@bookinghotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0907654321'),
(3, 3, 'Trần Thị Khách Hàng', 'khachhang@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0912345678'),
(4, 3, 'Lê Văn Dũng', 'dung.le@yahoo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0988776655'),
(5, 3, 'Phạm Minh Tuấn', 'tuan.pham@outlook.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0944332211');

-- 3. Room Types
INSERT INTO `room_types` (`id`, `name`, `description`, `size_m2`, `capacity`, `base_price`) VALUES
(1, 'Standard Single', 'Phòng đơn tiêu chuẩn, đầy đủ tiện nghi cơ bản.', 20, 1, 500000.00),
(2, 'Standard Double', 'Phòng đôi tiêu chuẩn, không gian ấm cúng, phù hợp cặp đôi.', 25, 2, 800000.00),
(3, 'Deluxe Ocean View', 'Phòng Deluxe với tầm nhìn hướng biển tuyệt đẹp, ban công rộng.', 35, 2, 1500000.00),
(4, 'Family Suite', 'Phòng Suite dành cho gia đình, có phòng khách riêng.', 50, 4, 2500000.00),
(5, 'Presidential Suite', 'Phòng Tổng thống sang trọng bậc nhất, đầy đủ tiện ích xa hoa.', 120, 2, 8000000.00);

-- 3.1 Amenities
INSERT INTO `amenities` (`id`, `name`, `icon`) VALUES
(1, 'Wifi miễn phí', 'fa-wifi'),
(2, 'Điều hòa', 'fa-snowflake'),
(3, 'Tivi', 'fa-tv'),
(4, 'Minibar', 'fa-wine-glass'),
(5, 'Bồn tắm', 'fa-bath'),
(6, 'Ban công', 'fa-sun');

-- 3.2 Room Type Amenities Mapping
INSERT INTO `room_type_amenities` (`room_type_id`, `amenity_id`) VALUES
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2), (2, 3), (2, 4),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6),
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6),
(5, 1), (5, 2), (5, 3), (5, 4), (5, 5), (5, 6);

-- 3.3 Room Images
INSERT INTO `room_images` (`room_type_id`, `room_id`, `image_path`, `is_primary`) VALUES
(1, NULL, '/assets/image/standard_single.jpg', 1),
(2, NULL, '/assets/image/standard_double.jpg', 1),
(3, NULL, '/assets/image/image.png', 1),
(4, NULL, '/assets/image/family_suite.jpg', 1),
(5, NULL, '/assets/image/presidential.jpg', 1);

-- 4. Room Details
INSERT INTO `room_details` (`room_type_id`, `room_number`, `floor`, `status`, `image_path`) VALUES
(1, '101', 1, 'available', NULL), (1, '102', 1, 'available', NULL), (1, '103', 1, 'booked', NULL), (1, '104', 1, 'available', NULL),
(2, '201', 2, 'available', NULL), (2, '202', 2, 'available', NULL), (2, '203', 2, 'available', NULL), (2, '204', 2, 'maintenance', NULL),
(3, '301', 3, 'available', NULL), (3, '302', 3, 'available', NULL), (3, '303', 3, 'available', NULL), (3, '304', 3, 'available', NULL), (3, '305', 3, 'booked', NULL),
(4, '401', 4, 'available', NULL), (4, '402', 4, 'available', NULL), (4, '403', 4, 'available', NULL),
(5, '501', 5, 'available', NULL), (5, '502', 5, 'available', NULL);

-- 5. Services
INSERT INTO `services` (`name`, `price`, `description`, `type`) VALUES
('Buffet Sáng', 150000.00, 'Buffet sáng tiêu chuẩn quốc tế tại nhà hàng tầng 1', 'addon'),
('Đưa đón sân bay', 300000.00, 'Xe riêng đón tiễn sân bay Tân Sơn Nhất', 'addon'),
('Dịch vụ Spa trọn gói', 800000.00, 'Liệu trình massage 90 phút thư giãn', 'standalone'),
('Giặt ủi nhanh', 50000.00, 'Giặt và sấy khô quần áo lấy trong ngày', 'addon'),
('Thuê xe máy', 150000.00, 'Thuê xe máy di chuyển tự do trong thành phố (24h)', 'standalone'),
('Gym & Fitness', 100000.00, 'Sử dụng phòng Gym hiện đại tại tầng thượng', 'addon');

-- 10. Coupons
INSERT INTO `coupons` (`code`, `discount_type`, `discount_value`, `min_order_value`, `valid_from`, `valid_to`, `is_active`) VALUES
('WELCOME30', 'percent', 30.00, 0.00, '2026-01-01', '2026-12-31', 1),
('HOTEL500', 'fixed', 500000.00, 5000000.00, '2026-02-01', '2026-03-31', 1);

-- 11. Settings
INSERT INTO `settings` (`setting_key`, `setting_value`, `description`) VALUES
('site_name', 'Booking Hotel', 'Tên website'),
('contact_email', 'contact@bookinghotel.com', 'Email liên hệ'),
('contact_phone', '(028) 1234 5678', 'Số điện thoại hỗ trợ'),
('address', '123 Đường ABC, Quận 1, TP.HCM', 'Địa chỉ khách sạn');

-- 6. Bookings
INSERT INTO `bookings` (`id`, `user_id`, `check_in`, `check_out`, `total_price`, `status`, `payment_menthod`, `payment_at`) VALUES
(1, 3, '2026-02-01', '2026-02-03', 3300000.00, 'confirmed', 'Credit Card', '2026-02-01 10:00:00'),
(2, 4, '2026-02-05', '2026-02-07', 5000000.00, 'pending', NULL, NULL),
(3, 5, '2026-02-10', '2026-02-12', 16000000.00, 'confirmed', 'Momo', '2026-02-04 14:00:00');

-- 7. Booking Details
INSERT INTO `booking_details` (`booking_id`, `room_id`, `price`) VALUES
(1, 3, 500000.00), -- Room 103
(2, 13, 1500000.00), -- Room 305
(3, 17, 8000000.00); -- Room 501

-- 8. Reviews
INSERT INTO `reviews` (`user_id`, `room_id`, `rating`, `comment`) VALUES
(3, 3, 5, 'Phòng rất sạch sẽ, nhân viên phục vụ tận tình.'),
(4, 13, 4, 'View biển cực đẹp, phòng hơi nhỏ một chút nhưng vẫn ok.'),
(5, 17, 5, 'Phòng cực kỳ sang trọng, xứng đáng với giá tiền.');

-- 9. Payments
INSERT INTO `payments` (`booking_id`, `method`, `amount`, `status`, `paid_at`, `currency`) VALUES
(1, 'Credit Card', 3300000.00, 'success', '2026-02-01 10:00:00', 'VND'),
(3, 'Momo', 16000000.00, 'success', '2026-02-04 14:00:00', 'VND');

COMMIT;


