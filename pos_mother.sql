-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2019 at 08:27 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_mother`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `user_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `access` text COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_super_admin` int(11) NOT NULL DEFAULT '0',
  `branch` tinyint(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `update_by` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `name`, `access`, `user_name`, `password`, `is_super_admin`, `branch`, `is_active`, `is_deleted`, `added_by`, `update_by`) VALUES
(1, 'Hasan Sheikh', 'all', 'admin', '1', 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `branch_id` tinyint(4) NOT NULL,
  `branch_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`branch_id`, `branch_name`, `branch_location`, `is_active`) VALUES
(1, 'Master Branch', 'Dhaka Bangladesh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_colors`
--

CREATE TABLE `tbl_colors` (
  `id` int(11) NOT NULL,
  `color_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `update_by` tinyint(4) DEFAULT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_colors`
--

INSERT INTO `tbl_colors` (`id`, `color_name`, `is_deleted`, `added_by`, `update_by`, `added_time`, `update_time`) VALUES
(1, 'Black', 0, 1, 1, '2019-09-27 09:48:01', '2019-09-27 09:50:22'),
(2, 'Green', 0, 1, 1, '2019-09-27 09:48:09', '2019-09-27 09:50:05'),
(3, 'White', 0, 1, 1, '2019-09-27 09:48:16', '2019-09-27 09:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_current_inventory`
--

CREATE TABLE `tbl_current_inventory` (
  `inventory_id` int(11) NOT NULL,
  `barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `purchase_quantity` int(11) NOT NULL,
  `purchase_rate` decimal(15,2) NOT NULL,
  `sale_quantity` int(11) NOT NULL,
  `sale_rate` decimal(15,2) NOT NULL,
  `purchase_return_quantity` int(11) NOT NULL,
  `sale_return_quantity` int(11) NOT NULL,
  `transfer_from_quantity` int(11) NOT NULL,
  `transfer_to_quantity` int(11) NOT NULL,
  `damage_quantity` int(11) NOT NULL,
  `branch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_current_inventory`
--

INSERT INTO `tbl_current_inventory` (`inventory_id`, `barcode`, `product_id`, `group_id`, `purchase_quantity`, `purchase_rate`, `sale_quantity`, `sale_rate`, `purchase_return_quantity`, `sale_return_quantity`, `transfer_from_quantity`, `transfer_to_quantity`, `damage_quantity`, `branch`) VALUES
(9, 'P000023', 2, 3, 10, '100.00', 0, '150.00', 0, 0, 0, 0, 0, 1),
(10, 'P000014', 1, 4, 2, '20.00', 0, '50.00', 0, 0, 0, 0, 0, 1),
(11, 'P000024', 2, 4, 204, '120.00', 0, '150.00', 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_id` int(11) NOT NULL,
  `is_general` tinyint(1) NOT NULL DEFAULT '0',
  `due_amount` decimal(15,2) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `update_by` tinyint(4) DEFAULT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_groups`
--

INSERT INTO `tbl_groups` (`id`, `group_name`, `is_deleted`, `added_by`, `update_by`, `added_time`, `update_time`) VALUES
(1, 'AA', 0, 1, NULL, '2019-09-28 18:18:02', NULL),
(2, 'HH', 0, 1, NULL, '2019-09-28 18:18:35', NULL),
(3, 'HKJDW', 0, 1, NULL, '2019-09-28 18:39:46', NULL),
(4, 'ASA', 0, 1, NULL, '2019-09-28 18:39:48', NULL),
(5, 'AS', 0, 1, NULL, '2019-09-28 18:39:50', NULL),
(6, 'AS New', 1, 1, 1, '2019-09-28 18:39:52', '2019-09-28 20:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `unit_id` tinyint(4) NOT NULL,
  `color_id` tinyint(4) NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) DEFAULT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_code`, `product_name`, `unit_id`, `color_id`, `branch`, `is_active`, `is_deleted`, `added_by`, `added_time`, `update_by`, `update_time`) VALUES
(1, 'P00001', 't-shirt', 1, 2, 1, 1, 0, 1, '2019-09-27 16:38:08', NULL, ''),
(2, 'P00002', 'Pant ok', 2, 3, 1, 1, 0, 1, '2019-09-27 16:48:37', 1, '2019-09-27 18:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchases_details`
--

CREATE TABLE `tbl_purchases_details` (
  `purchase_detail_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` tinyint(4) NOT NULL,
  `qty` int(11) NOT NULL,
  `purchase_rate` decimal(10,2) NOT NULL,
  `sale_rate` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_purchases_details`
--

INSERT INTO `tbl_purchases_details` (`purchase_detail_id`, `purchase_id`, `product_id`, `group_id`, `qty`, `purchase_rate`, `sale_rate`, `purchase_date`, `total`, `branch`, `is_deleted`, `added_by`, `added_time`, `update_by`, `update_time`) VALUES
(13, 16, 2, 3, 5, '100.00', '150.00', '2019-10-07', '500.00', 1, 0, 1, '2019-10-07 07:47:23', 0, ''),
(14, 16, 1, 4, 2, '20.00', '50.00', '2019-10-07', '40.00', 1, 0, 1, '2019-10-07 07:47:23', 0, ''),
(15, 17, 2, 4, 99, '120.00', '150.00', '2019-10-07', '11880.00', 1, 0, 1, '2019-10-07 07:51:06', 0, ''),
(16, 18, 2, 3, 5, '100.00', '180.00', '2019-10-07', '500.00', 1, 0, 1, '2019-10-07 07:54:14', 0, ''),
(17, 19, 2, 4, 100, '100.00', '100.00', '2019-10-07', '10000.00', 1, 0, 1, '2019-10-07 07:55:11', 0, ''),
(18, 20, 2, 4, 5, '90.00', '100.00', '2019-10-08', '450.00', 1, 0, 1, '2019-10-07 08:02:01', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_master`
--

CREATE TABLE `tbl_purchase_master` (
  `purchase_id` int(11) NOT NULL,
  `supplier_id` smallint(6) NOT NULL,
  `invoice` smallint(10) NOT NULL,
  `sub_total` decimal(15,2) NOT NULL,
  `discount_percent` smallint(6) NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `vat_percent` smallint(6) NOT NULL,
  `vat_amount` decimal(10,2) NOT NULL,
  `transport_cost` decimal(10,2) NOT NULL,
  `other_cost` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `paid` decimal(15,2) NOT NULL,
  `due` decimal(15,2) NOT NULL,
  `previous_due` decimal(15,2) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `purchase_date` date NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_purchase_master`
--

INSERT INTO `tbl_purchase_master` (`purchase_id`, `supplier_id`, `invoice`, `sub_total`, `discount_percent`, `discount_amount`, `vat_percent`, `vat_amount`, `transport_cost`, `other_cost`, `total`, `paid`, `due`, `previous_due`, `comment`, `branch`, `purchase_date`, `is_deleted`, `added_by`, `added_time`, `update_by`, `update_time`) VALUES
(16, 1, 32767, '540.00', 0, '10.00', 10, '54.00', '20.00', '0.00', '604.00', '600.00', '4.00', '0.00', '', 1, '2019-10-07', 0, 1, '2019-10-07 07:47:23', '', ''),
(17, 1, 32767, '11880.00', 0, '0.00', 0, '0.00', '0.00', '0.00', '11880.00', '0.00', '11880.00', '0.00', '', 1, '2019-10-07', 0, 1, '2019-10-07 07:51:06', '', ''),
(18, 1, 32767, '500.00', 0, '0.00', 0, '0.00', '0.00', '0.00', '500.00', '0.00', '500.00', '0.00', '', 1, '2019-10-07', 0, 1, '2019-10-07 07:54:14', '', ''),
(19, 1, 32767, '10000.00', 0, '0.00', 0, '0.00', '0.00', '0.00', '10000.00', '0.00', '10000.00', '0.00', '', 1, '2019-10-07', 0, 1, '2019-10-07 07:55:11', '', ''),
(20, 1, 32767, '450.00', 0, '0.00', 0, '0.00', '0.00', '0.00', '450.00', '0.00', '450.00', '0.00', '', 1, '2019-10-08', 0, 1, '2019-10-07 08:02:01', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return`
--

CREATE TABLE `tbl_purchase_return` (
  `purchase_return_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `return_date` date NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_details`
--

CREATE TABLE `tbl_sale_details` (
  `sale_detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `discount_percent` tinyint(4) NOT NULL,
  `discount_amount` decimal(8,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `sale_date` date NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_master`
--

CREATE TABLE `tbl_sale_master` (
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice` smallint(10) NOT NULL,
  `sub_total` decimal(15,2) NOT NULL,
  `discount_percent` tinyint(4) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `vat_percent` tinyint(4) NOT NULL,
  `vat_amount` decimal(10,2) NOT NULL,
  `other_cost` decimal(10,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `paid` decimal(15,2) NOT NULL,
  `due` decimal(15,2) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `previous_due` decimal(15,2) NOT NULL,
  `sale_date` date NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_return`
--

CREATE TABLE `tbl_sale_return` (
  `sale_return_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `branch` tinyint(4) NOT NULL,
  `return_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_code` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `due_amount` decimal(15,2) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch` tinyint(4) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` tinyint(4) NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`supplier_id`, `supplier_code`, `due_amount`, `name`, `phone`, `email`, `address`, `branch`, `is_deleted`, `added_by`, `added_time`, `update_by`, `update_time`) VALUES
(1, 'S00001', '0.00', 'Jabed Khan', '0174712121', 'a@gmail.com', 'Dhaka Bangladesh', 1, 0, 1, '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_units`
--

CREATE TABLE `tbl_units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `added_by` tinyint(4) NOT NULL,
  `update_by` tinyint(4) DEFAULT NULL,
  `added_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_units`
--

INSERT INTO `tbl_units` (`id`, `unit_name`, `is_deleted`, `added_by`, `update_by`, `added_time`, `update_time`) VALUES
(1, 'KG', 0, 1, 0, '2019-09-27 08:47:15', ''),
(2, 'Liter', 0, 1, 0, '2019-09-27 08:48:54', ''),
(3, 'OK', 1, 1, 1, '2019-09-27 08:51:42', '2019-09-27 09:20:50'),
(4, 'Pices y', 1, 1, 1, '2019-09-27 09:23:25', '2019-09-27 09:24:17'),
(5, 'sds', 1, 1, NULL, '2019-09-27 09:27:37', ''),
(6, 'Work Yest', 1, 1, 1, '2019-09-27 09:28:37', '2019-09-27 09:28:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tbl_colors`
--
ALTER TABLE `tbl_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_current_inventory`
--
ALTER TABLE `tbl_current_inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_purchases_details`
--
ALTER TABLE `tbl_purchases_details`
  ADD PRIMARY KEY (`purchase_detail_id`);

--
-- Indexes for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `tbl_purchase_return`
--
ALTER TABLE `tbl_purchase_return`
  ADD PRIMARY KEY (`purchase_return_id`);

--
-- Indexes for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  ADD PRIMARY KEY (`sale_detail_id`);

--
-- Indexes for table `tbl_sale_master`
--
ALTER TABLE `tbl_sale_master`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `tbl_sale_return`
--
ALTER TABLE `tbl_sale_return`
  ADD PRIMARY KEY (`sale_return_id`);

--
-- Indexes for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbl_units`
--
ALTER TABLE `tbl_units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `branch_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_colors`
--
ALTER TABLE `tbl_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_current_inventory`
--
ALTER TABLE `tbl_current_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_purchases_details`
--
ALTER TABLE `tbl_purchases_details`
  MODIFY `purchase_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_purchase_return`
--
ALTER TABLE `tbl_purchase_return`
  MODIFY `purchase_return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  MODIFY `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sale_master`
--
ALTER TABLE `tbl_sale_master`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sale_return`
--
ALTER TABLE `tbl_sale_return`
  MODIFY `sale_return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_units`
--
ALTER TABLE `tbl_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
