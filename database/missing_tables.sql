-- Bảng phương thức thanh toán (orders có id_payment nhưng thiếu bảng này)
CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Tên phương thức thanh toán',
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - inactive, 1 - active',
  `sort` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng giảm giá/khuyến mãi (products có id_discount nhưng thiếu bảng này)
CREATE TABLE `discounts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 - percentage, 2 - fixed amount',
  `value` decimal(10,2) NOT NULL COMMENT 'Giá trị giảm giá',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - inactive, 1 - active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng giỏ hàng (để lưu trữ lâu dài thay vì chỉ dùng session)
CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_variant` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_id_user_foreign` (`id_user`),
  KEY `carts_id_variant_foreign` (`id_variant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng danh sách yêu thích
CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_product` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_id_user_foreign` (`id_user`),
  KEY `wishlists_id_product_foreign` (`id_product`),
  UNIQUE KEY `wishlists_user_product_unique` (`id_user`, `id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng mã giảm giá/coupon
CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL UNIQUE,
  `name` varchar(150) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 - percentage, 2 - fixed amount',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(12,2) DEFAULT NULL COMMENT 'Giá trị đơn hàng tối thiểu',
  `usage_limit` int(10) UNSIGNED DEFAULT NULL COMMENT 'Giới hạn số lần sử dụng',
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lần đã sử dụng',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - inactive, 1 - active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng phương thức vận chuyển
CREATE TABLE `shipping_methods` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0,
  `estimated_days` int(10) UNSIGNED DEFAULT NULL COMMENT 'Số ngày dự kiến giao hàng',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - inactive, 1 - active',
  `sort` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng đánh giá sản phẩm (nâng cấp từ comments)
CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_product` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5 COMMENT 'Điểm đánh giá từ 1-5',
  `title` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - hidden, 1 - approved, 2 - pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_id_user_foreign` (`id_user`),
  KEY `reviews_id_product_foreign` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng banner/slider
CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `position` varchar(50) NOT NULL DEFAULT 'home_slider' COMMENT 'Vị trí hiển thị banner',
  `sort` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 - inactive, 1 - active',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng thông báo
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'info' COMMENT 'info, success, warning, error',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_id_user_foreign` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng cài đặt hệ thống
CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL UNIQUE,
  `value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'text' COMMENT 'text, number, boolean, json',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm cột shipping_method_id vào bảng orders
ALTER TABLE `orders` ADD COLUMN `id_shipping_method` int(10) UNSIGNED DEFAULT NULL AFTER `id_payment`;
ALTER TABLE `orders` ADD COLUMN `coupon_code` varchar(50) DEFAULT NULL AFTER `id_shipping_method`;
ALTER TABLE `orders` ADD COLUMN `discount_amount` decimal(10,2) DEFAULT 0 AFTER `coupon_code`;
ALTER TABLE `orders` ADD COLUMN `shipping_fee` decimal(10,2) DEFAULT 0 AFTER `discount_amount`;

-- Thêm dữ liệu mẫu cho các bảng mới
INSERT INTO `payments` (`name`, `description`, `status`, `sort`) VALUES
('Thanh toán khi nhận hàng (COD)', 'Thanh toán bằng tiền mặt khi nhận hàng', 1, 1),
('Chuyển khoản ngân hàng', 'Chuyển khoản qua tài khoản ngân hàng', 1, 2),
('Ví điện tử MoMo', 'Thanh toán qua ví MoMo', 1, 3),
('Thẻ tín dụng/ghi nợ', 'Thanh toán bằng thẻ Visa/Mastercard', 1, 4);

INSERT INTO `shipping_methods` (`name`, `description`, `price`, `estimated_days`, `status`, `sort`) VALUES
('Giao hàng tiêu chuẩn', 'Giao hàng trong 3-5 ngày làm việc', 30000, 5, 1, 1),
('Giao hàng nhanh', 'Giao hàng trong 1-2 ngày làm việc', 50000, 2, 1, 2),
('Giao hàng hỏa tốc', 'Giao hàng trong ngày (nội thành)', 80000, 1, 1, 3);

INSERT INTO `settings` (`key`, `value`, `description`, `type`) VALUES
('site_name', 'Shop Thời Trang', 'Tên website', 'text'),
('site_description', 'Cửa hàng thời trang trực tuyến', 'Mô tả website', 'text'),
('contact_phone', '0123456789', 'Số điện thoại liên hệ', 'text'),
('contact_email', 'info@shop.com', 'Email liên hệ', 'text'),
('contact_address', '123 Đường ABC, Quận 1, TP.HCM', 'Địa chỉ liên hệ', 'text'),
('free_shipping_amount', '500000', 'Miễn phí ship cho đơn hàng từ (VNĐ)', 'number'),
('currency', 'VNĐ', 'Đơn vị tiền tệ', 'text');
