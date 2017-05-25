-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2016 at 01:44 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtc_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `text_answer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `item_id`, `choice_id`, `text_answer`) VALUES
(1, 1, 3, NULL),
(2, 2, 6, NULL),
(3, 3, 9, NULL),
(4, 4, 15, NULL),
(5, 5, 18, NULL),
(6, 6, 21, NULL),
(7, 7, 25, NULL),
(8, 8, 26, NULL),
(9, 9, 31, NULL),
(10, 10, 34, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE IF NOT EXISTS `choice` (
  `choice_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `choice`
--

INSERT INTO `choice` (`choice_id`, `order`, `item_id`, `content`) VALUES
(1, 1, 1, 'Relation'),
(2, 2, 1, 'Function'),
(3, 3, 1, 'Set'),
(4, 4, 1, 'Proposition'),
(5, 1, 2, '{1, 2, 3}'),
(6, 2, 2, '{1, 3, 5, 7, 9}'),
(7, 3, 2, '{1, 2, 5, 9}'),
(8, 4, 2, '{1, 5, 7, 9, 11}'),
(9, 1, 3, 'One'),
(10, 2, 3, 'Two'),
(11, 3, 3, 'Zero'),
(12, 4, 3, 'Three'),
(13, 1, 4, '{(1, a), (1, b), (2, a), (b, b)}'),
(14, 2, 4, '{(1, 1), (2, 2), (a, a), (b, b)}'),
(15, 3, 4, '{(1, a), (2, a), (1, b), (2, b)}'),
(16, 4, 4, '{(1, 1), (a, a), (2, a), (1, b)}'),
(17, 1, 5, 'TRUE'),
(18, 2, 5, 'FALSE'),
(19, 1, 6, 'One'),
(20, 2, 6, 'Two'),
(21, 3, 6, 'Three'),
(22, 1, 7, 'Get the phone'),
(23, 2, 7, 'Snooze your alarm then sleep'),
(24, 3, 7, 'Go to toilet'),
(25, 4, 7, 'Stretching'),
(26, 1, 8, 'Read input from user'),
(27, 2, 8, 'Write output to screen'),
(28, 3, 8, 'Read input from file'),
(29, 4, 8, 'Write output to file'),
(30, 1, 9, 'Read input form user'),
(31, 2, 9, 'Write output to screen'),
(32, 3, 9, 'Read input form file'),
(33, 4, 9, 'Write output to file'),
(34, 1, 10, 'print'),
(35, 2, 10, 'read'),
(36, 3, 10, 'asd'),
(37, 4, 10, 'dsdsad');

-- --------------------------------------------------------

--
-- Table structure for table `constraint`
--

