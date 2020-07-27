-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2020 at 04:53 PM
-- Server version: 10.3.22-MariaDB-0+deb10u1
-- PHP Version: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty_list`
--

CREATE TABLE `faculty_list` (
  `faculty_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_list`
--

INSERT INTO `faculty_list` (`faculty_id`, `name`, `emailid`, `password`) VALUES
(1, 'Head', 'head@abc.com', 'testing'),
(2, 'Raman', 'test@abc.com', 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_papers`
--

CREATE TABLE `faculty_papers` (
  `paper_ID` int(11) NOT NULL COMMENT 'A unique ID assigned to the paper',
  `faculty_ID` int(11) NOT NULL COMMENT 'The faculty ID of the faculty creating the paper',
  `paper-due` datetime NOT NULL COMMENT 'time and date of when the paper is to be made available for students',
  `paper_duration` int(11) NOT NULL COMMENT 'duration in minutes',
  `total_marks` int(11) NOT NULL COMMENT 'total marks as set by the faculty',
  `question_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'The questions in json format',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-new 1-in progress 2-done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_papers`
--

INSERT INTO `faculty_papers` (`paper_ID`, `faculty_ID`, `paper-due`, `paper_duration`, `total_marks`, `question_data`, `status`) VALUES
(6, 1, '2020-07-27 13:01:00', 90, 60, '[[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"sdfgsdhf djkfhg  hkfdhgk sdlgjhfdkg ?\\\",\\\"image\\\":\\\"\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"dfgdfghfghj fhg fdgjhf fhy fg\\\",\\\"image\\\":\\\"QImages/97d7967477c6591b4d222156d358fe18.png\\\"}],[{\\\"questionNumber\\\":\\\"3\\\",\\\"questionText\\\":\\\"fdhgfdhjgfk  gfhkhj mloi\\\",\\\"image\\\":\\\"\\\"},{\\\"questionNumber\\\":\\\"4\\\",\\\"questionText\\\":\\\"dgfv fdg fghgfj hghgjkhg ?\\\",\\\"image\\\":\\\"QImages/7e904fdab7ef5ada3285a9a797944a2e.png\\\"}],[{\\\"questionNumber\\\":\\\"5\\\",\\\"questionText\\\":\\\"fvhfg jgfhjgh hgjhg lgyhkiy kiuy ?\\\",\\\"image\\\":\\\"\\\"},{\\\"questionNumber\\\":\\\"6\\\",\\\"questionText\\\":\\\"xcgbxd fgfjgh hgjgh kgfhj gf?\\\",\\\"image\\\":\\\"QImages/489d749658636bbab7a31a0f95857ea3.png\\\"}]]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `student_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`student_ID`, `name`, `email`, `password`) VALUES
(1, 'pman', 'pman@amb.com', 'test'),
(2, 'p2', 'p2@abc.com', 'testest');

-- --------------------------------------------------------

--
-- Table structure for table `student_papers`
--

CREATE TABLE `student_papers` (
  `student_ID` int(11) NOT NULL,
  `paper_ID` int(11) NOT NULL,
  `paper_URL` varchar(255) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `unique_submission_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty_papers`
--
ALTER TABLE `faculty_papers`
  ADD PRIMARY KEY (`paper_ID`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`student_ID`);

--
-- Indexes for table `student_papers`
--
ALTER TABLE `student_papers`
  ADD PRIMARY KEY (`unique_submission_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty_papers`
--
ALTER TABLE `faculty_papers`
  MODIFY `paper_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A unique ID assigned to the paper', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_papers`
--
ALTER TABLE `student_papers`
  MODIFY `unique_submission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
