-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 01:30 AM
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
(1192, 111, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-29 23:14:43', NULL, NULL, NULL, NULL, NULL, '2024-04-29 23:16:42', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(1193, 111, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-30 07:47:30', NULL, '2024-04-29 10:40:00', NULL, '2024-04-30 07:50:30', NULL, NULL, NULL, NULL, NULL, '', NULL, 'xad', 'xad'),
(1194, 112, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-30 07:47:30', NULL, '2024-04-29 10:40:00', NULL, '2024-04-30 09:16:45', NULL, NULL, NULL, NULL, NULL, '', NULL, 'xad', 'xad'),
(1195, 127, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-30 07:54:07', NULL, '2024-04-30 10:01:58', NULL, NULL, NULL, NULL, NULL, '2024-04-30 10:02:48', NULL, 'sad', 'F8U7FWPG', 'No Issue', NULL, NULL),
(1196, 119, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-30 07:54:07', NULL, '2024-04-30 10:01:58', NULL, NULL, NULL, NULL, NULL, '2024-04-30 10:42:50', NULL, 'xad', 'FPHVP9JT', 'No Issue', NULL, NULL),
(1197, 72, 3, 3, NULL, 3, 10, 'Returned', NULL, '2024-04-30 09:16:36', '2024-04-30 10:08:04', '2024-04-30 09:16:00', NULL, '2024-04-30 09:16:45', NULL, NULL, '2024-04-30 10:42:50', NULL, 'xad', 'FPHVP9JT', 'No Issue', 'sad', 'sad'),
(1198, 116, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-30 10:43:11', NULL, '2024-04-30 10:45:53', NULL, NULL, NULL, NULL, NULL, '2024-04-30 11:23:52', '2024-04-30 11:07:02', 'sad', '3GW6WY9L', 'Damage', NULL, NULL),
(1199, 72, 3, NULL, NULL, NULL, 10, 'Approved', '2024-04-30 11:12:06', NULL, '2024-04-30 11:13:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(1200, 127, 3, 3, NULL, 3, 10, 'Returned', NULL, '2024-04-30 11:19:24', '2024-04-30 11:28:44', '2024-04-30 11:22:00', NULL, '2024-04-30 11:21:15', NULL, NULL, '2024-05-01 12:51:10', '2024-04-30 23:03:22', 'xad', 'LH3I45IK', 'No Issue', 'sad', 'sad'),
(1201, 119, 3, NULL, NULL, 3, 988, 'Returned', '2024-04-30 12:00:41', NULL, '2024-04-30 12:00:50', NULL, NULL, NULL, NULL, NULL, '2024-04-30 12:01:19', NULL, 'sad', '8A4EYNFV', 'Lost', NULL, NULL),
(1202, 128, 3, NULL, NULL, 3, 69, 'Returned', '2024-04-30 13:55:32', NULL, '2024-05-01 11:47:43', NULL, NULL, NULL, NULL, NULL, '2024-05-01 12:50:15', NULL, 'xad\r\n', 'NZPJBQEW', 'No Issue', NULL, NULL),
(1203, 75, 19104629, 3, NULL, NULL, 10, 'Approved', NULL, '2024-04-30 21:05:33', '2024-04-30 21:17:12', '2024-04-30 21:06:00', '2024-04-30 21:17:08', '2024-04-30 21:06:10', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(1204, 73, 0, 3, NULL, NULL, 10, 'Approve Reserve', NULL, '2024-05-01 11:16:04', NULL, '2024-05-17 23:19:00', '2024-05-01 11:31:28', '2024-05-01 11:17:00', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(1205, 128, 3, NULL, NULL, NULL, 10, 'Approved', '2024-05-01 12:50:31', NULL, '2024-05-01 12:50:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL);

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
(72, 3, 'Naix Lifestealer', 'Intel Pentium Dual E2140 160 Ghz', 'Computer Hardware and Projector', 'CPU', 'Yes', '', '', 'SN-9356-VSND', 0, 'Borrowed', 'New', '2024-03-13 16:12:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', 'SN-1265-XNIZ', 0, 'Reserve', 'New', '2024-03-13 16:13:50', 'MS. Aurora Miro Desk', '2024-03-01'),
(74, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', 'SN-9046-CGWJ', 0, 'Available', 'New', '2024-03-13 16:13:50', 'For Faculty 1', '2024-03-01'),
(75, 3, 'Naix Lifestealer', '80 GB SATA', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', '', 'SN-2510-ZBFX', 0, 'Borrowed', 'New', '2024-03-13 16:14:31', 'MS. Aurora Miro Desk', '2024-03-01'),
(76, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'Yes', '', '', 'SN-3458-YMVO', 0, 'Available', 'New', '2024-03-13 16:16:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(77, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', 'SN-7089-HFBT', 0, 'Standby', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(78, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', 'SN-9365-VEDX', 0, 'Standby', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'Yes', '', '', 'SN-8724-FVZM', 0, 'Available', 'New', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(80, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', 'SN-6013-SWUK', 0, 'Standby', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(81, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', 'SN-2396-ELGN', 0, 'Standby', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(82, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', 'SN-4691-QPKR', 0, 'Standby', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-6723-TFRE', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', 'OP-620D	', 'SN-2584-KGAC', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-4987-WOQY', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-7156-LHEX', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-3984-JOHY', 0, 'Available', 'New', '2024-03-13 16:19:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-8402-QWPA', 0, 'Available', 'New', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-7315-ULRV', 0, 'Available', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(90, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', 'SN-9873-NMZV', 3600, 'Standby', 'New', '2024-03-13 16:21:40', 'MS. Aurora Miro Desk', '2024-03-01'),
(91, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', 'SN-6231-DVBP', 3600, 'Standby', 'New', '2024-03-13 16:24:15', 'MS. Aurora Miro Desk', '2024-03-01'),
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-7209-WRZP', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-4921-KGBN', 32, 'Standby', 'New', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-6098-VHTL', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-1473-LNFM', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-3185-TQRO', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-9562-PIJX', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-6734-GZAF', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-8240-EBMD', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-5407-FRDW', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', 'SN-3629-YXUC', 32, 'Standby', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(106, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', 'SN-2873-TSYC', 0, 'Standby', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(111, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', 'SN-7910-IWRF', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(112, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', 'SN-5147-LZAO', 0, 'Available', 'New', '2024-03-13 21:18:16', 'Miss Gian PC', '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'Yes', '', '', 'SN-7084-HKWT', 0, 'Available', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', 'SN-5739-BVOF', 0, 'Available', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'Yes', '', '', 'SN-1470-PXEF', 0, 'Available', 'New', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', 'SN-3401-IUHM', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'Toshiba v1', 'Appliances', 'Stand Fan', 'No', '', '', 'SN-8356-AXYK', 0, 'Standby', 'Good', '2024-03-19 21:07:44', '', '2024-03-20'),
(121, 3, 'Naix Lifestealer', 'pldt', 'Ring Binder', 'Sample', 'Yes', '', '', 'SN-6402-KXJD', 0, 'Available', 'Good', '2024-04-09 19:11:18', '', '2024-04-09'),
(122, 3, 'Naix Lifestealer', 'sad12ds', 'Ring Binder', 'Sample', 'Yes', '', '', 'SN-8675-BNWP', 0, 'Available', 'New', '2024-04-09 19:19:26', '', '2024-04-09'),
(123, 3, 'Naix Lifestealer', 'sample', 'Sample', 'ZamBo', 'Yes', 'awd', 'sad', 'SN-3794-OAKG', 2131, 'Available', 'New', '2024-04-21 10:02:33', '', '2024-04-02'),
(124, 3, 'Naix Lifestealer', 'sample', 'Sample', 'ZamBo', 'Yes', 'awd', 'sad', 'SN-9251-PCTQ', 2131, 'Available', 'New', '2024-04-21 10:02:33', '', '2024-04-02'),
(125, 3, 'Ms. Gian Mahusay', 'Converge', 'Computer Hardware and Projector', 'Router', 'Yes', '', '', 'SN-5823-CTQI', 600, 'Available', 'New', '2024-04-28 10:43:26', '', '2024-04-02'),
(126, 3, 'Ms. Gian Mahusay', 'Converge', 'Computer Hardware and Projector', 'Router', 'Yes', '', '', 'SN-3902-ARJU', 600, 'Available', 'New', '2024-04-28 10:43:26', '', '2024-04-02'),
(127, 3, 'Ms. Gian Mahusay', 'sample', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', 'sad', 'SN-1867-DTQA', 100, 'Available', 'New', '2024-04-29 18:17:08', '', '2024-04-29'),
(128, 3, 'Ms. Gian Mahusay', 'sample', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', 'sad', 'SN-5073-MKCI', 100, 'Borrowed', 'New', '2024-04-29 18:17:08', '', '2024-04-29'),
(133, 3, 'Ms. Gian Mahusay', 'xp windoes', 'Sample', 'ZamBo', 'Yes', '', '', 'NA', 0, 'Available', 'New', '2024-05-01 20:23:49', NULL, '2023-11-30'),
(134, 3, 'Ms. Gian Mahusay', 'xp windoes', 'Sample', 'ZamBo', 'Yes', '', '', 'NA', 0, 'Available', 'Old', '2024-05-01 20:30:13', NULL, '2023-10-01'),
(135, 3, 'Ms. Gian Mahusay', 'Epson', 'Appliances', 'Stand Fan', 'Yes', '', '', 'NA', 0, 'Available', 'Old', '2024-05-01 20:52:39', '', '2023-10-19');

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
(215, 3, 'eyy', '2024-05-01 03:09:07', 'unread'),
(216, 10, 'eyy', '2024-05-01 03:09:19', 'unread'),
(217, 3, 'eyy', '2024-05-01 14:51:15', 'unread');

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
(534, 215, 10, 'read'),
(535, 216, 3, 'unread'),
(536, 216, 15, 'unread'),
(537, 216, 17, 'unread'),
(538, 216, 11111, 'unread'),
(539, 217, 10, 'read');

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
(9, 0, 'Student', 'John Neil', 'Aying', 'uclm-9', 'offline', 'Active', 'ayingneil9@gmail.com', 'Male', 'College of Computer Studies', 'Ms. Gian Mahusay', '2024-03-16 19:32:50', '2024-04-27 13:50:44'),
(10, 0, 'Student', 'John Neil', 'Aying', 'uclm-10', 'offline', 'Active', 'ayingneil10@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-16 19:30:36', '2024-03-16 19:30:46'),
(11, 0, 'Student', 'John Neil', 'Aying', 'Sadboid15', 'offline', 'Active', 'ayingsad2@gmail.com', 'Male', 'Eyy', 'Ms. Gian Mahusay', '2024-04-27 13:52:47', '2024-04-27 13:53:01'),
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'offline', 'Active', 'sad@sad.com', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'offline', 'Active', 'sad1@sad.com', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'Zues', 'Wrath', 'uclm-51', 'offline', 'Inactive', 'ayingneil15@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'John', 'Aying', 'uclm-69', 'offline', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(100, 0, 'Student', 'John Neil', 'Aying', 'Ayingneil100@gmail.com', 'offline', 'Inactive', 'Ayingneil100@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-04-12 17:20:27', '2024-04-22 23:36:55'),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'offline', 'Active', 'sad2@sad.com', '', '', NULL, NULL, NULL),
(988, 0, 'Employee', 'Jeneth', 'Escala', 'uclm-988', 'offline', 'Active', 'jen15@gmhail.com', 'Female', 'College of Hotel & Restaurant Management', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(2024, 0, 'Student', 'Rogelyn', 'Aying', 'uclm-2024', 'offline', 'Active', 'glyn1@gmail.com', 'Female', 'College of Engineering', 'Neil Aying', '2024-03-17 22:03:06', '2024-03-17 22:03:22'),
(6060, 0, 'Student', 'Sample', 'Sample', 'Sample22', 'offline', 'Active', 'Sample@sad.com', 'Male', 'College of Nursing', 'Ms. Gian Mahusay', '2024-04-23 11:30:19', '2024-04-27 13:50:38'),
(6969, 0, 'Student', 'Anthony', 'Augusto', 'uclm-6969', 'offline', 'Active', 'ayingant2q1@gmail.com', 'Male', 'College of Engineering', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
(11111, 0, 'CCS Staff', 'awd', 'awd', 'uclm-11111', 'offline', 'Active', 'ayingneil1010@gmail.com', '', '', NULL, NULL, NULL),
(12333, 0, 'Student', 'John Neil', 'Aying', '@sad!Addws23', 'offline', 'Active', 'ayingnsadasdeil15@gmail.com', 'Male', 'College of Customs Administration', 'Ms. Gian Mahusay', '2024-04-26 13:39:52', '2024-04-27 11:40:35'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1206;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=540;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

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
