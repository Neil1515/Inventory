-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2024 at 03:31 PM
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
  `rejectedbyid` int(11) NOT NULL,
  `approvereturnbyid` int(11) DEFAULT NULL,
  `borrowerid` int(11) NOT NULL,
  `itemreqstatus` varchar(20) NOT NULL,
  `datetimereqborrow` datetime NOT NULL,
  `datimeapproved` datetime DEFAULT NULL,
  `datimerejected` datetime DEFAULT NULL,
  `datetimecanceled` datetime DEFAULT NULL,
  `datetimereturn` datetime DEFAULT NULL,
  `returnremarks` varchar(100) DEFAULT NULL,
  `returncode` varchar(10) NOT NULL,
  `returnitemcondition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblborrowingreports`
--

INSERT INTO `tblborrowingreports` (`id`, `itemid`, `approvebyid`, `rejectedbyid`, `approvereturnbyid`, `borrowerid`, `itemreqstatus`, `datetimereqborrow`, `datimeapproved`, `datimerejected`, `datetimecanceled`, `datetimereturn`, `returnremarks`, `returncode`, `returnitemcondition`) VALUES
(443, 120, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(444, 92, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(445, 116, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(446, 75, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(447, 73, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(448, 85, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(449, 106, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(450, 111, 15, 0, 15, 51, 'Returned', '2024-03-24 21:52:07', '2024-03-24 21:52:15', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(451, 93, 0, 15, NULL, 51, 'Rejected', '2024-03-24 21:54:29', NULL, '2024-03-24 21:54:35', NULL, NULL, NULL, '', NULL),
(452, 94, 15, 0, 15, 51, 'Returned', '2024-03-24 21:54:47', '2024-03-24 21:54:55', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(453, 98, 15, 0, 15, 51, 'Returned', '2024-03-24 21:54:47', '2024-03-24 21:54:55', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue'),
(454, 112, 0, 0, NULL, 51, 'Canceled', '2024-03-24 21:55:05', NULL, NULL, '2024-03-24 21:55:10', NULL, NULL, '', NULL),
(455, 101, 15, 0, 15, 51, 'Returned', '2024-03-24 21:55:15', '2024-03-24 21:55:37', NULL, NULL, '2024-03-24 22:14:14', 'aw', 'ESFL222Y', 'No Issue');

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
(72, 3, 'Naix Lifestealer', 'Intel Pentium Dual E2140 160 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:12:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:13:50', 'MS. Aurora Miro Desk', '2024-03-01'),
(74, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:13:50', 'For Faculty 1', '2024-03-01'),
(75, 3, 'Naix Lifestealer', '80 GB SATA', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:14:31', 'MS. Aurora Miro Desk', '2024-03-01'),
(76, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(77, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(78, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(80, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(81, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(82, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', 'OP-620D	', '', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(90, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:21:40', 'MS. Aurora Miro Desk', '2024-03-01'),
(91, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:24:15', 'MS. Aurora Miro Desk', '2024-03-01'),
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(106, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(107, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(108, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(109, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(110, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(111, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(112, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', 'Miss Gian PC', '2024-03-01'),
(113, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(114, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(115, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'sad', 'Appliances', 'Stand Fan', 'Yes', '', '', 'NA', 0, 'Available', 'Poor', '2024-03-19 21:07:44', NULL, '2024-03-20');

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
(198, 'Office Document');

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
(161, 3, 'Eyy', '2024-03-21 05:28:56', 'unread');

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
(438, 161, 69, 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `tblreservereports`
--

CREATE TABLE `tblreservereports` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffname` varchar(50) NOT NULL,
  `itembrand` varchar(50) NOT NULL,
  `categoryname` varchar(50) NOT NULL,
  `subcategoryname` varchar(50) NOT NULL,
  `serialno` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `datetimereserve` datetime NOT NULL,
  `location` varchar(50) NOT NULL,
  `borrowername` varchar(50) NOT NULL,
  `reason` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreservereports`
--

INSERT INTO `tblreservereports` (`id`, `itemid`, `staffid`, `staffname`, `itembrand`, `categoryname`, `subcategoryname`, `serialno`, `remarks`, `datetimereserve`, `location`, `borrowername`, `reason`) VALUES
(7, 38, 15, 'Neil Aying', 'SSM 16-Black', 'Appliances', 'Stand Fan', 'NA', '', '2024-03-05 16:28:52', 'sad', 'sad', 'sad'),
(8, 37, 15, 'Neil Aying', 'Long', 'Clearbook', 'Color Blue Without Cover', 'NA', '', '2024-03-05 18:53:05', 'NA', 'John Neil Augusto', 'NA'),
(9, 44, 15, 'Neil Aying', 'Micropack', 'Computer Hardware and Projector', 'Mouse', 'NA', '', '2024-03-05 19:20:54', 'sad', 'sad', 'sad'),
(10, 37, 15, 'Neil Aying', 'Long', 'Clearbook', 'Color Blue Without Cover', 'NA', '', '2024-03-05 19:46:30', 'NA', 'John Neil Augusto', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `tblreturnreports`
--

CREATE TABLE `tblreturnreports` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `borrowerid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffname` varchar(50) NOT NULL,
  `itembrand` varchar(50) NOT NULL,
  `categoryname` varchar(50) NOT NULL,
  `subcategoryname` varchar(50) NOT NULL,
  `serialno` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `datetimereturn` datetime NOT NULL,
  `returnborrowername` varchar(50) NOT NULL,
  `itemstatus` varchar(100) NOT NULL,
  `damageDetails` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreturnreports`
--

INSERT INTO `tblreturnreports` (`id`, `itemid`, `borrowerid`, `staffid`, `staffname`, `itembrand`, `categoryname`, `subcategoryname`, `serialno`, `remarks`, `datetimereturn`, `returnborrowername`, `itemstatus`, `damageDetails`) VALUES
(33, 38, 0, 3, 'Naix Lifestealer', 'SSM 16-Black', 'Appliances', 'Stand Fan', 'NA', '', '2024-03-06 21:02:29', 'sad', 'No Issue', ''),
(34, 37, 0, 3, 'Naix Lifestealer', 'Long', 'Clearbook', 'Color Blue Without Cover', 'NA', '', '2024-03-06 21:02:40', 'sad', 'No Issue', ''),
(35, 38, 0, 3, 'Naix Lifestealer', 'SSM 16-Black', 'Appliances', 'Stand Fan', 'NA', '', '2024-03-07 18:54:16', 'awd', 'No Issue', '');

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
(179, 'Filing Box', 'Filing Box Long');

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

INSERT INTO `tblusers` (`id`, `addedbyid`, `usertype`, `fname`, `lname`, `password`, `status`, `email`, `gender`, `department`, `approveby`, `datetimeregister`, `datetimeapprove`) VALUES
(1, 0, 'Admin', 'John', 'Neil', 'admin', 'Active', '', '', '', NULL, NULL, NULL),
(2, 0, 'Admin', 'Naix', 'eawd', 'admin', 'Active', '', '', '', NULL, NULL, NULL),
(3, 0, 'CCS Staff', 'Naix', 'Lifestealer', 'uclm-3', 'Active', '', '', '', NULL, NULL, NULL),
(8, 0, 'Employee', 'John Neil', 'Aying', 'uclm-8', 'Pending', 'ayingneil8@gmail.com', 'Male', 'College of Hotel & Restaurant Management', NULL, '2024-03-16 19:41:34', NULL),
(9, 0, 'Student', 'John Neil', 'Aying', 'uclm-9', 'Pending', 'ayingneil9@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-03-16 19:32:50', NULL),
(10, 0, 'Employee', 'John Neil', 'Aying', 'uclm-10', 'Active', 'ayingneil10@gmail.com', 'Male', 'Ambot', 'Naix Lifestealer', '2024-03-16 19:30:36', '2024-03-16 19:30:46'),
(11, 0, 'Student', 'John Neil', 'Aying', 'uclm-11', 'Pending', 'ayingneil11@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:27:30', NULL),
(12, 0, 'Student', 'John Neil', 'Aying', 'uclm-12', 'Pending', 'ayingneil12@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:24:10', NULL),
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'Active', '', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'Active', '', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'JOHN', 'A AYING', 'uclm-51', 'Active', 'ayingneil15@gmail.com', 'Male', 'Educ', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'JOHN', 'A AYING', 'uclm-69', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'Inactive', '', '', '', NULL, NULL, NULL),
(988, 0, 'Employee', 'Hh', 'Hv', 'uclm-988', 'Active', 'ayingneil15@gmhail.com', 'Male', 'Jhvc', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(1313, 0, 'Student', 'John Neil', 'Aying', 'uclm-1313', 'Pending', 'ayingneil13@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:21:59', NULL),
(2024, 0, 'Student', 'Jeneth', 'Escala', 'uclm-2024', 'Active', 'Jeneth15@gmail.com', 'Female', 'College of Teacher Education', 'Neil Aying', '2024-03-17 22:03:06', '2024-03-17 22:03:22'),
(6969, 0, 'Student', 'JOHN', 'A AYING', 'uclm-6969', 'Active', 'ayingneil2q15@gmail.com', 'Female', 'Educ', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
(19104629, 0, 'Dean', 'neil', 'aying', 'uclm-19104629', 'Active', '', '', '', NULL, NULL, NULL);

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
-- Indexes for table `tblreservereports`
--
ALTER TABLE `tblreservereports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblreturnreports`
--
ALTER TABLE `tblreturnreports`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `tblreservereports`
--
ALTER TABLE `tblreservereports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblreturnreports`
--
ALTER TABLE `tblreturnreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

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
