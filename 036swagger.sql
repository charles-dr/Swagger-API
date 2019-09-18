-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2019 at 04:45 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `036swagger`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `client_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `business_url` varchar(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `api_secret` varchar(200) NOT NULL,
  `status` enum('PENDING','ACTIVE') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`client_id`, `name`, `email`, `business_url`, `api_key`, `api_secret`, `status`) VALUES
(1, 'Professional Web Solution', 'alerk.star@gmail.com', 'www.freelancer.com', '1752-0180-4dd1-9623-4c27-c887-44f8-3d7d', 'ec86d7f9-810f8899-16d112ea-ace78281', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `date_activity` datetime NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `due_date` datetime NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `date_activity`, `employee_id`, `due_date`, `course_name`, `created_at`, `updated_at`) VALUES
(3, '2018-06-21 00:00:00', '1239498', '2019-11-30 00:00:00', 'Course #1 to 5 - updated', '2019-09-18 00:35:16', '2019-09-18 01:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `pkemployee` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `location_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `active` enum('Checked','Unchecked') NOT NULL DEFAULT 'Unchecked',
  `activated_at` datetime DEFAULT NULL,
  `train_manager` varchar(100) NOT NULL,
  `escalation_manager` varchar(100) NOT NULL,
  `role` varchar(500) NOT NULL COMMENT 'JSON content',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`pkemployee`, `first_name`, `last_name`, `employee_id`, `location_id`, `email`, `password`, `active`, `activated_at`, `train_manager`, `escalation_manager`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Patrick', 'Jones', '202010', 27, 'al.erk.star@gmail.com', '123456', 'Checked', NULL, 'blackrock@example.com', 'tom.dillon@example.com', '', '2019-09-02 19:41:19', '2019-09-02 19:41:19'),
(2, 'Tai', 'Jin', '202015', 27, 'alerk.star@gmail.com', '234234', 'Unchecked', NULL, 'blackrock@example.com', 'tom.dillon@example.com', '', '2019-09-03 14:40:56', '2019-09-03 14:40:56'),
(3, 'Yang', 'Johnson', '202565', 27, 'alerkstar@gmail.com', '234234', 'Checked', NULL, 'blackrock@example.com', 'tom.dillon@example.com', '', '2019-09-03 14:41:47', '2019-09-03 14:41:47'),
(5, 'Test', 'Update', '1239498', 27, 'hello.again@gmail.com', '0e9212587d373ca58e9bada0c15e6fe4', 'Checked', NULL, 'blackrock.delete@example.com', 'tom.dillon.delete@example.com', '{\"id\":12,\"name\":\"Sponsor\"}', '2019-09-17 23:00:58', '2019-09-18 00:15:48'),
(6, 'Hello', 'Again', '232565', 27, 'hasdello.agai@gmail.com', '0e9212587d373ca58e9bada0c15e6fe4', 'Checked', NULL, 'blackrock@example.com', 'tom.dillon@example.com', '[{\"id\":12},{\"id\":15}]', '2019-09-17 23:08:29', '2019-09-17 23:08:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`pkemployee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_client`
--
ALTER TABLE `tbl_client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `pkemployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
