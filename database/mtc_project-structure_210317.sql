-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2017 at 03:56 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

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

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `text_answer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auto_resultset`
--

CREATE TABLE `auto_resultset` (
  `resultset_id` int(11) NOT NULL,
  `constraint_id` int(11) NOT NULL,
  `avg_df` double NOT NULL,
  `avg_sads` double NOT NULL,
  `sd` double NOT NULL,
  `a_time` double NOT NULL DEFAULT '0',
  `b_time` double NOT NULL DEFAULT '0',
  `is_success` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='result set of automatic test forms construction';

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `choice_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `constraint`
--

CREATE TABLE `constraint` (
  `constraint_id` int(11) NOT NULL,
  `constraint_name` varchar(100) DEFAULT NULL,
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  `difficulty_target` double DEFAULT NULL,
  `total_item` int(11) NOT NULL,
  `total_form` int(11) NOT NULL,
  `duplicate_rate` double NOT NULL DEFAULT '0',
  `topic_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text,
  `user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_owner`
--

CREATE TABLE `course_owner` (
  `owner_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `adder_user` int(11) NOT NULL,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `testform_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `question` text,
  `pic_link` varchar(100) DEFAULT NULL,
  `refer` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`cat_id`, `cat_name`) VALUES
(1, 'Recall'),
(2, 'Interpretation'),
(3, 'Problem Solving');

-- --------------------------------------------------------

--
-- Table structure for table `item_param`
--

CREATE TABLE `item_param` (
  `id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `a` double NOT NULL,
  `b` double NOT NULL,
  `time` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_answer`
--

CREATE TABLE `log_answer` (
  `id` int(11) NOT NULL,
  `testform_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_no` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `definition` text NOT NULL,
  `user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `testform`
--

CREATE TABLE `testform` (
  `testform_id` int(11) NOT NULL,
  `resultset_id` int(11) DEFAULT NULL,
  `constraint_id` int(11) NOT NULL,
  `dl_form` double NOT NULL,
  `sd_form` double DEFAULT NULL,
  `name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `definition` text NOT NULL,
  `objective` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `user_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `type` int(1) NOT NULL,
  `student_id` varchar(15) DEFAULT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `password`, `type`, `student_id`, `fname`, `lname`, `email`, `department`) VALUES
(1, 'admin', 'admin', 0, NULL, 'Teerapat', 'Laddawong', 'teerapat.l@allied.tu.ac.th', 'Physical Therapy'),
(2, 'namfon', 'namfon', 1, NULL, 'Namfon', 'Mahasup', 'namfon.m@allied.tu.ac.th ', 'Physical Therapy');

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
-- Indexes for table `auto_resultset`
--
ALTER TABLE `auto_resultset`
  ADD PRIMARY KEY (`resultset_id`),
  ADD KEY `constraint_id` (`constraint_id`);

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
  ADD KEY `user_create` (`user_create`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `course_owner`
--
ALTER TABLE `course_owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `adder_user` (`adder_user`);

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
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`cat_id`);

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
  ADD KEY `constraint_id` (`constraint_id`),
  ADD KEY `resultset_id` (`resultset_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `auto_resultset`
--
ALTER TABLE `auto_resultset`
  MODIFY `resultset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `choice`
--
ALTER TABLE `choice`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `constraint`
--
ALTER TABLE `constraint`
  MODIFY `constraint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `course_owner`
--
ALTER TABLE `course_owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item_param`
--
ALTER TABLE `item_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `log_answer`
--
ALTER TABLE `log_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `testform`
--
ALTER TABLE `testform`
  MODIFY `testform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- Constraints for table `auto_resultset`
--
ALTER TABLE `auto_resultset`
  ADD CONSTRAINT `auto_resultset_ibfk_1` FOREIGN KEY (`constraint_id`) REFERENCES `constraint` (`constraint_id`);

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `constraint`
--
ALTER TABLE `constraint`
  ADD CONSTRAINT `constraint_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `course_owner`
--
ALTER TABLE `course_owner`
  ADD CONSTRAINT `course_owner_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `course_owner_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`),
  ADD CONSTRAINT `course_owner_ibfk_3` FOREIGN KEY (`adder_user`) REFERENCES `user_account` (`user_id`);

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
  ADD CONSTRAINT `item_ibfk_4` FOREIGN KEY (`author_id`) REFERENCES `user_account` (`user_id`),
  ADD CONSTRAINT `item_ibfk_5` FOREIGN KEY (`cat_id`) REFERENCES `item_category` (`cat_id`);

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
