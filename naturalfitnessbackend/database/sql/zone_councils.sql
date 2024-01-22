-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2023 at 02:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shyamfuturetech_biomebackend`
--

-- --------------------------------------------------------

--
-- Table structure for table `zone_councils`
--



--
-- Dumping data for table `zone_councils`
--

INSERT INTO `zone_councils` (`id`, `uuid`, `name`, `post_code`, `lat`, `long`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'b6cf1455-48b1-11ee-935f-f4ee08d04889', 'Scottish Funding Council', 'ST2', '53.6175679', '-8.1675546,6', 1, '2023-09-01 10:22:13', '2023-09-01 10:22:13'),
(2, 'b6cf34ae-48b1-11ee-935f-f4ee08d04889', 'Higher Education Funding Council for England', 'ST2', '55.791609', '-3.519076', 1, '2023-09-01 10:22:13', '2023-09-01 10:22:13'),
(3, '41adab2f-48b2-11ee-935f-f4ee08d04889', 'StartUp Business Funding Council', 'ST2', '55.944948', '-3.445605', 1, '2023-09-01 10:26:06', '2023-09-01 10:26:06'),
(4, '41adb8bf-48b2-11ee-935f-f4ee08d04889', 'West Lothian Council', 'EH28 8', '55.88517', '-3.6281', 1, '2023-09-01 10:26:06', '2023-09-01 10:26:06'),
(5, '85a5d85c-48b2-11ee-935f-f4ee08d04889', 'Scottish Refugee Council', 'EH28 8', '55.901253', '-3.549289', 1, '2023-09-01 10:28:00', '2023-09-01 10:28:00'),
(6, '85a60fa5-48b2-11ee-935f-f4ee08d04889', 'Glasgow City Chambers', 'EH28 8', '55.88516843', '-3.62782985', 1, '2023-09-01 10:28:00', '2023-09-01 10:28:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zone_councils`
--
ALTER TABLE `zone_councils`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zone_councils`
--
ALTER TABLE `zone_councils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
