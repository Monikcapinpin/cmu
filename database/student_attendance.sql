-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 04:20 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_record`
--

CREATE TABLE `activity_record` (
  `ID` int(11) NOT NULL,
  `Student_Name` varchar(255) NOT NULL,
  `Att_Date` varchar(255) NOT NULL,
  `Att_Time` varchar(255) NOT NULL,
  `Activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `ID` int(11) NOT NULL,
  `Student_Name` int(11) NOT NULL,
  `Att_Date` int(11) NOT NULL,
  `Att_Time` int(11) NOT NULL,
  `Instructor` int(11) NOT NULL,
  `Subject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `Course` varchar(255) NOT NULL,
  `Abbreviation` varchar(255) NOT NULL,
  `Discription` text NOT NULL,
  `Department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `Course`, `Abbreviation`, `Discription`, `Department`) VALUES
(1, 'Bachelor of Science in Computer Science', 'BSCS', 'Sample', 'CTE'),
(2, 'Bachelor of Science in Information Technology', 'BSIT', 'Sample', 'CTE'),
(3, 'Bachelor of Science in Computer Engineering', 'BSCoE', 'Sample', 'COE');

-- --------------------------------------------------------

--
-- Stand-in structure for view `instructor1`
-- (See below for the actual view)
--
CREATE TABLE `instructor1` (
`ID` int(11)
,`Name` varchar(255)
,`Username` varchar(255)
,`Password` varchar(255)
,`Photo` varchar(255)
,`Roles` varchar(255)
,`Email` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Block` varchar(255) NOT NULL,
  `Year` varchar(255) NOT NULL,
  `Program` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Photo` varchar(255) NOT NULL,
  `Roles` varchar(255) NOT NULL,
  `Barcode` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT '2023-01-13 00:00:00',
  `password_reset_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`ID`, `Name`, `Block`, `Year`, `Program`, `Username`, `Password`, `Photo`, `Roles`, `Barcode`, `Email`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`) VALUES
(2, 'Lorna S. Guarte', '', '', '', 'lorna', '$2y$10$3ymlWBqzVYHncNn8Omugz.TJeR5GH/HsDSbF6nUXrCplaRX36BKsG', 'http://localhost/cmu/uploads/files/3k1ye4f5w8hv7rg.JPG', 'Teacher', '', 'lorna@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL),
(4, 'Admin', '', '', '', 'admin', '$2y$10$Ny2yLibFxeu5Flrp2yNN3.4j44w2JllN54rydgq1xb1MshMT1n.lW', 'http://localhost/cmu/uploads/files/1i2pum5ehr9jty7.JPG', 'Admin', '', 'admin@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL),
(5, 'Merrit E. Guarte', '', '', '', 'merrit', '$2y$10$lKUf9zb7dfcVU4iqyp0WUuhrrQUQ7FR8Iz82C3u03yYs.gXFh/lgG', 'http://localhost/cmu/uploads/files/pwbv8zxrl5n2u69.jpg', 'Teacher', '', 'merrit@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL),
(6, 'Maleah S. Guarte', 'Block 1', '1st ', 'BSCS', 'maleah', '$2y$10$aVNgBQf3xACNa74Cno0YteEYVLigLTM0685CMEAbbKxDHsVhIEcy6', 'http://localhost/cmu/uploads/files/3hcv4f_by092pno.JPG', 'Student', 'Fb1#uQ5XoVH3%T_ONJzd$MrwCZSK!a', 'maleah@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL),
(7, 'Sarah S. Guarte', 'Block 1', '2nd', 'BSIT', 'sarah', '$2y$10$eLlSXHrAwnwsttWjDJbCOerkkjFbKPlpfLR3LJHt6s/EXfk81jHBS', 'http://localhost/cmu/uploads/files/oyzce684_7jng9s.jpg', 'Student', 'Av0ZR!kgXrl%PCb8Ba62K_yL@dMzG$', 'sarah@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL),
(8, 'Scarlet G. Panes', 'Block 2', '2nd', 'BSCoE', 'alet', '$2y$10$yvd8ZIs9DAV7auy4UwMrnOQXGGbylv7HvMQJwlLU74BjW/DqWIu7y', 'http://localhost/cmu/uploads/files/q0jl1g7vcu9isr3.JPG', 'Student', '$%o&q5^2au_9-T3pNKncWrYQyl0vX!', 'alet@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure for view `instructor1`
--
DROP TABLE IF EXISTS `instructor1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `instructor1`  AS  select `si`.`ID` AS `ID`,`si`.`Name` AS `Name`,`si`.`Username` AS `Username`,`si`.`Password` AS `Password`,`si`.`Photo` AS `Photo`,`si`.`Roles` AS `Roles`,`si`.`Email` AS `Email` from `student_info` `si` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_record`
--
ALTER TABLE `activity_record`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_record`
--
ALTER TABLE `activity_record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_record`
--
ALTER TABLE `attendance_record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
