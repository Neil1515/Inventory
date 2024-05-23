-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 08:05 PM
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
-- Table structure for table `tblborrowernotifreports`
--

CREATE TABLE `tblborrowernotifreports` (
  `id` int(11) NOT NULL,
  `reportid` int(11) NOT NULL,
  `borrowerid` int(11) NOT NULL,
  `datetimereqborrow` varchar(20) NOT NULL,
  `datetimereqreservation` varchar(20) NOT NULL,
  `datimeapproved` varchar(20) NOT NULL,
  `datetimereserve` varchar(20) NOT NULL,
  `updatereservation` varchar(20) NOT NULL,
  `datetimeapprovereserved` varchar(20) NOT NULL,
  `datimerejected` varchar(20) NOT NULL,
  `datetimecanceled` varchar(20) NOT NULL,
  `datetimereturn` varchar(20) NOT NULL,
  `datetimereqreturn` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1350, 144, 3, NULL, NULL, 3, 19104629, 'Returned', '2024-05-15 21:52:56', NULL, '2024-05-15 21:53:01', NULL, NULL, NULL, NULL, NULL, '2024-05-15 23:43:41', '2024-05-15 23:43:30', 'sad', 'BM4TENJF', 'Lost', NULL, NULL),
(1351, 87, 0, NULL, 3, NULL, 19104629, 'Rejected', '2024-05-15 23:00:53', NULL, NULL, NULL, NULL, NULL, '2024-05-15 23:02:19', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(1352, 88, 3, NULL, NULL, 3, 19104629, 'Returned', '2024-05-15 23:00:53', NULL, '2024-05-15 23:02:05', NULL, NULL, NULL, NULL, NULL, '2024-05-16 01:56:36', NULL, 'sad', 'XVPYIAW9', 'No Issue', NULL, NULL),
(1353, 87, 0, 3, NULL, NULL, 19104629, 'Canceled', NULL, '2024-05-15 23:08:19', NULL, '2024-05-15 23:14:00', '2024-05-15 23:09:10', '2024-05-15 23:08:30', NULL, '2024-05-15 23:09:48', NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(1354, 89, 0, 3, NULL, NULL, 19104629, 'Expired Reservation', NULL, '2024-05-15 23:08:19', NULL, '2024-05-15 23:14:00', '2024-05-15 23:09:10', '2024-05-15 23:08:30', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(1355, 83, 0, NULL, 3, NULL, 19104629, 'Rejected', NULL, '2024-05-15 23:10:22', NULL, '2024-05-15 23:15:00', NULL, NULL, '2024-05-15 23:10:35', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(1356, 83, 0, NULL, 3, NULL, 19104629, 'Rejected', '2024-05-15 23:38:36', NULL, NULL, NULL, NULL, NULL, '2024-05-15 23:41:05', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL);

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
  `remarks` varchar(50) DEFAULT NULL,
  `modelno` varchar(50) NOT NULL,
  `serialno` varchar(50) DEFAULT NULL,
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
(72, 3, 'Naix Lifestealer', 'Intel Pentium Dual E2140 160 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', 'SN-9356-VSND', 0, 'Standby', 'New', '2024-03-13 16:12:54', '', '2024-03-01'),
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memory', 'No', '', '', 'SN-1265-XNIZ', 0, 'Standby', 'New', '2024-03-13 16:13:50', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-6723-TFRE', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', 'OP-620D	', 'SN-2584-KGAC', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-4987-WOQY', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', 'SN-7156-LHEX', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-3984-JOHY', 0, 'Available', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-8402-QWPA', 0, 'Available', 'New', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'Yes', '', '', 'SN-7315-ULRV', 0, 'Available', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', 'SN-7084-HKWT', 0, 'Standby', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', 'SN-5739-BVOF', 0, 'Available', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', 'SN-3401-IUHM', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'Toshiba v1', 'Appliances', 'Stand Fan', 'Yes', '', '', 'SN-8356-AXYK', 0, 'Available', 'Good', '2024-03-19 21:07:44', '', '2024-03-20'),
(128, 3, 'Ms. Gian Mahusay', '500GB Storage', 'Computer Hardware and Projector', 'Hard Disk', 'No', '', '', 'SN-5073-MKCI', 100, 'Standby', 'New', '2024-04-29 18:17:08', '', '2024-04-29'),
(136, 3, 'Gian Mahusay', 'Converge ZTE Dual Band', 'Phones and Other Devices', 'Router', 'Yes', '', '', 'SN-1245-XFIZ', 400, 'Available', 'New', '2024-05-10 14:07:57', '', '2024-05-10'),
(137, 3, 'Gian Mahusay', 'Converge ZTE Dual Band', 'Phones and Other Devices', 'Router', 'Yes', '', '', 'SN-4225-XFIT', 400, 'Available', 'New', '2024-05-10 14:07:57', '', '2024-05-10'),
(138, 3, 'Gian Mahusay', 'Port Adapter', 'Phones and Other Devices', 'VGA to HDMI', 'Yes', '', '', 'SN-4278-SADN', 0, 'Available', 'New', '2024-05-10 14:14:19', '', '2024-05-10'),
(139, 3, 'Gian Mahusay', 'Port Adapter', 'Phones and Other Devices', 'VGA to HDMI', 'Yes', '', '', 'SN-1928-SADE', 0, 'Available', 'New', '2024-05-10 14:14:19', '', '2024-05-10'),
(140, 3, 'Gian Mahusay', 'A4tech', 'Phones and Other Devices', 'Webcam', 'Yes', '', '', 'SN-2019-SADS	', 500, 'Available', 'New', '2024-05-10 14:17:24', '', '2024-05-10'),
(141, 3, 'Gian Mahusay', 'A4tech', 'Phones and Other Devices', 'Webcam', 'Yes', '', 'PKS-810G', 'SN-2020-AYIN', 500, 'Available', 'New', '2024-05-10 14:17:24', '', '2024-05-10'),
(142, 3, 'Gian Mahusay', 'Logitech Stereo', 'Phones and Other Devices', 'Speaker', 'Yes', '', '', 'SN-4123-DVSW', 0, 'Available', 'New', '2024-05-10 14:18:59', '', '2024-05-10'),
(143, 3, 'Gian Mahusay', 'Mini Display Port', 'Phones and Other Devices', 'VGA', 'Yes', '', '', 'SN-4675-XBIN', 0, 'Available', 'New', '2024-05-10 14:20:50', '', '2024-05-10'),
(144, 3, 'Gian Mahusay', 'Super Vision Gaming Monitor HD 1080p 165HZ', 'Computer Hardware and Projector', 'Monitor', 'Yes', '', '', 'SN-7232-SQAA', 0, 'Available', 'New', '2024-05-10 18:52:16', '', '2024-05-10'),
(145, 3, 'Gian Mahusay', 'Epson', 'Appliances', 'Stand Fan', 'Yes', '', '', 'SN-8456-EPSL', 0, 'Available', 'New', '2024-05-10 23:25:15', '', '2024-05-10'),
(146, 3, 'Gian Mahusay', 'Epson', 'Appliances', 'Stand Fan', 'No', '', '', 'SN-8231-XADD', 0, 'Standby', 'New', '2024-05-10 23:25:15', '', '2024-05-10');

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
(191, 'Office Supplies and Equipment'),
(195, 'Appliances');

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
(250, 3, 'awww', '2024-05-15 16:56:01', 'unread'),
(251, 3, 'sad', '2024-05-15 16:56:06', 'unread');

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
(590, 250, 19104629, 'read'),
(591, 251, 19104629, 'read');

-- --------------------------------------------------------

--
-- Table structure for table `tblpendingitemremoval`
--

CREATE TABLE `tblpendingitemremoval` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetimereq` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreportborroweracc`
--

CREATE TABLE `tblreportborroweracc` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `borrowerid` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetimereported` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(135, 'Computer Hardware and Projector', 'Memory'),
(143, 'Appliances', 'Stand Fan'),
(145, 'Computer Hardware and Projector', 'Mouse'),
(151, 'Computer Hardware and Projector', 'Hard Disk'),
(152, 'Computer Hardware and Projector', 'Monitor'),
(153, 'Computer Hardware and Projector', 'Sound Card'),
(154, 'Computer Hardware and Projector', 'Operating System'),
(155, 'Computer Hardware and Projector', 'AVR'),
(156, 'Computer Hardware and Projector', 'Flash Drive'),
(157, 'Computer Hardware and Projector', 'MS Office'),
(159, 'Computer Hardware and Projector', 'Router'),
(163, 'Computer Hardware and Projector', 'Keyboard'),
(164, 'Computer Hardware and Projector', 'Video Card'),
(168, 'Computer Hardware and Projector', 'Projector'),
(206, 'Phones and Other Devices', 'VGA'),
(207, 'Phones and Other Devices', 'Speaker'),
(208, 'Phones and Other Devices', 'Webcam'),
(209, 'Phones and Other Devices', 'Laptop'),
(210, 'Phones and Other Devices', 'Printer'),
(211, 'Office Supplies and Equipment', 'Typewriter'),
(212, 'Phones and Other Devices', 'Router'),
(213, 'Phones and Other Devices', 'VGA to HDMI');

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
(2, 0, 'Dean', 'Aurora', 'Miro', 'uclm-2', 'offline', 'Active', 'Miro2@gmail.com', '', '', NULL, NULL, NULL),
(3, 0, 'CCS Staff', 'Gian', 'Mahusay', 'uclm-3', 'offline', 'Active', 'Mahusay3@gmail.com', 'Female', '', NULL, NULL, NULL),
(15, 15, 'Admin', 'John', 'Neil', 'admin', 'offline', 'Active', 'admin@gmail.com', '', '', NULL, NULL, NULL),
(69, 0, 'Student', 'Sample', 'Sample', 'Ayingneil100', 'offline', 'Pending', 'ayingneil2215@gmail.com', 'Female', 'Sample', NULL, '2024-05-15 23:36:05', NULL),
(19104629, 0, 'Student', 'John Neil', 'Aying', 'Uclm-19104629', 'online', 'Active', 'ayingneil15@gmail.com', 'Male', 'College of Computer Studies', 'Gian Mahusay', '2024-05-11 06:20:55', '2024-05-15 20:29:24'),
(19116243, 15, 'Student', 'John Wilson', 'Solamo', 'uclm-19116243', 'offline', 'Active', 'johnwilson@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-05-10 08:19:42', '2024-05-10 08:19:42'),
(20169219, 0, 'Student', 'Lance Carvin', 'Tinapay', 'Uclm-20169219', 'offline', 'Active', 'tinapaylance@gmail.com', 'Male', 'College of Computer Studies', 'Gian Mahusay', '2024-05-10 14:39:55', '2024-05-10 14:40:20'),
(20169225, 0, 'Student', 'James Rovic', 'Amistoso', 'Uclm-20169225', 'offline', 'Active', 'Rovic.amistoso@gmail.com', 'Male', 'College of Computer Studies', 'Gian Mahusay', '2024-05-10 14:38:32', '2024-05-10 14:40:18'),
(20175114, 0, 'Student', 'John Victor', 'Ong', 'Uclm-20175114', 'offline', 'Active', 'jvkoong@gmail.com', 'Male', 'College of Computer Studies', 'Gian Mahusay', '2024-05-10 14:30:36', '2024-05-10 14:31:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblborrowernotifreports`
--
ALTER TABLE `tblborrowernotifreports`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tblpendingitemremoval`
--
ALTER TABLE `tblpendingitemremoval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblreportborroweracc`
--
ALTER TABLE `tblreportborroweracc`
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
-- AUTO_INCREMENT for table `tblborrowernotifreports`
--
ALTER TABLE `tblborrowernotifreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblborrowingreports`
--
ALTER TABLE `tblborrowingreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1357;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=592;

--
-- AUTO_INCREMENT for table `tblpendingitemremoval`
--
ALTER TABLE `tblpendingitemremoval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblreportborroweracc`
--
ALTER TABLE `tblreportborroweracc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

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
