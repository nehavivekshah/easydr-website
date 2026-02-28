-- 1. Add Payment Fields to Orders Table
ALTER TABLE `orders` 
ADD COLUMN `payment_method` VARCHAR(50) NULL AFTER `total_amount`,
ADD COLUMN `payment_gateway_id` BIGINT UNSIGNED NULL AFTER `payment_method`;

-- 2. Create Payment Gateway Configs Table
CREATE TABLE `payment_gateway_configs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gateway_name` VARCHAR(100) NOT NULL,
  `merchant_id` VARCHAR(100) NULL,
  `api_key` VARCHAR(255) NULL,
  `api_secret` VARCHAR(255) NULL,
  `webhook_secret` VARCHAR(255) NULL,
  `environment` VARCHAR(20) NOT NULL DEFAULT 'sandbox',
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `additional_config` JSON NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. (Optional) Insert some dummy data for testing the UI
INSERT INTO `payment_gateway_configs` 
(`gateway_name`, `environment`, `is_active`, `created_at`, `updated_at`) 
VALUES 
('Razorpay', 'sandbox', 1, NOW(), NOW()),
('Stripe', 'sandbox', 1, NOW(), NOW()),
('PayTM', 'sandbox', 0, NOW(), NOW());
