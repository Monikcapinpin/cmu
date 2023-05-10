-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2023 at 08:04 AM
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
  `Activity` varchar(255) NOT NULL,
  `Organization` varchar(255) NOT NULL,
  `Semester` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_record`
--

INSERT INTO `activity_record` (`ID`, `Student_Name`, `Att_Date`, `Att_Time`, `Activity`, `Organization`, `Semester`) VALUES
(6, 'Kaire Palulay', '2023-05-09', '07:27:22', 'dsadas', 'sdasda', '1st Semester');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `ID` int(11) NOT NULL,
  `Student_Name` varchar(255) DEFAULT NULL,
  `Att_Date` varchar(255) DEFAULT NULL,
  `Att_Time` varchar(255) DEFAULT NULL,
  `Instructor` varchar(255) DEFAULT NULL,
  `Subject` varchar(11) DEFAULT NULL,
  `Status` varchar(255) NOT NULL,
  `Semester` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_record`
--

INSERT INTO `attendance_record` (`ID`, `Student_Name`, `Att_Date`, `Att_Time`, `Instructor`, `Subject`, `Status`, `Semester`) VALUES
(12, 'Kaire Palulay', '2023-05-06', '23:53:44', 'Scarlet G. Panes', 'English', 'On-Time', '2nd Semester'),
(13, 'Kaire Palulay', '2023-05-07', '05:11:00', 'Sarah Guarte', 'English', 'Late', '1st Semester');

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
(3, 'Bachelor of Science in Computer Engineering', 'BSCoE', 'Sample', 'COE'),
(4, 'Bachelor of Science in Computer Studies', 'BSCSt', 'Sample', 'CTE');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Ins_id` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `Fname`, `Mname`, `Lname`, `Ins_id`, `Email`, `Username`, `Password`) VALUES
(1, 'dsa', 'sdas', 'sdasd', 'Late', 'sdsda@gmaiul.com', 'sdsdsasd', '$2y$10$9zR27OWsFIwGLO2.P/pJYe.0jSzyP.fv1WvA3aYRh38mV4NIyIZai'),
(2, 'dsad', 'sda', 'dsasdsda', 'on-time', 'dasdasds@gmail.com', '', '');

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
-- Table structure for table `scheduling`
--

CREATE TABLE `scheduling` (
  `id` int(11) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Teacher` varchar(255) NOT NULL,
  `sched` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `days` varchar(255) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  `SY` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheduling`
--

INSERT INTO `scheduling` (`id`, `Subject`, `Teacher`, `sched`, `code`, `days`, `Semester`, `SY`) VALUES
(1, 'English', 'Scarlet G. Panes', '9-10', 'Eng-101', 'tth', '1st Semester', '');

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `password_reset_key` varchar(255) DEFAULT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Middlename` varchar(255) NOT NULL,
  `Inst_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`ID`, `Name`, `Block`, `Year`, `Program`, `Username`, `Password`, `Photo`, `Roles`, `Barcode`, `Email`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`, `Firstname`, `Lastname`, `Middlename`, `Inst_id`) VALUES
(4, 'Admin', '', '', '', 'admin', '$2y$10$Ny2yLibFxeu5Flrp2yNN3.4j44w2JllN54rydgq1xb1MshMT1n.lW', 'http://localhost/cmu/uploads/files/1i2pum5ehr9jty7.JPG', 'Admin', '', 'admin@gmail.com', NULL, NULL, '2022-11-07 07:22:42', '92a203845cc3c31ce9c7bfbb6306c12d', '', '', '', ''),
(5, 'Scarlet G. Panes', '', '', '', 'merrit', '$2y$10$lKUf9zb7dfcVU4iqyp0WUuhrrQUQ7FR8Iz82C3u03yYs.gXFh/lgG', 'http://localhost/cmu/uploads/files/lmohsgbvtfkjwn4.JPG', 'Teacher', '', 'merrit@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL, '', '', '', ''),
(11, 'Maleah S. Guarte', '', '', '', 'maleah', '$2y$10$mpT.l08EPyAFW.Rs6SWzmOTSC1yQ8LvjXLwZS7ilCiQhe6EN.Qe7O', 'http://localhost/cmu/uploads/files/x_cgv3dm685esi4.JPG', 'Teacher', '', 'maleah@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL, '', '', '', ''),
(14, 'Sarah Guarte', '', '', '', 'sarah', '$2y$10$f9x6..OvL.UH5wDgnlGNdOk9d0mzil9AU.JkzH60meuF0jsbsUnJO', 'http://localhost/cmu/uploads/files/jug9rn0hzm1kdx7.JPG', 'Teacher', '', 'sarah@gmail.com', NULL, NULL, '2023-01-13 00:00:00', NULL, 'Sarah', 'Guarte', 'Salgado', ''),
(19, 'Maleah Guarte', 'Block 2', '1st ', 'BSCS', 'maleah1', '$2y$10$S/q2oUQrTHfSfknHxSVd1.mRds9ljYqcJD6B/M35etUzgjZVEnY4e', 'http://localhost/cmu/uploads/files/9zm8_2t7bpniwo1.jpg', 'Student', 'xjuBi0Qh5cNtDE6a*VYJlfeX%wS#Rm', 'maleah@gamil.com', NULL, NULL, '2023-01-13 00:00:00', NULL, 'Maleah', 'Guarte', 'Salgado', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Schedule` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `Schedule`, `Description`, `code`) VALUES
(1, 'English', '9-10', 'dasads', 'Eng-101'),
(2, 'Mathematics', '10-12', 'sdsda', 'Math101');

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
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduling`
--
ALTER TABLE `scheduling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_record`
--
ALTER TABLE `activity_record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance_record`
--
ALTER TABLE `attendance_record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scheduling`
--
ALTER TABLE `scheduling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
