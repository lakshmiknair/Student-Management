-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2020 at 11:09 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_mgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classes`
--

CREATE TABLE `tbl_classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`class_id`, `class_name`) VALUES
(68, 'Second Grade'),
(69, 'Third Grade'),
(72, 'Fifth Grade'),
(74, 'First Grade'),
(75, 'Fourth Grade');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `emergency_number` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `profile_image` blob NOT NULL,
  `status` enum('1','0') NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `firstname`, `lastname`, `address`, `contact_number`, `emergency_number`, `email`, `profile_image`, `status`, `class_id`, `created_date`, `updated_date`) VALUES
(82, 'Madhav', 'Nair', 'Tets Address', '123456789', '9876543456', 'madhav@check.com', 0x31383032333232373537356664666334666133363634612e706e67, '', 72, '2020-12-20 22:41:14', '2020-12-20 22:46:46'),
(83, 'Ananya s', 'Test', 'Test', '66666666', '8765456789', 'ananya@ff.com', 0x31353733363731303633356664666335363561356638302e706e67, '1', 68, '2020-12-20 22:43:01', '2020-12-20 22:50:40'),
(84, 'Kevin', 'James', 'testet', '4444444', '9876543456', 'kevein@cd.com', 0x373834313837303731356664666336313230353865612e706e67, '1', 68, '2020-12-20 22:45:54', '2020-12-20 15:45:54'),
(85, 'Diya ', 'Singh', 'test', '66666666', '3333333333', 'diya@yaho.com', 0x393536363939333639356664666336383636333365632e706e67, '1', 69, '2020-12-20 22:47:50', '2020-12-20 15:47:50'),
(86, 'Neha', 'sharma', 'ttest', '66666666', '7656765676', 'neha@sdf.co', 0x313333353238393530356664666336623735663463642e706e67, '1', 72, '2020-12-20 22:48:39', '2020-12-20 15:48:39'),
(87, 'David', 'James', 'test', '77777777', '9876567876', 'david@d.com', 0x31333235383639333233356664666337303937613234642e706e67, '1', 69, '2020-12-20 22:50:01', '2020-12-20 15:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'Admin', 'admin@lorem.com', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class-student` (`class_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `class-student` FOREIGN KEY (`class_id`) REFERENCES `tbl_classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