CREATE TABLE IF NOT EXISTS `constraint` (
  `constraint_id` int(11) NOT NULL,
  `total_item` int(11) NOT NULL,
  `total_form` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `constraint`
--

INSERT INTO `constraint` (`constraint_id`, `total_item`, `total_form`, `topic_id`, `time`, `note`) VALUES
(1, 5, 1, 1, '2015-08-05 10:35:03', 'Pre exam discrete math'),
(2, 6, 1, 1, '2015-08-25 19:56:41', 'test quiz 2'),
(3, 3, 1, 1, '2015-09-01 15:45:42', 'TEST CONSTRUCTION');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `form_id` int(11) NOT NULL,
  `testform_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `testform_id`, `item_id`) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 1, 3),
(1, 1, 4),
(1, 1, 5),
(2, 2, 1),
(2, 2, 2),
(2, 2, 3),
(2, 2, 4),
(2, 2, 5),
(2, 2, 6),
(3, 3, 2),
(3, 3, 4),
(3, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `question` text,
  `pic_link` varchar(100) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `type`, `question`, `pic_link`, `author_id`, `topic_id`, `subject_id`) VALUES
(1, 0, 'A _______ is an ordered collection of objects.', NULL, 1, 1, 5),
(2, 0, 'The set O of odd positive integers less than 10 can be expressed by ___________ .', NULL, 1, 1, 5),
(3, 0, 'Power set of?empty set?has exactly _____ subset.', NULL, 1, 1, 5),
(4, 0, 'What is the Cartesian product of A = {1, 2} and B = {a, b}?', NULL, 1, 1, 5),
(5, 0, 'The Cartesian Product B x A is equal to the Cartesian product A x B. Is it True or False?', NULL, 1, 1, 5),
(6, 0, 'Answer the following equation $1+2=?$', NULL, 1, 1, 5),
(7, 0, 'What is the first thing that you gonna do?', '', 1, 4, 7),
(8, 0, 'What is scanf() function ?', '', 1, 3, 6),
(9, 0, 'What is printf() function ?', '', 1, 3, 6),
(10, 0, 'what is printf ?', '', 1, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `item_param`
--

CREATE TABLE IF NOT EXISTS `item_param` (
  `id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `a` double NOT NULL,
  `b` double NOT NULL,
  `time` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_param`
--

INSERT INTO `item_param` (`id`, `create_time`, `a`, `b`, `time`, `item_id`) VALUES
(2, '2015-08-25 19:44:54', 0.4, 0.3, 5, 1),
(3, '2015-08-25 19:44:54', 0.44, 0.35, 5, 2),
(4, '2015-08-25 19:44:54', 0.5, 0.55, 5, 3),
(5, '2015-08-25 19:44:54', 0.45, 0.65, 5, 4),
(6, '2015-08-25 19:44:54', 0.66, 0.75, 5, 5),
(7, '2015-08-25 19:49:02', 0.4, 0.1, 3, 6),
(8, '2015-11-04 14:14:33', 0.7, 0.8, 1, 7),
(9, '2015-12-01 17:06:57', 0.3, 0.43, 3, 8),
(10, '2015-12-01 17:10:02', 0.2, 0.25, 1, 9),
(11, '2015-12-02 04:39:53', 0.5, 0.2, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `log_answer`
--

CREATE TABLE IF NOT EXISTS `log_answer` (
  `id` int(11) NOT NULL,
  `testform_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_no` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_answer`
--

INSERT INTO `log_answer` (`id`, `testform_id`, `user_id`, `exam_no`, `item_id`, `answer`, `start_time`, `submit_time`) VALUES
(1, 1, 2, 1, 1, '3', '2015-08-27 03:00:56', '2015-08-26 20:01:01'),
(2, 1, 2, 1, 2, '6', '2015-08-27 03:01:01', '2015-08-26 20:01:03'),
(3, 1, 2, 1, 3, '10', '2015-08-27 03:01:03', '2015-08-26 20:01:06'),
(4, 1, 2, 1, 4, '15', '2015-08-27 03:01:06', '2015-08-26 20:01:10'),
(5, 1, 2, 1, 5, '17', '2015-08-27 03:01:10', '2015-08-26 20:01:12'),
(6, 1, 2, 2, 1, '3', '2015-08-27 03:01:17', '2015-08-26 20:01:20'),
(7, 1, 2, 2, 2, '6', '2015-08-27 03:01:20', '2015-08-26 20:01:22'),
(8, 1, 2, 2, 3, '9', '2015-08-27 03:01:22', '2015-08-26 20:01:26'),
(9, 1, 2, 2, 4, '15', '2015-08-27 03:01:26', '2015-08-26 20:01:31'),
(10, 1, 2, 2, 5, '18', '2015-08-27 03:01:31', '2015-08-26 20:01:33'),
(11, 2, 2, 1, 1, '3', '2015-08-27 03:37:08', '2015-08-26 20:37:10'),
(12, 2, 2, 1, 2, '7', '2015-08-27 03:37:10', '2015-08-26 20:37:13'),
(13, 2, 2, 1, 3, '11', '2015-08-27 03:37:13', '2015-08-26 20:37:16'),
(14, 2, 2, 1, 4, '15', '2015-08-27 03:37:16', '2015-08-26 20:37:19'),
(15, 2, 2, 1, 5, '17', '2015-08-27 03:37:19', '2015-08-26 20:37:22'),
(16, 2, 2, 1, 6, '21', '2015-08-27 03:37:22', '2015-08-26 20:37:24'),
(17, 2, 2, 2, 1, '3', '2015-08-27 03:42:39', '2015-08-26 20:42:41'),
(18, 2, 2, 2, 2, '6', '2015-08-27 03:42:42', '2015-08-26 20:42:44'),
(19, 2, 2, 2, 3, '12', '2015-08-27 03:42:44', '2015-08-26 20:42:47'),
(20, 2, 2, 2, 4, '15', '2015-08-27 03:42:47', '2015-08-26 20:42:49'),
(21, 2, 2, 2, 5, '18', '2015-08-27 03:42:49', '2015-08-26 20:42:51'),
(22, 2, 2, 2, 6, '20', '2015-08-27 03:42:51', '2015-08-26 20:42:53'),
(23, 2, 2, 3, 1, '3', '2015-08-27 03:43:49', '2015-08-26 20:43:51'),
(24, 2, 2, 3, 2, '6', '2015-08-27 03:43:51', '2015-08-26 20:43:54'),
(25, 2, 2, 3, 3, '9', '2015-08-27 03:43:54', '2015-08-26 20:44:01'),
(26, 2, 2, 3, 4, '15', '2015-08-27 03:44:01', '2015-08-26 20:44:04'),
(27, 2, 2, 3, 5, '18', '2015-08-27 03:44:04', '2015-08-26 20:44:06'),
(28, 2, 2, 3, 6, '21', '2015-08-27 03:44:06', '2015-08-26 20:44:09'),
(29, 1, 3, 1, 1, '3', '2015-08-27 14:33:03', '2015-08-27 07:33:08'),
(30, 1, 3, 1, 2, '6', '2015-08-27 14:33:08', '2015-08-27 07:33:10'),
(31, 1, 3, 1, 3, '12', '2015-08-27 14:33:10', '2015-08-27 07:33:12'),
(32, 1, 3, 1, 4, '15', '2015-08-27 14:33:12', '2015-08-27 07:33:15'),
(33, 1, 3, 1, 5, '18', '2015-08-27 14:33:15', '2015-08-27 07:33:17'),
(34, 2, 3, 1, 1, '3', '2015-08-27 14:33:24', '2015-08-27 07:33:26'),
(35, 2, 3, 1, 2, '6', '2015-08-27 14:33:26', '2015-08-27 07:33:29'),
(36, 2, 3, 1, 3, '11', '2015-08-27 14:33:29', '2015-08-27 07:33:32'),
(37, 2, 3, 1, 4, '16', '2015-08-27 14:33:32', '2015-08-27 07:33:34'),
(38, 2, 3, 1, 5, '18', '2015-08-27 14:33:34', '2015-08-27 07:33:36'),
(39, 2, 3, 1, 6, '21', '2015-08-27 14:33:36', '2015-08-27 07:33:38'),
(40, 2, 3, 2, 1, '3', '2015-08-27 14:33:49', '2015-08-27 07:33:52'),
(41, 2, 3, 2, 2, '6', '2015-08-27 14:33:52', '2015-08-27 07:33:54'),
(42, 2, 3, 2, 3, '11', '2015-08-27 14:33:54', '2015-08-27 07:33:56'),
(43, 2, 3, 2, 4, '15', '2015-08-27 14:33:56', '2015-08-27 07:33:58'),
(44, 2, 3, 2, 5, '18', '2015-08-27 14:33:58', '2015-08-27 07:34:01'),
(45, 2, 3, 2, 6, '21', '2015-08-27 14:34:01', '2015-08-27 07:34:03'),
(46, 1, 4, 1, 1, '2', '2015-08-27 14:34:34', '2015-08-27 07:34:37'),
(47, 1, 4, 1, 2, '8', '2015-08-27 14:34:37', '2015-08-27 07:34:39'),
(48, 1, 4, 1, 3, '9', '2015-08-27 14:34:39', '2015-08-27 07:34:42'),
(49, 1, 4, 1, 4, '15', '2015-08-27 14:34:42', '2015-08-27 07:34:44'),
(50, 1, 4, 1, 5, '18', '2015-08-27 14:34:44', '2015-08-27 07:34:46'),
(51, 1, 4, 2, 1, '3', '2015-08-27 14:34:52', '2015-08-27 07:34:55'),
(52, 1, 4, 2, 2, '6', '2015-08-27 14:34:55', '2015-08-27 07:34:58'),
(53, 1, 4, 2, 3, '9', '2015-08-27 14:34:58', '2015-08-27 07:35:01'),
(54, 1, 4, 2, 4, '15', '2015-08-27 14:35:01', '2015-08-27 07:35:03'),
(55, 1, 4, 2, 5, '18', '2015-08-27 14:35:03', '2015-08-27 07:35:05'),
(56, 2, 4, 1, 1, '3', '2015-08-27 14:35:08', '2015-08-27 07:35:11'),
(57, 2, 4, 1, 2, '6', '2015-08-27 14:35:11', '2015-08-27 07:35:13'),
(58, 2, 4, 1, 3, '9', '2015-08-27 14:35:13', '2015-08-27 07:35:15'),
(59, 2, 4, 1, 4, '15', '2015-08-27 14:35:15', '2015-08-27 07:35:17'),
(60, 2, 4, 1, 5, '18', '2015-08-27 14:35:17', '2015-08-27 07:35:19'),
(61, 2, 4, 1, 6, '21', '2015-08-27 14:35:19', '2015-08-27 07:35:20'),
(62, 3, 4, 1, 2, '7', '2015-09-01 23:25:38', '2015-09-01 16:25:43'),
(63, 3, 4, 1, 4, '16', '2015-09-01 23:25:43', '2015-09-01 16:25:46'),
(64, 3, 4, 1, 6, '21', '2015-09-01 23:25:46', '2015-09-01 16:25:50');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `definition` text NOT NULL,
  `user_create` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `course_name`, `course_id`, `definition`, `user_create`) VALUES
