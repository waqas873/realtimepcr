-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2021 at 04:53 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcr`
--

-- --------------------------------------------------------

--
-- Table structure for table `system_invoices`
--

CREATE TABLE `system_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'who created this',
  `collection_point_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `embassy_user_id` int(11) DEFAULT NULL,
  `airline_user_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_id` int(11) DEFAULT NULL COMMENT 'amount_id is from amounts table',
  `is_recieved` tinyint(4) NOT NULL DEFAULT 1,
  `is_bank_payment` tinyint(1) NOT NULL DEFAULT 0,
  `account_category_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_invoices`
--

INSERT INTO `system_invoices` (`id`, `user_id`, `collection_point_id`, `lab_id`, `doctor_id`, `embassy_user_id`, `airline_user_id`, `purchase_id`, `unique_id`, `amount`, `payment_method`, `description`, `amount_id`, `is_recieved`, `is_bank_payment`, `account_category_id`, `date`, `created_at`, `updated_at`) VALUES
(7, 13, 1, NULL, NULL, NULL, NULL, NULL, '191106', 567, 'Bank Transfer', NULL, NULL, 1, 0, NULL, '2021-05-18', '2021-05-17 20:01:47', '2021-05-17 20:01:47'),
(8, 13, 1, NULL, NULL, NULL, NULL, NULL, '994529', 3500, 'Cash', 'testing-894723429423', NULL, 1, 0, NULL, '2021-05-18', '2021-05-17 20:04:04', '2021-05-18 20:03:51'),
(10, 13, 1, NULL, NULL, NULL, NULL, NULL, '134325', 1500, 'Cash', 'teesti', NULL, 1, 0, NULL, '2021-05-19', '2021-05-18 19:29:07', '2021-05-18 19:29:07'),
(12, 13, 1, NULL, NULL, NULL, NULL, NULL, '794791', 1200, 'Payment Gateway', 'hello world', NULL, 1, 0, NULL, '2021-05-19', '2021-05-18 20:32:02', '2021-05-18 20:32:02'),
(23, 1, NULL, NULL, NULL, NULL, NULL, NULL, '291424', 6000, NULL, 'Amount received from patient', NULL, 1, 0, NULL, '2021-06-26', '2021-06-26 04:51:34', '2021-06-26 04:51:34'),
(24, 1, NULL, NULL, NULL, NULL, NULL, NULL, '126219', 5000, NULL, 'Amount received from patient', NULL, 1, 0, NULL, '2021-06-26', '2021-06-26 04:56:15', '2021-06-26 04:56:15'),
(25, 1, NULL, NULL, NULL, NULL, NULL, NULL, '546065', 6000, NULL, 'Amount received from patient', NULL, 1, 0, NULL, '2021-06-26', '2021-06-26 04:57:33', '2021-06-26 04:57:33'),
(26, 1, NULL, 1, NULL, NULL, NULL, NULL, '880812', 3000, NULL, 'Amount received from patient', NULL, 1, 0, NULL, '2021-06-26', '2021-06-26 04:58:34', '2021-06-26 04:58:34'),
(30, 13, NULL, NULL, NULL, NULL, NULL, 13, '829724', 1000, NULL, NULL, NULL, 0, 0, NULL, NULL, '2021-06-28 03:15:16', '2021-06-28 03:15:16'),
(32, 13, NULL, NULL, 2, NULL, NULL, NULL, '76282', 100, 'Payment Gateway', NULL, NULL, 0, 0, NULL, '2021-06-23', '2021-06-28 03:43:29', '2021-06-28 03:43:29'),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '569295', 1200, NULL, NULL, 1533, 0, 0, NULL, NULL, '2021-06-29 05:19:04', '2021-06-29 05:19:04'),
(35, 1, NULL, NULL, NULL, NULL, NULL, NULL, '373428', 100, NULL, NULL, 1536, 0, 0, NULL, NULL, '2021-06-30 05:10:47', '2021-06-30 05:10:47'),
(37, 1, NULL, NULL, NULL, NULL, NULL, NULL, '99036', 200, NULL, NULL, 1538, 1, 0, NULL, NULL, '2021-06-30 05:11:56', '2021-06-30 05:11:56'),
(38, 1, NULL, NULL, NULL, NULL, NULL, NULL, '554735', 230, NULL, NULL, 1539, 1, 0, NULL, NULL, '2021-06-30 05:14:50', '2021-06-30 05:14:50'),
(39, 13, NULL, NULL, NULL, NULL, NULL, NULL, '800041', 100, NULL, NULL, 1542, 0, 0, NULL, NULL, '2021-07-01 04:37:07', '2021-07-01 04:37:07'),
(40, 13, NULL, NULL, NULL, NULL, NULL, NULL, '221351', 250, NULL, NULL, 1543, 0, 0, NULL, NULL, '2021-07-01 04:39:36', '2021-07-01 04:39:36'),
(41, 13, NULL, NULL, NULL, NULL, NULL, NULL, '55204', 555, NULL, NULL, 1544, 1, 0, NULL, NULL, '2021-07-01 04:46:05', '2021-07-01 04:46:05'),
(42, 13, NULL, NULL, NULL, NULL, NULL, NULL, '997746', 1520, NULL, NULL, 1545, 0, 0, NULL, NULL, '2021-07-01 04:46:29', '2021-07-01 04:46:29'),
(43, 13, NULL, NULL, NULL, NULL, NULL, NULL, '480463', 2000, NULL, 'hello world', NULL, 1, 1, 2, '2021-07-28', '2021-07-03 12:12:17', '2021-07-03 12:12:17'),
(44, 13, NULL, NULL, NULL, NULL, NULL, NULL, '951488', 1000, NULL, NULL, NULL, 1, 1, 1, '2021-07-15', '2021-07-03 12:32:30', '2021-07-03 12:32:30'),
(45, 13, NULL, NULL, NULL, NULL, NULL, NULL, '39383', 1000, NULL, NULL, NULL, 0, 1, 2, '2021-07-15', '2021-07-03 12:33:36', '2021-07-03 12:33:36'),
(46, 13, NULL, NULL, NULL, NULL, NULL, NULL, '274103', 1000, NULL, NULL, NULL, 0, 1, 2, '2021-07-14', '2021-07-03 12:34:31', '2021-07-03 12:34:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `system_invoices`
--
ALTER TABLE `system_invoices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `system_invoices`
--
ALTER TABLE `system_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
