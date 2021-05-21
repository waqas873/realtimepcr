-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2021 at 09:18 PM
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
  `doctor_id` int(11) DEFAULT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_recieved` tinyint(4) NOT NULL DEFAULT 1,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_invoices`
--

INSERT INTO `system_invoices` (`id`, `user_id`, `collection_point_id`, `doctor_id`, `unique_id`, `amount`, `payment_method`, `description`, `is_recieved`, `date`, `created_at`, `updated_at`) VALUES
(7, 13, 1, NULL, '191106', 567, 'Bank Transfer', NULL, 1, '2021-05-18', '2021-05-17 20:01:47', '2021-05-17 20:01:47'),
(8, 13, 1, NULL, '994529', 3500, 'Cash', 'testing-894723429423', 1, '2021-05-18', '2021-05-17 20:04:04', '2021-05-18 20:03:51'),
(10, 13, 1, NULL, '134325', 1500, 'Cash', 'teesti', 1, '2021-05-19', '2021-05-18 19:29:07', '2021-05-18 19:29:07'),
(12, 13, 1, NULL, '794791', 1200, 'Payment Gateway', 'hello world', 1, '2021-05-19', '2021-05-18 20:32:02', '2021-05-18 20:32:02');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
