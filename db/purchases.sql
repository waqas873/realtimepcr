-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2021 at 09:19 AM
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
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'who created this',
  `supplier_id` int(11) DEFAULT NULL,
  `unique_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_type` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT 0,
  `advance_payment` int(11) DEFAULT 0,
  `remaining_balance` int(11) DEFAULT 0,
  `date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `supplier_id`, `unique_id`, `purchase_type`, `price`, `advance_payment`, `remaining_balance`, `date`, `description`, `created_at`, `updated_at`) VALUES
(6, 13, 1, '627443', 1, 15000, 7000, 0, '2021-06-17', NULL, '2021-06-23 04:28:11', '2021-06-24 03:56:35'),
(7, 13, 1, '877879', 2, 3000, 2000, 1000, '2021-06-12', 'sdafljsadf', '2021-06-23 04:59:00', '2021-06-23 04:59:00'),
(8, 13, 1, '244807', 2, 3000, 2000, 1000, '2021-06-12', 'sdafljsadf', '2021-06-23 04:59:07', '2021-06-23 04:59:07'),
(9, 13, 1, '821078', 2, 3000, 2000, 1000, '2021-06-12', 'sdafljsadf', '2021-06-23 04:59:37', '2021-06-23 04:59:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
