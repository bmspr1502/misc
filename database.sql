-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2020 at 08:55 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

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
(1, 1, '2020-07-10 05:59:00', 50, 50, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"q 1 is the earth flat\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"is your face flat?\\\"}]', 0),
(2, 1, '2020-07-01 04:17:00', 40, 30, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"fdgdfghfdh\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"gfhjgkjhliuo\\\"},{\\\"questionNumber\\\":\\\"3\\\",\\\"questionText\\\":\\\"hjklhjuk;liop\\\'\\\"}]', 0),
(3, 1, '2020-07-01 04:32:00', 50, 50, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"yhertytryu\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"jytiuytiuyol\\\"}]', 1),
(4, 2, '2020-07-16 04:32:00', 70, 50, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"yhertytryu\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"jytiuytiuyol\\\"},{\\\"questionNumber\\\":\\\"3\\\",\\\"questionText\\\":\\\"jhgkgjhklhj\\\"},{\\\"questionNumber\\\":\\\"4\\\",\\\"questionText\\\":\\\"dyjuytikyuiou\\\"}]', 2),
(5, 1, '2020-07-01 04:39:00', 53, 563, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"ktfiytu\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"yuytiuyti\\\"},{\\\"questionNumber\\\":\\\"3\\\",\\\"questionText\\\":\\\"tyutryeurtu\\\"}]', 0),
(6, 1, '2020-07-23 05:56:00', 5, 10, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"Just checking\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"These are all the values that will be added\\\"}]', 0),
(7, 1, '2020-07-24 06:05:00', 20, 200, '[{\\\"questionNumber\\\":\\\"1\\\",\\\"questionText\\\":\\\"Whatever the question is\\\"},{\\\"questionNumber\\\":\\\"2\\\",\\\"questionText\\\":\\\"write the data into it\\\"}]', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty_papers`
--
ALTER TABLE `faculty_papers`
  ADD PRIMARY KEY (`paper_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty_papers`
--
ALTER TABLE `faculty_papers`
  MODIFY `paper_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A unique ID assigned to the paper', AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
