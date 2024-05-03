-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 12:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maininventorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblborrowingreports`
--

CREATE TABLE `tblborrowingreports` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `approvebyid` int(11) NOT NULL,
  `approvereservebyid` int(11) DEFAULT NULL,
  `rejectedbyid` int(11) DEFAULT NULL,
  `approvereturnbyid` int(11) DEFAULT NULL,
  `borrowerid` int(11) NOT NULL,
  `itemreqstatus` varchar(20) NOT NULL,
  `datetimereqborrow` datetime DEFAULT NULL,
  `datetimereqreservation` datetime DEFAULT NULL,
  `datimeapproved` datetime DEFAULT NULL,
  `datetimereserve` datetime DEFAULT NULL,
  `updatereservation` datetime DEFAULT NULL,
  `datetimeapprovereserved` datetime DEFAULT NULL,
  `datimerejected` datetime DEFAULT NULL,
  `datetimecanceled` datetime DEFAULT NULL,
  `datetimereturn` datetime DEFAULT NULL,
  `datetimereqreturn` datetime DEFAULT NULL,
  `returnremarks` varchar(100) DEFAULT NULL,
  `returncode` varchar(10) NOT NULL,
  `returnitemcondition` varchar(50) DEFAULT NULL,
  `reservelocation` varchar(100) DEFAULT NULL,
  `reservepurpose` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblborrowingreports`
--

