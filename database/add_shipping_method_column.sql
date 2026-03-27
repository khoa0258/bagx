-- Thêm cột id_shipping_method vào bảng orders
ALTER TABLE `orders` ADD COLUMN `id_shipping_method` int(10) UNSIGNED DEFAULT NULL AFTER `id_payment`;

-- Thêm foreign key constraint (tùy chọn)
ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_shipping_method` 
FOREIGN KEY (`id_shipping_method`) REFERENCES `shipping_methods`(`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Thêm index cho hiệu suất
ALTER TABLE `orders` ADD INDEX `idx_orders_shipping_method` (`id_shipping_method`);
