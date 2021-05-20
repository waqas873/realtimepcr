-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2021 at 10:01 PM
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
-- Table structure for table `doctor_categories`
--

CREATE TABLE `doctor_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'who created this',
  `doctor_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `discount_percentage` int(11) DEFAULT NULL,
  `custom_prizes` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_categories`
--

INSERT INTO `doctor_categories` (`id`, `user_id`, `doctor_id`, `category_id`, `discount_percentage`, `custom_prizes`, `created_at`, `updated_at`) VALUES
(1, 13, 4, 1, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(2, 13, 4, 2, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(3, 13, 4, 3, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(4, 13, 4, 4, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(5, 13, 4, 5, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(6, 13, 4, 6, 20, 0, '2021-05-20 19:01:15', '2021-05-20 19:24:19'),
(7, 13, 4, 7, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(8, 13, 4, 8, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(9, 13, 4, 9, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(10, 13, 4, 10, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15'),
(11, 13, 4, 11, 0, 1, '2021-05-20 19:01:15', '2021-05-20 19:01:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_categories`
--
ALTER TABLE `doctor_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor_categories`
--
ALTER TABLE `doctor_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
