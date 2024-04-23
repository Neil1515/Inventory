-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 04:27 PM
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
  `rejectedbyid` int(11) NOT NULL,
  `approvereturnbyid` int(11) DEFAULT NULL,
  `borrowerid` int(11) NOT NULL,
  `itemreqstatus` varchar(20) NOT NULL,
  `datetimereqborrow` datetime NOT NULL,
  `datetimereqreservation` datetime NOT NULL,
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
(641, 120, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 14:19:57', '0000-00-00 00:00:00', '2024-04-07 11:04:16', '2024-04-07 14:21:00', NULL, '2024-04-07 08:20:11', NULL, NULL, '2024-04-07 17:04:24', NULL, '+', '3WR540EL', 'No Issue', 'sadss', 'sad'),
(642, 92, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 14:19:57', '0000-00-00 00:00:00', '2024-04-07 11:04:16', '2024-04-07 14:21:00', NULL, '2024-04-07 08:20:11', NULL, NULL, '2024-04-07 17:04:24', NULL, '+', '3WR540EL', 'No Issue', 'sadss', 'sad'),
(643, 93, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 14:24:23', '0000-00-00 00:00:00', NULL, '2024-04-08 14:26:00', NULL, '2024-04-07 08:24:35', '2024-04-07 17:16:36', NULL, NULL, NULL, NULL, '', NULL, 'sadasd', 'asd'),
(644, 120, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 17:04:49', '0000-00-00 00:00:00', '2024-04-07 11:16:43', '2024-04-07 20:04:00', NULL, '2024-04-07 11:05:06', NULL, NULL, '2024-04-07 17:16:59', NULL, 'awdawds', '8UCVBH29', 'No Issue', 'awd', 'awd'),
(645, 92, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 17:04:49', '0000-00-00 00:00:00', '2024-04-07 11:16:43', '2024-04-07 20:04:00', NULL, '2024-04-07 11:05:06', NULL, NULL, '2024-04-07 17:16:59', NULL, 'awdawds', '8UCVBH29', 'No Issue', 'awd', 'awd'),
(646, 120, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 17:17:18', '0000-00-00 00:00:00', NULL, '2024-04-08 20:20:00', NULL, '2024-04-07 11:17:38', '2024-04-07 18:06:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(647, 85, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 17:17:18', '0000-00-00 00:00:00', NULL, '2024-04-08 20:20:00', NULL, '2024-04-07 11:17:38', '2024-04-07 18:06:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(648, 106, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 17:17:18', '0000-00-00 00:00:00', NULL, '2024-04-08 20:20:00', NULL, '2024-04-07 11:17:38', '2024-04-07 18:06:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(649, 92, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 17:19:02', '0000-00-00 00:00:00', NULL, '2024-04-08 20:20:00', NULL, '2024-04-07 11:19:09', '2024-04-07 18:06:55', NULL, NULL, NULL, NULL, '', NULL, 'awd', 'awd'),
(650, 93, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 18:00:21', '0000-00-00 00:00:00', '2024-04-07 12:06:47', '2024-04-07 18:00:00', NULL, '2024-04-07 12:00:28', NULL, NULL, '2024-04-07 18:26:12', NULL, 'sad', '840OKPAN', 'No Issue', 'sad', 'sad'),
(651, 94, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 18:00:21', '0000-00-00 00:00:00', NULL, '2024-04-07 18:00:00', NULL, '2024-04-07 12:00:28', '2024-04-07 18:06:55', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(652, 120, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-07 18:07:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-07 18:10:52', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(653, 98, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-07 18:07:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-07 18:10:52', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(654, 100, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-07 18:07:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-07 18:10:52', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(655, 92, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 18:07:44', '0000-00-00 00:00:00', NULL, '2024-04-07 20:07:00', NULL, '2024-04-07 12:07:51', '2024-04-07 18:11:04', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'dawdawd'),
(656, 94, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-07 18:07:44', '0000-00-00 00:00:00', NULL, '2024-04-07 20:07:00', NULL, '2024-04-07 12:07:51', '2024-04-07 18:11:04', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'dawdawd'),
(657, 120, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 18:21:05', '0000-00-00 00:00:00', '2024-04-07 12:23:06', '2024-04-07 17:21:00', NULL, '2024-04-07 12:21:14', NULL, NULL, '2024-04-07 18:26:12', NULL, 'sad', '840OKPAN', 'No Issue', '9', '6'),
(658, 120, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 19:04:48', '0000-00-00 00:00:00', '2024-04-09 08:51:49', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-07 13:04:59', NULL, NULL, '2024-04-12 21:05:36', NULL, 'sad', 'HUMPBKPT', 'No Issue', 'sad', 'sad'),
(659, 92, 3, 3, 0, 3, 51, 'Returned', '2024-04-07 19:04:48', '0000-00-00 00:00:00', '2024-04-09 08:51:49', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-07 13:04:59', NULL, NULL, '2024-04-12 21:05:36', NULL, 'sad', 'HUMPBKPT', 'No Issue', 'sad', 'sad'),
(660, 93, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 09:31:36', '0000-00-00 00:00:00', '2024-04-08 08:00:25', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-08 03:32:18', NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 14:00:43', 'sad', '2XH98AS0', 'No Issue', 'sasdasd', 'asadasd'),
(661, 94, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 09:31:36', '0000-00-00 00:00:00', '2024-04-08 08:00:25', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-08 03:32:18', NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 14:15:41', 'sad', '2XH98AS0', 'No Issue', 'sasdasd', 'asadasd'),
(662, 98, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 09:33:17', '0000-00-00 00:00:00', '2024-04-08 08:00:25', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-08 03:33:33', NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 14:15:39', 'sad', '2XH98AS0', 'No Issue', 'sad', 'sad'),
(663, 100, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 09:33:17', '0000-00-00 00:00:00', '2024-04-08 08:00:25', '2024-04-09 00:00:00', '2024-04-09 14:51:40', '2024-04-08 03:33:33', NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 14:06:04', 'sad', '2XH98AS0', 'No Issue', 'sad', 'sad'),
(664, 101, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 10:02:27', '0000-00-00 00:00:00', '2024-04-08 10:02:43', NULL, NULL, NULL, NULL, NULL, '2024-04-08 13:26:49', NULL, 'sad', 'O6LA4934', 'No Issue', NULL, NULL),
(665, 116, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 10:02:27', '0000-00-00 00:00:00', '2024-04-08 10:02:43', NULL, NULL, NULL, NULL, NULL, '2024-04-08 13:26:49', NULL, 'sad', 'O6LA4934', 'No Issue', NULL, NULL),
(666, 75, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 10:06:32', '0000-00-00 00:00:00', '2024-04-08 13:34:13', NULL, NULL, NULL, NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 13:34:24', 'sad', '2XH98AS0', 'No Issue', NULL, NULL),
(667, 73, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 10:06:32', '0000-00-00 00:00:00', '2024-04-08 13:34:13', NULL, NULL, NULL, NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 13:38:33', 'sad', '2XH98AS0', 'No Issue', NULL, NULL),
(668, 85, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 10:18:15', '0000-00-00 00:00:00', '2024-04-08 08:13:08', '2024-04-08 10:18:00', '2024-04-08 14:13:06', '2024-04-08 08:12:38', NULL, NULL, '2024-04-08 14:19:23', '2024-04-08 14:15:43', 'sad', '2XH98AS0', 'No Issue', 'sad', 'sad'),
(671, 93, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 14:19:39', '0000-00-00 00:00:00', '2024-04-08 14:19:45', NULL, NULL, NULL, NULL, NULL, '2024-04-09 14:41:13', '2024-04-08 22:08:35', 'sad', 'RY8TQUJF', 'No Issue', NULL, NULL),
(672, 94, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 14:19:39', '0000-00-00 00:00:00', '2024-04-08 14:19:45', NULL, NULL, NULL, NULL, NULL, '2024-04-09 14:41:13', NULL, 'sad', 'RY8TQUJF', 'No Issue', NULL, NULL),
(673, 101, 3, NULL, 0, 3, 69, 'Returned', '2024-04-08 14:19:39', '0000-00-00 00:00:00', '2024-04-08 14:19:45', NULL, NULL, NULL, NULL, NULL, '2024-04-09 14:41:13', NULL, 'sad', 'RY8TQUJF', 'No Issue', NULL, NULL),
(674, 98, 0, 3, 0, NULL, 69, 'Canceled', '2024-04-08 15:08:49', '0000-00-00 00:00:00', NULL, '2024-04-29 15:09:00', NULL, '2024-04-09 06:16:35', NULL, '2024-04-14 11:08:22', NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(675, 100, 3, 3, 0, 3, 69, 'Returned', '2024-04-08 22:11:11', '0000-00-00 00:00:00', '2024-04-09 08:51:26', '2024-04-09 22:12:00', NULL, '2024-04-09 06:16:35', NULL, NULL, '2024-04-14 11:07:38', '2024-04-14 11:07:22', 'sad', 'ZDQ1937N', 'No Issue', 'sad', 'sad'),
(676, 116, 0, NULL, 3, NULL, 69, 'Rejected', '2024-04-08 22:11:11', '0000-00-00 00:00:00', NULL, '2024-04-09 22:12:00', NULL, NULL, '2024-04-09 14:51:02', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(677, 118, 0, NULL, 0, NULL, 69, 'Canceled', '2024-04-08 22:15:38', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '2024-04-08 22:16:09', NULL, NULL, NULL, '', NULL, NULL, NULL),
(678, 75, 0, NULL, 0, NULL, 51, 'Canceled', '2024-04-09 12:28:19', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '2024-04-12 20:33:43', NULL, NULL, NULL, '', NULL, NULL, NULL),
(679, 73, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-09 12:28:19', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-09 21:45:00', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(680, 121, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-09 19:26:48', '0000-00-00 00:00:00', NULL, '2024-04-10 19:28:00', NULL, NULL, '2024-04-09 19:27:10', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'awd'),
(681, 93, 3, 3, 0, 3, 51, 'Returned', '2024-04-12 15:02:36', '0000-00-00 00:00:00', '2024-04-13 06:23:03', '2024-04-13 17:02:00', '2024-04-13 12:22:13', '2024-04-13 06:22:50', NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', 'sad', 'sad'),
(682, 94, 0, 3, 3, NULL, 51, 'Rejected', '2024-04-12 15:02:36', '0000-00-00 00:00:00', NULL, '2024-04-13 17:02:00', '2024-04-13 12:22:13', '2024-04-13 06:21:45', '2024-04-13 12:22:22', NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(683, 121, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 20:34:11', '0000-00-00 00:00:00', '2024-04-12 21:25:51', NULL, NULL, NULL, NULL, NULL, '2024-04-12 21:26:00', NULL, 'ok', 'AC55X4MW', 'No Issue', NULL, NULL),
(684, 120, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 21:05:44', '0000-00-00 00:00:00', '2024-04-12 21:25:51', NULL, NULL, NULL, NULL, NULL, '2024-04-12 21:26:00', NULL, 'ok', 'AC55X4MW', 'No Issue', NULL, NULL),
(685, 116, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 21:18:53', '0000-00-00 00:00:00', '2024-04-12 21:25:51', NULL, NULL, NULL, NULL, NULL, '2024-04-12 21:26:00', NULL, 'ok', 'AC55X4MW', 'No Issue', NULL, NULL),
(686, 120, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:26:14', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(687, 116, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:32:04', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(688, 92, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:35:48', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(689, 93, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:35:48', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(690, 98, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:35:48', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(691, 101, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:35:48', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(692, 75, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:39:16', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(693, 73, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:39:16', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(694, 85, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:39:49', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(695, 118, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:40:11', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(696, 79, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 21:40:26', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(697, 106, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:05:12', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(698, 111, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:05:12', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(699, 112, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:05:12', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(700, 121, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:05:12', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(701, 122, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:05:12', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:06:33', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(702, 121, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:06:50', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:35:04', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(703, 122, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:06:50', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:35:04', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(704, 120, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:07:15', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:35:04', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(705, 92, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:33:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:35:04', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(706, 85, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-12 23:33:32', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-12 23:35:04', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(707, 92, 0, NULL, 0, NULL, 51, 'Canceled', '2024-04-12 23:38:44', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '2024-04-13 09:55:38', NULL, NULL, NULL, '', NULL, NULL, NULL),
(708, 93, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 23:38:44', '0000-00-00 00:00:00', '2024-04-13 11:07:03', NULL, NULL, NULL, NULL, NULL, '2024-04-13 20:33:43', '2024-04-13 12:13:39', 'sad', '5WX4TKFK', 'No Issue', NULL, NULL),
(709, 94, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 23:43:14', '0000-00-00 00:00:00', '2024-04-13 11:07:03', NULL, NULL, NULL, NULL, NULL, '2024-04-13 20:33:43', '2024-04-13 12:18:12', 'sad', '5WX4TKFK', 'No Issue', NULL, NULL),
(710, 98, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 23:43:14', '0000-00-00 00:00:00', '2024-04-13 11:07:03', NULL, NULL, NULL, NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', NULL, NULL),
(711, 100, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 23:43:14', '0000-00-00 00:00:00', '2024-04-13 11:07:03', NULL, NULL, NULL, NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', NULL, NULL),
(712, 101, 3, NULL, 0, 3, 51, 'Returned', '2024-04-12 23:43:14', '0000-00-00 00:00:00', '2024-04-13 11:07:03', NULL, NULL, NULL, NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', NULL, NULL),
(713, 121, 3, 3, 0, 3, 51, 'Returned', '2024-04-13 09:54:26', '0000-00-00 00:00:00', '2024-04-13 06:23:40', '2024-04-13 09:56:00', '2024-04-13 12:23:35', '2024-04-13 06:21:45', NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', 'sad', 'sad'),
(714, 122, 3, 3, 0, 3, 51, 'Returned', '2024-04-13 09:54:26', '0000-00-00 00:00:00', '2024-04-13 08:22:23', '2024-04-13 09:56:00', '2024-04-13 12:23:35', '2024-04-13 06:22:50', NULL, NULL, '2024-04-13 20:33:43', NULL, 'sad', '5WX4TKFK', 'No Issue', 'sad', 'sad'),
(715, 92, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-13 12:44:21', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-14 11:07:58', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(716, 94, 0, NULL, 3, NULL, 51, 'Rejected', '2024-04-13 12:44:21', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-14 11:07:58', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(717, 120, 0, NULL, 0, NULL, 51, 'Canceled', '2024-04-13 13:39:20', '0000-00-00 00:00:00', NULL, '2024-04-17 13:41:00', NULL, NULL, NULL, '2024-04-13 13:41:43', NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(718, 120, 0, NULL, 0, NULL, 51, 'Canceled', '2024-04-13 13:42:55', '0000-00-00 00:00:00', NULL, '2024-04-15 13:44:00', NULL, NULL, NULL, '2024-04-13 13:43:05', NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(719, 120, 0, 3, 0, NULL, 51, 'Canceled', '2024-04-13 13:57:05', '0000-00-00 00:00:00', NULL, '2024-04-23 13:00:00', NULL, '2024-04-13 07:57:32', NULL, '2024-04-13 13:58:01', NULL, NULL, NULL, '', NULL, 'ssad', 'sad'),
(720, 120, 0, 3, 0, NULL, 69, 'Approve Reserve', '2024-04-14 11:09:03', '0000-00-00 00:00:00', NULL, '2024-04-14 11:11:00', '2024-04-14 20:22:40', '2024-04-14 05:20:11', NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(721, 121, 3, NULL, 0, NULL, 69, 'Approved', '2024-04-14 11:25:45', '0000-00-00 00:00:00', '2024-04-14 11:26:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(722, 75, 0, NULL, 0, NULL, 69, 'Pending Borrow', '2024-04-14 11:34:18', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(723, 92, 0, NULL, 0, NULL, 69, 'Pending Borrow', '2024-04-14 12:32:46', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(724, 93, 0, NULL, 0, NULL, 69, 'Pending Borrow', '2024-04-14 12:32:46', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(725, 94, 0, NULL, 0, NULL, 988, 'Canceled', '2024-04-14 13:40:20', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, '2024-04-14 13:40:44', NULL, NULL, NULL, '', NULL, NULL, NULL),
(726, 94, 0, NULL, 0, NULL, 988, 'Pending Borrow', '2024-04-14 13:44:09', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(727, 98, 0, NULL, 0, NULL, 10, 'Pending Borrow', '2024-04-14 14:16:06', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(728, 100, 0, NULL, 0, NULL, 10, 'Pending Borrow', '2024-04-14 14:21:26', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(729, 101, 0, NULL, 0, NULL, 10, 'Pending Borrow', '2024-04-14 14:21:26', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(730, 73, 0, NULL, 0, NULL, 10, 'Canceled', '2024-04-14 14:21:53', '0000-00-00 00:00:00', NULL, '2024-04-17 14:23:00', NULL, NULL, NULL, '2024-04-14 14:53:12', NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(731, 85, 0, NULL, 0, NULL, 10, 'Canceled', '2024-04-14 14:23:52', '0000-00-00 00:00:00', NULL, '2024-04-28 14:01:00', NULL, NULL, NULL, '2024-04-14 14:53:08', NULL, NULL, NULL, '', NULL, 'sad', 'sasd'),
(732, 122, 0, NULL, 3, NULL, 10, 'Rejected', '2024-04-14 14:43:01', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, '2024-04-14 15:32:21', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL),
(734, 73, 0, NULL, 0, NULL, 10, 'Pending Reserve', '0000-00-00 00:00:00', '2024-04-14 14:53:38', NULL, '2024-04-24 14:55:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad'),
(735, 85, 0, NULL, 0, NULL, 10, 'Pending Reserve', '0000-00-00 00:00:00', '2024-04-14 15:04:28', NULL, '2024-04-14 17:04:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'sad', 'sad');

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
(73, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'Yes', '', '', '', 0, 'Pending Reserve', 'New', '2024-03-13 16:13:50', 'MS. Aurora Miro Desk', '2024-03-01'),
(74, 3, 'Naix Lifestealer', '1 GB Kingston', 'Computer Hardware and Projector', 'Memmory', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:13:50', 'For Faculty 1', '2024-03-01'),
(75, 3, 'Naix Lifestealer', '80 GB SATA', 'Computer Hardware and Projector', 'Hard Disk', 'Yes', '', '', '', 0, 'Pending Borrow', 'New', '2024-03-13 16:14:31', 'MS. Aurora Miro Desk', '2024-03-01'),
(76, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(77, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(78, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Video Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:16:56', '', '2024-03-01'),
(79, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', 'MS. Aurora Miro Desk', '2024-03-01'),
(80, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(81, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(82, 3, 'Naix Lifestealer', 'attached', 'Computer Hardware and Projector', 'Sound Card', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:17:56', '', '2024-03-01'),
(83, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(84, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', 'OP-620D	', '', 0, 'Available', 'New', '2024-03-13 16:18:45', 'MS. Aurora Miro Desk', '2024-03-01'),
(85, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'Yes', '', '', '', 0, 'Pending Reserve', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(86, 3, 'Naix Lifestealer', 'Logitech', 'Computer Hardware and Projector', 'Mouse', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:18:45', '', '2024-03-01'),
(87, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', 'MS. Aurora Miro Desk', '2024-03-01'),
(88, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', 'For Faculty 1', '2024-03-01'),
(89, 3, 'Naix Lifestealer', 'A4-Tech', 'Computer Hardware and Projector', 'Keyboard', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 16:19:54', '', '2024-03-01'),
(90, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:21:40', 'MS. Aurora Miro Desk', '2024-03-01'),
(91, 3, 'Naix Lifestealer', 'MS Office Pro Plus 2013 Sngl Acad', 'Computer Hardware and Projector', 'MS Office', 'No', '', '', '', 3600, 'Available', 'New', '2024-03-13 16:24:15', 'MS. Aurora Miro Desk', '2024-03-01'),
(92, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(93, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '      ', '2024-03-01'),
(94, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(95, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(96, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(97, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(98, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(99, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'No', '', '', '', 32, 'Available', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(100, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
(101, 3, 'Naix Lifestealer', 'Color Blue/Long', 'Clearbook', 'Seagull Clearbook', 'Yes', '', '', '', 32, 'Pending Borrow', 'New', '2024-03-13 16:53:48', '', '2024-03-01'),
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
(116, 3, 'Naix Lifestealer', 'Intel Core Duo E7400 2.80 Ghz', 'Computer Hardware and Projector', 'CPU', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:25:01', 'For Faculty 1', '2024-03-01'),
(117, 3, 'Naix Lifestealer', 'Samsung', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:27:31', 'For Faculty 1', '2024-03-01'),
(118, 3, 'Naix Lifestealer', 'Windows XP Professional', 'Computer Hardware and Projector', 'Operating System', 'Yes', '', '', '', 0, 'Available', 'New', '2024-03-13 21:32:34', 'For Faculty 1', '2024-03-01'),
(119, 3, 'Naix Lifestealer', 'Samsung Syncmaster', 'Computer Hardware and Projector', 'Monitor', 'No', '', '', '', 0, 'Available', 'New', '2024-03-13 21:36:58', 'Miss Gian PC', '2024-03-01'),
(120, 3, 'Naix Lifestealer', 'Toshiba v1', 'Appliances', 'Stand Fan', 'Yes', '', '', 'NA', 0, 'Reserve', 'Good', '2024-03-19 21:07:44', '', '2024-03-20'),
(121, 3, 'Naix Lifestealer', 'pldt', 'Ring Binder', 'Clocks', 'Yes', '', '', 'no', 0, 'Borrowed', 'Good', '2024-04-09 19:11:18', NULL, '2024-04-09'),
(122, 3, 'Naix Lifestealer', 'sad12ds', 'Ring Binder', 'Clocks', 'Yes', '', '', 'NA', 0, 'Available', 'New', '2024-04-09 19:19:26', NULL, '2024-04-09');

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
(173, 10, 'Eyy', '2024-04-14 06:18:12', 'unread');

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
(458, 173, 17, 'unread');

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
(179, 'Filing Box', 'Filing Box Long'),
(196, 'Ring Binder', 'Clocks');

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
(3, 0, 'CCS Staff', 'Naix', 'Lifestealer', 'uclm-3', 'Active', 'ayingneil3@gmail.com', '', '', NULL, NULL, NULL),
(8, 0, 'Employee', 'John Neil', 'Aying', 'uclm-8', 'Pending', 'ayingneil8@gmail.com', 'Male', 'College of Hotel & Restaurant Management', NULL, '2024-03-16 19:41:34', NULL),
(9, 0, 'Student', 'John Neil', 'Aying', 'uclm-9', 'Pending', 'ayingneil9@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-03-16 19:32:50', NULL),
(10, 0, 'Employee', 'John Neil', 'Aying', 'uclm-10', 'Active', 'ayingneil10@gmail.com', 'Male', 'Ambot', 'Naix Lifestealer', '2024-03-16 19:30:36', '2024-03-16 19:30:46'),
(11, 0, 'Student', 'John Neil', 'Aying', 'uclm-11', 'Pending', 'ayingneil11@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:27:30', NULL),
(12, 0, 'Student', 'John Neil', 'Aying', 'uclm-12', 'Pending', 'ayingneil12@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:24:10', NULL),
(15, 0, 'CCS Staff', 'Neil', 'Aying', 'uclm-15', 'Active', '', '', '', NULL, NULL, NULL),
(17, 0, 'CCS Staff', 'sad', 'sad', 'uclm-17', 'Active', '', '', '', NULL, NULL, NULL),
(51, 0, 'Student', 'JOHN', 'A AYING', 'uclm-51', 'Active', 'ayingneil15@gmail.com', 'Male', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-08 20:20:05', '2024-03-09 09:43:05'),
(69, 0, 'Student', 'John', 'Aying', 'uclm-69', 'Active', 'ayingneil5@gmail.com', 'Male', 'Ibobax', 'Naix Lifestealer', '2024-03-08 22:13:22', '2024-03-09 09:56:54'),
(100, 0, 'Student', 'John Neil', 'Aying', 'Ayingneil100@gmail.com', 'Pending', 'Ayingneil100@gmail.com', 'Male', 'College of Computer Studies', NULL, '2024-04-12 17:20:27', NULL),
(123, 0, 'Dean', 'John Neil', 'Aying', 'uclm-123', 'Inactive', '', '', '', NULL, NULL, NULL),
(988, 0, 'Employee', 'Jeneth', 'Escala', 'uclm-988', 'Active', 'jen15@gmhail.com', 'Female', 'Jhvc', 'Naix Lifestealer', '2024-03-10 13:41:25', '2024-03-12 23:26:55'),
(1313, 0, 'Student', 'John Neil', 'Aying', 'uclm-1313', 'Pending', 'ayingneil13@gmail.com', 'Male', 'Others', NULL, '2024-03-16 19:21:59', NULL),
(2024, 0, 'Student', 'Jeneth', 'Escala', 'uclm-2024', 'Active', 'Jeneth15@gmail.com', 'Female', 'College of Teacher Education', 'Neil Aying', '2024-03-17 22:03:06', '2024-03-17 22:03:22'),
(6969, 0, 'Student', 'JOHN', 'A AYING', 'uclm-6969', 'Active', 'ayingneil2q15@gmail.com', 'Female', 'College of Computer Studies', 'Naix Lifestealer', '2024-03-09 09:58:06', '2024-03-10 16:39:20'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=736;

--
-- AUTO_INCREMENT for table `tblitembrand`
--
ALTER TABLE `tblitembrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tblitemcategory`
--
ALTER TABLE `tblitemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `tblmessages`
--
ALTER TABLE `tblmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `tblmessage_recipients`
--
ALTER TABLE `tblmessage_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

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
