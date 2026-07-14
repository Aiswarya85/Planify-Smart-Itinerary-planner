-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2025 at 06:13 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `planify_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_tb`
--

CREATE TABLE `activity_tb` (
  `id` int(11) NOT NULL,
  `activity` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_tb`
--

INSERT INTO `activity_tb` (`id`, `activity`) VALUES
(1, 'trekking'),
(2, 'Camping'),
(3, 'Cycling'),
(4, 'Wildlife safaries'),
(5, 'Beach Activities'),
(6, 'Cultural Exploration'),
(7, 'Relaxation and Wellness'),
(8, 'Shopping');

-- --------------------------------------------------------

--
-- Table structure for table `ac_tb`
--

CREATE TABLE `ac_tb` (
  `a_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `h_type` int(11) NOT NULL,
  `place` int(11) DEFAULT NULL,
  `r_type` int(11) NOT NULL,
  `no_of_people` int(11) NOT NULL,
  `facilities` int(11) NOT NULL,
  `h_description` varchar(500) NOT NULL,
  `photo` varchar(5000) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `map` varchar(5000) NOT NULL,
  `distance` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ac_tb`
--

INSERT INTO `ac_tb` (`a_id`, `name`, `h_type`, `place`, `r_type`, `no_of_people`, `facilities`, `h_description`, `photo`, `rating`, `map`, `distance`) VALUES
(2, 'hehe', 2, 6, 2, 3, 2, 'vg', 'uploads/core.jpeg', '4', 'ebfb', '2');

-- --------------------------------------------------------

--
-- Table structure for table `cab_tb`
--

CREATE TABLE `cab_tb` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `pickup` varchar(200) NOT NULL,
  `dropoff` varchar(200) NOT NULL,
  `fare` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cab_tb`
--

INSERT INTO `cab_tb` (`id`, `u_id`, `pickup`, `dropoff`, `fare`) VALUES
(1, 0, '12:00', '01:00', 420);

-- --------------------------------------------------------

--
-- Table structure for table `dest_tb`
--

CREATE TABLE `dest_tb` (
  `id` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `destination` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `photo` varchar(5000) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `activities` int(11) NOT NULL,
  `map` varchar(5000) NOT NULL,
  `distance` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dest_tb`
--

INSERT INTO `dest_tb` (`id`, `place`, `destination`, `description`, `photo`, `rating`, `activities`, `map`, `distance`) VALUES
(4, 6, 'kattappana', 'dsxfcgvhbjnkml', 'uploads/core.jpeg', '4', 6, 'szxdfcgvhbjnm', '1');

-- --------------------------------------------------------

--
-- Table structure for table `facility_tb`
--

CREATE TABLE `facility_tb` (
  `f_id` int(11) NOT NULL,
  `f_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facility_tb`
--

INSERT INTO `facility_tb` (`f_id`, `f_type`) VALUES
(1, 'AC'),
(2, 'Non-AC');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tb`
--

CREATE TABLE `feedback_tb` (
  `fb_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `rating` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback_tb`
--

INSERT INTO `feedback_tb` (`fb_id`, `u_id`, `description`, `rating`) VALUES
(1, 3, 'wer', '5');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_tb`
--

CREATE TABLE `hotel_tb` (
  `hid` int(11) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel_tb`
--

INSERT INTO `hotel_tb` (`hid`, `type`) VALUES
(1, '5 Star'),
(2, '4 Star'),
(3, '3 Star'),
(4, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `payment_tb`
--

CREATE TABLE `payment_tb` (
  `id` int(11) NOT NULL,
  `payment` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `place_tb`
--

CREATE TABLE `place_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `place_tb`
--

INSERT INTO `place_tb` (`id`, `name`) VALUES
(5, 'KATTAPPANA'),
(6, 'KUMILY'),
(7, 'THEKKADY'),
(8, 'MUNNAR'),
(9, 'PAINAVU'),
(12, 'CHERUTHONI'),
(13, 'ANAMUDI'),
(14, 'VAGAMON');

-- --------------------------------------------------------

--
-- Table structure for table `room_tb`
--

CREATE TABLE `room_tb` (
  `r_id` int(11) NOT NULL,
  `r_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_tb`
--

INSERT INTO `room_tb` (`r_id`, `r_type`) VALUES
(1, 'Single'),
(2, 'Double'),
(3, 'Suite'),
(4, 'Deluxe');

-- --------------------------------------------------------

--
-- Table structure for table `user_plan`
--

CREATE TABLE `user_plan` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `acid` int(11) DEFAULT NULL,
  `destid` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_plan`
--

INSERT INTO `user_plan` (`id`, `userid`, `acid`, `destid`, `date`) VALUES
(1, 13, 2, NULL, '0000-00-00'),
(2, 13, 2, NULL, '0000-00-00'),
(3, 13, NULL, 4, '0000-00-00'),
(4, 13, 2, NULL, '0000-00-00'),
(5, 13, 2, NULL, '2025-08-07'),
(6, 13, 2, NULL, '2025-08-07'),
(7, 13, 2, NULL, '2025-08-07'),
(8, 13, 2, NULL, '2025-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`id`, `name`, `phone`, `email`, `password`, `role`) VALUES
(3, 'Noble ', '123', 'jadanriko@gmail.com', 'sss', 'user'),
(4, 'aa', '7686876768', 'ron@gmail.com', 'abcd', 'user'),
(5, 'Noble Johny', '9074030490', 'noblejohny097@gmail.com', 'abcd', 'user'),
(6, 'Noble Johny', '09074030490', 'noblejohny097@gmail.com', 'aa', 'user'),
(7, 'ais', '0987654321', 'ais@123', 'aa', 'user'),
(8, 'Noble Johny', '09074030490', 'noblejohny097@gmail.com', 'asdf', 'user'),
(9, 'QWERTY', '09074030490', 'as@gmail.com', 'QWE', 'user'),
(10, 'Noble Johny', '09074030490', 'noblejohny097@gmail.com', 'a', 'user'),
(11, 'Noble Johny', '09074030490', 'noblejohny097@gmail.com', 'aa', 'user'),
(12, 'admin', '1234567890', 'admin@gmail.com', 'admin', 'admin'),
(13, 'Noble Johny', '09074030490', 'noblejohny097@gmail.com', 'aa', 'user'),
(14, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(15, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(16, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(17, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(18, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(19, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(20, '', '09074030490', 'noblejohny097@gmail.com', '', 'user'),
(21, '', '99', 'aa@gmail.com', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_tb`
--
ALTER TABLE `activity_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ac_tb`
--
ALTER TABLE `ac_tb`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `h_type` (`h_type`),
  ADD KEY `roomtype` (`r_type`),
  ADD KEY `facilities` (`facilities`),
  ADD KEY `placefk` (`place`);

--
-- Indexes for table `cab_tb`
--
ALTER TABLE `cab_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dest_tb`
--
ALTER TABLE `dest_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place` (`place`),
  ADD KEY `fk_activities` (`activities`);

--
-- Indexes for table `facility_tb`
--
ALTER TABLE `facility_tb`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `feedback_tb`
--
ALTER TABLE `feedback_tb`
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `hotel_tb`
--
ALTER TABLE `hotel_tb`
  ADD PRIMARY KEY (`hid`);

--
-- Indexes for table `payment_tb`
--
ALTER TABLE `payment_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place_tb`
--
ALTER TABLE `place_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_tb`
--
ALTER TABLE `room_tb`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `user_plan`
--
ALTER TABLE `user_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_tb`
--
ALTER TABLE `activity_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ac_tb`
--
ALTER TABLE `ac_tb`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cab_tb`
--
ALTER TABLE `cab_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dest_tb`
--
ALTER TABLE `dest_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facility_tb`
--
ALTER TABLE `facility_tb`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel_tb`
--
ALTER TABLE `hotel_tb`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `place_tb`
--
ALTER TABLE `place_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `room_tb`
--
ALTER TABLE `room_tb`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_plan`
--
ALTER TABLE `user_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ac_tb`
--
ALTER TABLE `ac_tb`
  ADD CONSTRAINT `facilities` FOREIGN KEY (`facilities`) REFERENCES `facility_tb` (`f_id`),
  ADD CONSTRAINT `h_type` FOREIGN KEY (`h_type`) REFERENCES `hotel_tb` (`hid`),
  ADD CONSTRAINT `placefk` FOREIGN KEY (`place`) REFERENCES `place_tb` (`id`),
  ADD CONSTRAINT `roomtype` FOREIGN KEY (`r_type`) REFERENCES `room_tb` (`r_id`);

--
-- Constraints for table `dest_tb`
--
ALTER TABLE `dest_tb`
  ADD CONSTRAINT `fk_activities` FOREIGN KEY (`activities`) REFERENCES `activity_tb` (`id`),
  ADD CONSTRAINT `place` FOREIGN KEY (`place`) REFERENCES `place_tb` (`id`);

--
-- Constraints for table `feedback_tb`
--
ALTER TABLE `feedback_tb`
  ADD CONSTRAINT `u_id` FOREIGN KEY (`u_id`) REFERENCES `user_tb` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