(5, 'Discrete Mathematics', 'CS101', 'Discrete Mathematics . . . . . blah blahhh', 1),
(6, 'C Programming', 'CS102', 'C Programming Blah.......Blahh', 1),
(7, 'General Living', 'TP123', 'Chills course', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testform`
--

CREATE TABLE IF NOT EXISTS `testform` (
  `testform_id` int(11) NOT NULL,
  `constraint_id` int(11) NOT NULL,
  `name` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testform`
--

INSERT INTO `testform` (`testform_id`, `constraint_id`, `name`) VALUES
(1, 1, 'Quiz 1'),
(2, 2, 'Quiz2'),
(3, 3, 'TEST3');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `definition` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `user_create` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topic_id`, `topic_name`, `definition`, `subject_id`, `user_create`) VALUES
(1, 'Lesson 01 - Get Start', 'Introduce about course', 5, 1),
(2, 'Lesson 02 - Logic', 'Talk  about logic table', 5, 1),
(3, 'Input and Output', 'Intro printf and scanf', 6, 1),
(4, 'Morning Task', 'How to do when you wake up?', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `type` int(1) NOT NULL,
  `student_id` varchar(15) DEFAULT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `password`, `type`, `student_id`, `fname`, `lname`, `email`, `department`) VALUES
(1, 'admin', 'admin', 0, NULL, 'Chayawat', 'Pechwises', 'dxtlink@gmail.com', 'Computer Science TU'),
(2, 'std1', 'std1', 1, '5809650100', 'Sirinan', 'Paiboonrattananon', 'nt.sirinan@hotmail.com', 'Computer Science TU'),
(3, 'std2', 'std2', 1, '5809650101', 'Dextor', 'De Butler', 'dxtlink@gmail.com', 'Freelance'),
(4, 'std3', 'std3', 1, '5809650102', 'Top', 'Handsome', 'top_handsome@top.com', 'Everywhere');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `choice_id` (`choice_id`);

--
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `constraint`
--
ALTER TABLE `constraint`
  ADD PRIMARY KEY (`constraint_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD KEY `result_id` (`testform_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `item_param`
--
ALTER TABLE `item_param`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `log_answer`
--
ALTER TABLE `log_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `testform_id` (`testform_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `user_create` (`user_create`);

--
-- Indexes for table `testform`
--
ALTER TABLE `testform`
  ADD PRIMARY KEY (`testform_id`),
  ADD KEY `constraint_id` (`constraint_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_create` (`user_create`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `choice`
--
ALTER TABLE `choice`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `constraint`
--
ALTER TABLE `constraint`
  MODIFY `constraint_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `item_param`
--
ALTER TABLE `item_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `log_answer`
--
ALTER TABLE `log_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `testform`
--
ALTER TABLE `testform`
  MODIFY `testform_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`);

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `constraint`
--
ALTER TABLE `constraint`
  ADD CONSTRAINT `constraint_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`);

--
-- Constraints for table `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `form_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `form_ibfk_2` FOREIGN KEY (`testform_id`) REFERENCES `testform` (`testform_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`),
  ADD CONSTRAINT `item_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `item_ibfk_4` FOREIGN KEY (`author_id`) REFERENCES `user_account` (`user_id`);

--
-- Constraints for table `item_param`
--
ALTER TABLE `item_param`
  ADD CONSTRAINT `item_param_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `log_answer`
--
ALTER TABLE `log_answer`
  ADD CONSTRAINT `log_answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`),
  ADD CONSTRAINT `log_answer_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `log_answer_ibfk_3` FOREIGN KEY (`testform_id`) REFERENCES `testform` (`testform_id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`user_create`) REFERENCES `user_account` (`user_id`);

--
-- Constraints for table `testform`
--
ALTER TABLE `testform`
  ADD CONSTRAINT `testform_ibfk_1` FOREIGN KEY (`constraint_id`) REFERENCES `constraint` (`constraint_id`);

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`user_create`) REFERENCES `user_account` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
