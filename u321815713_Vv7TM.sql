-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 13, 2026 at 12:58 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u321815713_Vv7TM`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `medical_file` varchar(255) DEFAULT NULL,
  `health_card_file` varchar(255) DEFAULT NULL,
  `fees` int(11) DEFAULT 0,
  `payment_mode` varchar(255) DEFAULT '0',
  `trans_details` varchar(1000) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `is_completed` varchar(10) DEFAULT '0,0',
  `order_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `pid`, `did`, `date`, `time`, `note`, `medical_file`, `health_card_file`, `fees`, `payment_mode`, `trans_details`, `payment_status`, `payment_date`, `is_completed`, `order_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 51, 59, '2025-12-12', '17:30:00', 'jsjs dhd ddhdbdbdhd d', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-12 17:11:03', '2025-12-12 17:12:39'),
(2, 51, 10, '2025-12-12', '17:30:00', 'hs. dud ddhd xjdd dx', NULL, NULL, 20, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-12 17:13:13', '2025-12-12 17:13:13'),
(3, 51, 59, '2025-12-13', '15:30:00', 'hdjd xjd dhcd dias d duc f', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 2, '2025-12-12 17:18:35', '2025-12-13 13:38:12'),
(4, 76, 59, '2025-12-14', '12:00:00', 'very best', NULL, NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-13 12:49:02', '2025-12-13 13:02:29'),
(5, 51, 59, '2025-12-13', '14:00:00', 'hddh ddhdbddudbddbudbd fix xx dkd dhd d d', NULL, 'KHJSHDUBCUII', 25, 'Health Card', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-13 12:50:19', '2025-12-13 12:50:19'),
(6, 76, 59, '2025-12-14', '12:00:00', 'health care Health', NULL, NULL, 25, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-13 13:27:09', '2025-12-13 13:27:09'),
(7, 51, 3, '2025-12-13', '15:30:00', 'bxhd dhd dhd fbdf. fc', NULL, NULL, 10, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-13 15:22:14', '2025-12-13 15:22:14'),
(8, 51, 3, '2025-12-13', '16:00:00', 'bzbxxjd dhd dhd did dd', 'asdasd', 'KHJSHDUBCUII', 10, 'Health Card', NULL, 'paid', NULL, '0,1', NULL, 0, '2025-12-13 15:22:40', '2025-12-13 15:35:20'),
(9, 51, 59, '2025-12-13', '16:00:00', 'bdbd dhd did ddud', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-13 15:27:17', '2025-12-13 15:43:53'),
(10, 76, 59, '2025-12-13', '16:30:00', 'gfhfjfbd f.  f ffbffbccbff c. ff c fmg cbgm lh', NULL, NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-13 16:18:40', '2025-12-13 16:20:38'),
(11, 76, 59, '2025-12-13', '17:00:00', 'bad health', NULL, NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-13 16:34:11', '2025-12-13 16:55:00'),
(12, 76, 59, '2025-12-13', '17:30:00', 'good health care', NULL, NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-13 17:01:57', '2025-12-13 17:02:56'),
(13, 51, 59, '2025-12-18', '13:30:00', 'This is testing appointment booking', NULL, NULL, 25, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-18 12:38:08', '2025-12-18 12:38:08'),
(14, 51, 59, '2025-12-18', '17:30:00', 'This is a testing appointment booking', 'asdasd', 'KHJSHDUBCUII', 25, 'Health Card', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-18 12:38:58', '2025-12-18 14:25:35'),
(15, 51, 59, '2025-12-19', '17:30:00', 'This is a testing appointment booking', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2025-12-19 14:48:52', '2025-12-19 14:53:15'),
(16, 51, 59, '2025-12-25', '13:30:00', 'bxhc hc. jvy m vm y m nm mn d hu h na. .', NULL, NULL, 25, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2025-12-24 17:42:50', '2025-12-24 17:42:50'),
(17, 51, 59, '2026-01-07', '18:00:00', 'This is a testing appointment booking for features of the world of the world of the world of the world of the world of the world of', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2026-01-07 17:45:20', '2026-01-07 17:45:39'),
(18, 51, 59, '2026-01-07', '18:30:00', 'This is a testing appointment booking for tyy', 'asdasd', 'KHJSHDUBCUII', 25, 'Health Card', NULL, 'paid', NULL, '0,0', NULL, 0, '2026-01-07 17:46:31', '2026-01-07 17:46:39'),
(19, 51, 59, '2026-01-08', '12:30:00', 'This is a testing appointment booking for features of the world of the world of the world.', 'asdasd', NULL, 25, 'Cash Payment', NULL, 'paid', NULL, '0,0', NULL, 0, '2026-01-07 17:47:57', '2026-01-07 17:49:23'),
(20, 51, 59, '2026-01-08', '19:30:00', 'yeh kya Krna hai na sir urgent hai na', NULL, NULL, 25, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2026-01-08 15:35:49', '2026-01-08 15:35:49'),
(21, 77, 59, '2026-01-08', '19:30:00', 'this is the world of the day of the', NULL, NULL, 25, 'Cash Payment', NULL, NULL, NULL, '0,0', NULL, 0, '2026-01-08 17:54:54', '2026-01-08 17:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `mob` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `mob`, `email`, `email_verified_at`, `address`, `pincode`, `city`, `state`, `country`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Easy Doctor', '0000000000', 'admin@easydoctor.com', '2024-09-07 09:49:12', 'Goregeon East', '400065', 'Mumbai', 'Maharastra', 'India', '1', '2024-09-07 09:49:12', '2024-09-07 09:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `medicine_id`, `quantity`, `created_at`, `updated_at`) VALUES
(21, 77, 2, 2, '2026-01-08 16:20:46', '2026-01-08 16:20:46'),
(22, 77, 5, 2, '2026-01-08 19:12:05', '2026-01-08 19:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL,
  `msg` mediumblob DEFAULT NULL,
  `file` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `pid`, `did`, `aid`, `msg`, `file`, `status`, `created_at`, `updated_at`) VALUES
(1, 51, 59, 6, 0x686920536972, NULL, 0, '2025-05-14 17:15:25', '2025-05-14 17:15:25'),
(2, 51, 59, 6, 0xf09fa497, NULL, 0, '2025-05-14 17:15:30', '2025-05-14 17:15:30'),
(3, 51, 3, 5, 0xf09f918bf09f918b, NULL, 0, '2025-05-14 17:15:44', '2025-05-14 17:15:44'),
(4, 59, 51, 6, 0x48656c6c6f, NULL, 0, '2025-05-14 17:19:02', '2025-05-14 17:19:02'),
(5, 59, 51, 6, 0x486f772063616e20492068656c7020796f75, NULL, 0, '2025-05-14 17:19:14', '2025-05-14 17:19:14'),
(6, 59, 51, 6, 0xe29da4f09f998f, NULL, 0, '2025-05-14 17:19:15', '2025-05-14 17:19:15'),
(7, 51, 59, 6, NULL, 'assets/images/uploads/1747225719_IMG-20250514-WA0023.jpg', 0, '2025-05-14 17:58:39', '2025-05-14 17:58:39'),
(8, 51, 59, 6, NULL, 'assets/images/uploads/1747225722_IMG-20250514-WA0022.jpg', 0, '2025-05-14 17:58:42', '2025-05-14 17:58:42'),
(9, 51, 59, 7, 0x4869, NULL, 0, '2025-05-16 13:53:30', '2025-05-16 13:53:30'),
(10, 59, 51, 7, 0x4869, NULL, 0, '2025-05-16 13:54:15', '2025-05-16 13:54:15'),
(11, 51, 59, 8, 0x4869, NULL, 0, '2025-05-22 16:15:54', '2025-05-22 16:15:54'),
(12, 51, 59, 21, 0x486920736972, NULL, 0, '2025-05-30 15:25:27', '2025-05-30 15:25:27'),
(13, 51, 59, 21, 0x48656c6c, NULL, 0, '2025-05-30 17:30:30', '2025-05-30 17:30:30'),
(14, 51, 59, 21, 0xf09f918b, NULL, 0, '2025-05-30 17:30:36', '2025-05-30 17:30:36'),
(15, 51, 59, 21, NULL, 'assets/images/uploads/1748606465_IMG-20250530-WA0017.jpg', 0, '2025-05-30 17:31:05', '2025-05-30 17:31:05'),
(16, 59, 51, 21, 0x4869, NULL, 0, '2025-05-30 17:49:23', '2025-05-30 17:49:23'),
(17, 60, 59, 23, 0x4869, NULL, 0, '2025-05-31 07:40:53', '2025-05-31 07:40:53'),
(18, 60, 59, 24, 0x4869, NULL, 0, '2025-06-01 16:37:08', '2025-06-01 16:37:08'),
(19, 60, 59, 24, 0x4966206170706f696e746d656e7420636f6d706c657465207468656e2075736572207375626d697420666565646261636b, NULL, 0, '2025-06-01 16:37:46', '2025-06-01 16:37:46'),
(20, 51, 59, 47, 0x4869, NULL, 0, '2025-08-29 15:39:35', '2025-08-29 15:39:35'),
(21, 59, 51, 47, 0x6869, NULL, 0, '2025-08-29 15:40:01', '2025-08-29 15:40:01'),
(22, 51, 59, 47, 0x426468646864, NULL, 0, '2025-08-29 15:40:09', '2025-08-29 15:40:09'),
(23, 59, 51, 47, 0x7579747579747579, NULL, 0, '2025-08-29 15:40:16', '2025-08-29 15:40:16'),
(24, 59, 51, 47, 0x6f6f, NULL, 0, '2025-08-29 15:40:21', '2025-08-29 15:40:21'),
(25, 59, 51, 47, 0x6b3b6c6b3b6b, NULL, 0, '2025-08-29 15:40:26', '2025-08-29 15:40:26'),
(26, 51, 59, 47, 0x4e636e636e, NULL, 0, '2025-08-29 15:40:31', '2025-08-29 15:40:31'),
(27, 51, 59, 47, 0x4e656e206e63, NULL, 0, '2025-08-29 15:40:33', '2025-08-29 15:40:33'),
(28, 51, 59, 47, 0x4e636e63, NULL, 0, '2025-08-29 15:40:34', '2025-08-29 15:40:34'),
(29, 51, 59, 47, 0x4e636e63, NULL, 0, '2025-08-29 15:40:35', '2025-08-29 15:40:35'),
(30, 51, 59, 47, 0x4e63, NULL, 0, '2025-08-29 15:40:36', '2025-08-29 15:40:36'),
(31, 51, 59, 47, 0x4e63, NULL, 0, '2025-08-29 15:40:37', '2025-08-29 15:40:37'),
(32, 51, 59, 47, 0x4e63, NULL, 0, '2025-08-29 15:40:37', '2025-08-29 15:40:37'),
(33, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:38', '2025-08-29 15:40:38'),
(34, 51, 59, 47, 0x4e63, NULL, 0, '2025-08-29 15:40:39', '2025-08-29 15:40:39'),
(35, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:40', '2025-08-29 15:40:40'),
(36, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:41', '2025-08-29 15:40:41'),
(37, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:42', '2025-08-29 15:40:42'),
(38, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:42', '2025-08-29 15:40:42'),
(39, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:43', '2025-08-29 15:40:43'),
(40, 51, 59, 47, 0x4e66, NULL, 0, '2025-08-29 15:40:43', '2025-08-29 15:40:43'),
(41, 51, 59, 51, 0x4868646864, NULL, 0, '2025-09-19 16:13:18', '2025-09-19 16:13:18'),
(42, 51, 59, 51, 0x4264626468, NULL, 0, '2025-09-19 16:13:20', '2025-09-19 16:13:20'),
(43, 51, 59, 51, 0x4264626264, NULL, 0, '2025-09-19 16:13:21', '2025-09-19 16:13:21'),
(44, 51, 59, 51, 0x4264626468, NULL, 0, '2025-09-19 16:13:22', '2025-09-19 16:13:22'),
(45, 51, 59, 51, 0x446f6e65, NULL, 0, '2025-09-19 16:48:28', '2025-09-19 16:48:28'),
(46, 51, 59, 52, 0x4869, NULL, 0, '2025-09-26 13:25:24', '2025-09-26 13:25:24'),
(47, 59, 51, 52, 0x4869, NULL, 0, '2025-09-26 13:25:48', '2025-09-26 13:25:48'),
(48, 51, 3, 57, 0x4869, NULL, 0, '2025-11-07 12:38:39', '2025-11-07 12:38:39'),
(49, 51, 10, 66, 0x536972, NULL, 0, '2025-12-12 15:09:51', '2025-12-12 15:09:51'),
(50, 51, 59, 3, NULL, 'assets/images/uploads/1765540279_Screenshot_2025-12-12-13-22-30-688_com.easy.doctor.jpg', 0, '2025-12-12 17:21:19', '2025-12-12 17:21:19'),
(51, 51, 3, 8, 0x4869, NULL, 0, '2025-12-13 15:23:19', '2025-12-13 15:23:19'),
(52, 59, 76, 11, 0x4869, NULL, 0, '2025-12-13 16:34:55', '2025-12-13 16:34:55'),
(53, 59, 76, 11, 0x48656c6c6f, NULL, 0, '2025-12-13 16:55:13', '2025-12-13 16:55:13'),
(54, 51, 59, 17, 0x4869, NULL, 0, '2026-01-07 17:45:54', '2026-01-07 17:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country`, `state`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'India (IN)', 'Maharastra', 'Mumbai', NULL, 1, '2025-01-07 11:55:09', '2025-01-07 13:45:28'),
(2, 'India (IN)', 'Maharastra', 'Pune', NULL, 1, '2025-01-07 11:57:55', '2025-01-07 13:47:41'),
(3, 'India (IN)', 'Rajasthan', 'Jaipur', NULL, 1, '2025-01-07 13:48:01', '2025-01-07 13:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `socials` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'India (IN)', NULL, 1, '2025-01-07 12:28:25', '2025-01-07 12:29:23'),
(2, 'United State (US)', NULL, 1, '2025-01-07 12:28:54', '2025-01-07 12:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `specialist` varchar(255) NOT NULL,
  `wallet` int(11) DEFAULT 0,
  `experience` varchar(255) DEFAULT '0',
  `education` varchar(255) DEFAULT NULL,
  `license` varchar(50) DEFAULT NULL,
  `fees` int(11) DEFAULT 0,
  `about` varchar(1000) DEFAULT NULL,
  `extra` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `uid`, `specialist`, `wallet`, `experience`, `education`, `license`, `fees`, `about`, `extra`, `created_at`, `updated_at`) VALUES
(3, 3, 'Gastroenterologist', 10, '10', NULL, 'SAWFR545F', 10, 'Discover premium fragrances, skincare, and cosmetics at affordable prices. Inspired by luxury, crafted with care – our products blend quality, creativity, and passion to elevate your everyday beauty routine.', 'Let me know if you\'d like a more playful, elegant, or edgy tone!\n\n\n\n\n\n\n\n', '2024-08-21 18:52:17', '2025-12-13 15:23:09'),
(4, 4, 'Neurologist', 0, '12', 'MBBS', 'SXYFR545F', 20, 'Discover premium fragrances, skincare, and cosmetics at affordable prices. Inspired by luxury, crafted with care – our products blend quality, creativity, and passion to elevate your everyday beauty routine.', 'Let me know if you\'d like a more playful, elegant, or edgy tone!\n\n\n\n\n\n\n\n', '2024-08-21 18:52:17', '2024-08-21 18:52:17'),
(8, 59, 'Gayena logistics', 375, '15', 'MD', 'HDHDHRVSB', 25, 'Discover premium fragrances, skincare, and cosmetics at affordable prices. Inspired by luxury, crafted with care – our products blend quality, creativity, and passion to elevate your everyday beauty routine.', '', '2025-05-09 14:21:18', '2026-01-07 17:49:23'),
(9, 62, 'General Physician', 0, '0', '', '1234', 0, '', '', '2025-06-23 18:40:48', '2025-12-19 15:08:32'),
(10, 10, 'General Physician', 0, '0', 'MD', 'MD1', 20, '', NULL, '2025-07-04 18:14:13', '2025-12-12 12:52:17'),
(11, 79, '2fgbghfdg', 0, '0', 'fvbdfsdf', 'fdgffg', 0, 'fdfdfxd', NULL, '2025-12-19 15:47:17', '2025-12-19 15:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availables`
--

CREATE TABLE `doctor_availables` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `available_days` varchar(500) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_availables`
--

INSERT INTO `doctor_availables` (`id`, `doctor_id`, `from_date`, `to_date`, `available_days`, `start_time`, `end_time`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-05-08', '2025-06-08', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '18:00:00', 30, 1, '2025-05-08 17:41:49', '2025-05-08 17:41:49'),
(2, 59, '2025-05-09', '2025-05-24', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '18:00:00', 30, 1, '2025-05-09 14:24:21', '2025-05-09 14:24:21'),
(3, 59, '2025-05-29', '2025-05-31', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '02:00:00', '21:00:00', 30, 1, '2025-05-16 15:34:06', '2025-05-16 15:34:06'),
(4, 59, '2025-06-01', '2025-06-30', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '18:00:00', 30, 1, '2025-05-16 15:46:46', '2025-05-16 15:46:46'),
(5, 62, '2025-06-15', '2025-09-30', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '16:30:00', 30, 1, '2025-06-23 18:44:09', '2025-06-27 18:53:34'),
(6, 3, '2025-06-27', '2025-12-31', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', '10:00:00', '21:30:00', 30, 1, '2025-06-28 08:54:51', '2025-07-08 16:31:08'),
(7, 3, '2025-06-01', '2025-12-31', 'Monday,Tuesday,Wednesday,Friday', '09:00:00', '19:00:00', 30, 1, '2025-07-12 06:37:26', '2025-07-12 06:37:26'),
(8, 10, '2025-01-01', '2025-12-31', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', '09:00:00', '18:00:00', 30, 1, '2025-07-12 06:39:50', '2025-07-12 06:39:50'),
(9, 59, '2025-08-29', '2025-09-30', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', '09:00:00', '18:00:00', 30, 1, '2025-08-29 15:36:43', '2025-08-29 15:36:43'),
(10, 59, '2025-11-13', '2025-11-29', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '18:00:00', 30, 1, '2025-11-13 16:47:39', '2025-11-13 16:47:39'),
(11, 59, '2025-11-30', '2025-12-31', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '18:00:00', 30, 1, '2025-11-15 15:13:05', '2025-11-15 15:13:05'),
(12, 59, '2026-01-07', '2026-01-31', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', '09:00:00', '20:00:00', 30, 1, '2026-01-07 17:39:54', '2026-01-07 17:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reviews`
--

CREATE TABLE `doctor_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(10) NOT NULL,
  `rating` varchar(10) NOT NULL,
  `review_text` varchar(1000) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosages`
--

CREATE TABLE `dosages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosages`
--

INSERT INTO `dosages` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, '250 Mg', NULL, 1, '2025-07-01 16:30:53', '2025-07-01 17:25:38'),
(4, '500 mg', NULL, 1, '2025-07-01 17:25:46', '2025-07-01 17:25:46'),
(5, '1 Tablet', NULL, 1, '2025-07-01 17:25:58', '2025-07-01 17:25:58'),
(6, '2 capsules', NULL, 1, '2025-07-01 17:26:15', '2025-07-01 17:26:15'),
(7, '5 ml', NULL, 1, '2025-07-01 17:26:21', '2025-07-01 17:26:21'),
(8, '1 drop', NULL, 1, '2025-07-01 17:26:30', '2025-07-01 17:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `durations`
--

CREATE TABLE `durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `durations`
--

INSERT INTO `durations` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, '3 days', NULL, 1, '2025-07-01 16:30:53', '2025-07-01 17:35:01'),
(3, '5 days', NULL, 1, '2025-07-01 17:35:07', '2025-07-01 17:35:07'),
(4, '7 days', NULL, 1, '2025-07-01 17:35:16', '2025-07-01 17:35:16'),
(5, '10 days', NULL, 1, '2025-07-01 17:35:24', '2025-07-01 17:35:24'),
(6, '2 weeks', NULL, 1, '2025-07-01 17:35:32', '2025-07-01 17:35:32'),
(7, '1 month', NULL, 1, '2025-07-01 17:35:38', '2025-07-01 17:35:38'),
(8, 'Until symptoms', NULL, 1, '2025-07-01 17:35:57', '2025-07-01 17:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frequencies`
--

CREATE TABLE `frequencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frequencies`
--

INSERT INTO `frequencies` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Once Daily', NULL, 1, '2025-07-01 16:45:06', '2025-07-01 17:27:01'),
(5, 'Twice Daily', NULL, 1, '2025-07-01 17:27:20', '2025-07-01 17:27:20'),
(6, 'Three times daily', NULL, 1, '2025-07-01 17:27:39', '2025-07-01 17:27:39'),
(7, 'Every 6 hours', NULL, 1, '2025-07-01 17:27:51', '2025-07-01 17:27:51'),
(8, 'Every 8 hours', NULL, 1, '2025-07-01 17:28:02', '2025-07-01 17:28:02'),
(9, 'As needed', NULL, 1, '2025-07-01 17:32:20', '2025-07-01 17:32:20'),
(10, 'At bedtime', NULL, 1, '2025-07-01 17:32:29', '2025-07-01 17:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Before meals', NULL, 1, '2025-07-01 16:30:53', '2025-07-01 17:43:26'),
(2, 'After meals', NULL, 1, '2025-07-01 17:43:37', '2025-07-01 17:43:37'),
(3, 'With meals', NULL, 1, '2025-07-01 17:43:47', '2025-07-01 17:43:47'),
(4, 'Empty stomach', NULL, 1, '2025-07-01 17:43:59', '2025-07-01 17:43:59'),
(5, 'No meal restriction', NULL, 1, '2025-07-01 17:44:18', '2025-07-01 17:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `branch` int(20) NOT NULL,
  `pharmacy_id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `gallery` varchar(500) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `medical_stream` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `discount_cost` decimal(10,2) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `medicine_category` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `expiration_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `branch`, `pharmacy_id`, `name`, `img`, `gallery`, `store_id`, `medical_stream`, `cost`, `discount_cost`, `available`, `label`, `type_id`, `medicine_category`, `purpose`, `symptoms`, `description`, `stock_quantity`, `expiration_date`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 4, 'Baluff', 'assets/images/medicines/1746701215_ChatGPT Image Apr 25, 2025, 05_26_34 PM.png', '[\"assets\\/images\\/medicines\\/1746702547_681c90d3c1138_DALL\\u00b7E 2025-03-24 14.42.11 - A stunning artistic representation of Lady Legacy\\u2019s fashion collection. A woman dressed in an elegant fusion outfit combining traditional Indian attir.webp\",\"assets\\/images\\/medicines\\/1746702547_681c90d3c18aa_channels4_profile.jpg\",\"assets\\/images\\/medicines\\/1746702547_681c90d3c1a16_d61wk0d-e73d0189-4605-4fe2-9149-8ed5f5d09129.png\"]', 3, 'Demo', 100.00, 90.00, 1, 'HAPPY CLIENTS', 3, 'prescribed', 'Purpose', 'Demo', 'Demo 2', -4, '2026-03-10', 1, '2025-03-25 14:32:05', '2026-01-08 10:07:40'),
(5, 1, 4, 'Avastin 100mg Injection', '', NULL, 3, 'Demo', 50.00, 100.00, 1, 'Avastin 100mg Injection', 1, 'prescribed', 'Fever', 'fever', 'fecer', -4, '2025-05-31', 1, '2025-05-03 16:55:02', '2026-01-08 10:07:40'),
(6, 1, 4, 'Acetaminophen', '', NULL, 3, 'sdfsdf', 50.00, 20.00, 1, NULL, 2, 'prescribed', 'Edit', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 0, '2025-12-11', 1, '2025-05-03 17:17:53', '2025-05-03 17:26:15'),
(7, 1, 4, 'Adderall', '', NULL, 3, 'Demo', 110.00, 10.00, 1, 'TEAM MEMBERS', 1, 'prescribed', 'Purpose', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', -2, '2026-12-12', 1, '2025-05-03 17:18:59', '2025-12-30 11:41:46'),
(8, 1, 4, 'Amitriptyline', '', NULL, 3, 'Demo', 2000.00, 200.00, 1, 'test', 1, 'prescribed', 'Purpose', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 0, '2026-05-05', 1, '2025-05-03 17:20:22', '2025-05-03 17:20:22'),
(9, 1, 4, 'Amlodipine', '', NULL, 3, 'Demo', 5000.00, 500.00, 1, 'Avastin 100mg Injection', 9, 'otc', 'Purpose', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', -2, '2027-02-22', 1, '2025-05-03 17:21:31', '2026-01-08 10:07:40'),
(10, 1, 4, 'Amoxicillin', '', NULL, 3, 'Demo', 100.00, 10.00, 1, 'WORK WITH GYMS', 1, 'otc', NULL, 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', -2, '2026-05-08', 1, '2025-05-03 17:23:02', '2025-12-30 11:41:46'),
(11, 1, 4, 'Ativan', '', NULL, 3, 'Demo', 110.00, 10.00, 1, 'TEAM MEMBERS', 1, 'otc', 'Purpose', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', -2, '2028-05-05', 1, '2025-05-03 17:23:55', '2025-12-30 11:41:46'),
(12, 1, 4, 'Atorvastatin', '', NULL, 3, 'Demo', 500.00, 50.00, 1, 'Ratings', 1, 'otc', 'Edit', 'Symptoms are indications of illness, injury, or a health condition that are experienced by the individual and cannot be objectively observed by others. They are subjective, meaning they are based on the person\'s feelings and cannot be measured or seen by healthcare providers or others.', 'Symptoms can only be reported by the person experiencing them. They cannot be observed by a health care provider or other person and do not show up on medical tests.', 0, '2027-12-01', 1, '2025-05-03 17:24:55', '2025-05-03 17:24:55'),
(13, 1, 4, 'Azithromycin', '', NULL, 3, 'Demo', 1000.00, 100.00, 1, 'Ratings', 1, 'otc', 'Purpose', 'Symptoms can only be reported by the person experiencing them. They cannot be observed by a health care provider or other person and do not show up on medical tests.', 'Symptoms can only be reported by the person experiencing them. They cannot be observed by a health care provider or other person and do not show up on medical tests.', -2, '2025-05-05', 1, '2025-05-03 17:26:45', '2026-01-08 10:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_types`
--

CREATE TABLE `medicine_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_types`
--

INSERT INTO `medicine_types` (`id`, `name`, `icons`, `created_at`, `updated_at`) VALUES
(1, 'Analgesics', NULL, '2025-03-21 16:08:03', '2025-03-21 16:08:03'),
(2, 'Antibiotics', NULL, '2025-03-21 16:11:12', '2025-03-21 16:11:12'),
(3, 'Antivirals', NULL, '2025-03-21 16:11:18', '2025-03-21 16:11:18'),
(4, 'Antifungals', NULL, '2025-03-21 16:11:22', '2025-03-21 16:11:22'),
(5, 'Antihistamines', NULL, '2025-03-21 16:11:29', '2025-03-21 16:11:29'),
(6, 'Antidepressants', NULL, '2025-03-21 16:11:38', '2025-03-21 16:11:38'),
(7, 'Antacids', NULL, '2025-03-21 16:11:46', '2025-03-21 16:11:46'),
(8, 'Antidiabetic Drugs', NULL, '2025-03-21 16:11:54', '2025-03-21 16:11:54'),
(9, 'Antihypertensive', NULL, '2025-03-21 16:12:01', '2025-03-21 16:12:01'),
(10, 'Herbal Medicines', NULL, '2025-03-21 16:12:10', '2025-03-21 16:12:10'),
(11, 'Synthetic Drugs', NULL, '2025-03-21 16:12:17', '2025-03-21 16:12:17'),
(12, 'Biologics', NULL, '2025-03-21 16:12:24', '2025-03-21 16:12:24'),
(13, 'Central Nervous System (CNS) Drugs', NULL, '2025-03-21 16:12:35', '2025-03-21 16:12:35'),
(14, 'Cardiovascular Drugs', NULL, '2025-03-21 16:12:44', '2025-03-21 16:12:44'),
(15, 'Hormonal Drugs.', NULL, '2025-03-21 16:12:54', '2025-03-21 16:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_07_07_010222_create_branches_table', 1),
(5, '2024_07_07_010314_create_usermetas_table', 1),
(6, '2024_07_07_010549_create_categories_table', 1),
(7, '2024_07_07_010622_create_contacts_table', 1),
(8, '2024_07_07_010656_create_enquiries_table', 1),
(9, '2024_07_07_010807_create_notifications_table', 1),
(10, '2024_07_07_010846_create_pages_table', 1),
(11, '2024_07_07_010930_create_settings_table', 1),
(12, '2024_07_07_011006_create_sliders_table', 1),
(13, '2024_07_07_020627_create_doctors_table', 1),
(14, '2024_07_07_020832_create_patients_table', 1),
(15, '2024_07_07_035222_create_stores_table', 1),
(16, '2024_07_07_043133_create_medicines_table', 1),
(17, '2024_07_07_075613_create_cartlists_table', 1),
(18, '2024_07_07_075723_create_wishlists_table', 1),
(19, '2024_07_08_010801_create_chats_table', 1),
(20, '2024_07_08_010920_create_videochats_table', 1),
(21, '2024_07_08_011454_create_bookings_table', 1),
(22, '2024_07_08_011734_create_invoices_table', 1),
(23, '2024_07_08_011935_create_orders_table', 1),
(24, '2024_07_08_012110_create_order_items_table', 1),
(25, '2024_07_08_023611_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `shipping_address` text NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `store_id`, `supplier_id`, `shipping_address`, `order_date`, `status`, `total_amount`, `created_at`, `updated_at`) VALUES
(6, 51, 3, 4, 'xbdb', '2025-12-30 17:11:46', 'Pending', 840.00, '2025-12-30 11:41:46', '2025-12-30 11:41:46'),
(7, 51, 3, 4, 'nennd', '2025-12-30 19:04:40', 'Pending', 100.00, '2025-12-30 13:34:40', '2025-12-30 13:34:40'),
(8, 51, 3, 4, 'hhe', '2026-01-08 15:37:40', 'Pending', 12300.00, '2026-01-08 10:07:40', '2026-01-08 10:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `medicine_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 2, 100.00, '2025-12-30 11:41:46', '2025-12-30 11:41:46'),
(2, 6, 10, 2, 100.00, '2025-12-30 11:41:46', '2025-12-30 11:41:46'),
(3, 6, 11, 2, 110.00, '2025-12-30 11:41:46', '2025-12-30 11:41:46'),
(4, 6, 7, 2, 110.00, '2025-12-30 11:41:46', '2025-12-30 11:41:46'),
(5, 7, 5, 2, 50.00, '2025-12-30 13:34:40', '2025-12-30 13:34:40'),
(6, 8, 2, 2, 100.00, '2026-01-08 10:07:40', '2026-01-08 10:07:40'),
(7, 8, 5, 2, 50.00, '2026-01-08 10:07:40', '2026-01-08 10:07:40'),
(8, 8, 13, 2, 1000.00, '2026-01-08 10:07:40', '2026-01-08 10:07:40'),
(9, 8, 9, 2, 5000.00, '2026-01-08 10:07:40', '2026-01-08 10:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_itemsa`
--

CREATE TABLE `order_itemsa` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `branch`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Refund & Cancellation', '<h1>Refund & Cancellation</h1>', 0, '2024-12-21 15:45:04', '2024-12-21 15:45:04'),
(2, 1, 'Health Tips', 'Health Tips', 0, '2024-12-21 15:47:00', '2024-12-21 15:47:04'),
(3, 1, 'Help & Support', 'Help & Support', 0, '2024-12-21 15:45:04', '2024-12-21 15:45:04'),
(4, 1, 'Terms & Conditions', 'Terms & Conditions', 0, '2024-12-21 15:47:07', '2024-12-21 15:47:11'),
(5, 1, 'Privacy Policy', 'Privacy Policy', 0, '2024-12-21 15:45:04', '2024-12-21 15:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `familyDoctor` int(10) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `medical_file` varchar(100) DEFAULT NULL,
  `height` varchar(100) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `health_card` varchar(100) DEFAULT NULL,
  `health_card_file` varchar(100) DEFAULT NULL,
  `hc_issue_date` date DEFAULT NULL,
  `hc_expairy_date` date DEFAULT NULL,
  `hc_verified_at` timestamp NULL DEFAULT NULL,
  `marital_status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `uid`, `familyDoctor`, `blood_group`, `medical_file`, `height`, `weight`, `health_card`, `health_card_file`, `hc_issue_date`, `hc_expairy_date`, `hc_verified_at`, `marital_status`, `created_at`, `updated_at`) VALUES
(1, 58, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, '1', '2025-05-09 12:37:05', '2025-05-09 12:37:05'),
(2, 51, NULL, 'o+', 'asdasd', '5.8', '62', 'KHJSHDUBCUII', NULL, '2025-12-01', '2025-10-29', '2025-12-19 18:31:49', '1', '2025-05-09 12:37:05', '2025-12-19 18:31:58'),
(3, 63, NULL, 'No Group', NULL, '9999999999', '9999999', NULL, NULL, NULL, NULL, NULL, '1', '2025-06-23 18:57:51', '2025-12-19 17:12:28'),
(4, 76, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, '1', '2025-12-13 13:02:16', '2025-12-19 18:10:50'),
(5, 82, NULL, 'O-', NULL, '67', '76', '5656756', '1766139902.png', '2025-12-01', '2025-12-31', '2025-12-19 17:43:42', '2', '2025-12-19 15:55:02', '2025-12-19 18:14:15'),
(6, 73, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, '1', '2026-01-08 16:04:23', '2026-01-08 16:04:23'),
(7, 77, NULL, 'o', NULL, '6.8 ft', '62', NULL, NULL, NULL, NULL, NULL, '2', '2026-01-08 16:13:27', '2026-01-08 16:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_configs`
--

CREATE TABLE `payment_gateway_configs` (
  `id` int(11) NOT NULL,
  `gateway_name` varchar(50) NOT NULL,
  `merchant_id` varchar(100) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `webhook_secret` varchar(255) DEFAULT NULL,
  `environment` enum('sandbox','production') DEFAULT 'sandbox',
  `is_active` tinyint(1) DEFAULT 1,
  `additional_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_config`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateway_configs`
--

INSERT INTO `payment_gateway_configs` (`id`, `gateway_name`, `merchant_id`, `api_key`, `api_secret`, `webhook_secret`, `environment`, `is_active`, `additional_config`, `created_at`, `updated_at`) VALUES
(1, 'Razorpay', 'merchant_123456', 'rzp_test_ABC123xyz', 'secret_ABC123xyz987', 'whsec_123456secret', 'sandbox', 1, '{}', '2025-06-11 06:38:49', '2025-07-04 15:45:05'),
(3, 'Paypal', 'sb-sumvv856930@business.example.com', 'AXay6ZreMZsgpHVPHE5gqpWA9Fvb47X_jiaG5MBKTiEI_DLQlBEDjySFZhoPCybKZsf7x9q6M4YtxUwA', 'EHS7ruF4B5b82CtOS4BYUhlY7_ogmxQH5Ri9WdeF-TIkPL6MGZVS-EzAKxWE9xPCj-3ayqBXlxZhZzZp', '0N070897CN951584T', 'sandbox', 1, '{\"mode\":\"live\",\"locale\":\"en-US\"}', '2025-06-11 06:39:22', '2025-07-04 15:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'Personal Access Token', '0d3b0b430cd1d6659b24ad64250ce67b56ce2f0ac23eb5380704f2cd23e34c4f', '[\"*\"]', NULL, NULL, '2024-08-10 09:02:21', '2024-08-10 09:02:21'),
(2, 'App\\Models\\User', 2, 'Personal Access Token', '9465c22dad98214b668dabf945441ef2b416393adedd1348891e040684b13e93', '[\"*\"]', NULL, NULL, '2024-08-10 09:02:51', '2024-08-10 09:02:51'),
(3, 'App\\Models\\User', 2, 'Personal Access Token', '3a2b28592e9c1553d266aae43c69b66f896b264d8f4031eb026cf783be655513', '[\"*\"]', NULL, NULL, '2024-08-10 09:04:49', '2024-08-10 09:04:49'),
(4, 'App\\Models\\User', 2, 'Personal Access Token', 'ac807333bbb72617a61e067ea1950880b0038ace38fd23a308ce5ef3e66aa1d6', '[\"*\"]', NULL, NULL, '2024-08-10 09:09:40', '2024-08-10 09:09:40'),
(5, 'App\\Models\\User', 2, 'Personal Access Token', 'b0558b4f7585e9b71d07cba650c6d8b29609717f13db9d388015e91da349a325', '[\"*\"]', NULL, NULL, '2024-08-10 09:10:23', '2024-08-10 09:10:23'),
(6, 'App\\Models\\User', 2, 'Personal Access Token', '25bb4db6335158de190b0c59420cac905cd021e1ff009d8610ec56f97dc19fb2', '[\"*\"]', NULL, NULL, '2024-08-10 09:12:47', '2024-08-10 09:12:47'),
(7, 'App\\Models\\User', 2, 'Personal Access Token', 'd159324c600fa2732b181dad89d2564532e43010eaf773f2ac5a808957bb0df7', '[\"*\"]', NULL, NULL, '2024-08-10 09:14:38', '2024-08-10 09:14:38'),
(8, 'App\\Models\\User', 2, 'Personal Access Token', 'a04c94b05df9e93836fdd46a61add8c209d1ea860541ef0a975119654dc03bd3', '[\"*\"]', NULL, NULL, '2024-08-10 09:16:07', '2024-08-10 09:16:07'),
(9, 'App\\Models\\User', 2, 'Personal Access Token', '2bc793417f76f6f02166f11b2b22c1ff871623914fe9c506555c6d680fda699a', '[\"*\"]', NULL, NULL, '2024-08-10 09:18:00', '2024-08-10 09:18:00'),
(10, 'App\\Models\\User', 2, 'Personal Access Token', '20f91c2b8a25cb75104bbaa1cb22129b2c7b125b8e6acc2073acb6f4b3abf865', '[\"*\"]', NULL, NULL, '2024-08-10 11:51:26', '2024-08-10 11:51:26'),
(11, 'App\\Models\\User', 2, 'Personal Access Token', '63fb747a3841ffe9961fc556da2c98a26f2ab857ae1e754ceb555717a5b14250', '[\"*\"]', NULL, NULL, '2024-08-10 11:53:50', '2024-08-10 11:53:50'),
(12, 'App\\Models\\User', 2, 'Personal Access Token', 'cefb865a65597f26885be29c18105f889ec99c9f3e050e7286a9e1255db6f613', '[\"*\"]', NULL, NULL, '2024-08-10 11:54:02', '2024-08-10 11:54:02'),
(13, 'App\\Models\\User', 2, 'Personal Access Token', 'a01cc913648bd686686aa5806a3f132ea8f1f7a4054e2e78d10b8d102bf3d2af', '[\"*\"]', NULL, NULL, '2024-08-10 11:54:56', '2024-08-10 11:54:56'),
(14, 'App\\Models\\User', 2, 'Personal Access Token', '0974e83d06952b206d9b6eb37a4eaf52eb2b3908b9d7417572c4b03d3f35a55a', '[\"*\"]', NULL, NULL, '2024-08-10 11:55:45', '2024-08-10 11:55:45'),
(15, 'App\\Models\\User', 2, 'Personal Access Token', '88849daa8144ee5a18facb3a1315c3f98f4ef4a345cea8b0043479782564e178', '[\"*\"]', NULL, NULL, '2024-08-10 11:56:37', '2024-08-10 11:56:37'),
(16, 'App\\Models\\User', 2, 'Personal Access Token', '6930421f609cb51d615c3d5608d04dba56c5ea5bdcf8eb38355a7a2c489acb9e', '[\"*\"]', NULL, NULL, '2024-08-10 11:59:35', '2024-08-10 11:59:35'),
(17, 'App\\Models\\User', 2, 'Personal Access Token', 'ac7915b596ec7173e0cee4dce638cc70d0edc88c9d64a15439eaebe043121efa', '[\"*\"]', NULL, NULL, '2024-08-10 12:01:46', '2024-08-10 12:01:46'),
(18, 'App\\Models\\User', 2, 'Personal Access Token', '4ab7c199b58805f7cd52be2147a9a964e28ad339e293b2a1f44e249cb4905e26', '[\"*\"]', NULL, NULL, '2024-08-10 12:02:32', '2024-08-10 12:02:32'),
(19, 'App\\Models\\User', 2, 'Personal Access Token', '608dab701a5a51a05884f47f23cec9bc96e45880ebac7ca9dad1cc3da7bbea7b', '[\"*\"]', NULL, NULL, '2024-08-10 12:23:21', '2024-08-10 12:23:21'),
(20, 'App\\Models\\User', 2, 'Personal Access Token', '1ca00b6c33cc1b2e6edb697f1509666e1870215b577c7c386cebf34da6c53eb3', '[\"*\"]', NULL, NULL, '2024-08-17 07:37:48', '2024-08-17 07:37:48'),
(21, 'App\\Models\\User', 2, 'Personal Access Token', '07f8d16d3641b1a9502c5c925dda28cc68ecb036ae047a6f928c8a67ee590259', '[\"*\"]', NULL, NULL, '2024-08-17 10:59:24', '2024-08-17 10:59:24'),
(22, 'App\\Models\\User', 2, 'Personal Access Token', '579ff8e838dc353487e1d1ed0606a243c0a1bc0e7d7a70970869d7489ddca74a', '[\"*\"]', NULL, NULL, '2024-08-20 11:24:10', '2024-08-20 11:24:10'),
(23, 'App\\Models\\User', 2, 'Personal Access Token', 'aa252d7a707c06804b248411cf94545fab271e7f456283678b24a0dd066f3cf7', '[\"*\"]', NULL, NULL, '2024-08-20 13:31:39', '2024-08-20 13:31:39'),
(24, 'App\\Models\\User', 2, 'Personal Access Token', '1fb4d2042e157c60712280036ba78a42dcf62f6603f0b5d39aabacbae764e44c', '[\"*\"]', NULL, NULL, '2024-08-20 13:39:39', '2024-08-20 13:39:39'),
(25, 'App\\Models\\User', 2, 'Personal Access Token', '270bed4fc9b00f00f6ece5de27e8452c7d9021fb991473ed6690765ac06afa94', '[\"*\"]', NULL, NULL, '2024-08-20 13:49:29', '2024-08-20 13:49:29'),
(26, 'App\\Models\\User', 2, 'Personal Access Token', '4babbe73d025130e5ab240e8948654476df8fe89dec7062a7a69692dd8962854', '[\"*\"]', NULL, NULL, '2024-08-21 09:00:11', '2024-08-21 09:00:11'),
(27, 'App\\Models\\User', 2, 'Personal Access Token', '9b9ba119b94ca9fa5b0cdf761f9dcf20d48972d7ae5817b3e6d8ce7a000206bd', '[\"*\"]', NULL, NULL, '2024-08-21 09:29:03', '2024-08-21 09:29:03'),
(28, 'App\\Models\\User', 2, 'Personal Access Token', 'fc9a8fe7ee7967ec9ba855344dbbdf455d64849715640c0b97b3350a4b785ea2', '[\"*\"]', NULL, NULL, '2024-08-21 09:34:41', '2024-08-21 09:34:41'),
(29, 'App\\Models\\User', 2, 'Personal Access Token', '2eb92926f452a2a1855448ddcaa857972ade218fa7fbee5b29abeec259d4c065', '[\"*\"]', NULL, NULL, '2024-08-21 09:46:29', '2024-08-21 09:46:29'),
(30, 'App\\Models\\User', 2, 'Personal Access Token', '74e9cf91a68b24034c4a85fd9235bfca6c4cb69d817ec804fefa335e54ad9c12', '[\"*\"]', NULL, NULL, '2024-08-21 09:52:38', '2024-08-21 09:52:38'),
(31, 'App\\Models\\User', 2, 'Personal Access Token', '1b4a09219359e19af8c6d177ddb89e8d6661da059d907dd22da49ae989f3861a', '[\"*\"]', NULL, NULL, '2024-08-21 09:58:16', '2024-08-21 09:58:16'),
(32, 'App\\Models\\User', 2, 'Personal Access Token', 'eb1d539058798d6b1c6e0cc5d7ea41387697c6aa0e23dd9f47c311922a0ee768', '[\"*\"]', NULL, NULL, '2024-08-21 10:46:33', '2024-08-21 10:46:33'),
(33, 'App\\Models\\User', 2, 'Personal Access Token', '7ae74a63f569e4e0a7ccd86db4082313149fabc3e7fd4957b4ab42dcbd2b80cd', '[\"*\"]', NULL, NULL, '2024-08-21 11:17:04', '2024-08-21 11:17:04'),
(34, 'App\\Models\\User', 2, 'Personal Access Token', 'f476b46c8bd22962ff28fb53ac7388aa0c6b08f1840d5b9b69d1fd88ba89315f', '[\"*\"]', NULL, NULL, '2024-08-21 11:17:50', '2024-08-21 11:17:50'),
(35, 'App\\Models\\User', 2, 'Personal Access Token', '0887dd0a24054a9f667046a1f58be1564f84a8bb2f11c31c5129a7682b1ad7c0', '[\"*\"]', NULL, NULL, '2024-08-23 09:08:51', '2024-08-23 09:08:51'),
(36, 'App\\Models\\User', 2, 'Personal Access Token', '5bd0e1f44f88409f4837c58eed253cdbbf5f8e4e73eb1fa45d2680fd00527c2f', '[\"*\"]', NULL, NULL, '2024-08-24 07:44:52', '2024-08-24 07:44:52'),
(37, 'App\\Models\\User', 6, 'Personal Access Token', '5b4efe5c7860d66db0c88e347b5e713fc534ee7bc963a6174b921ea3a76ef667', '[\"*\"]', NULL, NULL, '2024-08-24 08:00:33', '2024-08-24 08:00:33'),
(38, 'App\\Models\\User', 2, 'Personal Access Token', 'dac680735ddb53a58cc0a26acd64b4c72fb8f52c54d7407b952250e980611439', '[\"*\"]', NULL, NULL, '2024-08-24 10:38:07', '2024-08-24 10:38:07'),
(39, 'App\\Models\\User', 7, 'Personal Access Token', '6bba552759cba1a1a7b1f63783c995ec490e81dd5a2c8fe4359361cb9d168674', '[\"*\"]', NULL, NULL, '2024-08-29 12:25:23', '2024-08-29 12:25:23'),
(40, 'App\\Models\\User', 2, 'Personal Access Token', '2caa1afb43bcf68bc9f5f8755d4dfd51c247ba0db7edfdd2515d7198d587c5d2', '[\"*\"]', NULL, NULL, '2024-08-29 12:29:59', '2024-08-29 12:29:59'),
(41, 'App\\Models\\User', 2, 'Personal Access Token', '669bf1d8325b42994d57148d4474736f4ba267c45944ac6ced4a352ffe266312', '[\"*\"]', NULL, NULL, '2024-08-30 09:14:53', '2024-08-30 09:14:53'),
(42, 'App\\Models\\User', 2, 'Personal Access Token', '883a378594cc0af74007fe2fb05619cf7cfac4a74e60b0b534b6853c921557bf', '[\"*\"]', NULL, NULL, '2024-08-30 11:48:49', '2024-08-30 11:48:49'),
(43, 'App\\Models\\User', 2, 'Personal Access Token', 'f824594c43b45138726b80db71a0a3348e1fac436d0ee1ca2575553fe7eeb82d', '[\"*\"]', NULL, NULL, '2024-08-30 13:00:35', '2024-08-30 13:00:35'),
(44, 'App\\Models\\User', 9, 'Personal Access Token', '4613cb55de2b613d8df0d9ae19bd29624fd008b5cd9b28ce3514ca1d388cb6cf', '[\"*\"]', NULL, NULL, '2024-08-30 13:09:27', '2024-08-30 13:09:27'),
(45, 'App\\Models\\User', 10, 'Personal Access Token', '2b9a7cb4109421f9252142c5d0fbc566455452e27c4cee9e0f9876d1e4632afa', '[\"*\"]', NULL, NULL, '2024-08-31 09:53:42', '2024-08-31 09:53:42'),
(46, 'App\\Models\\User', 10, 'Personal Access Token', '4d2b5936787383dbecca9f7a0fe65540f09109529be7d48a0d6d1ff1cc49a98c', '[\"*\"]', NULL, NULL, '2024-08-31 09:56:12', '2024-08-31 09:56:12'),
(47, 'App\\Models\\User', 10, 'Personal Access Token', '17d99a2ae91b108e5f341fd227cc12bd9cab11f7c4d96355e341524b3e8e8b24', '[\"*\"]', NULL, NULL, '2024-08-31 09:57:22', '2024-08-31 09:57:22'),
(48, 'App\\Models\\User', 2, 'Personal Access Token', 'b04ecb678dce33c98102a7d84cb9ba4e99e66e19d5096be2f02e1bf9575c1a23', '[\"*\"]', NULL, NULL, '2024-08-31 10:06:14', '2024-08-31 10:06:14'),
(49, 'App\\Models\\User', 10, 'Personal Access Token', '3ab3b07ba00f59c2c14408e1b838c443783a07d314e68d977a4998b80780256a', '[\"*\"]', NULL, NULL, '2024-09-01 13:41:59', '2024-09-01 13:41:59'),
(50, 'App\\Models\\User', 1, 'Personal Access Token', '8943de2b8ef55d2dc3f6e188e349dc7319ed7b9c3969006f8bce801167949e1f', '[\"*\"]', NULL, NULL, '2024-09-05 09:54:29', '2024-09-05 09:54:29'),
(51, 'App\\Models\\User', 2, 'Personal Access Token', '17e85e7d025e7a765dc466b6b9693e3b5a707eb3007c7c805cf4a30d82f6688b', '[\"*\"]', NULL, NULL, '2024-09-28 07:44:19', '2024-09-28 07:44:19'),
(52, 'App\\Models\\User', 2, 'Personal Access Token', '2bade85004421730209a929f2322f028b30e6a392d0f4a8b3722d684adcda146', '[\"*\"]', NULL, NULL, '2024-09-28 10:01:45', '2024-09-28 10:01:45'),
(53, 'App\\Models\\User', 2, 'Personal Access Token', 'f8930b31b985488150427a5275547466ca0b32bd0b4c4aa13d817d93597f0f7f', '[\"*\"]', NULL, NULL, '2024-10-06 14:53:19', '2024-10-06 14:53:19'),
(54, 'App\\Models\\User', 2, 'Personal Access Token', 'de0176cdf5e44649cdd5e222fb80b84bd67acdb812f5d09f0daf7b7a4badc7da', '[\"*\"]', NULL, NULL, '2024-10-07 03:43:56', '2024-10-07 03:43:56'),
(55, 'App\\Models\\User', 2, 'Personal Access Token', 'b190e6afb8adc163cbfd06481620b4d24ce5da4261fca5dab43701c391c90f34', '[\"*\"]', NULL, NULL, '2024-10-07 03:54:24', '2024-10-07 03:54:24'),
(56, 'App\\Models\\User', 2, 'Personal Access Token', 'ca751ec679756dad1ae18032ab2f7231954d76c1474d64a1f51a8527b7c61566', '[\"*\"]', NULL, NULL, '2024-10-07 04:07:56', '2024-10-07 04:07:56'),
(57, 'App\\Models\\User', 2, 'Personal Access Token', '0f6273545e852ede5a26cfd95034edc9ddff0635237808b860fb34e0ed415642', '[\"*\"]', NULL, NULL, '2024-10-07 05:22:49', '2024-10-07 05:22:49'),
(58, 'App\\Models\\User', 2, 'Personal Access Token', 'c056509d54638c11585fc8691458638c96c9794270d1018901119fa273745652', '[\"*\"]', NULL, NULL, '2024-10-07 05:43:53', '2024-10-07 05:43:53'),
(59, 'App\\Models\\User', 2, 'Personal Access Token', 'de17c3e693450df2de3a1ad6409211fc62f6ddb47ab91e1090f06cce21dc26a1', '[\"*\"]', NULL, NULL, '2024-10-07 05:51:17', '2024-10-07 05:51:17'),
(60, 'App\\Models\\User', 2, 'Personal Access Token', '83cfa01ee789ed66f4153b8e3729593dcb5f5c764b823c0e5b3f13a10b5e7ab3', '[\"*\"]', NULL, NULL, '2024-10-07 05:54:19', '2024-10-07 05:54:19'),
(61, 'App\\Models\\User', 2, 'Personal Access Token', '644ae3316f52da0948aa5cc68d3a865b0461172478109ad683b0bc641531f080', '[\"*\"]', NULL, NULL, '2024-10-07 06:10:39', '2024-10-07 06:10:39'),
(62, 'App\\Models\\User', 2, 'Personal Access Token', '0b4631a1942e6f9436b0c24759d7efa13c91fa496b245f2232071c729f31939d', '[\"*\"]', NULL, NULL, '2024-10-07 06:19:20', '2024-10-07 06:19:20'),
(63, 'App\\Models\\User', 2, 'Personal Access Token', '1ecb96ee5b965011262fdef5ad0844aca28deeb66ece1a434d17801faca36e94', '[\"*\"]', NULL, NULL, '2024-10-07 07:22:09', '2024-10-07 07:22:09'),
(64, 'App\\Models\\User', 2, 'Personal Access Token', '5a42cb65c7d53198c46bb9e6421d27dd1b1a35113f5bce77aab0c547abe7bcaa', '[\"*\"]', NULL, NULL, '2024-10-07 07:46:38', '2024-10-07 07:46:38'),
(65, 'App\\Models\\User', 2, 'Personal Access Token', 'b0c302d36f90cfad87d03c62c9656eba70bc0743e533cd346462d1e574bc4269', '[\"*\"]', NULL, NULL, '2024-10-07 07:52:06', '2024-10-07 07:52:06'),
(66, 'App\\Models\\User', 2, 'Personal Access Token', '40af620eea7174944ddb22bdc881cc1ecb85adf3a1bd9b3e91ee7f09ca50fecb', '[\"*\"]', NULL, NULL, '2024-10-07 08:01:51', '2024-10-07 08:01:51'),
(67, 'App\\Models\\User', 2, 'Personal Access Token', '66c9e88a2443bcc24c1935be4d1abd16900f3d169a6c9c938f13698ebe8aa667', '[\"*\"]', NULL, NULL, '2024-10-07 08:29:42', '2024-10-07 08:29:42'),
(68, 'App\\Models\\User', 2, 'Personal Access Token', '6fca03884ac8f0237ed078007f08f4a2b3bef94a8581fa90f5e808a1b88ce00f', '[\"*\"]', NULL, NULL, '2024-10-07 09:44:24', '2024-10-07 09:44:24'),
(69, 'App\\Models\\User', 2, 'Personal Access Token', '255885786d4ac24fad1ec170bd07cd4933a5bd7422fcccd6de9fdb04119fa333', '[\"*\"]', NULL, NULL, '2024-10-07 10:21:19', '2024-10-07 10:21:19'),
(70, 'App\\Models\\User', 2, 'Personal Access Token', 'b30a9ccc65b486135449e35a5e1d2a8193600ace21d51c57ab196c34a892ded8', '[\"*\"]', NULL, NULL, '2024-10-07 10:45:42', '2024-10-07 10:45:42'),
(71, 'App\\Models\\User', 2, 'Personal Access Token', 'e04e14be28c2982cdaf9e75e5ba5d49b9abaa1fe5a60336f75ec67b2717bac45', '[\"*\"]', NULL, NULL, '2024-10-07 11:03:29', '2024-10-07 11:03:29'),
(72, 'App\\Models\\User', 2, 'Personal Access Token', 'ed7a4a5dafd6001d4aebfc23da580038f35a94a5dd089829d26136785d459eca', '[\"*\"]', NULL, NULL, '2024-10-07 11:20:26', '2024-10-07 11:20:26'),
(73, 'App\\Models\\User', 2, 'Personal Access Token', '1cd5ef6ca6a1f8f15cf96b964533a754a2f87a809896c8e33c703af6af5ea68f', '[\"*\"]', NULL, NULL, '2024-10-07 11:56:33', '2024-10-07 11:56:33'),
(74, 'App\\Models\\User', 2, 'Personal Access Token', '06ecdf1c79adc2f2dd54fcb49370a6cb67d15a98b6bafa3df353ddbded4b7f13', '[\"*\"]', NULL, NULL, '2024-10-07 12:26:26', '2024-10-07 12:26:26'),
(75, 'App\\Models\\User', 2, 'Personal Access Token', '6402ccedb55278e7af7e9566ddc636ca6e4ca646fef1544d4a0e33f7ee6df37f', '[\"*\"]', NULL, NULL, '2024-10-07 12:26:52', '2024-10-07 12:26:52'),
(76, 'App\\Models\\User', 2, 'Personal Access Token', '3fb3c0e717c59904f46a5b990bfbda367b94c717151db45f28b827d108f274d8', '[\"*\"]', NULL, NULL, '2024-10-07 13:56:41', '2024-10-07 13:56:41'),
(77, 'App\\Models\\User', 2, 'Personal Access Token', '9d909915a8b82f62c8c43c66a5bf55ec7d94d9d7f9b41c84c73534629fcbf811', '[\"*\"]', NULL, NULL, '2024-10-07 14:04:22', '2024-10-07 14:04:22'),
(78, 'App\\Models\\User', 2, 'Personal Access Token', 'af3578db2249de599561fcde2ed682097942ccb85607b0dde8ecb62d2d26a0a3', '[\"*\"]', NULL, NULL, '2024-10-08 01:43:35', '2024-10-08 01:43:35'),
(79, 'App\\Models\\User', 2, 'Personal Access Token', '3f48f230971c411a1526391fe8032532b38af79fe10b193796af60fd162b2686', '[\"*\"]', NULL, NULL, '2024-10-08 02:15:07', '2024-10-08 02:15:07'),
(80, 'App\\Models\\User', 2, 'Personal Access Token', '91e7a99294a1796edbc716f562f7b3a26b03030714f5c5dd5e9a4eafaf68d240', '[\"*\"]', NULL, NULL, '2024-10-08 02:15:24', '2024-10-08 02:15:24'),
(81, 'App\\Models\\User', 2, 'Personal Access Token', '4559572d472781ab5483aa40f0f614a9f5b2010d852cceb01f549b46fe34ad67', '[\"*\"]', NULL, NULL, '2024-10-08 02:48:16', '2024-10-08 02:48:16'),
(82, 'App\\Models\\User', 2, 'Personal Access Token', '23dc3ca7f4f7dfe493e64727bdd71e780bb51b285d8d6d6be17fe885264fd632', '[\"*\"]', NULL, NULL, '2024-10-08 03:02:30', '2024-10-08 03:02:30'),
(83, 'App\\Models\\User', 2, 'Personal Access Token', '6ab803b3561aa3f93070d7c3fa2beab10cc7ba183e95628b8d960fd478cd761b', '[\"*\"]', NULL, NULL, '2024-10-08 11:36:11', '2024-10-08 11:36:11'),
(84, 'App\\Models\\User', 2, 'Personal Access Token', '0bc109080ba079b0b26c914d49aa173957d74045c76112e4f81805069f6480e1', '[\"*\"]', NULL, NULL, '2024-10-08 11:43:52', '2024-10-08 11:43:52'),
(85, 'App\\Models\\User', 2, 'Personal Access Token', '8bc18f6873f44c28b5992480bc00a2bded9f30c69dcf4cd92b6e0e6be918899d', '[\"*\"]', NULL, NULL, '2024-10-08 11:56:04', '2024-10-08 11:56:04'),
(86, 'App\\Models\\User', 2, 'Personal Access Token', '15380b919dec777192c1e9f1ddc097e12862a1e29651b30c2b86a453a5823d10', '[\"*\"]', NULL, NULL, '2024-10-08 12:11:37', '2024-10-08 12:11:37'),
(87, 'App\\Models\\User', 2, 'Personal Access Token', 'cea2f85500d3ba02c1b6bb10a6d4afe6911509de8ce07f9e118b6780070b385e', '[\"*\"]', NULL, NULL, '2024-10-10 06:18:41', '2024-10-10 06:18:41'),
(88, 'App\\Models\\User', 2, 'Personal Access Token', 'cb25afd214d27855d47ce70ba2449653f2d2abd72d40817c7a5c71197b6bd605', '[\"*\"]', NULL, NULL, '2024-10-12 03:18:13', '2024-10-12 03:18:13'),
(89, 'App\\Models\\User', 2, 'Personal Access Token', '405ec8f40a40f4a8826fe22fd458d1dfea06019c9228bb4e122d18f5a0e9e058', '[\"*\"]', NULL, NULL, '2024-10-22 06:01:18', '2024-10-22 06:01:18'),
(90, 'App\\Models\\User', 10, 'Personal Access Token', 'cecbac8afd4fda4e4dac5b5b6e577087dcda488bcc02e1b44e277c13e4a20594', '[\"*\"]', NULL, NULL, '2024-10-26 09:39:11', '2024-10-26 09:39:11'),
(91, 'App\\Models\\User', 10, 'Personal Access Token', '0027195a315cf8f8b63e770d1a470d4b460a5e206d13a77ee0398e8440a1961e', '[\"*\"]', NULL, NULL, '2024-10-26 09:40:10', '2024-10-26 09:40:10'),
(92, 'App\\Models\\User', 2, 'Personal Access Token', '3f87f2ad43d4d21ae2859de276f9924185047b2e9a19107a77cf92274491368c', '[\"*\"]', NULL, NULL, '2024-11-06 06:14:26', '2024-11-06 06:14:26'),
(93, 'App\\Models\\User', 2, 'Personal Access Token', 'c1d0b97923045774e9badb29ac1ce21bdc9297d66b1ed9c96b034aca706da18a', '[\"*\"]', NULL, NULL, '2024-11-06 06:24:23', '2024-11-06 06:24:23'),
(94, 'App\\Models\\User', 2, 'Personal Access Token', '2f5001c5cb96326836a6be41be246c8056112e80f2ff4c88d1e0ba375a192b5c', '[\"*\"]', NULL, NULL, '2024-11-06 12:15:42', '2024-11-06 12:15:42'),
(95, 'App\\Models\\User', 2, 'Personal Access Token', '195cef3dcc1531488a03637337d19571df17614923e16e28286ffb3efa71158f', '[\"*\"]', NULL, NULL, '2024-11-07 05:45:40', '2024-11-07 05:45:40'),
(96, 'App\\Models\\User', 2, 'Personal Access Token', 'c99b089fc753a2ece581b0a37b4827239e14077dc79fa4b755926a919a8fcf44', '[\"*\"]', NULL, NULL, '2024-11-07 05:45:56', '2024-11-07 05:45:56'),
(97, 'App\\Models\\User', 2, 'Personal Access Token', '062579b2b45f8f49ec3a61a65a0abf2f1a1d264e496daf19ef480bc672a1ca0f', '[\"*\"]', NULL, NULL, '2024-11-07 05:46:14', '2024-11-07 05:46:14'),
(98, 'App\\Models\\User', 2, 'Personal Access Token', 'ad87a94fed03257a80374fe8225775b2733067aff3bd99572cec9285ce37fadf', '[\"*\"]', NULL, NULL, '2024-11-07 05:46:17', '2024-11-07 05:46:17'),
(99, 'App\\Models\\User', 2, 'Personal Access Token', 'b61f2790dd0cf4f510bcd8c68f3231f8f13d83ef746651e08c28183693fca84a', '[\"*\"]', NULL, NULL, '2024-11-07 05:55:53', '2024-11-07 05:55:53'),
(100, 'App\\Models\\User', 2, 'Personal Access Token', '1fc487933ee058a52746761d903e3981f4e76115a344cebf683cdf457a9f05de', '[\"*\"]', NULL, NULL, '2024-11-07 05:55:57', '2024-11-07 05:55:57'),
(101, 'App\\Models\\User', 2, 'Personal Access Token', '40d40bb0486b601ab7e981b3e8545b218219614a815f2bbb3771986bea6ac232', '[\"*\"]', NULL, NULL, '2024-11-07 05:56:33', '2024-11-07 05:56:33'),
(102, 'App\\Models\\User', 2, 'Personal Access Token', '7a5a8dc8f247328f4d1869ba20eab17fe39fbe5ca7dec0c940fc2ea1cbd6b693', '[\"*\"]', NULL, NULL, '2024-11-07 05:57:43', '2024-11-07 05:57:43'),
(103, 'App\\Models\\User', 2, 'Personal Access Token', '798147f19843c936b3255988b7a2b5379ec78349b9a424796ecd3c00c4d3f94f', '[\"*\"]', NULL, NULL, '2024-11-10 16:29:06', '2024-11-10 16:29:06'),
(104, 'App\\Models\\User', 2, 'Personal Access Token', 'f9cb7e5496a1a79d36f3d72037dbd76c256b3203e414953aa192019db674e064', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:03', '2024-11-10 16:30:03'),
(105, 'App\\Models\\User', 2, 'Personal Access Token', '5bdf5937ac0aa1e675639748477a67aed4504f3bbe54aebd822398b826e15d8f', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:12', '2024-11-10 16:30:12'),
(106, 'App\\Models\\User', 2, 'Personal Access Token', 'e7c37ab5de194455b05b4f979eb7d914b8e4734d254b60701863c2686af3bf44', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:26', '2024-11-10 16:30:26'),
(107, 'App\\Models\\User', 2, 'Personal Access Token', '68e035e5c59e5434aabaa50d7d39a4322d0bf9397140bafda8e78708de386bde', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:30', '2024-11-10 16:30:30'),
(108, 'App\\Models\\User', 2, 'Personal Access Token', '036bffaf3a2c5baf3df833a11f4d633df7c29bc28b9f121a4b66d23cb415dee8', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:33', '2024-11-10 16:30:33'),
(109, 'App\\Models\\User', 2, 'Personal Access Token', '0c1bd5400f711ad7d2d3c2b1f56333ba253dc30ed42238216015d5923f0217c9', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:42', '2024-11-10 16:30:42'),
(110, 'App\\Models\\User', 2, 'Personal Access Token', 'aacf7ac9b833d46f2ca5cf1b342d0631b3e205e6b42b0d9f8649c18f2a16ee26', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:44', '2024-11-10 16:30:44'),
(111, 'App\\Models\\User', 2, 'Personal Access Token', 'b993383bd8d1edc9e9c1c21a64805f45b2c37ffed41b025980f92a7793a1bc22', '[\"*\"]', NULL, NULL, '2024-11-10 16:30:47', '2024-11-10 16:30:47'),
(112, 'App\\Models\\User', 2, 'Personal Access Token', '629adfa6f4ab0430cbd01245ea1a792f1ecf0acfea28ca371c1ac229334aa506', '[\"*\"]', NULL, NULL, '2024-11-10 16:31:02', '2024-11-10 16:31:02'),
(113, 'App\\Models\\User', 2, 'Personal Access Token', 'b924fc2289710e1e26c84e077cd85d2aacd6364f8505596b4663fa45738093a5', '[\"*\"]', NULL, NULL, '2024-11-10 16:33:23', '2024-11-10 16:33:23'),
(114, 'App\\Models\\User', 2, 'Personal Access Token', '0204405cf8f4e9c39ad894b44af342cad5df756505c4767014b8f2dc64d6fcb8', '[\"*\"]', NULL, NULL, '2024-11-10 16:33:46', '2024-11-10 16:33:46'),
(115, 'App\\Models\\User', 2, 'Personal Access Token', 'bf5d276820b8fbed1605160c806136c6063d1a0db2ccd401bd5971a560e3aa4c', '[\"*\"]', NULL, NULL, '2024-11-10 16:34:09', '2024-11-10 16:34:09'),
(116, 'App\\Models\\User', 2, 'Personal Access Token', '48a9c42d665981c30681431dc4546ccfbd331c1b56b367fdab0ae9f6a6c1ca36', '[\"*\"]', NULL, NULL, '2024-11-10 17:21:28', '2024-11-10 17:21:28'),
(117, 'App\\Models\\User', 2, 'Personal Access Token', '7703aff8861ede7e6e4c7c9967a1be16a9644dc1154da33bf6742865510a3356', '[\"*\"]', NULL, NULL, '2024-11-10 17:52:33', '2024-11-10 17:52:33'),
(118, 'App\\Models\\User', 2, 'Personal Access Token', '8767437b22035785f156a5c620e73c2a6f6d779eb0f485b113aabf9938a4d0f2', '[\"*\"]', NULL, NULL, '2024-11-10 17:52:36', '2024-11-10 17:52:36'),
(119, 'App\\Models\\User', 2, 'Personal Access Token', 'b0f43b9f2e234f195013ba0cf1a206f12d2f74744c7f714eb6b4254332b95815', '[\"*\"]', NULL, NULL, '2024-11-10 17:52:37', '2024-11-10 17:52:37'),
(120, 'App\\Models\\User', 2, 'Personal Access Token', '30739f98ea18a15586fecb42c56179a5e3234b00a9cdfbbae63792eda2041d6b', '[\"*\"]', NULL, NULL, '2024-11-11 07:49:11', '2024-11-11 07:49:11'),
(121, 'App\\Models\\User', 2, 'Personal Access Token', 'a36da6dc0da92342a27e691e88392d3a3a600a4eb3233567e8c79641b4556cad', '[\"*\"]', NULL, NULL, '2024-11-11 07:49:15', '2024-11-11 07:49:15'),
(122, 'App\\Models\\User', 2, 'Personal Access Token', 'c9b2855f33cf5a33aa36c0be88bcf646e4225ea6c15e9c16af549432329cde9a', '[\"*\"]', NULL, NULL, '2024-11-11 07:51:22', '2024-11-11 07:51:22'),
(123, 'App\\Models\\User', 2, 'Personal Access Token', 'f8bce35d22d59a1e444588a29d2b5e152c302bfcce1d668675170a0cd10244ad', '[\"*\"]', NULL, NULL, '2024-11-11 07:58:04', '2024-11-11 07:58:04'),
(124, 'App\\Models\\User', 2, 'Personal Access Token', '2eb4184c2e7ac5ffdf6e99453f2e8ad1caacb341b6ee7306165ffeb34a417f04', '[\"*\"]', NULL, NULL, '2024-11-11 09:12:34', '2024-11-11 09:12:34'),
(125, 'App\\Models\\User', 2, 'Personal Access Token', '153fc2d92ff0fcb515f6e170175068c5e8868bbf9341c59f4db8bf1edf6a46b9', '[\"*\"]', NULL, NULL, '2024-11-11 10:49:58', '2024-11-11 10:49:58'),
(126, 'App\\Models\\User', 8, 'Personal Access Token', 'acc6b0d610e5cd0081d27be7bf51190e4b775ef2bb0920e3b460dd8abe233db5', '[\"*\"]', NULL, NULL, '2024-11-11 12:09:47', '2024-11-11 12:09:47'),
(127, 'App\\Models\\User', 2, 'Personal Access Token', 'd0fa0bda5df6daddae0f5d118b3c951adb7f77eb5c85a07e33f77d7fc498de9f', '[\"*\"]', NULL, NULL, '2024-11-11 12:13:20', '2024-11-11 12:13:20'),
(128, 'App\\Models\\User', 8, 'Personal Access Token', 'adb425a155c44bb90138f58fb595be30a7a1fbc6d7c31a977ff00c26af17c319', '[\"*\"]', NULL, NULL, '2024-11-15 07:50:26', '2024-11-15 07:50:26'),
(129, 'App\\Models\\User', 8, 'Personal Access Token', 'e078736adfc6343780dd566e2b76c9bc5e0dd406588c8f5466df8b0a43ea3f6f', '[\"*\"]', NULL, NULL, '2024-11-15 11:29:26', '2024-11-15 11:29:26'),
(130, 'App\\Models\\User', 8, 'Personal Access Token', 'c2a90fe3c21bf4c25c70b600afb52a8fffc603013cda3a6f89cb7cb3ae187f95', '[\"*\"]', NULL, NULL, '2024-11-15 11:29:46', '2024-11-15 11:29:46'),
(131, 'App\\Models\\User', 8, 'Personal Access Token', '22cc992db4bda0e63b3cca8401d5544233dd9b47a005076d2c1a759659fafc73', '[\"*\"]', NULL, NULL, '2024-11-15 11:45:04', '2024-11-15 11:45:04'),
(132, 'App\\Models\\User', 8, 'Personal Access Token', 'ed7b1a4e9f01470f3e0e6f1bb09824929ec06c4b6fa1c826103f7fc63f77c6b0', '[\"*\"]', NULL, NULL, '2024-11-15 12:27:03', '2024-11-15 12:27:03'),
(133, 'App\\Models\\User', 2, 'Personal Access Token', '01beb5088f619df1f0d1a57c1a344ad68fb78a1967592cf9bf41e221f27049f9', '[\"*\"]', NULL, NULL, '2024-11-16 01:53:35', '2024-11-16 01:53:35'),
(134, 'App\\Models\\User', 8, 'Personal Access Token', '7ca44d80106a2a820195bf8164b21f57e992241ae956621d9d21272a46dafc0a', '[\"*\"]', NULL, NULL, '2024-11-16 07:54:19', '2024-11-16 07:54:19'),
(135, 'App\\Models\\User', 2, 'Personal Access Token', '8283e08a300fff44974c7959ab949e79b7c3ec87c485cce1de1d968b3e114c67', '[\"*\"]', NULL, NULL, '2024-11-16 09:17:49', '2024-11-16 09:17:49'),
(136, 'App\\Models\\User', 2, 'Personal Access Token', '62906d46c8b14bc75886b808ddabe7b2d7b3420774302a303a5bfba16a2e34cd', '[\"*\"]', NULL, NULL, '2024-11-16 09:19:31', '2024-11-16 09:19:31'),
(137, 'App\\Models\\User', 8, 'Personal Access Token', 'bd29e168a5a2afa4c6ba8e6de622570a40de4ce3a3299be05cee7d72c621f0af', '[\"*\"]', NULL, NULL, '2024-11-16 09:20:57', '2024-11-16 09:20:57'),
(138, 'App\\Models\\User', 2, 'Personal Access Token', '2d3d096940c896732a5de1726899c110685b2a4f313450f6e143b9d06333564e', '[\"*\"]', NULL, NULL, '2024-11-16 10:11:33', '2024-11-16 10:11:33'),
(139, 'App\\Models\\User', 8, 'Personal Access Token', '5bf9614bcb94cb70fbee258f39bc3346dc30a877608ed33d4df4fd58a5e8d357', '[\"*\"]', NULL, NULL, '2024-11-16 10:12:31', '2024-11-16 10:12:31'),
(140, 'App\\Models\\User', 2, 'Personal Access Token', '9772cdbf666cdfe3f4ed420f5a58a0c1ad7132d528728a31c4d24270bbcfcbb4', '[\"*\"]', NULL, NULL, '2024-11-16 11:17:07', '2024-11-16 11:17:07'),
(141, 'App\\Models\\User', 8, 'Personal Access Token', '9314e86fbe9bff8ff3cd4f2c49796018b3d71a22646a45512ec87dc0fbeef999', '[\"*\"]', NULL, NULL, '2024-11-22 12:17:59', '2024-11-22 12:17:59'),
(142, 'App\\Models\\User', 8, 'Personal Access Token', 'b2b141e78d44e4acef0aea27364abb26ab68d783f205f2c26cd7e080638d192d', '[\"*\"]', NULL, NULL, '2024-11-23 07:42:54', '2024-11-23 07:42:54'),
(143, 'App\\Models\\User', 2, 'Personal Access Token', 'f75c300ff6fb4e64643578cce47af750a06edf197e08e94bbb6d47a5500632d4', '[\"*\"]', NULL, NULL, '2024-11-23 10:55:02', '2024-11-23 10:55:02'),
(144, 'App\\Models\\User', 8, 'Personal Access Token', '9ddcd7058c7dbceef1eca3eef757dc93d743459d4cf9ab42edb11ac84b30b85c', '[\"*\"]', NULL, NULL, '2024-11-23 11:51:33', '2024-11-23 11:51:33'),
(145, 'App\\Models\\User', 8, 'Personal Access Token', '678cfcc826a2591ae0b539546b6c72e62c287544c39226208dcc7f4918988b2a', '[\"*\"]', NULL, NULL, '2024-11-23 12:03:52', '2024-11-23 12:03:52'),
(146, 'App\\Models\\User', 8, 'Personal Access Token', '1b6bd3753bc3b561a9e681abed75aaa86670dc11cdfee60aea48e25cf8678381', '[\"*\"]', NULL, NULL, '2024-11-29 09:59:09', '2024-11-29 09:59:09'),
(147, 'App\\Models\\User', 8, 'Personal Access Token', 'aadedbbdae8ad8626ec3753d01cce907d91e65af31ef323a88029379010b8c99', '[\"*\"]', NULL, NULL, '2024-11-29 10:51:25', '2024-11-29 10:51:25'),
(148, 'App\\Models\\User', 8, 'Personal Access Token', '594262203068406ad24466ed6d1378ebc70b3a4d00b08010eec32cea2a4503e9', '[\"*\"]', NULL, NULL, '2024-11-29 11:07:03', '2024-11-29 11:07:03'),
(149, 'App\\Models\\User', 8, 'Personal Access Token', 'f49349572bfa2f0303c080f60da4391db889d0f467df48ba1423e9b62f39105d', '[\"*\"]', NULL, NULL, '2024-11-29 11:20:15', '2024-11-29 11:20:15'),
(150, 'App\\Models\\User', 8, 'Personal Access Token', 'f3340215bcb4ea82775b4c77dee778a3246e34fce092fdf7db9da2710009e9e6', '[\"*\"]', NULL, NULL, '2024-11-29 12:13:37', '2024-11-29 12:13:37'),
(151, 'App\\Models\\User', 8, 'Personal Access Token', '8a40f6f336463d27be1cbb8f899faaf869db70bf03235e37feab2b10bf3cf44e', '[\"*\"]', NULL, NULL, '2024-11-30 06:39:12', '2024-11-30 06:39:12'),
(152, 'App\\Models\\User', 8, 'Personal Access Token', 'bda4ffa40f51cc19d1fe55537a2cde21d43d166b4dd6ef6a89e52f1a2b86a609', '[\"*\"]', NULL, NULL, '2024-11-30 07:14:15', '2024-11-30 07:14:15'),
(153, 'App\\Models\\User', 8, 'Personal Access Token', '60a27c3001e8fc6c70e9d4529b1d37ebdf320cc0d08acfb019448dd68ee4c25a', '[\"*\"]', NULL, NULL, '2024-11-30 07:17:39', '2024-11-30 07:17:39'),
(154, 'App\\Models\\User', 8, 'Personal Access Token', 'a9b9117961324afec194bc29ec13c0bccad40be6a803170a2bf9e14d70b55a66', '[\"*\"]', NULL, NULL, '2024-11-30 07:27:33', '2024-11-30 07:27:33'),
(155, 'App\\Models\\User', 8, 'Personal Access Token', 'f5e92b31cc11a7f828053d473f17f2c777234df8acf46075475cfb7eee732117', '[\"*\"]', NULL, NULL, '2024-11-30 07:33:35', '2024-11-30 07:33:35'),
(156, 'App\\Models\\User', 8, 'Personal Access Token', 'f183d42169042ea79262bcf9bd96ed636faed99f90292744d5d173fabf926843', '[\"*\"]', NULL, NULL, '2024-11-30 09:01:48', '2024-11-30 09:01:48'),
(157, 'App\\Models\\User', 2, 'Personal Access Token', 'a0ccf8e6041e029171dbabe2e0937d4e6d13f16a9139ef624731219789d0a175', '[\"*\"]', NULL, NULL, '2024-11-30 09:22:25', '2024-11-30 09:22:25'),
(158, 'App\\Models\\User', 8, 'Personal Access Token', 'ea88550d5aa1047e9f167a9e0f76d21b438bd2856f72f5251c3d2bc7e2c867e2', '[\"*\"]', NULL, NULL, '2024-11-30 09:29:12', '2024-11-30 09:29:12'),
(159, 'App\\Models\\User', 8, 'Personal Access Token', '2b2c2f56e5898edf8ba73ddcda1832627e0c5b797a9dfaa6e3c56df0f46441ee', '[\"*\"]', NULL, NULL, '2024-11-30 11:28:59', '2024-11-30 11:28:59'),
(160, 'App\\Models\\User', 22, 'Personal Access Token', 'b3236e57df6701a38165113a2252769be4b13247c20d5ce3a280add34e339905', '[\"*\"]', NULL, NULL, '2024-12-06 11:40:15', '2024-12-06 11:40:15'),
(161, 'App\\Models\\User', 24, 'Personal Access Token', '443a4e92293adecf33633fbdbee0dcd16208c5952cad4cb0516f9fdb30c9bd83', '[\"*\"]', NULL, NULL, '2024-12-06 11:57:48', '2024-12-06 11:57:48'),
(162, 'App\\Models\\User', 24, 'Personal Access Token', 'a80f30721553ec05163ab5190580c20b4eacfc6602139eb9d154e1292809340a', '[\"*\"]', NULL, NULL, '2024-12-06 11:58:49', '2024-12-06 11:58:49'),
(163, 'App\\Models\\User', 2, 'Personal Access Token', '4c8335f70742e5b5820333883f7bf4158793f79bd617663a91415b5ea2afcef7', '[\"*\"]', NULL, NULL, '2024-12-06 14:00:58', '2024-12-06 14:00:58'),
(164, 'App\\Models\\User', 8, 'Personal Access Token', 'a9d502ff4b0983831c13917ca6ee9ec0eba0e03f1919b0ca7aa985223c18c875', '[\"*\"]', NULL, NULL, '2024-12-06 14:01:28', '2024-12-06 14:01:28'),
(165, 'App\\Models\\User', 8, 'Personal Access Token', '6a15559c6af2d83bb4f8cde015d95389abfb9f4995546ddf1149d4d409ca5ab4', '[\"*\"]', NULL, NULL, '2024-12-07 07:19:31', '2024-12-07 07:19:31'),
(166, 'App\\Models\\User', 8, 'Personal Access Token', 'a24cffd99a3ac16ce1b5aba6cac30b53e8104e01c4deb70a6426ea705b7e823d', '[\"*\"]', NULL, NULL, '2024-12-07 10:10:48', '2024-12-07 10:10:48'),
(167, 'App\\Models\\User', 24, 'Personal Access Token', '9cebcce8eeb09d6202a1d1b271b5494f83a0ecbfb610e6b624d94e382bbca083', '[\"*\"]', NULL, NULL, '2024-12-07 11:55:02', '2024-12-07 11:55:02'),
(168, 'App\\Models\\User', 24, 'Personal Access Token', 'a5c954a66b7d50ab05a9b8b0dc6b97e6631a40774a2161ad0fde7eacb3225094', '[\"*\"]', NULL, NULL, '2024-12-10 10:58:17', '2024-12-10 10:58:17'),
(169, 'App\\Models\\User', 2, 'Personal Access Token', '4070f5367f125fbcf825ad99c043db2a07492aa8a614265b0240781b7245c169', '[\"*\"]', NULL, NULL, '2024-12-13 08:09:26', '2024-12-13 08:09:26'),
(170, 'App\\Models\\User', 24, 'Personal Access Token', '4adecbba895ab4db131cc93fc5f4dfe5e44e633ff35af9ef8aacc065acb1818f', '[\"*\"]', NULL, NULL, '2024-12-13 08:09:55', '2024-12-13 08:09:55'),
(171, 'App\\Models\\User', 24, 'Personal Access Token', '772c9af5b9be0bfad64340cab70779dedbd4a596cbfd5953bf5085b75fd38276', '[\"*\"]', NULL, NULL, '2024-12-13 08:19:00', '2024-12-13 08:19:00'),
(172, 'App\\Models\\User', 24, 'Personal Access Token', '7e25c6ee76da3604a1f7e3ca43b7122f2f625bbd982c1edd1dff74ad2976c24f', '[\"*\"]', NULL, NULL, '2024-12-13 09:01:54', '2024-12-13 09:01:54'),
(173, 'App\\Models\\User', 24, 'Personal Access Token', 'c02307199104d37e4a5b29c3daf2afe05e71122c0c1e5949768ab2ec04a156a8', '[\"*\"]', NULL, NULL, '2024-12-13 09:20:56', '2024-12-13 09:20:56'),
(174, 'App\\Models\\User', 24, 'Personal Access Token', '607f86d6f9afd70a97ba863658a3c93886af59131ec0bcdae0e6bd8a294b94b4', '[\"*\"]', NULL, NULL, '2024-12-13 09:30:43', '2024-12-13 09:30:43'),
(175, 'App\\Models\\User', 24, 'Personal Access Token', '863998901fd50c323c03b782a7122b8ea4af3dd152dea1c6bd56e3c4423cfaeb', '[\"*\"]', NULL, NULL, '2024-12-14 09:40:08', '2024-12-14 09:40:08'),
(176, 'App\\Models\\User', 24, 'Personal Access Token', '8d61e3698da71e59cde9ba7f6b668f44fd9f9cce7263f02c7c27ab7ef058fb0c', '[\"*\"]', NULL, NULL, '2024-12-19 07:26:18', '2024-12-19 07:26:18'),
(177, 'App\\Models\\User', 2, 'Personal Access Token', '33f512ef15fbd04eca0f85508a3a56129daaeab5013c8a54d974154c96923eaf', '[\"*\"]', NULL, NULL, '2024-12-19 09:57:36', '2024-12-19 09:57:36'),
(178, 'App\\Models\\User', 24, 'Personal Access Token', 'c40ed56b7f14df1c877fcb86632a2768c322968e96a1d0fa5dea58847f538aaa', '[\"*\"]', NULL, NULL, '2024-12-19 09:58:01', '2024-12-19 09:58:01'),
(179, 'App\\Models\\User', 24, 'Personal Access Token', 'fd461b30826e3679b5db250db53c25ea1ec0b7b25f2d86dd31eb43f3e29585f9', '[\"*\"]', NULL, NULL, '2024-12-19 11:14:22', '2024-12-19 11:14:22'),
(180, 'App\\Models\\User', 24, 'Personal Access Token', 'd6031a6bf0ec5d54586ea67e230f57e0382f05532f03e834c862498bad20b46e', '[\"*\"]', NULL, NULL, '2024-12-21 07:51:57', '2024-12-21 07:51:57'),
(181, 'App\\Models\\User', 24, 'Personal Access Token', '321029c6cb365ae2448f84cfad6b68df2c94251d9405423380b1f9df1c59b900', '[\"*\"]', NULL, NULL, '2024-12-21 08:04:08', '2024-12-21 08:04:08'),
(182, 'App\\Models\\User', 24, 'Personal Access Token', 'a0a947d3cdbc4ddd5d4e68d418546581bd8491fd6cde73e36ee840a3a9957cb5', '[\"*\"]', NULL, NULL, '2024-12-21 08:21:56', '2024-12-21 08:21:56'),
(183, 'App\\Models\\User', 24, 'Personal Access Token', '3eff55e958541c0dbccd823848f9c32210c7b8e2f17eaec83eb483446e7dbd48', '[\"*\"]', NULL, NULL, '2024-12-21 08:22:56', '2024-12-21 08:22:56'),
(184, 'App\\Models\\User', 2, 'Personal Access Token', 'ac382c09364bb3addb95dce6934bc939af4c39d498f7bb181cac4ad4a5af6fce', '[\"*\"]', NULL, NULL, '2024-12-21 10:45:37', '2024-12-21 10:45:37'),
(185, 'App\\Models\\User', 24, 'Personal Access Token', 'df1ad297184a99d37631b1438aafa1116eff4bad7557511233c65ed92f62dd65', '[\"*\"]', NULL, NULL, '2024-12-21 10:47:53', '2024-12-21 10:47:53'),
(186, 'App\\Models\\User', 24, 'Personal Access Token', '3744e62336579ab5be55097228c5c936f447d5ca1a474e9b65b45317b4959a64', '[\"*\"]', NULL, NULL, '2024-12-21 10:50:12', '2024-12-21 10:50:12'),
(187, 'App\\Models\\User', 24, 'Personal Access Token', '165c6ce3be95da68957ff0388443a7a6fd343aeeeb2d7499e8078bace9ff7e7e', '[\"*\"]', NULL, NULL, '2024-12-21 11:50:02', '2024-12-21 11:50:02'),
(188, 'App\\Models\\User', 24, 'Personal Access Token', '9d2c095d750eba4e860ccbe7943235293a6cdb8a921d5d5b780554ff334f9d80', '[\"*\"]', NULL, NULL, '2024-12-23 09:27:55', '2024-12-23 09:27:55'),
(189, 'App\\Models\\User', 24, 'Personal Access Token', 'e4e6ad29592335d9c22deaf2e86b0de454d8c1e34a696ae2faef0f0c5a5917c5', '[\"*\"]', NULL, NULL, '2024-12-23 09:44:01', '2024-12-23 09:44:01'),
(190, 'App\\Models\\User', 24, 'Personal Access Token', '8504a66c6e480f80e222fc7b8a54e306700970fc8972fc4ff57c42d76021ab3b', '[\"*\"]', NULL, NULL, '2024-12-23 10:03:46', '2024-12-23 10:03:46'),
(191, 'App\\Models\\User', 24, 'Personal Access Token', '9f5ca193b40b46e7bd9770457fd57103cde6957cf513ffbf9adddff27d828db0', '[\"*\"]', NULL, NULL, '2024-12-24 11:54:46', '2024-12-24 11:54:46'),
(192, 'App\\Models\\User', 24, 'Personal Access Token', 'a3da2a2d910ea57c8e4d21615886d7d2a86130c4bb0e78f00e2eeacc1d59f721', '[\"*\"]', NULL, NULL, '2024-12-24 13:32:04', '2024-12-24 13:32:04'),
(193, 'App\\Models\\User', 24, 'Personal Access Token', '9b82a21b764a42e4599ea4378854e327cb5d55c69d22188adaaca51aec7ff20e', '[\"*\"]', NULL, NULL, '2024-12-24 13:47:38', '2024-12-24 13:47:38'),
(194, 'App\\Models\\User', 24, 'Personal Access Token', '5376e7a85c9f73814123c72dab964298c7c9a7d4eafe0bf02b0d25bf7baefd7f', '[\"*\"]', NULL, NULL, '2024-12-24 13:57:33', '2024-12-24 13:57:33'),
(195, 'App\\Models\\User', 24, 'Personal Access Token', '9cc4d5518cdfbe68b9812afdada94ea28162fdd4c2191712793d7d87585cb3aa', '[\"*\"]', NULL, NULL, '2024-12-24 14:06:10', '2024-12-24 14:06:10'),
(196, 'App\\Models\\User', 24, 'Personal Access Token', '288f70eeec1c7a7340977d5758fa01f78d92a14194014a96bb54d70c359750e3', '[\"*\"]', NULL, NULL, '2024-12-24 14:21:15', '2024-12-24 14:21:15'),
(197, 'App\\Models\\User', 24, 'Personal Access Token', '3bdb8f4ce1f8a73a262fff08388d7cebbcf7180b51d8d2b666d3a4298ed0066a', '[\"*\"]', NULL, NULL, '2024-12-26 07:09:59', '2024-12-26 07:09:59'),
(198, 'App\\Models\\User', 24, 'Personal Access Token', '22161f03d2956b186a0fc5eac6ca4a2cc44ad3537dddbe28c2bb659effadbaba', '[\"*\"]', NULL, NULL, '2024-12-26 07:27:37', '2024-12-26 07:27:37'),
(199, 'App\\Models\\User', 24, 'Personal Access Token', 'c3a46847c69d47c0710f720d676486e2884cfa2894abb2476cb4e64f5123bf84', '[\"*\"]', NULL, NULL, '2024-12-26 07:35:54', '2024-12-26 07:35:54'),
(200, 'App\\Models\\User', 24, 'Personal Access Token', '0d3b64e860c4bb53ef2b684d6571d014f98fd50438d7b23817370eacf89e2662', '[\"*\"]', NULL, NULL, '2024-12-26 07:39:04', '2024-12-26 07:39:04'),
(201, 'App\\Models\\User', 24, 'Personal Access Token', 'd17322aa87d7c93e9b6e4771c9532ba54d4c833671bba8c08a2b685b3b956777', '[\"*\"]', NULL, NULL, '2024-12-26 08:43:38', '2024-12-26 08:43:38'),
(202, 'App\\Models\\User', 24, 'Personal Access Token', 'f68f31024b8283c6e066e130576464278537b85c130732625ac22783bfd76f34', '[\"*\"]', NULL, NULL, '2024-12-27 08:29:51', '2024-12-27 08:29:51'),
(203, 'App\\Models\\User', 24, 'Personal Access Token', '45bda2230b2abb856100c5d90c126ac9b5716db8d2099e172fc39e50bbe34306', '[\"*\"]', NULL, NULL, '2024-12-27 10:07:59', '2024-12-27 10:07:59'),
(204, 'App\\Models\\User', 2, 'Personal Access Token', '03bb1dc72d02ccbbcbc8d1913d06f7c957a4c04fd461402eca584e82c4d6dc85', '[\"*\"]', NULL, NULL, '2024-12-28 09:53:24', '2024-12-28 09:53:24'),
(205, 'App\\Models\\User', 24, 'Personal Access Token', 'a05dcd9ccc2871006feb5608c96365f4ec0452ea47cb6570af855689f1de57cf', '[\"*\"]', NULL, NULL, '2024-12-28 09:54:22', '2024-12-28 09:54:22'),
(206, 'App\\Models\\User', 2, 'Personal Access Token', 'ebde9e23971bcfa81d4de9c7831874f4a3870aaacdfb6e3033454881cb48a102', '[\"*\"]', NULL, NULL, '2024-12-28 09:57:17', '2024-12-28 09:57:17'),
(207, 'App\\Models\\User', 24, 'Personal Access Token', '9cd0c76723b8e872cc79d4e5268f2d5b7a112afaf470fdcaa8b9de94b67b2ab8', '[\"*\"]', NULL, NULL, '2024-12-28 10:11:20', '2024-12-28 10:11:20'),
(208, 'App\\Models\\User', 2, 'Personal Access Token', '222c912981ef81c2979a819d589b9bf0b5cad1205b273d77448b194f41202924', '[\"*\"]', NULL, NULL, '2025-01-03 11:38:25', '2025-01-03 11:38:25'),
(209, 'App\\Models\\User', 24, 'Personal Access Token', 'de941c4c2e2fbd82a69679d67c577069d1c4a0d7b64735b3e67ebb5bc44f7e03', '[\"*\"]', NULL, NULL, '2025-01-03 11:57:28', '2025-01-03 11:57:28'),
(210, 'App\\Models\\User', 2, 'Personal Access Token', 'da88136a5bf1848c3241eb3fde0b2165e515299e9c389affaa5d9095c8ab213a', '[\"*\"]', NULL, NULL, '2025-01-03 11:57:54', '2025-01-03 11:57:54'),
(211, 'App\\Models\\User', 24, 'Personal Access Token', 'dc4f047cfa9685f587ce3fc21537b1f13a8d12c1ccd47928f71a393b91921dae', '[\"*\"]', NULL, NULL, '2025-01-03 13:50:34', '2025-01-03 13:50:34'),
(212, 'App\\Models\\User', 2, 'Personal Access Token', 'db872bdb4748230a8e504027d219ec696e9976b76a43318c0e3f6a3758f2cf4b', '[\"*\"]', NULL, NULL, '2025-01-03 14:01:12', '2025-01-03 14:01:12'),
(213, 'App\\Models\\User', 2, 'Personal Access Token', '9cc78efc1649419d320d4ca2481fa6a9e78f6378590e28b08b5fa026744c54c6', '[\"*\"]', NULL, NULL, '2025-01-04 07:21:35', '2025-01-04 07:21:35'),
(214, 'App\\Models\\User', 24, 'Personal Access Token', '764778ba76a70fb81ad959a6728e9fc3e728293ca085f06374b2e13cfc56c264', '[\"*\"]', NULL, NULL, '2025-01-04 07:28:47', '2025-01-04 07:28:47'),
(215, 'App\\Models\\User', 2, 'Personal Access Token', '7406358720440f0b11c336f6428621d33bfd4dc31086a14e11e43445fe66c895', '[\"*\"]', NULL, NULL, '2025-01-04 07:31:02', '2025-01-04 07:31:02'),
(216, 'App\\Models\\User', 24, 'Personal Access Token', 'ae9f089315d18e64d76d8ca6e94d644c580b5d5fb0534eccab8c09002d3acde7', '[\"*\"]', NULL, NULL, '2025-01-04 08:06:07', '2025-01-04 08:06:07'),
(217, 'App\\Models\\User', 2, 'Personal Access Token', '4f360dd6242fba7943cfbd9a900515766f83b824cfe9572ff3234148adf0febd', '[\"*\"]', NULL, NULL, '2025-01-04 08:27:36', '2025-01-04 08:27:36'),
(218, 'App\\Models\\User', 24, 'Personal Access Token', 'b5293bdb722237e7865bb2d80986b1724efbd8056820f4bf40839ee28b79832a', '[\"*\"]', NULL, NULL, '2025-01-04 10:29:34', '2025-01-04 10:29:34'),
(219, 'App\\Models\\User', 2, 'Personal Access Token', '165bed81de4fcf6f29847b3c471c636cfa0714b49ea778e8ddecb041accac823', '[\"*\"]', NULL, NULL, '2025-01-04 10:31:11', '2025-01-04 10:31:11'),
(220, 'App\\Models\\User', 2, 'Personal Access Token', '787b18e061714d679d51d217d5a0c3c70cb8d7e0d15baf8d6aeb49f625d40417', '[\"*\"]', NULL, NULL, '2025-01-04 11:13:27', '2025-01-04 11:13:27'),
(221, 'App\\Models\\User', 24, 'Personal Access Token', '039ee2a70d32b2bae59d60f158684e634fc46e14aeb40bc23d3c4a1d844a22ed', '[\"*\"]', NULL, NULL, '2025-01-06 09:14:44', '2025-01-06 09:14:44'),
(222, 'App\\Models\\User', 2, 'Personal Access Token', '97f62034875154312632117ff5bbac38fd0a464952f3fb359f02671839241747', '[\"*\"]', NULL, NULL, '2025-01-08 13:18:40', '2025-01-08 13:18:40'),
(223, 'App\\Models\\User', 2, 'Personal Access Token', '733a5b3590ab5c4321baad9f0f35bf4bdbab27b12a7398cd19687823ec477ebd', '[\"*\"]', NULL, NULL, '2025-01-08 13:25:30', '2025-01-08 13:25:30'),
(224, 'App\\Models\\User', 2, 'Personal Access Token', 'ebf430791e684543ee301248cd9cf675d52d3d61d8a8253b4b79f9c16fa2bc3d', '[\"*\"]', NULL, NULL, '2025-01-09 06:58:51', '2025-01-09 06:58:51'),
(225, 'App\\Models\\User', 2, 'Personal Access Token', '66e5a2ce006cc0e26cc8316abc4679a79e628dbe1141956a0e837d1b60506dd5', '[\"*\"]', NULL, NULL, '2025-01-09 07:35:54', '2025-01-09 07:35:54'),
(226, 'App\\Models\\User', 2, 'Personal Access Token', '2d34f92b5ac4cac6969f34404ce09b9084c3f6b8cd6d62c5f26a888ddfd608de', '[\"*\"]', NULL, NULL, '2025-01-09 08:54:29', '2025-01-09 08:54:29'),
(227, 'App\\Models\\User', 24, 'Personal Access Token', 'afc2c04d0d5e17fb9d34aa0d91cbc316950115aa00e733f25fc661d90c5c123d', '[\"*\"]', NULL, NULL, '2025-01-09 09:16:54', '2025-01-09 09:16:54'),
(228, 'App\\Models\\User', 2, 'Personal Access Token', '78cfb242346cb664ae674a930ab097dedf87360ab956f3fdba4c3a8396b3363a', '[\"*\"]', NULL, NULL, '2025-01-09 09:18:45', '2025-01-09 09:18:45'),
(229, 'App\\Models\\User', 24, 'Personal Access Token', 'acd8ce8e4cbde4bd50dac18e4de288c306f292fcbd62e2a170ce269799b7bbcc', '[\"*\"]', NULL, NULL, '2025-01-09 12:08:09', '2025-01-09 12:08:09'),
(230, 'App\\Models\\User', 2, 'Personal Access Token', '30dee97b52b262636feeea090a1196ac985c6f8f1b45c4dc330450fe8fc653da', '[\"*\"]', NULL, NULL, '2025-01-09 12:08:41', '2025-01-09 12:08:41'),
(231, 'App\\Models\\User', 2, 'Personal Access Token', 'a1b59233cc0bbb6e2b0ffe0e454859d19f9171a49f8d9b5f63c8bbaf724d232a', '[\"*\"]', NULL, NULL, '2025-01-09 12:32:29', '2025-01-09 12:32:29'),
(232, 'App\\Models\\User', 2, 'Personal Access Token', '178999c2216b1e63498c64b72b007b4942aa8becea80f43091973018dab77c59', '[\"*\"]', NULL, NULL, '2025-01-09 12:43:48', '2025-01-09 12:43:48'),
(233, 'App\\Models\\User', 2, 'Personal Access Token', '51946f6ce759b6971494223edb60c329db451e40bd8c483c755af9654a76f13b', '[\"*\"]', NULL, NULL, '2025-01-10 10:07:06', '2025-01-10 10:07:06'),
(234, 'App\\Models\\User', 24, 'Personal Access Token', 'a12564ac4ae4e27faea930723afbccc4344997b71a3b9c95f523dc8d40cf25e1', '[\"*\"]', NULL, NULL, '2025-01-10 10:44:25', '2025-01-10 10:44:25'),
(235, 'App\\Models\\User', 2, 'Personal Access Token', 'dbbbeb668c760d97e9f3da60ed5c92da9bb5041107884ebdb90ad27d1d3ddd91', '[\"*\"]', NULL, NULL, '2025-01-10 10:48:12', '2025-01-10 10:48:12'),
(236, 'App\\Models\\User', 2, 'Personal Access Token', 'efc8c175a5132cbf147fcc793c1b718c01beca2254c0efcabb19ffd1721fba5a', '[\"*\"]', NULL, NULL, '2025-01-11 07:13:29', '2025-01-11 07:13:29'),
(237, 'App\\Models\\User', 2, 'Personal Access Token', '79d0620498c9335f53b367219329caff2fe89a51b1f016bf57eafae384854e68', '[\"*\"]', NULL, NULL, '2025-01-11 07:41:46', '2025-01-11 07:41:46'),
(238, 'App\\Models\\User', 24, 'Personal Access Token', '27364a36b0869659eba04d95dec2a41878b430c1a49a8ae43a72b3ec77953a8a', '[\"*\"]', NULL, NULL, '2025-01-11 10:19:33', '2025-01-11 10:19:33'),
(239, 'App\\Models\\User', 2, 'Personal Access Token', '51c0bf5044d7ebe06eff756485893f3f41d831ae4621e47e73084f4fe14c209b', '[\"*\"]', NULL, NULL, '2025-01-14 07:48:11', '2025-01-14 07:48:11'),
(240, 'App\\Models\\User', 24, 'Personal Access Token', 'cddcec4302a8d7ea118a1a7c04804a96279566c3d1ab10d4d7db89a4b10dc727', '[\"*\"]', NULL, NULL, '2025-01-14 08:00:48', '2025-01-14 08:00:48'),
(241, 'App\\Models\\User', 24, 'Personal Access Token', 'f381f9a8bc2294a84c310a9b43dd14b2820f40a13d009b0274cd9d6e89850157', '[\"*\"]', NULL, NULL, '2025-01-14 08:02:54', '2025-01-14 08:02:54'),
(242, 'App\\Models\\User', 24, 'Personal Access Token', 'fe07af45ea475b6a92e477f61970e395f06c2b8fe5ec3cfe38359f8e5ccd2e69', '[\"*\"]', NULL, NULL, '2025-01-14 11:30:32', '2025-01-14 11:30:32'),
(243, 'App\\Models\\User', 24, 'Personal Access Token', '84d6e53f3c2646f8887a66ea266f6bf93a2eed8fa285f4e49b656e9156956d49', '[\"*\"]', NULL, NULL, '2025-01-14 12:18:39', '2025-01-14 12:18:39'),
(244, 'App\\Models\\User', 24, 'Personal Access Token', 'b7b171d0ad1b054e2bf6fcf3cb7e5a29f4bfbbdf8a9f01ba6b2051705f62350a', '[\"*\"]', NULL, NULL, '2025-01-17 17:40:21', '2025-01-17 17:40:21'),
(245, 'App\\Models\\User', 2, 'Personal Access Token', 'c73ae5b9e99507a60d4c05c6b595fc98f6ac39bd8fcf9cc2244fb24af59fdbb7', '[\"*\"]', NULL, NULL, '2025-01-17 18:54:04', '2025-01-17 18:54:04'),
(246, 'App\\Models\\User', 24, 'Personal Access Token', '108ca1bf8c9ee48b1632a79433e4195330cad7348b35b7746ddc9e6efacfe1de', '[\"*\"]', NULL, NULL, '2025-01-17 19:04:37', '2025-01-17 19:04:37'),
(247, 'App\\Models\\User', 2, 'Personal Access Token', '08e013bd9235977b2fa5421115c144a4c4531053f77d55cb4654e68df350ff62', '[\"*\"]', NULL, NULL, '2025-01-20 19:45:11', '2025-01-20 19:45:11'),
(248, 'App\\Models\\User', 24, 'Personal Access Token', '51550eade7b10f5581350559545e8065e2c4be903d9fd4aefb2fdf6d0f78a409', '[\"*\"]', NULL, NULL, '2025-01-21 20:29:25', '2025-01-21 20:29:25'),
(249, 'App\\Models\\User', 2, 'Personal Access Token', 'a0aa6e6c0446ba984c6eaf4e02be6428e75481688d22145047a0843419a3e7da', '[\"*\"]', NULL, NULL, '2025-01-24 16:41:20', '2025-01-24 16:41:20'),
(250, 'App\\Models\\User', 24, 'Personal Access Token', '0951a7101763fd4360b27073ed355ee2f929359fc844467335eb81ee406e8e35', '[\"*\"]', NULL, NULL, '2025-01-24 17:07:13', '2025-01-24 17:07:13'),
(251, 'App\\Models\\User', 24, 'Personal Access Token', 'a515e7371d8313ce6ad9b6812edc1fcd10fcbdd04cb6998837d64e6f80956e4a', '[\"*\"]', NULL, NULL, '2025-01-24 17:35:04', '2025-01-24 17:35:04'),
(252, 'App\\Models\\User', 2, 'Personal Access Token', 'e57fac81488fb1f050f9b1b96b2c07ab8cebea2dedfe2c5afafb78f0981457a4', '[\"*\"]', NULL, NULL, '2025-01-24 20:52:07', '2025-01-24 20:52:07'),
(253, 'App\\Models\\User', 24, 'Personal Access Token', 'c40b447f612e2d7efa629e0c1c6bf832588f9e66b75755a8961d3bda516802ce', '[\"*\"]', NULL, NULL, '2025-01-25 13:23:12', '2025-01-25 13:23:12'),
(254, 'App\\Models\\User', 24, 'Personal Access Token', '7f92d038c6982d96dadf14a88bb9a70b9ca73327c37a6ba6745a7d3aa7d13e69', '[\"*\"]', NULL, NULL, '2025-01-25 13:39:25', '2025-01-25 13:39:25'),
(255, 'App\\Models\\User', 2, 'Personal Access Token', '71b5c8fb08759fbab96a02bdfcdbb8c89014dd690915435054bdcc985999f552', '[\"*\"]', NULL, NULL, '2025-01-25 13:39:39', '2025-01-25 13:39:39'),
(256, 'App\\Models\\User', 27, 'Personal Access Token', 'e30b6c040fb7f51db28d1a16c9310068324603c49a57635daf89ed1389cdbf0f', '[\"*\"]', NULL, NULL, '2025-01-25 13:44:27', '2025-01-25 13:44:27'),
(257, 'App\\Models\\User', 24, 'Personal Access Token', '30e1ac91a32b4fc50e72e4af00e4e2ae6201489278fdde106b3c9f2f9e4e4dea', '[\"*\"]', NULL, NULL, '2025-01-25 15:59:32', '2025-01-25 15:59:32'),
(258, 'App\\Models\\User', 2, 'Personal Access Token', 'ecf9dfd8164845f01ccc536fc3077f58b52a7b9f78194fa517be38f4a3f70cf0', '[\"*\"]', NULL, NULL, '2025-01-25 16:00:35', '2025-01-25 16:00:35'),
(259, 'App\\Models\\User', 24, 'Personal Access Token', '82448138c5b2b04c226760dab6a4c8ecb25132994e283185c5eee17d16b21107', '[\"*\"]', NULL, NULL, '2025-01-30 18:07:52', '2025-01-30 18:07:52'),
(260, 'App\\Models\\User', 2, 'Personal Access Token', '6d04f4b4b65edf8925b8d8729cbb65f2f7ed5b1e158000d51f887cf789ede27c', '[\"*\"]', NULL, NULL, '2025-01-30 18:08:19', '2025-01-30 18:08:19'),
(261, 'App\\Models\\User', 24, 'Personal Access Token', '33b03932cc8cba7c3d1d57f62d73b7e3901382e9385a19f5990f29118988fc06', '[\"*\"]', NULL, NULL, '2025-01-30 18:21:19', '2025-01-30 18:21:19');
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(262, 'App\\Models\\User', 2, 'Personal Access Token', '6cf6b17affb81e9a036b2ee2780ec4e1181b2a26231702006b473dcf2e634a3a', '[\"*\"]', NULL, NULL, '2025-01-30 18:27:58', '2025-01-30 18:27:58'),
(263, 'App\\Models\\User', 24, 'Personal Access Token', '0ca4b18bdb73ebde6f63ffd725782b1b6f71d04bc097712bd9f9c141b8c16ae5', '[\"*\"]', NULL, NULL, '2025-01-30 18:32:52', '2025-01-30 18:32:52'),
(264, 'App\\Models\\User', 2, 'Personal Access Token', '026fb3db882785f65e747a6003acfc868a15b25e6ebb6a03d4852cf22e7b9466', '[\"*\"]', NULL, NULL, '2025-01-30 18:44:31', '2025-01-30 18:44:31'),
(265, 'App\\Models\\User', 24, 'Personal Access Token', 'f87520bd7f20de58932cdf07916cf6964220314b440d2fd75fccf8fcb18c3d1d', '[\"*\"]', NULL, NULL, '2025-01-30 18:50:59', '2025-01-30 18:50:59'),
(266, 'App\\Models\\User', 2, 'Personal Access Token', '3eaecababc1a628b1397739ec8ea1946bcc5173a8b96650000b7ad1e0e4bb0fe', '[\"*\"]', NULL, NULL, '2025-01-30 18:51:20', '2025-01-30 18:51:20'),
(267, 'App\\Models\\User', 2, 'Personal Access Token', '1d238b0f12ce08686fca529ba28d715ab3da0b0190a59a72a7777433eaa02737', '[\"*\"]', NULL, NULL, '2025-01-30 19:08:38', '2025-01-30 19:08:38'),
(268, 'App\\Models\\User', 2, 'Personal Access Token', '69a0c2b581b31b3efb5b4daaaca883fd608b2596231d5c2bfb58576827c0dbc5', '[\"*\"]', NULL, NULL, '2025-01-31 14:49:10', '2025-01-31 14:49:10'),
(269, 'App\\Models\\User', 24, 'Personal Access Token', '87e1145e2fee3b1f56aa0355ca7d19c5de91c464e0eed907c0851b2a76e9767f', '[\"*\"]', NULL, NULL, '2025-01-31 17:30:46', '2025-01-31 17:30:46'),
(270, 'App\\Models\\User', 2, 'Personal Access Token', '3193ce57438ea6b756edcf238a919c3c4b90503431b9ff65512ec6f4742d1e54', '[\"*\"]', NULL, NULL, '2025-01-31 17:34:08', '2025-01-31 17:34:08'),
(271, 'App\\Models\\User', 24, 'Personal Access Token', '2c6cec67e1e2dad5593ea938cdf3f09656bea2698d5d63deedfb52e60607322d', '[\"*\"]', NULL, NULL, '2025-03-26 15:45:49', '2025-03-26 15:45:49'),
(272, 'App\\Models\\User', 2, 'Personal Access Token', '8c374e27be5502ceccf633d213ac3e1f922764e0796b9e2309d111f2cb484702', '[\"*\"]', NULL, NULL, '2025-04-03 17:14:05', '2025-04-03 17:14:05'),
(273, 'App\\Models\\User', 24, 'Personal Access Token', '043b204a1758408ebbdc0e027a726c03c12ba7fc9efdb8dc0a10c8dc3f7ed8ac', '[\"*\"]', NULL, NULL, '2025-04-04 18:23:52', '2025-04-04 18:23:52'),
(274, 'App\\Models\\User', 51, 'Personal Access Token', 'c18a3104831e14b4731bf9efcd1913abab16816ccaec0fcfa96955f6984449af', '[\"*\"]', NULL, NULL, '2025-04-16 14:46:42', '2025-04-16 14:46:42'),
(275, 'App\\Models\\User', 51, 'Personal Access Token', '6468fcc01017bc7a215ba7bf8cfcf4166ead60599582a66db06ac63b434b20b1', '[\"*\"]', NULL, NULL, '2025-04-18 19:36:40', '2025-04-18 19:36:40'),
(276, 'App\\Models\\User', 51, 'Personal Access Token', '82bd976dc68bf255bbcf48f0b8a0a44034f69de6d4a6d69902137d7547494ed8', '[\"*\"]', NULL, NULL, '2025-04-19 13:15:01', '2025-04-19 13:15:01'),
(277, 'App\\Models\\User', 51, 'Personal Access Token', 'de02d7cd0bd3445ac6cc615cc9ef616383190c3e43864cc2e9dffd4cfe5778c2', '[\"*\"]', NULL, NULL, '2025-04-19 13:28:11', '2025-04-19 13:28:11'),
(278, 'App\\Models\\User', 51, 'Personal Access Token', '3c21beb5d2757d86244a05a1be82718075d57db24cac2f9ccc014d9d67800015', '[\"*\"]', NULL, NULL, '2025-04-19 14:23:41', '2025-04-19 14:23:41'),
(279, 'App\\Models\\User', 51, 'Personal Access Token', 'e2dfcee32162024ae492e29eb52ddbc914d69f84c88a7def4623777ab61a2380', '[\"*\"]', NULL, NULL, '2025-04-19 14:25:20', '2025-04-19 14:25:20'),
(280, 'App\\Models\\User', 51, 'Personal Access Token', '3e508e6f42adc9a3d29bfb9c0c6c94fbed7aa1fe854aa47feaf7ebf0c3aa99bd', '[\"*\"]', NULL, NULL, '2025-04-19 14:26:14', '2025-04-19 14:26:14'),
(281, 'App\\Models\\User', 51, 'Personal Access Token', 'cdb781c4b8b957fa00819ef53406fa999ed4dbd5e6b2df135d43262feb84e148', '[\"*\"]', NULL, NULL, '2025-04-19 18:15:50', '2025-04-19 18:15:50'),
(282, 'App\\Models\\User', 51, 'Personal Access Token', '578d42496d5c1790282eb3915290ae3ccb69fffd6c8ba8573bfb31c6d4162c7b', '[\"*\"]', NULL, NULL, '2025-05-08 18:56:54', '2025-05-08 18:56:54'),
(283, 'App\\Models\\User', 51, 'Personal Access Token', '5fe9bad85617a156000bc058a2250745cb5f10a92e0345837c0dc14ab11807d8', '[\"*\"]', NULL, NULL, '2025-05-08 18:57:35', '2025-05-08 18:57:35'),
(284, 'App\\Models\\User', 58, 'Personal Access Token', '3ca466e5512c2e783446674238b9cb27a090a633d5bcf426b172628f8334f3fe', '[\"*\"]', NULL, NULL, '2025-05-09 12:33:29', '2025-05-09 12:33:29'),
(285, 'App\\Models\\User', 51, 'Personal Access Token', 'c855d3bf5105ef1e5d837ed42cfa536bc3e8bb43e0999a2868724fa2747afc17', '[\"*\"]', NULL, NULL, '2025-05-09 12:48:31', '2025-05-09 12:48:31'),
(286, 'App\\Models\\User', 59, 'Personal Access Token', 'a8fef4cd01ddccab9a1983e2406cd6f3f98180a071442b820987d3a18c736b13', '[\"*\"]', NULL, NULL, '2025-05-09 14:21:53', '2025-05-09 14:21:53'),
(287, 'App\\Models\\User', 59, 'Personal Access Token', '0ada37a49e8a8b81c21dd3219cef4464d21ecc5301574bf0cd736f5663164ad0', '[\"*\"]', NULL, NULL, '2025-05-09 17:42:51', '2025-05-09 17:42:51'),
(288, 'App\\Models\\User', 51, 'Personal Access Token', '8828c6ba0e5e18188cf084415f93180f5b97ff1c19be0eaa511ac6c784c035f6', '[\"*\"]', NULL, NULL, '2025-05-14 15:12:26', '2025-05-14 15:12:26'),
(289, 'App\\Models\\User', 51, 'Personal Access Token', 'b225434f2099564b1cb9c918b4610e05649f291319304df045aaf3dc4c024bc1', '[\"*\"]', NULL, NULL, '2025-05-14 15:16:19', '2025-05-14 15:16:19'),
(290, 'App\\Models\\User', 59, 'Personal Access Token', '3e295dc8bfbf9454ff51c8fdfceeb55449d61fd5432f30204b3f57d5027e3545', '[\"*\"]', NULL, NULL, '2025-05-14 17:03:45', '2025-05-14 17:03:45'),
(291, 'App\\Models\\User', 59, 'Personal Access Token', 'aab6505bb0d18c615ff0aa0d3646999219aaa0d9206573999cc7693d8ea37f06', '[\"*\"]', NULL, NULL, '2025-05-16 15:17:08', '2025-05-16 15:17:08'),
(292, 'App\\Models\\User', 59, 'Personal Access Token', '59f5a159a976037e2021b5109b7b84386881ac5b7a42da2a5775547369da00ad', '[\"*\"]', NULL, NULL, '2025-05-16 15:20:55', '2025-05-16 15:20:55'),
(293, 'App\\Models\\User', 51, 'Personal Access Token', '315e263041de50982a19f0961dd8d86f23fd5adab26d7322b3dd205dc5ea58f2', '[\"*\"]', NULL, NULL, '2025-05-16 18:35:24', '2025-05-16 18:35:24'),
(294, 'App\\Models\\User', 59, 'Personal Access Token', 'be6a6fac4a8e1b4ecbfb87be85c304e08f82e4f547da682e01313d06dbf62748', '[\"*\"]', NULL, NULL, '2025-05-16 18:39:20', '2025-05-16 18:39:20'),
(295, 'App\\Models\\User', 51, 'Personal Access Token', '7a08a8d5e4e65b0d2b85a01a33d12687d4acbd50f639ede9b8c8b19c2e343c89', '[\"*\"]', NULL, NULL, '2025-05-16 18:51:46', '2025-05-16 18:51:46'),
(296, 'App\\Models\\User', 51, 'Personal Access Token', '8a6b64104c89fa2b02d1fec8522d7d4f6ebfaa16ffdca74035401b6cb5ff18ca', '[\"*\"]', NULL, NULL, '2025-05-22 16:15:25', '2025-05-22 16:15:25'),
(297, 'App\\Models\\User', 59, 'Personal Access Token', 'af2315a93821cf9efd3d647ed345ca54320b7886347e03aa541d28651c1dabd5', '[\"*\"]', NULL, NULL, '2025-05-22 16:19:54', '2025-05-22 16:19:54'),
(298, 'App\\Models\\User', 59, 'Personal Access Token', '8a2ade85a60064d3175eb01c6c5c2b665b7672b09bc54eb2eb4919f9f6362956', '[\"*\"]', NULL, NULL, '2025-05-22 16:48:28', '2025-05-22 16:48:28'),
(299, 'App\\Models\\User', 59, 'Personal Access Token', 'fa7e4385cac43826a687543dcb73bfccf5697c9839dfe97c1fd0efb885c7b453', '[\"*\"]', NULL, NULL, '2025-05-22 17:10:28', '2025-05-22 17:10:28'),
(300, 'App\\Models\\User', 59, 'Personal Access Token', '87a261fad02fd930b22bfe6c1a574855ad6253339158a15897fe2b7597ac7dd9', '[\"*\"]', NULL, NULL, '2025-05-22 19:34:50', '2025-05-22 19:34:50'),
(301, 'App\\Models\\User', 51, 'Personal Access Token', '8c267c878e94d208e76a3cf0d96fbd24d3e0854b004c09a4ba42605dab4b5e6c', '[\"*\"]', NULL, NULL, '2025-05-26 16:10:10', '2025-05-26 16:10:10'),
(302, 'App\\Models\\User', 51, 'Personal Access Token', '6e091308aa2560b036ccfde9f86cdbfab86c862b978061168c923fd68e1b19fa', '[\"*\"]', NULL, NULL, '2025-05-26 16:55:57', '2025-05-26 16:55:57'),
(303, 'App\\Models\\User', 51, 'Personal Access Token', 'dbba8f5a98bce5994bad56a3dd03e55bbab4024f1eec5669f0cd6c026b848ebb', '[\"*\"]', NULL, NULL, '2025-05-26 18:00:57', '2025-05-26 18:00:57'),
(304, 'App\\Models\\User', 51, 'Personal Access Token', 'afaac2e381a6cba0b1c5aabe8283c1a8b2611701b7e32907715103edbb7b8579', '[\"*\"]', NULL, NULL, '2025-05-26 18:30:37', '2025-05-26 18:30:37'),
(305, 'App\\Models\\User', 59, 'Personal Access Token', '1ec7260ac9eb0fdd86cc03fa1ffdab4f49c294d16aaf1b3f7093558618e6df25', '[\"*\"]', NULL, NULL, '2025-05-30 14:14:28', '2025-05-30 14:14:28'),
(306, 'App\\Models\\User', 59, 'Personal Access Token', '15b0f8dae3bea66fff3eb8005702f11379ebd5ecfe2f3bd4051b70780a979e11', '[\"*\"]', NULL, NULL, '2025-05-30 14:45:22', '2025-05-30 14:45:22'),
(307, 'App\\Models\\User', 51, 'Personal Access Token', '13beb0d82b071ea2815f17c60eec48da9ace3239522bd34250d59b224e224513', '[\"*\"]', NULL, NULL, '2025-05-30 17:46:56', '2025-05-30 17:46:56'),
(308, 'App\\Models\\User', 59, 'Personal Access Token', '7a1a8bef87c129a37754d9642100f6ae6345abd16146c54c50645cd832068881', '[\"*\"]', NULL, NULL, '2025-05-30 17:47:15', '2025-05-30 17:47:15'),
(309, 'App\\Models\\User', 51, 'Personal Access Token', 'e7c4802731cc13ae38781ac931291730cb70b3e58b70aa4cc1241a428f15310a', '[\"*\"]', NULL, NULL, '2025-05-30 18:04:03', '2025-05-30 18:04:03'),
(310, 'App\\Models\\User', 59, 'Personal Access Token', 'da7b94f86decbc638671971e317ca9c3eef240e154049782dca4441288e6434c', '[\"*\"]', NULL, NULL, '2025-05-30 18:16:12', '2025-05-30 18:16:12'),
(311, 'App\\Models\\User', 51, 'Personal Access Token', '11666005481dda5742f766cf53cfdbaf60807a35d267d4200f68586642605583', '[\"*\"]', NULL, NULL, '2025-05-30 18:26:21', '2025-05-30 18:26:21'),
(312, 'App\\Models\\User', 60, 'Personal Access Token', '465feec9650774e8958a2d6a2a9ff87f536972c8097307552c27ce4263df8098', '[\"*\"]', NULL, NULL, '2025-05-31 06:53:02', '2025-05-31 06:53:02'),
(313, 'App\\Models\\User', 59, 'Personal Access Token', '69eb9892fc0c7cf41649b0ec78b229ac5a3043bf1d2eb95de1c8d50cf5fe7b76', '[\"*\"]', NULL, NULL, '2025-06-02 06:36:31', '2025-06-02 06:36:31'),
(314, 'App\\Models\\User', 51, 'Personal Access Token', '679f1c08652226adfcb7c55ce8476ca3ba9a6f495511b51ba9dbaa22d3083b9a', '[\"*\"]', NULL, NULL, '2025-06-04 10:59:08', '2025-06-04 10:59:08'),
(315, 'App\\Models\\User', 59, 'Personal Access Token', '4bf0244d415f5822a3eec6d132e067fd2629ebd4a05f34401eeee5e068e915cb', '[\"*\"]', NULL, NULL, '2025-06-09 12:20:44', '2025-06-09 12:20:44'),
(316, 'App\\Models\\User', 51, 'Personal Access Token', 'e6eb8a2d6f11cb346110464476e8cdb7504d131cdbcc512a17367fbaea3b37a5', '[\"*\"]', NULL, NULL, '2025-06-11 12:24:31', '2025-06-11 12:24:31'),
(317, 'App\\Models\\User', 59, 'Personal Access Token', '07046fa1b05778f6d6369fa69af45e7313284794b6975d5d9be16d6ad8cd8313', '[\"*\"]', NULL, NULL, '2025-06-11 12:24:47', '2025-06-11 12:24:47'),
(318, 'App\\Models\\User', 59, 'Personal Access Token', 'fefaab581bc2b342c2ff5634a9df111b0df28e448c0db45e11bc8bb97a4bfa9a', '[\"*\"]', NULL, NULL, '2025-06-13 17:00:26', '2025-06-13 17:00:26'),
(319, 'App\\Models\\User', 51, 'Personal Access Token', 'b4956812eebb18c309a56a44c2c9d4a9e629d7fb70625f82c9061b8ee9f83d02', '[\"*\"]', NULL, NULL, '2025-06-20 15:47:07', '2025-06-20 15:47:07'),
(320, 'App\\Models\\User', 59, 'Personal Access Token', '3a0664176899f622a32aa4bac0d632319722dd6dbe14d421c6e51fb544c8701c', '[\"*\"]', NULL, NULL, '2025-06-20 15:48:00', '2025-06-20 15:48:00'),
(321, 'App\\Models\\User', 59, 'Personal Access Token', '94d5d38069531ffc7605dbcfed99e62d4b4df569ac35073e672fca9d33951850', '[\"*\"]', NULL, NULL, '2025-06-20 15:54:31', '2025-06-20 15:54:31'),
(322, 'App\\Models\\User', 59, 'Personal Access Token', '4a6798a13619def727ae92c1b30581fe2fd29d86a08ff86b5b88d6196992d140', '[\"*\"]', NULL, NULL, '2025-06-20 16:49:48', '2025-06-20 16:49:48'),
(323, 'App\\Models\\User', 51, 'Personal Access Token', '2fd636330eb6f309d2e7451faeaa633eab3c17aee2c21557f5757e37a360819f', '[\"*\"]', NULL, NULL, '2025-06-23 17:00:31', '2025-06-23 17:00:31'),
(324, 'App\\Models\\User', 59, 'Personal Access Token', 'c922bf0fb46823b3fab86838f888b7fe6d603d32e1c84d30b128f773f5c25b07', '[\"*\"]', NULL, NULL, '2025-06-23 17:02:12', '2025-06-23 17:02:12'),
(325, 'App\\Models\\User', 59, 'Personal Access Token', '65d6b5a875894e65e507976e6058f63c26f800d640be065ae66272bafe4ebb66', '[\"*\"]', NULL, NULL, '2025-06-23 17:45:28', '2025-06-23 17:45:28'),
(326, 'App\\Models\\User', 62, 'Personal Access Token', 'fa5558e9d1c5ba496d29b5868170eaef15bfc21dcdf1e7f213b1d9b95dc87f25', '[\"*\"]', NULL, NULL, '2025-06-23 18:49:30', '2025-06-23 18:49:30'),
(327, 'App\\Models\\User', 63, 'Personal Access Token', '896853949282d24fd1a0ed7026907c172091aab7cb8e3172d0e8a694bf591b74', '[\"*\"]', NULL, NULL, '2025-06-23 18:59:13', '2025-06-23 18:59:13'),
(328, 'App\\Models\\User', 51, 'Personal Access Token', 'b9b93e0d7a10c5111a6e0580bb4f882f8247a194057d300ca9a3aa56db5bbbd6', '[\"*\"]', NULL, NULL, '2025-06-25 13:18:50', '2025-06-25 13:18:50'),
(329, 'App\\Models\\User', 63, 'Personal Access Token', 'c109f58494955184fe281b312ff35727823e2570e2b02da385f7b461bf56c1eb', '[\"*\"]', NULL, NULL, '2025-06-25 20:26:37', '2025-06-25 20:26:37'),
(330, 'App\\Models\\User', 62, 'Personal Access Token', '55ade5ed9ee4089743a3d378ddb096b8fcb69d6357aad937188bd08af84a7001', '[\"*\"]', NULL, NULL, '2025-06-25 20:28:42', '2025-06-25 20:28:42'),
(331, 'App\\Models\\User', 62, 'Personal Access Token', 'b958acc250d89101bf7c5906ab3b2c9494e06a93a7641e18b0b6bf7b210074d9', '[\"*\"]', NULL, NULL, '2025-06-25 20:35:34', '2025-06-25 20:35:34'),
(332, 'App\\Models\\User', 63, 'Personal Access Token', '7f995c340e91bf0386b900684193bb363a9381bd2d961216b38fc1f1b3915b12', '[\"*\"]', NULL, NULL, '2025-06-25 20:36:28', '2025-06-25 20:36:28'),
(333, 'App\\Models\\User', 51, 'Personal Access Token', '95d125bd1d02528d0d50289e4a98cf6223d7b5d31da30c953315d81b76ba92aa', '[\"*\"]', NULL, NULL, '2025-06-26 15:15:03', '2025-06-26 15:15:03'),
(334, 'App\\Models\\User', 51, 'Personal Access Token', 'd937b61585f52aa4fe28d04f2740ecdf6a25636f27c6c01c568a36d13a508791', '[\"*\"]', NULL, NULL, '2025-06-27 09:45:03', '2025-06-27 09:45:03'),
(335, 'App\\Models\\User', 51, 'Personal Access Token', '95d48d5c17fd1294fcf711525d690febf569cbeedced45988c2ac595b5961a02', '[\"*\"]', NULL, NULL, '2025-06-27 11:23:57', '2025-06-27 11:23:57'),
(336, 'App\\Models\\User', 59, 'Personal Access Token', '29635b36cfad77e1d97d9d91f3159c3a86c596c4b8fdf63838cfc5ea97973829', '[\"*\"]', NULL, NULL, '2025-06-27 14:27:07', '2025-06-27 14:27:07'),
(337, 'App\\Models\\User', 51, 'Personal Access Token', '1b2c70b206450cd28f88b33e20212e390548e7c04f8b097479a86d66df3ee65e', '[\"*\"]', NULL, NULL, '2025-06-27 14:28:15', '2025-06-27 14:28:15'),
(338, 'App\\Models\\User', 59, 'Personal Access Token', '18fce738c26d9fa437cb62bcea90d11aa9e8c313f9564e062f6c6ab2c4cd3691', '[\"*\"]', NULL, NULL, '2025-06-27 14:29:22', '2025-06-27 14:29:22'),
(339, 'App\\Models\\User', 51, 'Personal Access Token', '2f6e9828e7053611e8645b4dffca93b2a3826fb770a0946eab5523b2b46764a3', '[\"*\"]', NULL, NULL, '2025-06-27 18:54:13', '2025-06-27 18:54:13'),
(340, 'App\\Models\\User', 62, 'Personal Access Token', '90bfdf77f3e17c8adec1c94eb689503ba98333c95895022144d882fcaf25f9a9', '[\"*\"]', NULL, NULL, '2025-06-27 18:54:53', '2025-06-27 18:54:53'),
(341, 'App\\Models\\User', 62, 'Personal Access Token', 'ed9d7644d467fe105e73dd824484513601aabd40383fd886c075892d1f1ddc75', '[\"*\"]', NULL, NULL, '2025-06-27 18:58:19', '2025-06-27 18:58:19'),
(342, 'App\\Models\\User', 63, 'Personal Access Token', '8a72115ab76863cba539e1511f5fe1b564775effeee0d85f00237913bbf84bbd', '[\"*\"]', NULL, NULL, '2025-06-27 18:58:53', '2025-06-27 18:58:53'),
(343, 'App\\Models\\User', 59, 'Personal Access Token', '1a0dddcced2fa4aa44c7cf61a67b42104532e7d057eb3cd6d1db6a22a1c5c2d9', '[\"*\"]', NULL, NULL, '2025-07-01 17:25:05', '2025-07-01 17:25:05'),
(344, 'App\\Models\\User', 51, 'Personal Access Token', '120088d8499e6aa609e7cb3f810f3894f99aff8f7d712151718593754aed2361', '[\"*\"]', NULL, NULL, '2025-07-04 14:15:21', '2025-07-04 14:15:21'),
(345, 'App\\Models\\User', 59, 'Personal Access Token', '278d645917bdf6f82634bf9cc1b8f11830f549feff89303e728094e9d7c6620d', '[\"*\"]', NULL, NULL, '2025-07-04 16:26:58', '2025-07-04 16:26:58'),
(346, 'App\\Models\\User', 51, 'Personal Access Token', 'c727ca80938866a66378feeede967c2531d94eef966a67afd4af039ff3b128a8', '[\"*\"]', NULL, NULL, '2025-07-04 16:27:19', '2025-07-04 16:27:19'),
(347, 'App\\Models\\User', 10, 'Personal Access Token', 'b168153c009c66e1001cec6346abf1c507e05e434407d7155a181d63df9dd0ac', '[\"*\"]', NULL, NULL, '2025-07-04 18:14:32', '2025-07-04 18:14:32'),
(348, 'App\\Models\\User', 51, 'Personal Access Token', '585c0dcd904771c39e02c2fa687543aded402cc06f94489dee83a2f2db9750c7', '[\"*\"]', NULL, NULL, '2025-07-04 18:52:25', '2025-07-04 18:52:25'),
(349, 'App\\Models\\User', 59, 'Personal Access Token', '5f040c1941cd44aad2e845e4c65ecc647bd39ff57642c80b48bd8f577fa5694b', '[\"*\"]', NULL, NULL, '2025-07-05 16:33:05', '2025-07-05 16:33:05'),
(350, 'App\\Models\\User', 51, 'Personal Access Token', '51cce87fdb5222b42422a6ccfa58103df2799d3dcd2cbe81afbcff7ed4b7a5da', '[\"*\"]', NULL, NULL, '2025-07-05 16:33:29', '2025-07-05 16:33:29'),
(351, 'App\\Models\\User', 63, 'Personal Access Token', 'ac6312b071d8a5b549d485225e57a7a13ef495ae6169d530f7aea0128814a30b', '[\"*\"]', NULL, NULL, '2025-07-06 05:25:33', '2025-07-06 05:25:33'),
(352, 'App\\Models\\User', 51, 'Personal Access Token', '407cdb970cf1a78da1cccb73411f6e4c494b50d779869b7f5ce4516ac84871f3', '[\"*\"]', NULL, NULL, '2025-07-07 13:06:47', '2025-07-07 13:06:47'),
(353, 'App\\Models\\User', 51, 'Personal Access Token', 'd0af4d13300c173db8b8800951cd447f037cdff789e88254ad3c6a51f1058a17', '[\"*\"]', NULL, NULL, '2025-07-08 11:52:48', '2025-07-08 11:52:48'),
(354, 'App\\Models\\User', 51, 'Personal Access Token', '7e022f70557d0248459b4a5a746175866679f1faa388b28fa917425ac62db56b', '[\"*\"]', NULL, NULL, '2025-07-08 11:53:34', '2025-07-08 11:53:34'),
(355, 'App\\Models\\User', 51, 'Personal Access Token', '38c4471d3c7b737f2bc55856294e305759e1e911172a21182f4d6826410c7c50', '[\"*\"]', NULL, NULL, '2025-07-08 11:53:45', '2025-07-08 11:53:45'),
(356, 'App\\Models\\User', 51, 'Personal Access Token', 'dd245db732148932adfb1543095802bb9fdbe7ea443244eff67a84dd0acd9591', '[\"*\"]', NULL, NULL, '2025-07-08 11:54:19', '2025-07-08 11:54:19'),
(357, 'App\\Models\\User', 51, 'Personal Access Token', '83e289dea27d7b6e2b40941deb1fcc9c857c2afec28c11caa5e38840b25d278a', '[\"*\"]', NULL, NULL, '2025-07-08 12:45:35', '2025-07-08 12:45:35'),
(358, 'App\\Models\\User', 51, 'Personal Access Token', '51931ed14b8bd5e233d4ab69662ea44ae55553114abc521dd609416c0aefa35d', '[\"*\"]', NULL, NULL, '2025-07-08 12:50:14', '2025-07-08 12:50:14'),
(359, 'App\\Models\\User', 51, 'Personal Access Token', 'ef613918a7a9a0b08e7d438c06ec4ee2af7e8ff0c514af936ab7b1bd801a0cb8', '[\"*\"]', NULL, NULL, '2025-07-08 12:50:51', '2025-07-08 12:50:51'),
(360, 'App\\Models\\User', 51, 'Personal Access Token', '0a852d80fffea5cb0818ee3a3bf9ed75a64b1287601b92de8218abd46793882a', '[\"*\"]', NULL, NULL, '2025-07-08 12:51:21', '2025-07-08 12:51:21'),
(361, 'App\\Models\\User', 51, 'Personal Access Token', '2b69c37979ba85102b67a24b9bc536d56c1bee74f5e350a560bb07f7eb6e0608', '[\"*\"]', NULL, NULL, '2025-07-08 12:52:21', '2025-07-08 12:52:21'),
(362, 'App\\Models\\User', 51, 'Personal Access Token', '5fc3091fc853d9a7541429867e34b85b751fee7fabab9edb561d284f86d891b8', '[\"*\"]', NULL, NULL, '2025-07-08 13:01:32', '2025-07-08 13:01:32'),
(363, 'App\\Models\\User', 51, 'Personal Access Token', 'c6de62185c6bc41f7fc3ce7b5a3c806e61f3a8a72bc66fbb52d9567412d2dc7f', '[\"*\"]', NULL, NULL, '2025-07-08 13:22:03', '2025-07-08 13:22:03'),
(364, 'App\\Models\\User', 51, 'Personal Access Token', 'de335f6db21285fcd2d20f0d49025fdc7de7c08643bc33a773faa100fe176223', '[\"*\"]', NULL, NULL, '2025-07-09 15:03:27', '2025-07-09 15:03:27'),
(365, 'App\\Models\\User', 51, 'Personal Access Token', '71d0747bd3e1e2481dd4d7fefe1141d72d4b9caf4c77f8fcbd061242c3f1cdc0', '[\"*\"]', NULL, NULL, '2025-07-11 18:42:16', '2025-07-11 18:42:16'),
(366, 'App\\Models\\User', 51, 'Personal Access Token', '43373b291d03c2c7ea831c77111f9eda7dd7520fdbbd215e983551c0e5193de6', '[\"*\"]', NULL, NULL, '2025-07-11 19:23:27', '2025-07-11 19:23:27'),
(367, 'App\\Models\\User', 59, 'Personal Access Token', '31acf76bd93e7499f90b513b5f93121320e221a800fc4a2ec6a2c3195dfa7400', '[\"*\"]', NULL, NULL, '2025-08-29 15:34:56', '2025-08-29 15:34:56'),
(368, 'App\\Models\\User', 51, 'Personal Access Token', 'f920ddb5641452bd2e0326a05784b3ae335ce4e9b82f69c39bb72c71b972c2a2', '[\"*\"]', NULL, NULL, '2025-08-29 15:37:59', '2025-08-29 15:37:59'),
(369, 'App\\Models\\User', 51, 'Personal Access Token', 'fed0f76bd5a58facf3325dc2c81bb85aa07bce7f52b87587dc073e23265dc4f2', '[\"*\"]', NULL, NULL, '2025-09-19 14:56:05', '2025-09-19 14:56:05'),
(370, 'App\\Models\\User', 59, 'Personal Access Token', '1ee4215a4f8f62a34c83a05f67a8c62a5dfe2c70a78cf152e698239bd7690122', '[\"*\"]', NULL, NULL, '2025-09-19 16:49:23', '2025-09-19 16:49:23'),
(371, 'App\\Models\\User', 51, 'Personal Access Token', '3747abb18fd185628173c324cf643c011bd0a6095e6ea7ce6206775a919ed3d7', '[\"*\"]', NULL, NULL, '2025-09-26 15:00:16', '2025-09-26 15:00:16'),
(372, 'App\\Models\\User', 59, 'Personal Access Token', '3c8fe6497942b196e87f920f3c46ef5b30a29a333ac739829acec75a7181e436', '[\"*\"]', NULL, NULL, '2025-09-26 15:01:24', '2025-09-26 15:01:24'),
(373, 'App\\Models\\User', 51, 'Personal Access Token', 'c16801dd9dd6a71e7123632b42bf86a77a49f57c192314f71009e536fc7c1991', '[\"*\"]', NULL, NULL, '2025-11-06 11:57:16', '2025-11-06 11:57:16'),
(374, 'App\\Models\\User', 59, 'Personal Access Token', '020b9c573aed3f9cf7ef8816de2fb0444f52e6cefed0a798f913d1cd7d702f50', '[\"*\"]', NULL, NULL, '2025-11-06 12:30:19', '2025-11-06 12:30:19'),
(375, 'App\\Models\\User', 59, 'Personal Access Token', 'dd2a0309427af6918bea3381d51477869277ec253f549c3958cbb34badb15a64', '[\"*\"]', NULL, NULL, '2025-11-06 13:01:27', '2025-11-06 13:01:27'),
(376, 'App\\Models\\User', 51, 'Personal Access Token', 'c06d6071c57bb34f0e994520b1d271d459f0266360d77a6469491122900ffa56', '[\"*\"]', NULL, NULL, '2025-11-06 16:31:15', '2025-11-06 16:31:15'),
(377, 'App\\Models\\User', 59, 'Personal Access Token', 'd8b972a097504791d899f3538b2b5e64e7e744bf3143ff45ef8491fef0f26268', '[\"*\"]', NULL, NULL, '2025-11-13 16:46:19', '2025-11-13 16:46:19'),
(378, 'App\\Models\\User', 59, 'Personal Access Token', 'd8440d5698851c3089e85a2fdf2bfca97045ae0a83529c1097fc440a40565106', '[\"*\"]', NULL, NULL, '2025-11-15 15:03:28', '2025-11-15 15:03:28'),
(379, 'App\\Models\\User', 59, 'Personal Access Token', '6126ddeb21902c3f5cf0ef42634eb1f333402993718d2cd02f6f7809fca4bb32', '[\"*\"]', NULL, NULL, '2025-12-05 17:40:09', '2025-12-05 17:40:09'),
(380, 'App\\Models\\User', 51, 'Personal Access Token', '638111b8ab4da4e8614664d44c2b059ba41625e6bfe61a214bd5e6084e642490', '[\"*\"]', NULL, NULL, '2025-12-05 17:41:05', '2025-12-05 17:41:05'),
(381, 'App\\Models\\User', 51, 'Personal Access Token', 'b61cffa9b84fec8d987e72cc983a3510f93114e62bb09c15091727e3083f12e2', '[\"*\"]', NULL, NULL, '2025-12-06 17:21:30', '2025-12-06 17:21:30'),
(382, 'App\\Models\\User', 51, 'Personal Access Token', '8922c17549e3c93d49c86375ad5e5f50f80f141cda63de405f88da241ef0591d', '[\"*\"]', NULL, NULL, '2025-12-11 18:00:49', '2025-12-11 18:00:49'),
(383, 'App\\Models\\User', 51, 'Personal Access Token', 'ea208926503b31eeb42ada6f36b9d458bc31a643ad017e8d0b9e965291e52a0f', '[\"*\"]', NULL, NULL, '2025-12-11 18:03:35', '2025-12-11 18:03:35'),
(384, 'App\\Models\\User', 59, 'Personal Access Token', '0cb11afb21d17dee8f59fdbb4de17d0f328b4215ae4e8957633c74862e70a5c1', '[\"*\"]', NULL, NULL, '2025-12-11 18:04:02', '2025-12-11 18:04:02'),
(385, 'App\\Models\\User', 51, 'Personal Access Token', '9ab1b224faa93c29b70b2f4ffba3b323e7069b8b8e641d9c84b79375d489059a', '[\"*\"]', NULL, NULL, '2025-12-12 12:21:37', '2025-12-12 12:21:37'),
(386, 'App\\Models\\User', 59, 'Personal Access Token', '195477cc5845f98d4d1579735b4bfbb1ef6ef41b0d1a58d43a6b963e4a97c95b', '[\"*\"]', NULL, NULL, '2025-12-12 12:38:01', '2025-12-12 12:38:01'),
(387, 'App\\Models\\User', 59, 'Personal Access Token', 'f0af67746865af4eeecb7f8c4b73ae72c9388c1474616dd45bcd89b222c12b47', '[\"*\"]', NULL, NULL, '2025-12-12 14:36:41', '2025-12-12 14:36:41'),
(388, 'App\\Models\\User', 51, 'Personal Access Token', '8f50963c0a9b1acc1a219e399697bab54ef46bfa8eac2c6a8fe109ce0f772161', '[\"*\"]', NULL, NULL, '2025-12-12 14:56:26', '2025-12-12 14:56:26'),
(389, 'App\\Models\\User', 76, 'Personal Access Token', '9914a8191e1502df26de738847a95248a2253c2aa0980ddbce355c3aacdfdee0', '[\"*\"]', NULL, NULL, '2025-12-12 15:05:06', '2025-12-12 15:05:06'),
(390, 'App\\Models\\User', 59, 'Personal Access Token', '2ef0a65dcf2e8bfa693aac0ea822be56561528397f22f137a315d45e5fe3da74', '[\"*\"]', NULL, NULL, '2025-12-12 15:10:24', '2025-12-12 15:10:24'),
(391, 'App\\Models\\User', 51, 'Personal Access Token', 'a432c9e4d71310a6ae01c65352c57edf0275916550eba43e076020a6d6aa791b', '[\"*\"]', NULL, NULL, '2025-12-12 15:11:19', '2025-12-12 15:11:19'),
(392, 'App\\Models\\User', 59, 'Personal Access Token', '3355c90118147ae2b87043d2801a24121f7f25d34b40b51bbb63f410e0308f2d', '[\"*\"]', NULL, NULL, '2025-12-12 15:20:09', '2025-12-12 15:20:09'),
(393, 'App\\Models\\User', 51, 'Personal Access Token', '82dce3fa5d75811506303687628fe2ae12499dc8db528ce45fcdb4289b33227a', '[\"*\"]', NULL, NULL, '2025-12-12 16:38:42', '2025-12-12 16:38:42'),
(394, 'App\\Models\\User', 51, 'Personal Access Token', 'a73b723e85660054963bbfbddf920395c8885ea9bc2b327c4cf875f0c89efa94', '[\"*\"]', NULL, NULL, '2025-12-12 16:55:21', '2025-12-12 16:55:21'),
(395, 'App\\Models\\User', 51, 'Personal Access Token', '75b92facf818f05bf1329ed88eaeaf2008f88a50d729a673026e34825c2d9759', '[\"*\"]', NULL, NULL, '2025-12-12 17:35:47', '2025-12-12 17:35:47'),
(396, 'App\\Models\\User', 59, 'Personal Access Token', '6d08226ab516fc7b88f427a402201fff177e43273827dad4af821a0af229614f', '[\"*\"]', NULL, NULL, '2025-12-12 17:36:04', '2025-12-12 17:36:04'),
(397, 'App\\Models\\User', 51, 'Personal Access Token', '6dd8164a137bfae8fafa8ed4b3b502921791bb1c59f136104bfd3cbfafed07a2', '[\"*\"]', NULL, NULL, '2025-12-12 17:39:48', '2025-12-12 17:39:48'),
(398, 'App\\Models\\User', 59, 'Personal Access Token', 'f1cc6ad0e84e077ac0c69b4d9c8edb390c0b904350ea127aa89fe70d53422293', '[\"*\"]', NULL, NULL, '2025-12-12 17:41:47', '2025-12-12 17:41:47'),
(399, 'App\\Models\\User', 51, 'Personal Access Token', '05a69a168f67f5be8a3a9704e4d2d586e789e069e04a9025ffc1e6735e295e96', '[\"*\"]', NULL, NULL, '2025-12-12 19:05:15', '2025-12-12 19:05:15'),
(400, 'App\\Models\\User', 51, 'Personal Access Token', '8e449035e5ec307bbc7fec471fba293fbd7577b08a01bcc768ca0fe99c648851', '[\"*\"]', NULL, NULL, '2025-12-12 19:06:23', '2025-12-12 19:06:23'),
(401, 'App\\Models\\User', 59, 'Personal Access Token', '93810ccfef8512d0ea6ebf6ffb01928324d2153301315a617f801d96397bc438', '[\"*\"]', NULL, NULL, '2025-12-12 19:10:24', '2025-12-12 19:10:24'),
(402, 'App\\Models\\User', 51, 'Personal Access Token', '2e1b3d49564a86f4a354a94e379706c733d7b709c7a215f023f41b8bf68cb4b0', '[\"*\"]', NULL, NULL, '2025-12-13 12:49:19', '2025-12-13 12:49:19'),
(403, 'App\\Models\\User', 51, 'Personal Access Token', '5af9b7b05bbb94b15aca71feae76694be83f44d2eeb40c5a8df69979802a22d2', '[\"*\"]', NULL, NULL, '2025-12-13 15:14:36', '2025-12-13 15:14:36'),
(404, 'App\\Models\\User', 51, 'Personal Access Token', 'e0ab8a2ca980224bdf41194bb06e0baf9693685b4ae0b76a7002e79c9505e091', '[\"*\"]', NULL, NULL, '2025-12-13 15:18:51', '2025-12-13 15:18:51'),
(405, 'App\\Models\\User', 59, 'Personal Access Token', '9a8e4b68a223aa9d5ccc3371f2cf4f4c4bc4c094eddc10a6c5bb592d3f2b2c70', '[\"*\"]', NULL, NULL, '2025-12-13 15:36:37', '2025-12-13 15:36:37'),
(406, 'App\\Models\\User', 76, 'Personal Access Token', '46a473f35ad372386c283b0b119c8bb0dad81c785f02ae54001b59182d25dd05', '[\"*\"]', NULL, NULL, '2025-12-17 17:15:23', '2025-12-17 17:15:23'),
(407, 'App\\Models\\User', 76, 'Personal Access Token', 'b4e5972cbcab2080c9f8523d2be20daf1ae741cc8485838523121d82ca4ab988', '[\"*\"]', NULL, NULL, '2025-12-17 17:18:00', '2025-12-17 17:18:00'),
(408, 'App\\Models\\User', 51, 'Personal Access Token', 'bb497430a00fe585ea05048fda3b56340804290a00dcd8daea70c2153af20d0e', '[\"*\"]', NULL, NULL, '2025-12-18 12:32:43', '2025-12-18 12:32:43'),
(409, 'App\\Models\\User', 59, 'Personal Access Token', 'f7750edf7315d286e61e8aa7ffb21f291a410b34779bc73a56ccb48bcbf7cd08', '[\"*\"]', NULL, NULL, '2025-12-18 12:36:16', '2025-12-18 12:36:16'),
(410, 'App\\Models\\User', 76, 'Personal Access Token', '7112fcf42f6d5f3a3fe89cdef26f7eefa22bc777c68f104126dc5c7a9c9b6f81', '[\"*\"]', NULL, NULL, '2025-12-18 13:08:56', '2025-12-18 13:08:56'),
(411, 'App\\Models\\User', 76, 'Personal Access Token', '3771733b58f5a10981a01f82e0bd69a07641eeb422dc18788933a270968e52ef', '[\"*\"]', NULL, NULL, '2025-12-19 14:58:32', '2025-12-19 14:58:32'),
(412, 'App\\Models\\User', 59, 'Personal Access Token', 'b237824f649cb8a4aae4c7f96e4ccfce2d07f78bd4718d4ce4dfddbafe27f1ea', '[\"*\"]', NULL, NULL, '2025-12-22 18:17:15', '2025-12-22 18:17:15'),
(413, 'App\\Models\\User', 76, 'Personal Access Token', 'e87a20488f3ed8afbb452755d25df28a8c843b970fe0082d65f503f7faf9e2ca', '[\"*\"]', NULL, NULL, '2025-12-23 14:03:39', '2025-12-23 14:03:39'),
(414, 'App\\Models\\User', 51, 'Personal Access Token', '608e9ad4b9f4ad104108c1bf93c113ca1bd44a6a622fe0ad84bac5bbbd5cad84', '[\"*\"]', NULL, NULL, '2025-12-24 17:41:52', '2025-12-24 17:41:52'),
(415, 'App\\Models\\User', 51, 'Personal Access Token', 'c44f8a3b828dbaff90e7849b0789e04f1c8c7324a35dd1a56169e3d191452651', '[\"*\"]', NULL, NULL, '2025-12-26 13:33:23', '2025-12-26 13:33:23'),
(416, 'App\\Models\\User', 59, 'Personal Access Token', '4af9fdd2592588c976ec782aab62dff008f2b0072785bcbc6c8784037c6e6f0c', '[\"*\"]', NULL, NULL, '2025-12-29 12:40:15', '2025-12-29 12:40:15'),
(417, 'App\\Models\\User', 51, 'Personal Access Token', 'c977ff6a18942b49d1e95d29d88b82619c08923bb14cb6dce9ef740fdd01e276', '[\"*\"]', NULL, NULL, '2025-12-29 18:20:33', '2025-12-29 18:20:33'),
(418, 'App\\Models\\User', 51, 'Personal Access Token', '83f4376f9d6c6ae0fd9f16ef087725cad196275705f91686a8b3438b3bef55e8', '[\"*\"]', NULL, NULL, '2025-12-31 12:46:51', '2025-12-31 12:46:51'),
(419, 'App\\Models\\User', 76, 'Personal Access Token', 'dc388b8618ebc42eb87b376e71903566c8d84fa7e09866b5f8f363d308f041bd', '[\"*\"]', NULL, NULL, '2026-01-03 14:40:59', '2026-01-03 14:40:59'),
(420, 'App\\Models\\User', 59, 'Personal Access Token', '078f01b5b906bd5f1295dee51ff604eceaabe2fe35d8a83f2f22d740ee45c597', '[\"*\"]', NULL, NULL, '2026-01-05 11:13:10', '2026-01-05 11:13:10'),
(421, 'App\\Models\\User', 59, 'Personal Access Token', 'b9b28923ff4bb59aab3d32ad136be02dabd9e40f115f1a131a837ed9174414cc', '[\"*\"]', NULL, NULL, '2026-01-06 14:33:35', '2026-01-06 14:33:35'),
(422, 'App\\Models\\User', 59, 'Personal Access Token', '0fb68a758f467189abfd459dfda9a3bcdd3300bef93d59745682f0148e0508bb', '[\"*\"]', NULL, NULL, '2026-01-08 16:01:36', '2026-01-08 16:01:36'),
(423, 'App\\Models\\User', 77, 'Personal Access Token', '7e1838673b47974a181fcfae6fc00ffb80dab99b4f326846e880eb318cee5593', '[\"*\"]', NULL, NULL, '2026-01-08 16:16:33', '2026-01-08 16:16:33'),
(424, 'App\\Models\\User', 77, 'Personal Access Token', 'e70a6376f851919ea730a229be2f0eeab597662ab35cefd218ec6339acc13ae1', '[\"*\"]', NULL, NULL, '2026-01-08 16:17:49', '2026-01-08 16:17:49'),
(425, 'App\\Models\\User', 77, 'Personal Access Token', 'ffa30918c0b9fe06be9620d5ab5689dea04f9d49eb5da3d4701aad5171391747', '[\"*\"]', NULL, NULL, '2026-01-08 19:07:51', '2026-01-08 19:07:51'),
(426, 'App\\Models\\User', 77, 'Personal Access Token', '212e761621bdd746aef9723579a962b061c910e4b16e17781098487a71ba9ad8', '[\"*\"]', NULL, NULL, '2026-01-09 17:41:46', '2026-01-09 17:41:46'),
(427, 'App\\Models\\User', 76, 'Personal Access Token', 'd51f90afe6f377901a3d04ff3a47d79defafe87e51b225ca3c1e8dba768cab01', '[\"*\"]', NULL, NULL, '2026-01-10 11:18:03', '2026-01-10 11:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_bank_details`
--

CREATE TABLE `pharmacy_bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pmId` int(11) NOT NULL,
  `bankname` varchar(100) DEFAULT NULL,
  `branchname` varchar(200) DEFAULT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `ifsccode` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacy_bank_details`
--

INSERT INTO `pharmacy_bank_details` (`id`, `pmId`, `bankname`, `branchname`, `account_type`, `account_name`, `account_number`, `ifsccode`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'State Bank of India', 'Mumbai', 'Savings', 'Vivek Raj', '147852369912', 'SIN147852', 1, '2025-05-02 18:44:29', '2025-05-02 18:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_masters`
--

CREATE TABLE `pharmacy_masters` (
  `PharmacyID` int(11) NOT NULL,
  `branch` int(11) NOT NULL DEFAULT 1,
  `PharmacyCode` varchar(20) NOT NULL,
  `PharmacyName` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL,
  `MobileNumber` varchar(15) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `FaxNumber` varchar(20) DEFAULT NULL,
  `EmailAddress` varchar(255) DEFAULT NULL,
  `WebsiteURL` varchar(255) DEFAULT NULL,
  `NPI` varchar(20) DEFAULT NULL,
  `DEANumber` varchar(20) DEFAULT NULL,
  `LicenseNumber` varchar(50) DEFAULT NULL,
  `LicenseExpirationDate` date DEFAULT NULL,
  `PharmacyType` varchar(50) DEFAULT NULL,
  `OwnershipType` varchar(50) DEFAULT NULL,
  `HoursOfOperation` varchar(255) DEFAULT NULL,
  `EmergencyServices` tinyint(1) DEFAULT NULL,
  `ServicesOffered` text DEFAULT NULL,
  `PaymentMethods` varchar(255) DEFAULT NULL,
  `PrimaryContactName` varchar(255) DEFAULT NULL,
  `Designation` varchar(100) DEFAULT NULL,
  `TaxID` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `CreatedAt` timestamp NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacy_masters`
--

INSERT INTO `pharmacy_masters` (`PharmacyID`, `branch`, `PharmacyCode`, `PharmacyName`, `Address`, `City`, `State`, `ZipCode`, `MobileNumber`, `PhoneNumber`, `FaxNumber`, `EmailAddress`, `WebsiteURL`, `NPI`, `DEANumber`, `LicenseNumber`, `LicenseExpirationDate`, `PharmacyType`, `OwnershipType`, `HoursOfOperation`, `EmergencyServices`, `ServicesOffered`, `PaymentMethods`, `PrimaryContactName`, `Designation`, `TaxID`, `status`, `CreatedAt`, `UpdatedAt`) VALUES
(4, 1, 'PH0012', 'Wellness Medical Hall', '520, R5, Asmi Industrial, Ram Mandir, Goregeon West', 'Mumbai', 'Maharastra', '400065', '7240052638', '9004837569', '7240052638', 'vivekrajraja@gmail.com', 'https://sellvell.com', 'RSCY1231SG', '14785236978', '456123789', '2025-03-11', 'Clinical Pharmacy', 'Independent Pharmacy', '[\"13:00\",\"17:10\"]', 1, 'Every order to get 50% discount.', 'asdasd', 'Vivek Raj', 'Manager', '[\"12\",\"2\",\"12\",\"2\"]', 1, '2025-03-11 07:45:28', '2025-05-02 13:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_types`
--

CREATE TABLE `pharmacy_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacy_types`
--

INSERT INTO `pharmacy_types` (`id`, `title`, `icons`, `created_at`, `updated_at`) VALUES
(1, 'Retail Pharmacy', NULL, '2025-02-21 13:21:59', '2025-02-21 13:24:56'),
(2, 'Hospital Pharmacy', NULL, '2025-02-21 13:22:21', '2025-02-21 13:22:21'),
(3, 'Online Pharmacy', NULL, '2025-02-21 13:22:38', '2025-02-21 13:22:38'),
(4, 'Clinical Pharmacy', NULL, '2025-02-21 13:22:47', '2025-02-21 13:22:47'),
(5, 'Consulting Pharmacy', NULL, '2025-02-21 13:22:57', '2025-02-21 13:22:57'),
(6, 'Wholesale Pharmacy', NULL, '2025-02-21 13:23:05', '2025-02-21 13:23:05'),
(7, 'Independent Pharmacy', NULL, '2025-02-21 13:23:12', '2025-02-21 13:23:12'),
(8, 'Specialty Pharmacy', NULL, '2025-02-21 13:23:21', '2025-02-21 13:23:21'),
(9, 'Homecare Pharmacy', NULL, '2025-02-21 13:23:41', '2025-02-21 13:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `prescribed_date` date DEFAULT curdate(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `doctor_id`, `patient_id`, `appointment_id`, `prescribed_date`, `created_at`, `updated_at`) VALUES
(1, 59, 51, NULL, '2025-06-13', '2025-06-13 17:01:12', '2026-01-07 10:43:38'),
(2, 59, 51, NULL, '2025-06-13', '2025-09-26 16:54:33', '2026-01-07 10:43:41'),
(3, 59, 51, NULL, '2025-06-13', '2026-01-06 14:36:31', '2026-01-07 10:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_medinices`
--

CREATE TABLE `prescription_medinices` (
  `id` int(11) NOT NULL,
  `prescribe_id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(100) DEFAULT NULL,
  `frequency` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `route` varchar(100) DEFAULT NULL,
  `meal` varchar(100) DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescription_medinices`
--

INSERT INTO `prescription_medinices` (`id`, `prescribe_id`, `medicine_name`, `dosage`, `frequency`, `duration`, `route`, `meal`, `instruction`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'Baluff', 'dnmmmf', 'sbsbg', 'agghe', 'agvsv', 'With meals', 'Avoid sunlight', 'Watch for signs of rash or reaction', '2025-06-13 17:01:12', '2025-06-13 18:49:36'),
(2, 1, 'Avastin 100mg Injection', '1 drop', 'Twice daily', '2 weeks', 'Inhalation', 'With meals', 'Avoid sunlight', 'Adjust dose in renal impairment', '2025-06-13 17:01:43', '2025-09-26 16:54:32'),
(4, 2, 'Baluff', '1 tablet', 'Twice daily', '10 days', 'Inhalation', 'After meals', 'Complete full course', 'Advise follow-up after 5 days', '2025-09-26 16:54:33', '2025-09-26 16:54:33'),
(5, 3, 'hdhdhd', '500 mg', 'Three times daily', '10 days', 'Ophthalmic', 'Empty stomach', 'Avoid sunlight', 'Advise follow-up after 5 days', '2026-01-06 14:36:31', '2026-01-06 14:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `features` varchar(500) NOT NULL,
  `permissions` varchar(1000) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `branch`, `title`, `subtitle`, `features`, `permissions`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', '', 'All', 'All', '1', '2024-09-07 14:22:48', '2025-06-27 18:49:15'),
(2, 1, 'Manager', '', 'doctors,patients,stores,users,setting,listing', 'doctors_add,doctors_edit,doctors_delete,patients_add,patients_edit,patients_delete,stores_add,stores_edit,stores_delete,users_add,users_edit,users_delete,setting_add,setting_edit,setting_delete,listing_add,listing_edit,listing_delete', '1', '2024-09-14 08:44:13', '2024-09-24 10:41:51'),
(3, 1, 'Coordinator', '', 'doctors,patients', 'doctors_add,doctors_edit,patients_add,patients_edit', '1', '2024-09-24 10:30:33', '2024-09-24 10:42:25'),
(4, 1, 'Doctor', '', 'doctors', 'doctors_add,doctors_edit,doctors_delete', '1', '2024-09-24 10:31:30', '2024-09-24 10:31:30'),
(5, 1, 'Patient', '', 'patients', 'patients_add,patients_edit', '1', '2024-09-24 10:32:20', '2024-09-24 10:32:20'),
(6, 1, 'Owner', 'Medicines Store', 'stores,listing', 'stores_add,stores_edit,stores_delete,listing_add,listing_edit,listing_delete', '1', '2025-02-14 12:22:23', '2025-02-14 12:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Oral', NULL, 1, '2025-07-01 16:30:53', '2025-07-01 17:41:01'),
(4, 'Topical', NULL, 1, '2025-07-01 17:36:37', '2025-07-01 17:36:37'),
(5, 'Intravenous (IV)', NULL, 1, '2025-07-01 17:36:51', '2025-07-01 17:37:32'),
(6, 'Intramuscular (IM)', NULL, 1, '2025-07-01 17:37:22', '2025-07-01 17:37:22'),
(7, 'Subcutaneous (SC)', NULL, 1, '2025-07-01 17:38:03', '2025-07-01 17:38:03'),
(8, 'Inhalation', NULL, 1, '2025-07-01 17:38:13', '2025-07-01 17:38:13'),
(9, 'Ophthalmic', NULL, 1, '2025-07-01 17:38:46', '2025-07-01 17:38:46'),
(10, 'Rectal', NULL, 1, '2025-07-01 17:39:04', '2025-07-01 17:39:04'),
(11, 'Sublingual', NULL, 1, '2025-07-01 17:39:29', '2025-07-01 17:39:29');

-- --------------------------------------------------------

--
-- Table structure for table `specialists`
--

CREATE TABLE `specialists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialists`
--

INSERT INTO `specialists` (`id`, `title`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Allergist/Immunologist', '1744355230.png', 1, '2024-08-21 17:18:10', '2025-04-11 12:37:10'),
(2, 'Anesthesiologist', '1744357548.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:15:48'),
(3, 'Cardiologist', '1744357076.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:07:56'),
(5, 'Endocrinologist', '1744359310.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:45:10'),
(6, 'Gastroenterologist', '1744359281.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:44:41'),
(7, 'Geriatrician', '1744359270.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:44:30'),
(8, 'Hematologist', '1744359259.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:44:19'),
(9, 'Infectious Disease Specialist', '1744359247.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:44:07'),
(10, 'Nephrologist', '1744359654.png', 1, '2024-08-21 17:18:10', '2025-04-11 13:50:54'),
(11, 'Neurologist', '1744361206.png', 1, '2024-08-21 17:18:10', '2025-04-11 14:16:46'),
(12, 'Obstetrician/Gynecologist (OB/GYN)', '1744361469.png', 1, '2024-08-21 17:18:10', '2025-04-11 14:21:09'),
(13, 'Oncologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(14, 'Ophthalmologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(15, 'Orthopedic Surgeon', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(17, 'Pediatrician', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(18, 'Plastic Surgeon', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(19, 'Psychiatrist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(20, 'Pulmonologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(21, 'Radiologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(22, 'Rheumatologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(23, 'Surgeon', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(24, 'Urologist', NULL, 1, '2024-08-21 17:18:10', '2024-08-21 17:18:10'),
(25, 'Vascular Surgeon', NULL, 1, '2024-08-21 17:54:27', '2024-08-21 17:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country`, `name`, `icons`, `status`, `created_at`, `updated_at`) VALUES
(1, 'India (IN)', 'Maharastra', NULL, 1, '2025-01-07 13:05:06', '2025-01-07 13:05:06'),
(2, 'India (IN)', 'Rajasthan', NULL, 1, '2025-01-07 13:09:24', '2025-01-07 13:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `store_locations`
--

CREATE TABLE `store_locations` (
  `LocationID` int(11) NOT NULL,
  `PharmacyID` int(11) NOT NULL,
  `LocationName` varchar(255) DEFAULT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(50) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `MapLink` varchar(500) DEFAULT NULL,
  `Latitude` decimal(9,6) DEFAULT NULL,
  `Longitude` decimal(9,6) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `HoursOfOperation` varchar(255) DEFAULT NULL,
  `ContactName` varchar(255) DEFAULT NULL,
  `Designation` varchar(100) DEFAULT NULL,
  `ContactEmail` varchar(50) DEFAULT NULL,
  `SquareFootage` varchar(255) DEFAULT NULL,
  `AccessibilityFeatures` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `CreatedAt` timestamp NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_locations`
--

INSERT INTO `store_locations` (`LocationID`, `PharmacyID`, `LocationName`, `Address`, `City`, `State`, `ZipCode`, `MapLink`, `Latitude`, `Longitude`, `PhoneNumber`, `HoursOfOperation`, `ContactName`, `Designation`, `ContactEmail`, `SquareFootage`, `AccessibilityFeatures`, `status`, `CreatedAt`, `UpdatedAt`) VALUES
(3, 4, 'Easy Doctor', 'road 123, build somethig 34', 'dharavi', 'Kerala', '400055', 'https://maps.app.goo.gl/Jwx8U4Bwo4jkeUwx6', NULL, NULL, '7418529633', '[\"10:00\",\"18:00\"]', 'Vikee Raj', 'Manager', 'info@vivzon.in', '400 X 500', 'Basic Features Available....', 1, '2025-03-21 06:55:33', '2025-05-03 06:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `usermetas`
--

CREATE TABLE `usermetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `adhar` varchar(255) DEFAULT NULL,
  `adhar_verified_at` timestamp NULL DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usermetas`
--

INSERT INTO `usermetas` (`id`, `uid`, `designation`, `adhar`, `adhar_verified_at`, `address`, `city`, `state`, `country`, `pincode`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, NULL, NULL, 'Ram Mandir, Goregeon West', 'Mumbai', 'Maharastra', 'India', '400065', '2025-04-25 14:23:46', '2025-04-25 14:23:46'),
(2, 59, '', NULL, NULL, 'Ram Mandir', 'Mumbai', 'Maharashtra', 'India', '400065', '2025-05-09 14:21:18', '2025-06-20 16:29:25'),
(3, 51, NULL, NULL, NULL, 'Ram Mandir, Goregeon West', 'Mumbai', 'Maharastra', 'India', '400065', '2025-04-25 14:23:46', '2025-04-25 14:23:46'),
(4, 62, '', NULL, NULL, 'Downtown', 'Toronto', 'Ontario', '', 'M1H 1L9', '2025-06-23 18:40:48', '2025-12-19 15:08:32'),
(5, 63, '', NULL, NULL, '01 Newport Street', 'Toronto', 'Ontario', 'Canada', 'M1L 5M9', '2025-06-23 18:57:51', '2025-06-23 18:57:51'),
(6, 1, '', NULL, NULL, '', 'Mumbai', 'Maharashtra', 'India', '', '2025-06-28 08:47:30', '2025-06-28 08:47:30'),
(7, 79, '', NULL, NULL, 'fdfedsd', 'dfgrdf', 'dfff', 'dfgfg', 'dfvg', '2025-12-19 15:47:17', '2025-12-19 15:47:17'),
(8, 82, '', NULL, NULL, 'ram mandir gore', 'Mumbai', 'Maharashtra', 'India', '401105', '2025-12-19 15:55:02', '2025-12-19 15:55:02'),
(9, 77, '', NULL, NULL, '520, R5, Ram Mandir', 'Mumbai', 'Maharashtra', 'India', '400065', '2026-01-08 16:16:07', '2026-01-08 16:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `altr_mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` varchar(10) NOT NULL,
  `notify` varchar(10) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branch`, `username`, `first_name`, `last_name`, `photo`, `mobile`, `altr_mobile`, `email`, `email_verified_at`, `password`, `dob`, `gender`, `role`, `notify`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'sadmin989', 'Imtiaz', 'Merchant', '1742995134.png', '9892220236', '7417417417', 'sadmin@easydoctor.com', NULL, '$2y$12$Rn9I6O4ArwOUXo9M/2.XGOPFJB.tr5fQevIT/QHmwI3LYBJofj0ba', '', '', '1', '1', 1, NULL, '2024-07-27 07:29:47', '2025-06-28 08:47:30'),
(3, 1, 'aman.k', 'Aman', 'Kumar', 'default_photo.png', '7878787878', '', 'aman.k@gmail.com', NULL, '$2y$12$LRvgszceo1G/9Yw7MeIKHOYWLj1E5F8nF.U7pO0q0/O1DLeLAD72G', '', '', '4', '1', 1, NULL, '2024-08-07 10:53:47', '2024-08-07 10:53:47'),
(4, 1, 'aniket.k', 'Aniket', 'K', 'default_photo.png', '7689054321', '', 'aniket.k@gmail.com', NULL, '$2y$12$wdFqOapOBrwa.YViRP7MX.P2tBynfFkd4/OJ16QBHnhD79yobr1.u', '', '', '4', '1', 1, NULL, '2024-08-10 11:52:53', '2024-08-10 11:52:53'),
(10, 1, 'imtiazsmerchant989', 'Imtiaz', 'Merchant', '', '9892220236', '', 'imtiazsmerchant@gmail.com', NULL, '$2y$12$K5t51E/wnq5ACh4G0hX29useRAUJ7EO5/YBtC1kBr3BYjJzQUB/9C', '', '', '4', '1', 1, NULL, '2024-08-31 09:53:02', '2025-07-04 18:14:13'),
(11, 1, 'nikita121', 'Nikita', 'Kumari', 'default_photo.png', '1212121222', '', 'nikita@gmail.com', NULL, '$2y$12$wQgITGYBwic9RAyzlxPhuecVjqYnQTxf495X.DX2c4JcNF1M13Jgq', '', '2', '3', '1', 1, NULL, '2024-09-26 14:57:30', '2025-01-08 12:53:48'),
(12, 1, 'aashika123', 'Aashika', 'Kumari', 'default_photo.png', '1231233211', '', 'aashika@gmail.com', NULL, '$2y$12$lvjzhwtYq9xmLThNi0wHnep7kcS/LR2Sv.nLf4//.OQagOs1qPL82', '', '2', '2', '1', 1, NULL, '2024-09-26 15:17:51', '2025-01-08 12:48:41'),
(14, 1, 'ag.vinod748', 'Agent', 'Vinod', 'default_photo.png', '7485748574', '', 'ag.vinod@gmail.com', NULL, '$2y$12$SouJ.O6nTnNTkP3SnQxQL.xOmcRJvExoZDc/QOaXNp6g4YpVp.22m', NULL, '1', '4', '1', 1, NULL, '2024-09-27 07:43:03', '2024-09-27 07:43:03'),
(20, 1, 'imtiazmer+91', 'Imtiaz', '', NULL, '9892220236', '', 'imtiazmer@gmail.com', NULL, '$2y$12$gKW3QriOMjzE36rs2XsTqu1zNTucXJROsacvKmHMb3pbAa8H9.V22', '', '1', '5', '1', 1, NULL, '2024-10-26 09:54:18', '2024-10-26 09:54:18'),
(52, 1, 'p1123', 'Patient 1', 'Surname 1', '', '1234', NULL, 'p1@gmail.com', NULL, '$2y$12$.h.3cX6ZByzkzeUsTKpsCu9ODsjAnCW1tyKfymS3MpvlJ6K9qrVkO', '', '', '5', '1', 0, NULL, '2025-04-18 19:10:12', '2025-04-18 19:10:12'),
(59, 1, 'iwebbrella808', 'Yoges', 'Kumar', '1765543379_scaled_2ba87b64-0a3e-46c6-bad8-0cc43da949b7-1_all_3616.png', '8080808165', '8585858585', 'iwebbrella@gmail.com', NULL, '$2y$12$qp0o9L2noxUiZ/.uAgVRXunfGdj8dXcpipEVQwMADS9O//ZB2zQBS', '', '', '4', '1', 1, NULL, '2025-05-09 14:21:18', '2025-12-12 18:12:59'),
(61, 1, 'lyndrods@gmail.com', 'Lyndon', 'Rodrigues', 'default_photo.png', '9054628323', NULL, 'lyndrods@gmail.com', NULL, '$2y$12$17DES8GTjHjGBjk0OMgqSegXU8zGmKeeZ2jbiO3LDTE6FiH652Urq', '', '', '5', '1', 0, NULL, '2025-06-13 01:41:02', '2025-06-13 01:41:02'),
(62, 1, 'easydoc.dr01989', 'Test', 'Doctor', NULL, '9892220236', '', 'easydoc.dr01@gmail.com', NULL, '$2y$12$ngWvCHHleG6imelrjdh9zOj3H9i3LOkqbEKfm8YC3Kh74QSjHQzzq', '', '', '4', '1', 1, NULL, '2025-06-23 18:40:48', '2025-06-28 08:52:59'),
(63, 1, 'easydoc.dr02989', 'Testing', 'User1', NULL, '9892220236', '', 'easydoc.dr02@gmail.com', NULL, '$2y$12$VkcoZJVrihOKvmpFsLoPt.NwyRIh2EqXc3nVkUBH5UykZtJcbHMCG', '2000-01-01', '1', '5', '1', 1, NULL, '2025-06-23 18:57:51', '2025-06-23 18:57:51'),
(74, 1, 'developrteam@gmail.com', 'Webbrella', 'Developer', 'default_photo.png', '9004837569', NULL, 'developrteam@gmail.com', NULL, '$2y$12$o6D7jW4mU1iCcY6bEYt5p.b13.eppUumy0wN3NQRQglQ8eVLnBCGC', '', '', '5', '1', 0, NULL, '2025-12-03 13:11:26', '2025-12-03 13:11:26'),
(76, 1, 'ijhar3634638', 'Ijhar', 'Hashami', '', '6387918901', '', 'ijhar3634@gmail.com', NULL, '$2y$12$.ytyTjwjuAOh5YslnV5.feTTJM/PoWgfzqv97Ne2RVL8CxSo6CsHS', '2004-12-07', '1', '5', '1', 1, NULL, '2025-12-12 15:03:00', '2025-12-17 15:27:47'),
(77, 1, 'Vivekrajraja724', 'Vivek', 'Raj', '1767960878_scaled_1000072787.png', '7240052638', '', 'Vivekrajraja@gmail.com', NULL, '$2y$12$0gnmafPsD.sONy2s9KU.ZuWDOwl1mtODiZc37bK0DNb/ivxpN3KmW', '1995-12-25', '1', '5', '1', 1, NULL, '2025-12-15 16:38:35', '2026-01-09 17:44:38'),
(79, 1, 'ij12322786', 'ij', '', '1766139437.png', '7868656545', '2343456545', 'ij12322@gmail.com', NULL, '$2y$12$tlsaDOG60zicQSLgmY/ZlO8nOFVgo.hOnBVUWm.bnIJyp5i3bhaVW', '', '', '4', '1', 1, NULL, '2025-12-19 15:47:17', '2025-12-19 15:47:17'),
(82, 1, 'ravi123907', 'ravi', 'kumar', '1766139901.png', '9078765654', '2323234545', 'ravi123@gmail.com', NULL, '$2y$12$pO8.xCaJMY4S4ALWjjoMOe1I/6yColCRkEs3C5/Kug0dK6rXWFYQO', '2000-07-19', '1', '5', '1', 1, NULL, '2025-12-19 15:55:02', '2025-12-19 15:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `video_call_gateway_configs`
--

CREATE TABLE `video_call_gateway_configs` (
  `id` int(11) NOT NULL,
  `provider_name` varchar(50) NOT NULL,
  `app_id` varchar(255) DEFAULT NULL,
  `app_secret` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `webhook_secret` varchar(255) DEFAULT NULL,
  `environment` enum('sandbox','production') DEFAULT 'sandbox',
  `is_active` tinyint(1) DEFAULT 1,
  `additional_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_config`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_call_gateway_configs`
--

INSERT INTO `video_call_gateway_configs` (`id`, `provider_name`, `app_id`, `app_secret`, `api_key`, `api_secret`, `webhook_secret`, `environment`, `is_active`, `additional_config`, `created_at`, `updated_at`) VALUES
(1, 'zoom', 'ueo3MhVtScmeW0g2VzIZjw', 'VXdHVVGDT265gl9LrJD5Ww', 'zFEnbcuvfRpAjMHbcLqI8WHaGfvEgwLl', 'HJiEJSX0Q4ui72WnX6hvVg', 'Q5cfEVvnRJSjCexi6HEJrA', 'production', 1, NULL, '2025-06-11 06:45:42', '2025-08-29 15:02:29'),
(2, 'webex', 'your_webex_api_key_sid', 'your_webex_api_key_secret', 'ACXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'your_auth_token', NULL, 'sandbox', 1, NULL, '2025-06-11 06:45:56', '2025-07-08 18:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `did` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL,
  `details` varchar(10000) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `did`, `aid`, `details`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-12 16:44:30', '2025-12-12 16:44:30'),
(2, 8, 2, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-12 16:58:33', '2025-12-12 16:58:33'),
(3, 8, 1, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-12 17:12:39', '2025-12-12 17:12:39'),
(4, 8, 3, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-12 17:18:52', '2025-12-12 17:18:52'),
(5, 8, 3, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-12 17:39:03', '2025-12-12 17:39:03'),
(6, 8, 4, 'Appointment payment received for patient ID: 76', 25, 'credit', '2025-12-13 13:02:29', '2025-12-13 13:02:29'),
(7, 3, 8, 'Appointment payment received for patient ID: 51', 10, 'credit', '2025-12-13 15:23:09', '2025-12-13 15:23:09'),
(8, 8, 9, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-13 15:43:53', '2025-12-13 15:43:53'),
(9, 8, 10, 'Appointment payment received for patient ID: 76', 25, 'credit', '2025-12-13 16:20:38', '2025-12-13 16:20:38'),
(10, 8, 11, 'Appointment payment received for patient ID: 76', 25, 'credit', '2025-12-13 16:55:00', '2025-12-13 16:55:00'),
(11, 8, 12, 'Appointment payment received for patient ID: 76', 25, 'credit', '2025-12-13 17:02:56', '2025-12-13 17:02:56'),
(12, 8, 14, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-18 14:25:35', '2025-12-18 14:25:35'),
(13, 8, 15, 'Appointment payment received for patient ID: 51', 25, 'credit', '2025-12-19 14:53:15', '2025-12-19 14:53:15'),
(14, 8, 17, 'Appointment payment received for patient ID: 51', 25, 'credit', '2026-01-07 17:45:39', '2026-01-07 17:45:39'),
(15, 8, 18, 'Appointment payment received for patient ID: 51', 25, 'credit', '2026-01-07 17:46:39', '2026-01-07 17:46:39'),
(16, 8, 19, 'Appointment payment received for patient ID: 51', 25, 'credit', '2026-01-07 17:49:23', '2026-01-07 17:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `uid`, `did`, `created_at`, `updated_at`) VALUES
(23, 24, 2, '2024-12-26 13:51:29', '2024-12-26 13:51:29'),
(25, 24, 5, '2024-12-26 13:53:55', '2024-12-26 13:53:55'),
(28, 24, 6, '2025-01-24 20:50:52', '2025-01-24 20:50:52'),
(29, 24, 3, '2025-01-24 20:50:54', '2025-01-24 20:50:54'),
(30, 24, 9, '2025-01-25 13:25:46', '2025-01-25 13:25:46'),
(37, 51, 3, '2025-06-26 15:19:05', '2025-06-26 15:19:05'),
(39, 51, 10, '2025-12-12 17:19:57', '2025-12-12 17:19:57'),
(40, 51, 59, '2025-12-12 19:08:55', '2025-12-12 19:08:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_availables`
--
ALTER TABLE `doctor_availables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_reviews`
--
ALTER TABLE `doctor_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosages`
--
ALTER TABLE `dosages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `durations`
--
ALTER TABLE `durations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frequencies`
--
ALTER TABLE `frequencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_types`
--
ALTER TABLE `medicine_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_itemsa`
--
ALTER TABLE `order_itemsa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateway_configs`
--
ALTER TABLE `payment_gateway_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pharmacy_bank_details`
--
ALTER TABLE `pharmacy_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pmId` (`pmId`);

--
-- Indexes for table `pharmacy_masters`
--
ALTER TABLE `pharmacy_masters`
  ADD PRIMARY KEY (`PharmacyID`),
  ADD UNIQUE KEY `NPI` (`NPI`),
  ADD KEY `idx_PharmacyName` (`PharmacyName`),
  ADD KEY `idx_City` (`City`),
  ADD KEY `idx_State` (`State`),
  ADD KEY `idx_ZipCode` (`ZipCode`);

--
-- Indexes for table `pharmacy_types`
--
ALTER TABLE `pharmacy_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_medinices`
--
ALTER TABLE `prescription_medinices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialists`
--
ALTER TABLE `specialists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_locations`
--
ALTER TABLE `store_locations`
  ADD PRIMARY KEY (`LocationID`),
  ADD KEY `idx_PharmacyID` (`PharmacyID`),
  ADD KEY `idx_City` (`City`),
  ADD KEY `idx_State` (`State`),
  ADD KEY `idx_ZipCode` (`ZipCode`);

--
-- Indexes for table `usermetas`
--
ALTER TABLE `usermetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usermetas_adhar_unique` (`adhar`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `video_call_gateway_configs`
--
ALTER TABLE `video_call_gateway_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `doctor_availables`
--
ALTER TABLE `doctor_availables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctor_reviews`
--
ALTER TABLE `doctor_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosages`
--
ALTER TABLE `dosages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `durations`
--
ALTER TABLE `durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frequencies`
--
ALTER TABLE `frequencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `medicine_types`
--
ALTER TABLE `medicine_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_itemsa`
--
ALTER TABLE `order_itemsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_gateway_configs`
--
ALTER TABLE `payment_gateway_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT for table `pharmacy_bank_details`
--
ALTER TABLE `pharmacy_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacy_masters`
--
ALTER TABLE `pharmacy_masters`
  MODIFY `PharmacyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pharmacy_types`
--
ALTER TABLE `pharmacy_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prescription_medinices`
--
ALTER TABLE `prescription_medinices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `specialists`
--
ALTER TABLE `specialists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_locations`
--
ALTER TABLE `store_locations`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usermetas`
--
ALTER TABLE `usermetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `video_call_gateway_configs`
--
ALTER TABLE `video_call_gateway_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_itemsa`
--
ALTER TABLE `order_itemsa`
  ADD CONSTRAINT `order_itemsa_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ordersd` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_itemsa_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicinesss` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pharmacy_bank_details`
--
ALTER TABLE `pharmacy_bank_details`
  ADD CONSTRAINT `fk_pmId` FOREIGN KEY (`pmId`) REFERENCES `pharmacy_masters` (`PharmacyID`) ON DELETE CASCADE;

--
-- Constraints for table `store_locations`
--
ALTER TABLE `store_locations`
  ADD CONSTRAINT `store_locations_ibfk_1` FOREIGN KEY (`PharmacyID`) REFERENCES `pharmacy_masters` (`PharmacyID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
