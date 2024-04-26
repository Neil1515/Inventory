-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 03:28 AM
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
(750, 120, 3, 3, NULL, 3, 51, 'Returned', NULL, '2024-04-17 15:59:50', '2024-04-17 16:01:35', '2024-04-17 15:00:00', NULL, '2024-04-17 16:00:09', NULL, NULL, '2024-04-20 13:19:41', NULL, 'sad', 'KV9V6QNT', 'No Issue', 'sad', 'sad'),
(751, 92, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-17 20:06:46', NULL, NULL, NULL, NULL, NULL, '2024-04-17 22:22:08', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(752, 93, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-17 20:07:50', NULL, NULL, NULL, NULL, NULL, '2024-04-17 22:22:11', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(753, 94, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-17 20:07:50', NULL, NULL, NULL, NULL, NULL, '2024-04-17 22:22:09', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(754, 106, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 21:38:41', NULL, NULL, NULL, NULL, NULL, '2024-04-17 22:21:37', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(755, 121, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 21:38:41', NULL, NULL, NULL, NULL, NULL, '2024-04-17 22:21:35', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(756, 75, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:22:27', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(757, 73, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:22:27', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(758, 85, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:22:27', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(759, 118, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:22:27', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(760, 79, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:22:27', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(761, 92, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:27:23', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(762, 93, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-17 22:27:23', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:06:55', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(763, 94, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-18 21:13:11', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:07:02', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(764, 98, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-18 21:13:11', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:07:02', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(765, 121, 3, 3, NULL, 3, 10, 'Returned', NULL, '2024-04-18 22:41:27', '2024-04-18 23:05:41', '2024-04-18 13:10:00', '2024-04-18 23:04:51', '2024-04-18 22:41:42', NULL, NULL, '2024-04-20 12:21:56', NULL, 'sad', 'YCJ6Z38Q', 'No Issue', 'sad', 'sad'),
(766, 101, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:07:35', NULL, '2024-04-19 22:00:00', '2024-04-19 20:36:14', '2024-04-18 23:07:54', NULL, NULL, NULL, NULL, NULL, '', NULL, 'awd', 'wad'),
(767, 75, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:07:35', NULL, '2024-04-19 22:00:00', '2024-04-19 20:36:14', '2024-04-18 23:07:54', NULL, NULL, NULL, NULL, NULL, '', NULL, 'awd', 'wad'),
(768, 73, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:07:35', NULL, '2024-04-19 22:00:00', '2024-04-19 20:36:14', '2024-04-18 23:07:54', NULL, NULL, NULL, NULL, NULL, '', NULL, 'awd', 'wad'),
(769, 85, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:07:35', NULL, '2024-04-19 22:00:00', '2024-04-19 20:36:14', '2024-04-18 23:07:54', NULL, NULL, NULL, NULL, NULL, '', NULL, 'awd', 'wad'),
(770, 121, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:07:35', NULL, '2024-04-19 22:00:00', '2024-04-19 20:36:14', '2024-04-18 23:07:54', NULL, NULL, NULL, NULL, NULL, '', NULL, 'awd', 'wad'),
(772, 118, 0, 3, NULL, NULL, 10, 'Expired Reservation', NULL, '2024-04-18 23:33:16', NULL, '2024-04-19 23:57:00', '2024-04-19 18:46:20', '2024-04-18 23:33:37', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(773, 106, 0, 3, NULL, NULL, 10, 'Expire Reservation', NULL, '2024-04-18 23:33:16', NULL, '2024-04-19 23:57:00', '2024-04-19 18:46:20', '2024-04-18 23:33:37', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(774, 111, 0, 3, NULL, NULL, 10, 'Expire Reservation', NULL, '2024-04-18 23:33:16', NULL, '2024-04-19 23:57:00', '2024-04-19 18:46:20', '2024-04-18 23:33:37', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(775, 92, 0, 3, NULL, NULL, 51, 'Expire Reservation', NULL, '2024-04-18 23:39:17', NULL, '2024-04-19 21:00:00', NULL, '2024-04-18 23:39:40', NULL, NULL, NULL, NULL, NULL, '', NULL, 'eyy', 'eyy'),
(776, 79, 0, 3, NULL, NULL, 51, 'Expire Reservation', NULL, '2024-04-18 23:39:17', NULL, '2024-04-19 21:00:00', NULL, '2024-04-18 23:39:40', NULL, NULL, NULL, NULL, NULL, '', NULL, 'eyy', 'eyy'),
(777, 93, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-19 18:19:29', NULL, '2024-04-19 19:41:00', NULL, NULL, '2024-04-20 13:18:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(778, 94, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-19 18:19:43', NULL, '2024-04-20 13:19:00', NULL, NULL, '2024-04-20 13:18:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(779, 98, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-20 11:35:56', NULL, '2024-04-20 11:36:34', NULL, NULL, NULL, NULL, NULL, '2024-04-20 12:21:56', NULL, 'sad', 'YCJ6Z38Q', 'No Issue', NULL, NULL),
(780, 100, 3, NULL, NULL, 3, 10, 'Returned', '2024-04-20 11:42:33', NULL, '2024-04-20 12:51:39', NULL, NULL, NULL, NULL, NULL, '2024-04-20 13:19:36', NULL, 'sad', 'Q3P57VYJ', 'No Issue', NULL, NULL),
(781, 112, 0, NULL, 3, NULL, 2024, 'Rejected', '2024-04-20 12:17:16', NULL, NULL, NULL, NULL, NULL, '2024-04-20 13:19:13', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(782, 98, 0, NULL, 3, NULL, 2024, 'Rejected', NULL, '2024-04-20 12:36:43', NULL, '2024-04-20 01:34:00', '2024-04-20 13:37:53', NULL, '2024-04-20 13:19:03', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(783, 120, 0, 3, NULL, NULL, 2024, 'Expired Reservation', NULL, '2024-04-20 13:25:41', NULL, '2024-04-20 01:00:00', '2024-04-20 13:30:16', '2024-04-20 13:26:56', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(784, 120, 0, 3, NULL, NULL, 2024, 'Expired Reservation', NULL, '2024-04-20 13:31:19', NULL, '2024-04-20 01:34:00', '2024-04-20 13:37:53', '2024-04-20 13:31:33', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(785, 120, 0, 3, NULL, NULL, 2024, 'Expired Reservation', NULL, '2024-04-20 13:38:19', NULL, '2024-04-20 05:39:00', '2024-04-20 13:40:01', '2024-04-20 13:38:30', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(786, 120, 0, 3, NULL, NULL, 2024, 'Expired Reservation', NULL, '2024-04-20 13:40:59', NULL, '2024-04-20 05:40:00', '2024-04-20 13:47:03', '2024-04-20 13:41:18', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(787, 120, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-20 19:47:03', NULL, '2024-04-20 20:40:00', NULL, NULL, '2024-04-20 20:15:45', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(788, 101, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-20 19:47:03', NULL, '2024-04-20 20:40:00', NULL, NULL, '2024-04-20 20:15:45', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(789, 75, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-20 19:47:03', NULL, '2024-04-20 20:40:00', NULL, NULL, '2024-04-20 20:15:45', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(790, 92, 0, NULL, 3, NULL, 51, 'Rejected', NULL, '2024-04-20 20:15:15', NULL, '2024-04-20 20:16:00', NULL, NULL, '2024-04-20 20:15:45', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(791, 120, 3, NULL, NULL, NULL, 988, 'Approved', '2024-04-20 21:35:14', NULL, '2024-04-20 21:49:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(792, 92, 3, NULL, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:37:48', '2024-04-20 21:55:03', '2024-04-20 23:37:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(793, 106, 0, 3, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:37:48', NULL, '2024-04-20 23:37:00', NULL, '2024-04-20 21:50:07', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(794, 121, 3, NULL, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:57:49', '2024-04-20 21:58:20', '2024-04-20 21:59:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(795, 122, 3, NULL, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:57:49', '2024-04-20 21:58:20', '2024-04-20 21:59:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(796, 93, 3, NULL, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:59:27', '2024-04-20 21:59:36', '2024-04-20 23:59:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(797, 94, 3, NULL, NULL, NULL, 988, 'Approve Reserve', NULL, '2024-04-20 21:59:27', '2024-04-20 21:59:36', '2024-04-20 23:59:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(798, 98, 0, NULL, 3, NULL, 988, 'Rejected', NULL, '2024-04-20 22:18:26', NULL, '2024-04-22 22:19:00', NULL, NULL, '2024-04-20 22:18:32', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(799, 75, 0, NULL, 3, NULL, 988, 'Rejected', NULL, '2024-04-20 22:18:26', NULL, '2024-04-22 22:19:00', NULL, NULL, '2024-04-20 22:18:32', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(800, 85, 0, NULL, 3, NULL, 988, 'Rejected', NULL, '2024-04-20 22:19:40', NULL, '2024-04-23 22:22:00', NULL, NULL, '2024-04-20 22:19:54', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad');

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
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
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
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Reserve', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Reserve', 'New', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Reserve', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(106, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Reserve', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(107, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(108, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(109, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(110, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(111, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', '', '2024-03-01'),
(112, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', 'Miss Gian PC', '2024-03-01'),
(113, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(114, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(115, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'Toshiba v1', 'Appliances', 'Stand Fan', 'Yes', '', '', 'NA', 0, 'Borrowed', 'Good', '2024-03-19 21:07:44', '', '2024-03-20'),
(121, 3, 'Naix Lifestealer', 'pldt', 'Ring Binder', 'Sample', 'Yes', '', '', 'no', 0, 'Reserve', 'Good', '2024-04-09 19:11:18', NULL, '2024-04-09'),
(122, 3, 'Naix Lifestealer', 'sad12ds', 'Ring Binder', 'Sample', 'Yes', '', '', 'NA', 0, 'Reserve', 'New', '2024-04-09 19:19:26', NULL, '2024-04-09');

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
(196, 'Ring Binder', 'Sample');

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
(3, 0, 'CCS Staff', 'Naix', 'Lifestealer', 'uclm-3', 'offline', 'Active', 'ayingneil3@gmail.com', '', '', NULL, NULL, NULL),
(8, 0, 'Employee', 'John Neil', 'Aying', 'uclm-8', 'offline', 'Pending', 'ayingneil8@gmail.com', 'Male', 'College of Hotel & Restaurant Management', NULL, '2024-03-16 19:41:34', NULL),
(9, 0, 'Student', 'John Neil', 'Aying', 'uclm-9', 'offline', 'Pending', 'ayingneil9@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-03-16 19:32:50', NULL),
(10, 0, 'Student', 'John Neil', 'Aying', 'uclm-10', 'offline', 'Active', 'ayingneil10@gmail.com', 'Male', 'Ambot', 'Naix Lifestealer', '2024-03-16 19:30:36', '2024-03-16 19:30:46'),
(11, 0, 'Student', 'John Neil', 'Aying', 'uclm-11', 'offline', 'Pending', 'ayingneil11@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:27:30', NULL),
(12, 0, 'Student', 'John Neil', 'Aying', 'uclm-12', 'offline', 'Pending', 'ayingneil12@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:24:10', NULL),
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'offline', 'Active', 'sad@sad.com', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'offline', 'Active', 'sad1@sad.com', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'Zues', 'Wrath', 'uclm-51', 'offline', 'Active', 'ayingneil15@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'John', 'Aying', 'uclm-69', 'offline', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(100, 0, 'Student', 'John Neil', 'Aying', 'Ayingneil100@gmail.com', 'offline', 'Pending', 'Ayingneil100@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-04-12 17:20:27', NULL),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'offline', 'Inactive', 'sad2@sad.com', '', '', NULL, NULL, NULL),
(988, 0, 'Employee', 'Jeneth', 'Escala', 'uclm-988', 'offline', 'Active', 'jen15@gmhail.com', 'Female', 'College of Hotel & Restaurant Management', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(1313, 0, 'Student', 'John Neil', 'Aying', 'uclm-1313', 'offline', 'Pending', 'ayingneil13@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:21:59', NULL),
(2024, 0, 'Student', 'Rogelyn', 'Aying', 'uclm-2024', 'offline', 'Active', 'glyn1@gmail.com', 'Female', 'College of Engineering', 'Neil Aying', '2024-03-17 22:03:06', '2024-03-17 22:03:22'),
(6969, 0, 'Student', 'Anthony', 'Augusto', 'uclm-6969', 'offline', 'Active', 'ayingant2q1@gmail.com', 'Male', 'College of Engineering', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
(11111, 0, 'CCS Staff', 'awd', 'awd', 'uclm-11111', 'offline', 'Active', 'ayingneil1010@gmail.com', '', '', NULL, NULL, NULL),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=801;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

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