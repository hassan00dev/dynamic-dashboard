-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 08:41 PM
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
-- Database: `dynamic_dashboard`
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
(1, 1, 0, '12'),
(2, 1, 1, '3,6,3'),
(3, 1, 2, '4,8'),
(4, 2, 0, '3,6,3'),
(5, 3, 0, '4,4,4');

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
(1, 12, 1, 0, 0, 0, 1),
(2, 6, 6, 1, 1, 0, 1),
(3, 6, 4, 1, 1, 1, 1),
(4, 8, 6, 2, 1, 0, 1),
(5, 6, 1, 0, 1, 0, 2),
(6, 4, 3, 0, 0, 0, 3),
(7, 4, 5, 0, 2, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`id`, `title`, `icon`, `file`) VALUES
(1, 'Line Chart', 'fas fa-chart-pie', 'lineChart.php'),
(2, 'Columns Chart', 'fas fa-bars', 'columnsChart.php'),
(3, 'CPU Usage', 'fas fa-users', 'cpuUsage.php'),
(4, 'Dragging Interval', 'fas fa-desktop', 'draggingInterval.php'),
(5, 'Pie Chart', 'fas fa-edit', 'PieChart.php'),
(6, 'Switches', 'fas fa-th-list', 'switches.php'),
(7, 'Total Clicks', 'fas fa-box', 'totalClicks.php'),
(8, 'Gauge Chart', 'fas fa-box', 'gaugeChart.php'),
(9, 'Gauge Styled Chart', 'fas fa-box', 'gaugeStyleChart.php'),
(10, 'Ram Usage', 'fas fa-box', 'ramUsage.php');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_dashboards`
--

CREATE TABLE `dynamic_dashboards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dynamic_dashboards`
--

INSERT INTO `dynamic_dashboards` (`id`, `name`, `color`) VALUES
(1, 'Default Dashboard', '#59ff00'),
(2, 'template 2', '#000000'),
(3, 'template 3', '#c51b1b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `architectures`
--
ALTER TABLE `architectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dashboard_id` (`dashboard_id`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_id` (`component_id`),
  ADD KEY `dashboard_id` (`dashboard_id`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_dashboards`
--
ALTER TABLE `dynamic_dashboards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `architectures`
--
ALTER TABLE `architectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dynamic_dashboards`
--
ALTER TABLE `dynamic_dashboards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `architectures`
--
ALTER TABLE `architectures`
  ADD CONSTRAINT `architectures_ibfk_1` FOREIGN KEY (`dashboard_id`) REFERENCES `dynamic_dashboards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `columns`
--
ALTER TABLE `columns`
  ADD CONSTRAINT `columns_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `columns_ibfk_2` FOREIGN KEY (`dashboard_id`) REFERENCES `dynamic_dashboards` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
