-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2020 at 03:10 PM
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
-- Table structure for table `assignment_done`
--

CREATE TABLE `assignment_done` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assignment_done`
--

INSERT INTO `assignment_done` (`id`, `assignment_id`, `user_id`, `file`, `time_stamp`) VALUES
(38, 1, 1, 'Operating System Concepts ( PDFDrive ).pdf', '2020-11-30 14:03:55'),
(39, 1, 4, 'test.pdf', '2020-12-03 13:59:56');

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
  `pdf` varchar(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `journal_title`, `instruction`, `grade_id`, `user_id`, `start_date`, `end_date`, `pdf`, `time_stamp`) VALUES
(6, 'Journal - 1', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ratione sit quod placeat, porro quae incidunt, voluptatum a ea fugit nulla vitae repellendus! Veniam autem alias numquam architecto qui vel labore.', 1, 3, '2020-12-27', '2020-12-28', 'Theory of Computer Science (Automata, Languages and Computation) Third Edition ( PDFDrive ).pdf', '2020-12-27 14:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `journal_done`
--

CREATE TABLE `journal_done` (
  `id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `journal_done`
--

INSERT INTO `journal_done` (`id`, `journal_id`, `user_id`, `time_stamp`) VALUES
(1, 6, 1, '2020-12-27 13:46:15');

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
(3, 'Assignment 3 Edit', 1, '2020-12-12', '2020-12-13', NULL, 2, NULL, '2020-11-30 06:18:07'),
(5, 'Assignment 1', 2, '2020-12-09', '2020-12-10', NULL, 3, NULL, '2020-11-30 08:43:19'),
(10, 'Quize 1', 1, '2020-12-30', '2020-12-31', 4, NULL, NULL, '2020-12-01 01:53:25'),
(12, 'Journal - 1', 1, '2020-12-27', '2020-12-28', NULL, NULL, 6, '2020-12-05 13:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `quize_question`
--

CREATE TABLE `quize_question` (
  `id` int(11) NOT NULL,
  `quize_title_id` int(11) NOT NULL,
  `question` mediumtext NOT NULL,
  `answer_1` varchar(255) NOT NULL,
  `answer_2` varchar(255) NOT NULL,
  `answer_3` varchar(255) NOT NULL,
  `true_answer_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quize_question`
--

INSERT INTO `quize_question` (`id`, `quize_title_id`, `question`, `answer_1`, `answer_2`, `answer_3`, `true_answer_no`, `user_id`, `time_stamp`) VALUES
(2, 4, 'Long form of HTML?', 'Hyper Text Madeup Language', 'Hyper Text Makeup Language', 'Hyper Text Markup Language', 3, 3, '2020-12-27 14:07:41'),
(3, 4, 'How many types of header tags in HTML?', '5', '6', '7', 2, 3, '2020-12-01 07:53:42'),
(4, 4, 'Which one is HTML Inline Element?', 'span', 'h1', 'p', 1, 3, '2020-12-01 07:55:29'),
(5, 4, 'Which one is HTML Block Element?', 'strong', 'p', 'span', 2, 3, '2020-12-01 07:56:56'),
(6, 4, 'Long form of CSS?', 'Cascading Shellsheet', 'Cascading StyleShell', 'Cascading StyleSheet', 3, 3, '2020-12-01 07:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `quize_title`
--

CREATE TABLE `quize_title` (
  `id` int(11) NOT NULL,
  `quize_title` varchar(255) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quize_title`
--

INSERT INTO `quize_title` (`id`, `quize_title`, `grade_id`, `user_id`, `start_date`, `end_date`, `time_stamp`) VALUES
(4, 'Quize 1', 1, 3, '2020-12-30', '2020-12-31', '2020-12-27 14:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_done`
--

CREATE TABLE `quiz_done` (
  `id` int(11) NOT NULL,
  `quiz_title_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quiz_done`
--

INSERT INTO `quiz_done` (`id`, `quiz_title_id`, `user_id`, `marks`, `time_stamp`) VALUES
(1, 4, 1, 4, '2020-12-31 15:04:35'),
(2, 4, 4, 2, '2020-12-31 13:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL,
  `quiz_title_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quiz_result`
--

INSERT INTO `quiz_result` (`id`, `quiz_title_id`, `question_id`, `result`, `user_id`, `time_stamp`) VALUES
(1, 4, 2, 0, 1, '2020-12-31 15:04:35'),
(2, 4, 3, 1, 1, '2020-12-31 15:04:35'),
(3, 4, 4, 1, 1, '2020-12-31 15:04:35'),
(4, 4, 5, 1, 1, '2020-12-31 15:04:35'),
(5, 4, 6, 1, 1, '2020-12-31 15:04:35'),
(6, 4, 2, 0, 4, '2020-12-31 13:58:07'),
(7, 4, 3, 1, 4, '2020-12-31 13:58:07'),
(8, 4, 4, 0, 4, '2020-12-31 13:58:07'),
(9, 4, 5, 1, 4, '2020-12-31 13:58:07'),
(10, 4, 6, 0, 4, '2020-12-31 13:58:07');

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
(1, 'Phyoe Htet Kyaw', '3CS - 2', 'phyoehtetkyaw614@gmail.com', '$2y$10$PpPIotKuqT/Fs97XBzFmQ.Armj8B/zFipZ1Nd4.86AXom.9m.rFLq', 0, 1, '2020-11-30 14:30:50'),
(2, 'Mg Mg', '3CS - 1', 'mgmg@gmail.com', '$2y$10$HT5Z51vFHK53ouXB3rRZDeIt8XJpJerJbVm/JBMRQQ68SOhQ1ORtO', 0, 1, '2020-12-03 14:23:39'),
(3, 'Ma Ma', 'Teacher', 'mama@gmail.com', '$2y$10$o5PQ0KVQz8IAKl0E5OpdquGJ7SldNpJgYribD6lZ4T87dvXqBvwUS', 1, 2, '2020-11-30 08:59:04'),
(4, 'User 1', '3CS - 3', 'user1@gmail.com', '$2y$10$RL7t4y4tw2oHq7.x3aR9bO/oMKuLxEaDTMS2mtdO.f8amHVR6Vhey', 0, 1, '2020-12-05 12:38:11'),
(5, 'Super Admin', 'Super Admin', 'superadmin@lms.com', '$2y$10$h76lhrAMyX1HUdlqvxKMo..L1ejD73tcP2G1Ij4fPnEfNgubTYOXa', 2, 2, '2020-12-05 12:26:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_done`
--
ALTER TABLE `assignment_done`
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
-- Indexes for table `journal_done`
--
ALTER TABLE `journal_done`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quize_question`
--
ALTER TABLE `quize_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quize_title`
--
ALTER TABLE `quize_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_done`
--
ALTER TABLE `quiz_done`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
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
-- AUTO_INCREMENT for table `assignment_done`
--
ALTER TABLE `assignment_done`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `journal_done`
--
ALTER TABLE `journal_done`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quize_question`
--
ALTER TABLE `quize_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quize_title`
--
ALTER TABLE `quize_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quiz_done`
--
ALTER TABLE `quiz_done`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
