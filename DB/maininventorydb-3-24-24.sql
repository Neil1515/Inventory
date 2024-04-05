-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 01:28 AM
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
  `approvereturnbyid` datetime DEFAULT NULL,
  `borrowerid` int(11) NOT NULL,
  `itemreqstatus` varchar(20) NOT NULL,
  `datetimereqborrow` datetime NOT NULL,
  `datimeapproved` datetime DEFAULT NULL,
  `datimerejected` datetime DEFAULT NULL,
  `datimereturn` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `datetimeadded` datetime NOT NULL,
  `assignfor` varchar(50) DEFAULT NULL,
  `datepurchased` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblitembrand`
--

INSERT INTO `tblitembrand` (`id`, `staffid`, `staffname`, `itembrand`, `categoryname`, `subcategoryname`, `borrowable`, `remarks`, `modelno`, `serialno`, `unitcost`, `status`, `datetimeadded`, `assignfor`, `datepurchased`) VALUES
(72, 3, 'Naix Lifestealer', 'Intel Pentium Dual E2140 160 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', '', 0, 'Available', '2024-03-13 16:12:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'No', '', '', '', 0, 'Available', '2024-03-13 16:13:50', 'MS. Aurora Miro Desk', '2024-03-01'),
(74, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'No', '', '', '', 0, 'Available', '2024-03-13 16:13:50', 'For Faculty 1', '2024-03-01'),
(75, 3, 'Naix Lifestealer', '80 GB SATA', 'Computer Hardware and Projector', 'Hard Disk', 'No', '', '', '', 0, 'Available', '2024-03-13 16:14:31', 'MS. Aurora Miro Desk', '2024-03-01'),
(76, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:16:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(77, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:16:56', '', '2024-03-01'),
(78, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:16:56', '', '2024-03-01'),
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(80, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:17:56', '', '2024-03-01'),
(81, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:17:56', '', '2024-03-01'),
(82, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', '2024-03-13 16:17:56', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', 'OP-620D	', '', 0, 'Available', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', '2024-03-13 16:19:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', '2024-03-13 16:19:54', '', '2024-03-01'),
(90, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', '2024-03-13 16:21:40', 'MS. Aurora Miro Desk', '2024-03-01'),
(91, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', '2024-03-13 16:24:15', 'MS. Aurora Miro Desk', '2024-03-01'),
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', '2024-03-13 16:53:48', '', '2024-03-01'),
(106, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(107, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(108, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(109, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(110, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(111, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(112, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(113, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(114, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(115, 3, 'Naix Lifestealer', 'Long Box w/o cover color blue', 'Filing Box', 'Filing Box Long', 'No', '', '', '', 0, 'Available', '2024-03-13 21:18:16', NULL, '2024-03-01'),
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', '', 0, 'Available', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'No', '', '', '', 0, 'Available', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01');

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
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'Active', '', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'Active', '', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'JOHN', 'A AYING', 'uclm-51', 'Active', 'ayingneil15@gmail.com', 'Male', 'Educ', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'JOHN', 'A AYING', 'uclm-69', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(111, 0, 'Student', 'Carl Anthont', 'Aying', 'uclm-111', 'Active', 'anthonyaying1234@gmail.com', 'Male', 'BSEE', 'Naix Lifestealer', '2024-03-09 13:16:18', '2024-03-09 13:17:09'),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'Inactive', '', '', '', NULL, NULL, NULL),
(231, 0, 'CCS Staff', 'Jeneth', 'Escala', 'uclm-231', 'Inactive', '', '', '', NULL, NULL, NULL),
(988, 0, 'Employee', 'Hh', 'Hv', 'uclm-988', 'Active', 'ayingneil15@gmhail.com', 'Male', 'Jhvc', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(6969, 0, 'Student', 'JOHN', 'A AYING', 'uclm-6969', 'Active', 'ayingneil2q15@gmail.com', 'Female', 'Educ', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
(213123, 0, 'CCS Staff', 'awdawd', 'awdawd', 'uclm-213123', 'Active', '', '', '', NULL, NULL, NULL),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
