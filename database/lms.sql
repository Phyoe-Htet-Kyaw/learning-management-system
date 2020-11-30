-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 10:17 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `assignment_title` varchar(255) NOT NULL,
  `instruction` mediumtext NOT NULL,
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `assignment_title`, `instruction`, `grade_id`, `user_id`, `start_date`, `end_date`, `time_stamp`) VALUES
(1, 'Assignment 1 EDIT', 'Hello', 1, 1, '2020-11-30', '2020-12-03', '2020-11-30 06:18:18'),
(2, 'Assignment 3 Edit', 'dw', 1, 1, '2020-12-12', '2020-12-13', '2020-11-30 06:18:07'),
(3, 'Assignment 1', 'hello', 2, 2, '2020-12-09', '2020-12-10', '2020-11-30 08:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `grade_name` varchar(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `grade_name`, `time_stamp`) VALUES
(1, 'Third Year', '2020-11-29 09:21:30'),
(2, 'First Year (Honorus)', '2020-11-29 09:21:30');

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `id` int(11) NOT NULL,
  `journal_title` varchar(255) NOT NULL,
  `instruction` varchar(255) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `journal_title`, `instruction`, `grade_id`, `user_id`, `start_date`, `end_date`, `time_stamp`) VALUES
(1, 'Journal - 1 Edit', 'hello', 1, 1, '2020-12-04', '2020-12-07', '2020-11-30 06:24:34'),
(2, 'Journal - 2 Edit', 'hello', 1, 1, '2020-12-09', '2020-12-10', '2020-11-30 06:25:22'),
(4, 'Journal - 1', 'helllo', 2, 2, '2020-12-14', '2020-12-15', '2020-11-30 08:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quize_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `name`, `grade_id`, `start_date`, `end_date`, `quize_id`, `assignment_id`, `journal_id`, `time_stamp`) VALUES
(1, 'Assignment 1 EDIT', 1, '2020-11-30', '2020-12-03', NULL, 1, NULL, '2020-11-30 06:18:18'),
(2, 'Journal - 1 Edit', 1, '2020-12-04', '2020-12-07', NULL, NULL, 1, '2020-11-30 06:24:34'),
(3, 'Assignment 3 Edit', 1, '2020-12-12', '2020-12-13', NULL, 2, NULL, '2020-11-30 06:18:07'),
(4, 'Journal - 2 Edit', 1, '2020-12-09', '2020-12-10', NULL, NULL, 2, '2020-11-30 06:25:22'),
(5, 'Assignment 1', 2, '2020-12-09', '2020-12-10', NULL, 3, NULL, '2020-11-30 08:43:19'),
(7, 'Journal - 1', 2, '2020-12-14', '2020-12-15', NULL, NULL, 4, '2020-11-30 08:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `quize`
--

CREATE TABLE `quize` (
  `id` int(11) NOT NULL,
  `question` mediumtext NOT NULL,
  `answer_1` varchar(255) NOT NULL,
  `answer_2` varchar(255) NOT NULL,
  `answer_3` varchar(255) NOT NULL,
  `true_answer_no` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `roll_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `roll_no`, `email`, `password`, `status`, `grade_id`, `time_stamp`) VALUES
(1, 'Phyoe Htet Kyaw', '4CS - 2', 'phyoehtetkyaw614@gmail.com', '$2y$10$PpPIotKuqT/Fs97XBzFmQ.Armj8B/zFipZ1Nd4.86AXom.9m.rFLq', 0, 1, '2020-11-30 09:09:37'),
(2, 'Mg Mg', '3CS - 1', 'mgmg@gmail.com', '$2y$10$HT5Z51vFHK53ouXB3rRZDeIt8XJpJerJbVm/JBMRQQ68SOhQ1ORtO', 0, 1, '2020-11-30 08:28:37'),
(3, 'Ma Ma', 'Teacher', 'mama@gmail.com', '$2y$10$o5PQ0KVQz8IAKl0E5OpdquGJ7SldNpJgYribD6lZ4T87dvXqBvwUS', 1, 2, '2020-11-30 08:59:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quize`
--
ALTER TABLE `quize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quize`
--
ALTER TABLE `quize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