INSERT INTO `tblborrowingreports` (`id`, `itemid`, `approvebyid`, `approvereservebyid`, `rejectedbyid`, `approvereturnbyid`, `borrowerid`, `itemreqstatus`, `datetimereqborrow`, `datetimereqreservation`, `datimeapproved`, `datetimereserve`, `updatereservation`, `datetimeapprovereserved`, `datimerejected`, `datetimecanceled`, `datetimereturn`, `datetimereqreturn`, `returnremarks`, `returncode`, `returnitemcondition`, `reservelocation`, `reservepurpose`) VALUES
(891, 75, 3, NULL, 3, NULL, 10, 'Rejected', NULL, '2024-04-24 18:56:12', '2024-04-24 18:56:34', '2024-04-24 18:56:00', NULL, NULL, '2024-04-24 19:17:15', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'xample'),
(892, 87, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(893, 89, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(894, 111, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(895, 112, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(896, 116, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(897, 92, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(898, 93, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(899, 94, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(900, 100, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(901, 101, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:11:53', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(902, 85, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:12:20', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(903, 86, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:12:20', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(904, 79, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:13:19', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(905, 120, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:14:05', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:14:18', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(906, 123, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:15:19', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:17:44', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(907, 124, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-24 19:15:19', NULL, NULL, NULL, NULL, NULL, '2024-04-24 19:17:44', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(908, 111, 0, NULL, 3, NULL, 10, 'Rejected', NULL, '2024-04-24 19:18:43', NULL, '2024-04-26 07:18:00', NULL, NULL, '2024-04-24 19:20:20', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(909, 112, 0, NULL, 3, NULL, 10, 'Rejected', NULL, '2024-04-24 19:18:43', NULL, '2024-04-26 07:18:00', NULL, NULL, '2024-04-24 19:20:20', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(910, 87, 0, 3, NULL, NULL, 10, 'Approve Reserve', NULL, '2024-04-24 19:25:50', NULL, '2024-04-25 21:25:00', NULL, '2024-04-24 19:32:32', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(911, 89, 0, 3, NULL, NULL, 10, 'Approve Reserve', NULL, '2024-04-24 19:25:50', NULL, '2024-04-25 21:25:00', NULL, '2024-04-24 19:32:32', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(912, 85, 0, 3, NULL, NULL, 10, 'Approve Reserve', NULL, '2024-04-24 19:33:12', NULL, '2024-04-24 19:34:00', NULL, '2024-04-24 19:33:28', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(913, 111, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-24 19:41:39', NULL, '2024-04-24 19:41:46', NULL, NULL, NULL, NULL, NULL, '2024-04-25 06:30:04', NULL, 'sad', 'PA7WS7ST', 'No Issue', NULL, NULL),
(914, 112, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-24 19:41:39', NULL, '2024-04-24 19:41:46', NULL, NULL, NULL, NULL, NULL, '2024-04-25 06:30:04', NULL, 'sad', 'PA7WS7ST', 'No Issue', NULL, NULL),
(915, 72, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-24 23:04:41', NULL, '2024-04-24 23:04:49', NULL, NULL, NULL, NULL, NULL, '2024-04-25 06:30:04', NULL, 'sad', 'PA7WS7ST', 'No Issue', NULL, NULL),
(916, 73, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-24 23:04:41', NULL, '2024-04-24 23:04:49', NULL, NULL, NULL, NULL, NULL, '2024-04-25 06:30:04', NULL, 'sad', 'PA7WS7ST', 'No Issue', NULL, NULL),
(917, 74, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-24 23:04:41', NULL, '2024-04-24 23:04:49', NULL, NULL, NULL, NULL, NULL, '2024-04-25 06:30:04', NULL, 'sad', 'PA7WS7ST', 'No Issue', NULL, NULL),
(918, 117, 0, NULL, NULL, NULL, 10, 'Pending Borrow', '2024-04-24 23:49:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(919, 83, 0, NULL, NULL, NULL, 10, 'Pending Borrow', '2024-04-24 23:57:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(920, 84, 0, NULL, NULL, NULL, 10, 'Pending Borrow', '2024-04-24 23:57:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(921, 86, 0, NULL, NULL, NULL, 10, 'Pending Borrow', '2024-04-24 23:57:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblitembrand`
--

CREATE TABLE `tblitembrand` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffname` varchar(50) NOT NULL,
  `itembrand` varchar(50) NOT NULL,
  `categoryname` varchar(50) NOT NULL,
  `subcategoryname` varchar(50) NOT NULL,
  `borrowable` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `modelno` varchar(50) NOT NULL,
  `serialno` varchar(50) NOT NULL,
  `unitcost` decimal(10,0) NOT NULL,
  `status` varchar(50) NOT NULL,
  `itemcondition` varchar(50) NOT NULL,
  `datetimeadded` datetime NOT NULL,
  `assignfor` varchar(50) DEFAULT NULL,
  `datepurchased` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblitembrand`
--

INSERT INTO `tblitembrand` (`id`, `staffid`, `staffname`, `itembrand`, `categoryname`, `subcategoryname`, `borrowable`, `remarks`, `modelno`, `serialno`, `unitcost`, `status`, `itemcondition`, `datetimeadded`, `assignfor`, `datepurchased`) VALUES
(72, 3, 'Naix Lifestealer', 'Intel Pentium Dual E2140 160 Ghz', 'Computer Hardware and Projector', 'CPU', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:12:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:13:50', 'MS. Aurora Miro Desk', '2024-03-01'),
(74, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:13:50', 'For Faculty 1', '2024-03-01'),
(75, 3, 'Naix Lifestealer', '80 GB SATA', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:14:31', 'MS. Aurora Miro Desk', '2024-03-01'),
(76, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(77, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(78, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(80, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(81, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(82, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', '', 0, 'Pending Borrow', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', 'OP-620D	', '', 0, 'Pending Borrow', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', '', 0, 'Reserve', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', '', 0, 'Pending Borrow', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', '', 0, 'Reserve', 'New', '2024-03-13 16:19:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', '', 0, 'Reserve', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(90, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:21:40', 'MS. Aurora Miro Desk', '2024-03-01'),
(91, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:24:15', 'MS. Aurora Miro Desk', '2024-03-01'),
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(106, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(107, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(108, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(109, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(110, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(111, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(112, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', 'Miss Gian PC', '2024-03-01'),
(113, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(114, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(115, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', '', 0, 'Pending Borrow', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'Toshiba v1', 'Appliances', 'Stand Fan', 'Yes', '', '', 'NA', 0, 'Available', 'Good', '2024-03-19 21:07:44', '', '2024-03-20'),
(121, 3, 'Naix Lifestealer', 'pldt', 'Ring Binder', 'ZamBo', 'Yes', '', '', 'no', 0, 'Available', 'Good', '2024-04-09 19:11:18', NULL, '2024-04-09'),
(122, 3, 'Naix Lifestealer', 'sad12ds', 'Ring Binder', 'ZamBo', 'Yes', '', '', 'NA', 0, 'Available', 'New', '2024-04-09 19:19:26', NULL, '2024-04-09'),
(123, 3, 'Naix Lifestealer', 'sample', 'Sample', 'ZamBo', 'Yes', 'awd', 'sad', 'sad', 2131, 'Available', 'New', '2024-04-21 10:02:33', NULL, '2024-04-02'),
(124, 3, 'Naix Lifestealer', 'sample', 'Sample', 'ZamBo', 'Yes', 'awd', 'sad', 'sad', 2131, 'Available', 'New', '2024-04-21 10:02:33', NULL, '2024-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `tblitemcategory`
--

CREATE TABLE `tblitemcategory` (
  `id` int(11) NOT NULL,
  `categoryname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblitemcategory`
--

INSERT INTO `tblitemcategory` (`id`, `categoryname`) VALUES
(186, 'Phones and Other Devices'),
(189, 'Computer Hardware and Projector'),
(190, 'Clearbook'),
(191, 'Office Supplies and Equipment'),
(193, 'Filing Box'),
(194, 'Ring Binder'),
(195, 'Appliances'),
(198, 'Office Document'),
(207, 'Sample');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessages`
--

CREATE TABLE `tblmessages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessages`
--

INSERT INTO `tblmessages` (`id`, `sender_id`, `message`, `timestamp`, `status`) VALUES
(141, 51, 'oii', '2024-03-18 10:05:37', 'unread'),
(142, 3, 'oi', '2024-03-18 10:05:42', 'unread'),
(143, 15, 'oi', '2024-03-18 10:05:50', 'unread'),
(144, 3, ' To display all sender messages where the sender is staff on the right and all recipient messages where the recipient is a borrower on the left, you need to adjust the SQL query and the PHP code as follows:', '2024-03-18 10:07:05', 'unread'),
(145, 51, 'eyy', '2024-03-18 10:19:01', 'unread'),
(146, 51, 'ambot lng', '2024-03-18 10:24:00', 'unread'),
(147, 3, 'eyy', '2024-03-18 10:24:07', 'unread'),
(148, 15, 'opawd', '2024-03-18 10:26:44', 'unread'),
(149, 3, 'wawd', '2024-03-18 10:26:55', 'unread'),
(150, 15, 'puya', '2024-03-18 10:27:20', 'unread'),
(151, 69, 'eyy', '2024-03-19 00:15:13', 'unread'),
(152, 3, 'oii', '2024-03-19 00:15:23', 'unread'),
(153, 69, 'Eyys', '2024-03-19 00:35:12', 'unread'),
(154, 3, 'eyy', '2024-03-19 00:35:22', 'unread'),
(155, 69, 'eyyyassad', '2024-03-19 06:23:20', 'unread'),
(156, 15, 'oi', '2024-03-19 06:23:36', 'unread'),
(157, 51, 'ahak', '2024-03-20 11:31:57', 'unread'),
(158, 51, 'oii', '2024-03-20 11:32:00', 'unread'),
(159, 3, 'salitaaa', '2024-03-20 11:32:10', 'unread'),
(160, 3, 'Eyys', '2024-03-21 05:28:46', 'unread'),
(161, 3, 'Eyy', '2024-03-21 05:28:56', 'unread'),
(162, 3, 'trfcg', '2024-03-26 12:46:55', 'unread'),
(163, 3, 'oii]', '2024-03-27 01:36:31', 'unread'),
(164, 3, 'eyy', '2024-03-27 01:36:34', 'unread'),
(165, 3, 'sad boi', '2024-03-27 01:36:42', 'unread'),
(166, 3, 'eyy', '2024-04-02 03:18:12', 'unread'),
(167, 3, 'aww', '2024-04-05 10:27:06', 'unread'),
(168, 51, 'oh', '2024-04-09 04:29:28', 'unread'),
(169, 51, 'awdfawe2q3q23', '2024-04-09 04:29:34', 'unread'),
(170, 51, 'awdawd', '2024-04-09 05:12:12', 'unread'),
(171, 3, 'ok', '2024-04-14 03:28:42', 'unread'),
(172, 3, 'ok', '2024-04-14 03:28:56', 'unread'),
(173, 10, 'Eyy', '2024-04-14 06:18:12', 'unread'),
(174, 51, 'eyy', '2024-04-17 06:46:23', 'unread'),
(175, 51, 'pa huwam', '2024-04-17 07:25:36', 'unread'),
(176, 3, 'unswa man', '2024-04-17 07:25:46', 'unread'),
(177, 3, 'eyy', '2024-04-17 11:34:36', 'unread'),
(178, 3, 'awdawd', '2024-04-18 13:04:22', 'unread'),
(179, 51, 'ey', '2024-04-18 13:04:55', 'unread'),
(180, 3, 'ey', '2024-04-20 03:31:13', 'unread'),
(181, 2024, 'aww', '2024-04-20 04:28:15', 'unread'),
(182, 3, 'eyy', '2024-04-20 12:36:14', 'unread'),
(183, 1, 'eyy', '2024-04-20 12:46:11', 'unread'),
(184, 3, 'aww', '2024-04-20 12:47:15', 'unread'),
(185, 3, 'aww', '2024-04-20 12:47:41', 'unread'),
(186, 1, 'wtt', '2024-04-20 12:48:50', 'unread'),
(187, 1, 'wtt', '2024-04-20 12:49:10', 'unread'),
(188, 1, 'etaw', '2024-04-20 12:49:29', 'unread'),
(189, 1, 'etaw', '2024-04-20 12:49:54', 'unread'),
(190, 1, 'sad', '2024-04-20 12:50:14', 'unread'),
(191, 1, 'ngee', '2024-04-20 12:51:12', 'unread'),
(192, 1, 'eyy', '2024-04-20 13:10:49', 'unread'),
(193, 3, 'eyy', '2024-04-20 13:11:02', 'unread'),
(194, 988, 'aww', '2024-04-20 13:11:34', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessage_recipients`
--

CREATE TABLE `tblmessage_recipients` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblmessage_recipients`
--

INSERT INTO `tblmessage_recipients` (`id`, `message_id`, `recipient_id`, `status`) VALUES
(402, 141, 3, 'unread'),
(403, 141, 15, 'unread'),
(404, 141, 17, 'unread'),
(405, 142, 51, 'unread'),
(406, 143, 51, 'unread'),
(407, 144, 51, 'unread'),
(408, 145, 3, 'unread'),
(409, 145, 15, 'unread'),
(410, 145, 17, 'unread'),
(411, 146, 3, 'unread'),
(412, 146, 15, 'unread'),
(413, 146, 17, 'unread'),
(414, 147, 51, 'unread'),
(415, 148, 51, 'unread'),
(416, 149, 51, 'unread'),
(417, 150, 51, 'unread'),
(418, 151, 3, 'unread'),
(419, 151, 15, 'unread'),
(420, 151, 17, 'unread'),
(421, 152, 69, 'unread'),
(422, 153, 3, 'unread'),
(423, 153, 15, 'unread'),
(424, 153, 17, 'unread'),
(425, 154, 69, 'unread'),
(426, 155, 3, 'unread'),
(427, 155, 15, 'unread'),
(428, 155, 17, 'unread'),
(429, 156, 69, 'unread'),
(430, 157, 3, 'unread'),
(431, 157, 15, 'unread'),
(432, 157, 17, 'unread'),
(433, 158, 3, 'unread'),
(434, 158, 15, 'unread'),
(435, 158, 17, 'unread'),
(436, 159, 51, 'unread'),
(437, 160, 69, 'unread'),
(438, 161, 69, 'unread'),
(439, 162, 69, 'unread'),
(440, 163, 51, 'unread'),
(441, 164, 51, 'unread'),
(442, 165, 51, 'unread'),
(443, 166, 69, 'unread'),
(444, 167, 51, 'unread'),
(445, 168, 3, 'unread'),
(446, 168, 15, 'unread'),
(447, 168, 17, 'unread'),
(448, 169, 3, 'unread'),
(449, 169, 15, 'unread'),
(450, 169, 17, 'unread'),
(451, 170, 3, 'unread'),
(452, 170, 15, 'unread'),
(453, 170, 17, 'unread'),
(454, 171, 51, 'unread'),
(455, 172, 69, 'unread'),
(456, 173, 3, 'unread'),
(457, 173, 15, 'unread'),
(458, 173, 17, 'unread'),
(459, 174, 3, 'unread'),
(460, 174, 15, 'unread'),
(461, 174, 17, 'unread'),
(462, 175, 3, 'unread'),
(463, 175, 15, 'unread'),
(464, 175, 17, 'unread'),
(465, 176, 51, 'unread'),
(466, 177, 10, 'unread'),
(467, 178, 6969, 'unread'),
(468, 179, 3, 'unread'),
(469, 179, 15, 'unread'),
(470, 179, 17, 'unread'),
(471, 180, 10, 'unread'),
(472, 181, 3, 'unread'),
(473, 181, 15, 'unread'),
(474, 181, 17, 'unread'),
(475, 182, 2024, 'unread'),
(476, 184, 19104629, 'unread'),
(477, 185, 19104629, 'unread'),
(478, 187, 3, 'unread'),
(479, 187, 15, 'unread'),
(480, 187, 17, 'unread'),
(481, 188, 3, 'unread'),
(482, 188, 15, 'unread'),
(483, 188, 17, 'unread'),
(484, 189, 3, 'unread'),
(485, 189, 15, 'unread'),
(486, 189, 17, 'unread'),
(487, 190, 3, 'unread'),
(488, 190, 15, 'unread'),
(489, 190, 17, 'unread'),
(490, 191, 3, 'unread'),
(491, 191, 15, 'unread'),
(492, 191, 17, 'unread'),
(493, 192, 3, 'unread'),
(494, 192, 15, 'unread'),
(495, 192, 17, 'unread'),
(496, 192, 11111, 'unread'),
(497, 193, 988, 'unread'),
(498, 194, 3, 'unread'),
(499, 194, 15, 'unread'),
(500, 194, 17, 'unread'),
(501, 194, 11111, 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `id` int(11) NOT NULL,
  `categoryname` varchar(50) NOT NULL,
  `subcategoryname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`id`, `categoryname`, `subcategoryname`) VALUES
(134, 'Computer Hardware and Projector', 'CPU'),
(135, 'Computer Hardware and Projector', 'Memmory'),
(143, 'Appliances', 'Stand Fan'),
(145, 'Computer Hardware and Projector', 'Mouse'),
(150, 'Computer Hardware and Projector', 'Laptop'),
(151, 'Computer Hardware and Projector', 'Hard Disk'),
(152, 'Computer Hardware and Projector', 'Monitor'),
(153, 'Computer Hardware and Projector', 'Sound Card'),
(154, 'Computer Hardware and Projector', 'Operating System'),
(155, 'Computer Hardware and Projector', 'AVR'),
(156, 'Computer Hardware and Projector', 'Flash Drive'),
(157, 'Computer Hardware and Projector', 'MS Office'),
(158, 'Computer Hardware and Projector', 'Printer'),
(159, 'Computer Hardware and Projector', 'Router'),
(163, 'Computer Hardware and Projector', 'Keyboard'),
(164, 'Computer Hardware and Projector', 'Video Card'),
(165, 'Clearbook', 'Clearbook'),
(166, 'Clearbook', 'Seagull Clearbook'),
(168, 'Computer Hardware and Projector', 'Projector'),
(179, 'Filing Box', 'Filing Box Long'),
(196, 'Ring Binder', 'Sample'),
(204, 'Sample', 'ZamBo');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `addedbyid` int(11) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `online_status` enum('online','offline') DEFAULT 'offline',
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `approveby` varchar(50) DEFAULT NULL,
  `datetimeregister` datetime DEFAULT NULL,
  `datetimeapprove` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `addedbyid`, `usertype`, `fname`, `lname`, `password`, `online_status`, `status`, `email`, `gender`, `department`, `approveby`, `datetimeregister`, `datetimeapprove`) VALUES
(1, 0, 'Admin', 'John', 'Neil', 'admin', 'offline', 'Active', 'admin@gmail.com', '', '', NULL, NULL, NULL),
(2, 0, 'Admin', 'Naix', 'eawd', 'admin', 'offline', 'Active', '', '', '', NULL, NULL, NULL),
(3, 0, 'CCS Staff', 'Ms. Gian', 'Mahusay', 'uclm-3', 'offline', 'Active', 'Mahusay3@gmail.com', '', '', NULL, NULL, NULL),
(8, 0, 'Employee', 'John Neil', 'Aying', 'uclm-8', 'offline', 'Pending', 'ayingneil8@gmail.com', 'Male', 'College of Hotel & Restaurant Management', NULL, '2024-03-16 19:41:34', NULL),
(9, 0, 'Student', 'John Neil', 'Aying', 'uclm-9', 'offline', 'Pending', 'ayingneil9@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-03-16 19:32:50', NULL),
(10, 0, 'Student', 'John Neil', 'Aying', 'uclm-10', 'online', 'Active', 'ayingneil10@gmail.com', 'Male', 'Ambot', 'Naix Lifestealer', '2024-03-16 19:30:36', '2024-03-16 19:30:46'),
(11, 0, 'Student', 'John Neil', 'Aying', 'uclm-11', 'offline', 'Pending', 'ayingneil11@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:27:30', NULL),
(12, 0, 'Student', 'John Neil', 'Aying', 'uclm-12', 'offline', 'Pending', 'ayingneil12@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:24:10', NULL),
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'offline', 'Active', 'sad@sad.com', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'offline', 'Active', 'sad1@sad.com', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'Zues', 'Wrath', 'uclm-51', 'offline', 'Active', 'ayingneil15@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'John', 'Aying', 'uclm-69', 'offline', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(100, 0, 'Student', 'John Neil', 'Aying', 'Ayingneil100@gmail.com', 'offline', 'Active', 'Ayingneil100@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-04-12 17:20:27', '2024-04-22 23:36:55'),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'offline', 'Inactive', 'sad2@sad.com', '', '', NULL, NULL, NULL),
(213, 0, 'Student', 'John Neil', 'awd', 'wdadawdawd!23', 'offline', 'Pending', 'ayingneil100222@gmail.com', 'Male', 'College of Teacher Education', NULL, '2024-04-23 11:15:56', NULL),
(988, 0, 'Employee', 'Jeneth', 'Escala', 'uclm-988', 'offline', 'Active', 'jen15@gmhail.com', 'Female', 'College of Hotel & Restaurant Management', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(1111, 0, 'Student', 'sad', 'sad', '1', 'offline', 'Pending', 'ayingneil23123100@gmail.com', 'Male', 'College of Teacher Education', NULL, '2024-04-23 11:21:59', NULL),
(1313, 0, 'Student', 'John Neil', 'Aying', 'uclm-1313', 'offline', 'Pending', 'ayingneil13@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:21:59', NULL),
(2024, 0, 'Student', 'Rogelyn', 'Aying', 'uclm-2024', 'offline', 'Active', 'glyn1@gmail.com', 'Female', 'College of Engineering', 'Neil Aying', '2024-03-17 22:03:06', '2024-03-17 22:03:22'),
(2134, 0, 'Employee', 'John Neil', 'awd', 'awd', 'offline', 'Pending', 'awd@ysadahoo.com', 'Male', 'College of Engineering', NULL, '2024-04-23 11:20:59', NULL),
(2222, 0, 'Student', 'John Neil', 'Aying', '1', 'offline', 'Pending', 'ayingn23eil15@gmail.com', 'Male', 'College of Nursing', NULL, '2024-04-23 11:18:31', NULL),
(6060, 0, 'Student', 'Sample', 'Sample', 'Sample22', 'offline', 'Pending', 'Sample@sad.com', 'Male', 'College of Nursing', NULL, '2024-04-23 11:30:19', NULL),
(6969, 0, 'Student', 'Anthony', 'Augusto', 'uclm-6969', 'offline', 'Active', 'ayingant2q1@gmail.com', 'Male', 'College of Engineering', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
(11111, 0, 'CCS Staff', 'awd', 'awd', 'uclm-11111', 'offline', 'Active', 'ayingneil1010@gmail.com', '', '', NULL, NULL, NULL),
(2133333, 0, 'Student', 'Sample', 'Sample', 'Sadboid22', 'offline', 'Pending', 'Sample1@sad.com', 'Male', 'College of Nursing', NULL, '2024-04-23 11:33:36', NULL),
(19104629, 0, 'Dean', 'Ms. Aurora', 'Miro', 'uclm-19104629', 'offline', 'Active', 'Miro22@gmail.com', '', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblborrowingreports`
--
ALTER TABLE `tblborrowingreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmessages`
--
ALTER TABLE `tblmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblborrowingreports`
--
ALTER TABLE `tblborrowingreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=922;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  ADD CONSTRAINT `tblmessage_recipients_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `tblmessages` (`id`),
  ADD CONSTRAINT `tblmessage_recipients_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `tblusers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
