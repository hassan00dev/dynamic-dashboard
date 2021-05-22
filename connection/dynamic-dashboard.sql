-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2021 at 10:05 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dynamic-dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `architectures`
--

CREATE TABLE `architectures` (
  `id` int(11) NOT NULL,
  `dashboard_id` int(11) NOT NULL,
  `row_position` int(11) NOT NULL DEFAULT 0,
  `pattern` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `architectures`
--

INSERT INTO `architectures` (`id`, `dashboard_id`, `row_position`, `pattern`) VALUES
(20, 1, 0, '4,4,4'),
(21, 1, 1, '4,8'),
(22, 7, 0, '3,6,3');

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE `columns` (
  `id` int(11) NOT NULL,
  `column` int(11) NOT NULL,
  `component_id` int(11) DEFAULT NULL,
  `row_position` int(11) NOT NULL,
  `col_position` int(11) NOT NULL DEFAULT 0,
  `vertical_col_position` int(11) NOT NULL DEFAULT 0,
  `dashboard_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`id`, `column`, `component_id`, `row_position`, `col_position`, `vertical_col_position`, `dashboard_id`) VALUES
(29, 4, 4, 0, 0, 0, 1),
(30, 4, 6, 0, 1, 0, 1),
(31, 4, 6, 0, 2, 0, 1),
(32, 4, 8, 0, 2, 1, 1),
(33, 8, 7, 1, 1, 0, 1),
(34, 3, 4, 0, 0, 0, 7),
(35, 6, 5, 0, 1, 0, 7),
(36, 3, 7, 0, 2, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`id`, `title`, `icon`) VALUES
(1, 'Sales', 'fas fa-chart-pie'),
(2, 'Bars', 'fas fa-bars'),
(3, 'Users', 'fas fa-users'),
(4, 'VS Code', 'fas fa-desktop'),
(5, 'Brackets Editor', 'fas fa-edit'),
(6, 'To-do', 'fas fa-th-list'),
(7, 'component 1', 'fas fa-box'),
(8, 'component 2', 'fas fa-box'),
(9, 'component 3', 'fas fa-box'),
(10, 'component 4', 'fas fa-box');

-- --------------------------------------------------------

--
-- Table structure for table `dashboards`
--

CREATE TABLE `dashboards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dashboards`
--

INSERT INTO `dashboards` (`id`, `name`, `color`) VALUES
(1, 'Default Dashboard', '#f21c1c'),
(7, 'tempate 2', '#35a815');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `architectures`
--
ALTER TABLE `architectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dashboard_id` (`dashboard_id`),
  ADD KEY `row_position` (`row_position`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_id` (`component_id`),
  ADD KEY `dashboard_id` (`dashboard_id`),
  ADD KEY `row_position` (`row_position`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `architectures`
--
ALTER TABLE `architectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dashboards`
--
ALTER TABLE `dashboards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `architectures`
--
ALTER TABLE `architectures`
  ADD CONSTRAINT `architectures_ibfk_1` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `columns`
--
ALTER TABLE `columns`
  ADD CONSTRAINT `columns_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `columns_ibfk_2` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `columns_ibfk_3` FOREIGN KEY (`row_position`) REFERENCES `architectures` (`row_position`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
