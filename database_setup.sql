-- Tạo database
CREATE DATABASE IF NOT EXISTS bagxdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bagxdb;

-- Import dữ liệu từ file SQL gốc của bạn ở đây
-- Sau đó thêm dữ liệu mẫu

-- Thêm dữ liệu mẫu cho bảng payments
INSERT INTO `payments` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Thanh toán khi nhận hàng (COD)', 'Thanh toán bằng tiền mặt khi nhận hàng', 1, NOW(), NOW()),
(2, 'Chuyển khoản ngân hàng', 'Chuyển khoản qua tài khoản ngân hàng', 1, NOW(), NOW()),
(3, 'Ví điện tử MoMo', 'Thanh toán qua ví MoMo', 1, NOW(), NOW());

-- Thêm dữ liệu mẫu cho bảng discounts
INSERT INTO `discounts` (`id`, `name`, `code`, `value`, `type`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Giảm giá 10%', 'SALE10', 10.00, 'percent', '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1, NOW(), NOW()),
(2, 'Giảm 50k', 'SAVE50K', 50000.00, 'fixed', '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1, NOW(), NOW());

-- Thêm user admin mẫu (password: password)
INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `password`, `phone`, `roles`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'System', 'admin@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 2, 1, NOW(), NOW());

-- Thêm user thường mẫu (password: password)  
INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `password`, `phone`, `roles`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Nguyen', 'Van A', 'user@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', 1, 1, NOW(), NOW());

-- Thêm dữ liệu mẫu cho main_categories
INSERT INTO `main_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Điện tử', NOW(), NOW()),
(2, 'Thời trang', NOW(), NOW()),
(3, 'Gia dụng', NOW(), NOW()),
(4, 'Sách', NOW(), NOW());

-- Thêm dữ liệu mẫu cho brands
INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Samsung', 'samsung', 1, NOW(), NOW()),
(2, 'Apple', 'apple', 1, NOW(), NOW()),
(3, 'Nike', 'nike', 1, NOW(), NOW()),
(4, 'Adidas', 'adidas', 1, NOW(), NOW());
