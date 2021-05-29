-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2021 at 09:37 PM
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
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'who created this',
  `invoice_id` int(11) DEFAULT NULL,
  `collection_point_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `embassy_user_id` int(11) DEFAULT NULL,
  `airline_user_id` int(11) DEFAULT NULL,
  `system_invoice_id` int(11) DEFAULT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `is_debit` tinyint(4) NOT NULL DEFAULT 0,
  `is_credit` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `user_id`, `invoice_id`, `collection_point_id`, `lab_id`, `doctor_id`, `embassy_user_id`, `airline_user_id`, `system_invoice_id`, `unique_id`, `description`, `amount`, `is_debit`, `is_credit`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, '410774', 'Amount received from patient', 7500, 1, 0, '2021-05-10 20:52:46', '2021-05-10 20:52:46'),
(2, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, '273269', 'Amount received from patient', 1000, 0, 1, '2021-05-10 20:54:26', '2021-05-10 20:54:26'),
(5, 8, NULL, 1, NULL, NULL, NULL, NULL, NULL, '66536', 'Amount received from patient', 1200, 1, 0, '2021-05-10 21:06:57', '2021-05-10 21:06:57'),
(6, 13, NULL, 1, NULL, NULL, NULL, NULL, 8, '643997', 'Amount recieved from collection point.', 3500, 0, 1, '2021-05-17 20:04:04', '2021-05-18 20:03:51'),
(8, 13, NULL, 1, NULL, NULL, NULL, NULL, 10, '570982', 'Amount recieved from collection point.', 1500, 0, 1, '2021-05-18 19:29:07', '2021-05-18 19:29:07'),
(10, 13, NULL, 1, NULL, NULL, NULL, NULL, 12, '760272', 'Amount recieved from collection point.', 1200, 0, 1, '2021-05-18 20:32:02', '2021-05-18 20:32:02'),
(11, 8, 1485, 1, NULL, NULL, NULL, NULL, NULL, '40094', 'Amount received from patient', 5200, 1, 0, '2021-05-21 19:51:45', '2021-05-21 19:51:45'),
(12, 8, 1486, 1, NULL, NULL, NULL, NULL, NULL, '191902', 'Amount received from patient', 5200, 1, 0, '2021-05-21 20:22:33', '2021-05-21 20:22:33'),
(13, 8, 1487, 1, NULL, NULL, NULL, NULL, NULL, '497337', 'Amount received from patient', 4800, 1, 0, '2021-05-21 20:25:25', '2021-05-21 20:25:25'),
(15, 8, 1491, 1, NULL, NULL, NULL, NULL, NULL, '525763', 'Amount received from patient', 4800, 1, 0, '2021-05-21 20:31:31', '2021-05-21 20:31:31'),
(16, 8, 1491, NULL, NULL, 2, NULL, NULL, NULL, '356511', 'Doctors Commssion', 2400, 1, 0, '2021-05-21 20:31:31', '2021-05-21 20:31:31'),
(19, 1, 1494, NULL, NULL, NULL, 30, NULL, NULL, '724168', 'Embassy Commssion', 200, 1, 0, '2021-05-29 19:08:11', '2021-05-29 19:08:11'),
(20, 13, NULL, NULL, NULL, NULL, 30, NULL, 15, '227566', 'Commission delivered to embassy.', 50, 0, 1, '2021-05-29 19:10:20', '2021-05-29 19:10:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
