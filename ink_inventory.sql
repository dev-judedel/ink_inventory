-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 09:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ink_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `ink_batches`
--

CREATE TABLE `ink_batches` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `batch_no` varchar(64) DEFAULT NULL,
  `supplier` varchar(128) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `unit_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `qty_received` int(11) NOT NULL DEFAULT 0,
  `qty_remaining` int(11) NOT NULL DEFAULT 0,
  `received_at` datetime NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ink_batches`
--

INSERT INTO `ink_batches` (`id`, `item_id`, `batch_no`, `supplier`, `expiry_date`, `unit_cost`, `qty_received`, `qty_remaining`, `received_at`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, 0.00, 8, 8, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(2, 2, NULL, NULL, NULL, 0.00, 7, 7, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(3, 3, NULL, NULL, NULL, 0.00, 6, 6, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(4, 4, NULL, NULL, NULL, 0.00, 9, 9, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(5, 5, NULL, NULL, NULL, 0.00, 2, 2, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(6, 6, NULL, NULL, NULL, 0.00, 2, 2, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(7, 7, NULL, NULL, NULL, 0.00, 2, 2, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(8, 8, NULL, NULL, NULL, 0.00, 2, 2, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(9, 9, NULL, NULL, NULL, 0.00, 5, 5, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(10, 10, NULL, NULL, NULL, 0.00, 5, 5, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(11, 11, NULL, NULL, NULL, 0.00, 12, 12, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(12, 12, NULL, NULL, NULL, 0.00, 8, 8, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(13, 13, NULL, NULL, NULL, 0.00, 3, 3, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(14, 14, NULL, NULL, NULL, 0.00, 3, 3, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(15, 15, NULL, NULL, NULL, 0.00, 2, 2, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(16, 16, NULL, NULL, NULL, 0.00, 3, 3, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(17, 17, NULL, NULL, NULL, 0.00, 1, 1, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(18, 18, NULL, NULL, NULL, 0.00, 8, 8, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(19, 19, NULL, NULL, NULL, 0.00, 3, 3, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL),
(20, 20, NULL, NULL, NULL, 0.00, 5, 5, '2025-08-27 00:00:00', NULL, '2025-08-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ink_items`
--

CREATE TABLE `ink_items` (
  `id` int(11) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(128) DEFAULT NULL,
  `color` varchar(64) DEFAULT NULL,
  `printer_models` text DEFAULT NULL,
  `uom` varchar(16) NOT NULL DEFAULT 'pc',
  `reorder_point` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ink_items`
--

INSERT INTO `ink_items` (`id`, `sku`, `name`, `brand`, `color`, `printer_models`, `uom`, `reorder_point`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CF500', 'CF 500 Black', NULL, 'Black', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(2, 'CF501', 'CF 501 Cyan', NULL, 'Cyan', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(3, 'CF502', 'CF 502 Yellow', NULL, 'Yellow', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(4, 'CF503', 'CF 503 Magenta', NULL, 'Magenta', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(5, 'W2110', 'W2110 Black', NULL, 'Black', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(6, 'W2111', 'W2111 Cyan', NULL, 'Cyan', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(7, 'W2112', 'W2112 Yellow', NULL, 'Yellow', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(8, 'W2113', 'W2113 Magenta', NULL, 'Magenta', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(9, 'CF410A', 'CF 410A Black', NULL, 'Black', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(10, 'CF411A', 'CF 411A Cyan', NULL, 'Cyan', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(11, 'CF412A', 'CF 412A Yellow', NULL, 'Yellow', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(12, 'CF413A', 'CF 413A Magenta', NULL, 'Magenta', NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(13, 'CF226A', 'CF 226A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(14, 'Q2612A', 'Q2612A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(15, 'CE255A', 'CE 255A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(16, 'CZ192A', 'CZ192A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(17, 'CE278A', 'CE 278A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(18, 'CB435A', 'CB435A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(19, '83A', '83A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL),
(20, '505A', '505A', NULL, NULL, NULL, 'pc', 0, 1, '2025-08-27 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ink_movements`
--

CREATE TABLE `ink_movements` (
  `id` bigint(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `txn_date` datetime NOT NULL,
  `type` enum('IN','OUT','ADJ') NOT NULL,
  `ref_no` varchar(64) DEFAULT NULL,
  `doc_type` varchar(64) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `unit_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `avg_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ink_movements`
--

INSERT INTO `ink_movements` (`id`, `item_id`, `batch_id`, `txn_date`, `type`, `ref_no`, `doc_type`, `doc_id`, `location`, `qty`, `unit_cost`, `avg_cost`, `note`, `created_by`, `created_at`) VALUES
(1, 1, 1, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 8, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(2, 2, 2, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 7, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(3, 3, 3, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 6, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(4, 4, 4, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 9, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(5, 5, 5, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 2, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(6, 6, 6, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 2, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(7, 7, 7, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 2, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(8, 8, 8, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 2, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(9, 9, 9, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 5, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(10, 10, 10, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 5, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(11, 11, 11, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 12, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(12, 12, 12, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 8, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(13, 13, 13, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 3, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(14, 14, 14, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 3, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(15, 15, 15, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 2, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(16, 16, 16, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 3, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(17, 17, 17, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(18, 18, 18, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 8, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(19, 19, 19, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 3, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00'),
(20, 20, 20, '2025-08-27 00:00:00', 'IN', NULL, NULL, NULL, NULL, 5, 0.00, 0.00, NULL, NULL, '2025-08-27 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ink_onhand`
-- (See below for the actual view)
--
CREATE TABLE `v_ink_onhand` (
`item_id` int(11)
,`sku` varchar(64)
,`name` varchar(255)
,`on_hand` decimal(33,0)
);

-- --------------------------------------------------------

--
-- Structure for view `v_ink_onhand`
--
DROP TABLE IF EXISTS `v_ink_onhand`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ink_onhand`  AS SELECT `i`.`id` AS `item_id`, `i`.`sku` AS `sku`, `i`.`name` AS `name`, coalesce(sum(case when `m`.`type` = 'IN' then `m`.`qty` when `m`.`type` = 'OUT' then -`m`.`qty` else `m`.`qty` end),0) AS `on_hand` FROM (`ink_items` `i` left join `ink_movements` `m` on(`m`.`item_id` = `i`.`id`)) GROUP BY `i`.`id`, `i`.`sku`, `i`.`name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ink_batches`
--
ALTER TABLE `ink_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_batches_item` (`item_id`),
  ADD KEY `idx_batches_received_at` (`received_at`);

--
-- Indexes for table `ink_items`
--
ALTER TABLE `ink_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `ink_movements`
--
ALTER TABLE `ink_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_movements_item` (`item_id`),
  ADD KEY `idx_movements_batch` (`batch_id`),
  ADD KEY `idx_movements_txn_date` (`txn_date`),
  ADD KEY `idx_movements_type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ink_batches`
--
ALTER TABLE `ink_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ink_items`
--
ALTER TABLE `ink_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ink_movements`
--
ALTER TABLE `ink_movements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ink_batches`
--
ALTER TABLE `ink_batches`
  ADD CONSTRAINT `fk_ink_batches_item` FOREIGN KEY (`item_id`) REFERENCES `ink_items` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ink_movements`
--
ALTER TABLE `ink_movements`
  ADD CONSTRAINT `fk_movements_batch` FOREIGN KEY (`batch_id`) REFERENCES `ink_batches` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movements_item` FOREIGN KEY (`item_id`) REFERENCES `ink_items` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
