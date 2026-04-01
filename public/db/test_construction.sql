-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2022 at 01:39 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_construction`
--

-- --------------------------------------------------------

--
-- Table structure for table `Assets`
--

CREATE TABLE `Assets` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_price` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_datetime` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_party`
--

CREATE TABLE `bills_party` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `panno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `site_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ac_holder_name` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_rate`
--

CREATE TABLE `bills_rate` (
  `id` int(11) NOT NULL,
  `work_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_work`
--

CREATE TABLE `bills_work` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_party_statement`
--

CREATE TABLE `bill_party_statement` (
  `id` int(11) NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `particular` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_no` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_datetime` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_time`
--

CREATE TABLE `data_time` (
  `id` int(11) NOT NULL,
  `type` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_date` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `party_id` varchar(255) NOT NULL,
  `head_id` varchar(255) NOT NULL,
  `particular` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `site_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `create_datetime` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_head`
--

CREATE TABLE `expense_head` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_party`
--

CREATE TABLE `expense_party` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machinery_details`
--

CREATE TABLE `machinery_details` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `create_datetime` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Running',
  `site_id` varchar(200) NOT NULL,
  `qty` varchar(50) NOT NULL,
  `next_service_on` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `machinery_documents`
--

CREATE TABLE `machinery_documents` (
  `id` int(11) NOT NULL,
  `Machinery_id` varchar(250) NOT NULL,
  `name` varchar(500) NOT NULL,
  `issue_date` varchar(250) NOT NULL,
  `end_date` varchar(250) NOT NULL,
  `create_date` varchar(250) NOT NULL,
  `pdf_address` varchar(500) NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `machinery_services`
--

CREATE TABLE `machinery_services` (
  `id` int(11) NOT NULL,
  `Machinery_id` varchar(250) NOT NULL,
  `Maintainence_date` varchar(250) NOT NULL,
  `Maintainence_done_by` varchar(500) NOT NULL,
  `Maintainence_item` varchar(2000) NOT NULL,
  `create_date` varchar(500) NOT NULL,
  `image1` varchar(500) NOT NULL,
  `image2` varchar(500) NOT NULL,
  `image3` varchar(500) NOT NULL,
  `image4` varchar(500) NOT NULL,
  `image5` varchar(500) NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_entry`
--

CREATE TABLE `material_entry` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_no` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_datetime` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_supplier`
--

CREATE TABLE `material_supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_bills_item_entry`
--

CREATE TABLE `new_bills_item_entry` (
  `id` int(11) NOT NULL,
  `work_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_bill_entry`
--

CREATE TABLE `new_bill_entry` (
  `id` int(11) NOT NULL,
  `party_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billdate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fromdate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `todate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remark` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE `rights` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `symbol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `uid` varchar(500) DEFAULT NULL,
  `session_key` varchar(250) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `last_activity` varchar(500) DEFAULT NULL,
  `ip_address` varchar(500) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `browser` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`uid`, `session_key`, `login_time`, `last_activity`, `ip_address`, `id`, `browser`) VALUES
('1', '1', '2022-01-23 12:12:52', NULL, '127.0.0.1', 1, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-24 15:06:57', NULL, '127.0.0.1', 2, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 06:19:29', NULL, '127.0.0.1', 3, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 06:58:56', NULL, '127.0.0.1', 4, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 07:07:21', NULL, '127.0.0.1', 5, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 07:19:24', NULL, '127.0.0.1', 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 07:24:19', NULL, '127.0.0.1', 7, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 07:51:59', NULL, '127.0.0.1', 8, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 08:08:18', NULL, '127.0.0.1', 9, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-25 08:16:18', NULL, '127.0.0.1', 10, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-26 07:04:11', NULL, '127.0.0.1', 11, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-26 17:33:20', NULL, '127.0.0.1', 12, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-26 17:38:27', NULL, '127.0.0.1', 13, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-26 17:39:57', NULL, '127.0.0.1', 14, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-27 11:02:32', NULL, '127.0.0.1', 15, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-29 15:42:09', NULL, '127.0.0.1', 16, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-31 05:14:57', NULL, '127.0.0.1', 17, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-31 05:51:41', NULL, '127.0.0.1', 18, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-01-31 05:55:11', NULL, '127.0.0.1', 19, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-02-03 11:17:42', NULL, '127.0.0.1', 20, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-02-05 06:36:27', NULL, '127.0.0.1', 21, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'),
('1', '1', '2022-02-10 17:00:55', NULL, '127.0.0.1', 22, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-15 16:33:28', NULL, '127.0.0.1', 23, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-16 12:52:37', NULL, '127.0.0.1', 24, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-19 05:36:36', NULL, '127.0.0.1', 25, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-19 08:38:10', NULL, '127.0.0.1', 26, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-19 18:08:20', NULL, '127.0.0.1', 27, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-19 18:52:48', NULL, '127.0.0.1', 28, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-27 11:48:49', NULL, '127.0.0.1', 29, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36'),
('1', '1', '2022-02-27 14:32:20', NULL, '127.0.0.1', 30, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `value` varchar(2000) NOT NULL,
  `name` varchar(200) NOT NULL,
  `uid` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`value`, `name`, `uid`, `updated_at`, `id`, `created_at`) VALUES
('menu_dark', 'menutheme', '1', '2022-01-25 02:32:25', 1, '2022-01-23 17:42:59'),
('purple', 'theme', '1', '2022-02-27 06:19:02', 2, '2022-01-23 17:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `balance` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(250) NOT NULL DEFAULT 'Active',
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `name`, `address`, `balance`, `status`, `create_datetime`) VALUES
(1, 'Admin', 'Admin Office', '0', 'Active', '2022-01-27 12:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `sites_transaction`
--

CREATE TABLE `sites_transaction` (
  `id` int(11) NOT NULL,
  `site_id` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `expense_id` varchar(200) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `create_datetime` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_payments`
--

CREATE TABLE `site_payments` (
  `id` int(11) NOT NULL,
  `site_id` varchar(250) NOT NULL,
  `amount` varchar(250) NOT NULL,
  `remark` varchar(2000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `site_id` varchar(200) NOT NULL,
  `rights` varchar(250) NOT NULL,
  `rank` varchar(250) NOT NULL,
  `pan_no` varchar(50) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'Active',
  `image` varchar(2000) NOT NULL DEFAULT 'noprofile.jpg',
  `contact_no` varchar(250) NOT NULL,
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `pass`, `site_id`, `rights`, `rank`, `pan_no`, `status`, `image`, `contact_no`, `create_datetime`) VALUES
(1, 'Sagar Mittal', 'admin', 'admin', '1', '', 'Admin', '', 'Active', 'noprofile.jpg', '', '2022-01-27 11:59:41'),
(2, 'Manvendra Singh', 'manvendra', 'manvendra', '1', '', 'Admin', '', 'Active', 'noprofile.jpg', '', '2022-01-27 12:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_rank`
--

CREATE TABLE `user_rank` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `expense` varchar(250) NOT NULL,
  `material` varchar(250) NOT NULL,
  `Bills` varchar(250) NOT NULL,
  `Machinery` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_rank`
--

INSERT INTO `user_rank` (`id`, `name`, `expense`, `material`, `Bills`, `Machinery`) VALUES
(1, 'Admin', 'true', 'true', 'true', 'true'),
(2, 'Accountant', 'true', 'true', 'true', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Assets`
--
ALTER TABLE `Assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_id` (`expense_id`);

--
-- Indexes for table `bills_party`
--
ALTER TABLE `bills_party`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills_rate`
--
ALTER TABLE `bills_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills_work`
--
ALTER TABLE `bills_work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_party_statement`
--
ALTER TABLE `bill_party_statement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_id` (`expense_id`),
  ADD UNIQUE KEY `bill_no` (`bill_no`);

--
-- Indexes for table `data_time`
--
ALTER TABLE `data_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_head`
--
ALTER TABLE `expense_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_party`
--
ALTER TABLE `expense_party`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machinery_details`
--
ALTER TABLE `machinery_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machinery_documents`
--
ALTER TABLE `machinery_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machinery_services`
--
ALTER TABLE `machinery_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_entry`
--
ALTER TABLE `material_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_supplier`
--
ALTER TABLE `material_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_bills_item_entry`
--
ALTER TABLE `new_bills_item_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_bill_entry`
--
ALTER TABLE `new_bill_entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_no` (`bill_no`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites_transaction`
--
ALTER TABLE `sites_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expense_id` (`expense_id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `site_payments`
--
ALTER TABLE `site_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rank`
--
ALTER TABLE `user_rank`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Assets`
--
ALTER TABLE `Assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_party`
--
ALTER TABLE `bills_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_rate`
--
ALTER TABLE `bills_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_work`
--
ALTER TABLE `bills_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_party_statement`
--
ALTER TABLE `bill_party_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_time`
--
ALTER TABLE `data_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_head`
--
ALTER TABLE `expense_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_party`
--
ALTER TABLE `expense_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machinery_details`
--
ALTER TABLE `machinery_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machinery_documents`
--
ALTER TABLE `machinery_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machinery_services`
--
ALTER TABLE `machinery_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_entry`
--
ALTER TABLE `material_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_supplier`
--
ALTER TABLE `material_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_bills_item_entry`
--
ALTER TABLE `new_bills_item_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_bill_entry`
--
ALTER TABLE `new_bill_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sites_transaction`
--
ALTER TABLE `sites_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_payments`
--
ALTER TABLE `site_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_rank`
--
ALTER TABLE `user_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
