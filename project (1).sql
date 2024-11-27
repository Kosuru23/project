-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 11:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `acronym` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `acronym`, `created_at`, `last_updated`) VALUES
(1, 'Bachelor of Computing Science', 'BSCS', '2024-10-29 12:49:47', '0000-00-00 00:00:00'),
(2, 'Bachelor of Information Management', 'BSIT', '2024-10-29 12:51:04', NULL),
(3, 'Mobile Application Development', 'MAD', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `excuse_letter`
--

CREATE TABLE `excuse_letter` (
  `id` int(11) NOT NULL,
  `excuse_letter` blob NOT NULL,
  `comment` text DEFAULT NULL,
  `prof_id` int(11) NOT NULL,
  `is_approve` tinyint(4) NOT NULL DEFAULT 0,
  `date_submitted` date NOT NULL,
  `date_absent` date NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `excuse_letter`
--

INSERT INTO `excuse_letter` (`id`, `excuse_letter`, `comment`, `prof_id`, `is_approve`, `date_submitted`, `date_absent`, `course_id`, `user_id`, `section_id`) VALUES
(17, 0x73637265656e73686f743030382e6a7067, 'dsaasa', 1, 0, '2024-11-27', '2024-11-02', 1, 9, 1),
(18, 0x73637265656e73686f743030372e6a7067, 'sdssdsds', 1, 0, '2024-11-27', '2024-11-09', 1, 9, 1),
(19, 0x73637265656e73686f743031342e6a7067, 'fddfsdfsdf', 4, 0, '2024-11-27', '0000-00-00', 1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `ID` int(11) NOT NULL,
  `type` enum('Adviser','Guidance','Professor','') NOT NULL DEFAULT 'Professor',
  `year_adviser` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`ID`, `type`, `year_adviser`, `user_id`) VALUES
(1, 'Professor', NULL, 16),
(4, 'Professor', NULL, 17);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL,
  `type` enum('CS','IT','ACT','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `year_level`, `type`) VALUES
(1, 'BSCS-3A', 3, 'CS'),
(2, 'BSCS-2B', 2, 'CS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ids` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_user` tinyint(1) DEFAULT 1,
  `is_professor` tinyint(1) DEFAULT NULL,
  `is_checker` tinyint(1) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ids`, `email`, `password`, `last_name`, `first_name`, `middle_name`, `created_at`, `last_updated`, `is_user`, `is_professor`, `is_checker`, `section_id`) VALUES
(8, 'jusonneiljam@gmail.com', '$2y$10$0rReBIyHrLJ/0iy96ER9F.44Tt46U1f8T0PuaT/xo9DjnEX4Mwb.6', 'Juson', 'Neil Jam', NULL, '2024-11-25 06:23:17', NULL, 1, NULL, NULL, 1),
(9, 'neil', '$2y$10$0zXduaxnmMDXJlDdUIv7qukkRSZwGy1XywTRXTmRVXtWxo10ATIbC', 'Juson', 'Neil Jam', NULL, '2024-11-25 06:25:20', '2024-11-26 14:08:31', 1, NULL, NULL, 1),
(10, 'jusonmarodel@gmail.com', '$2y$10$1tx1fqmhTijFenjZeo5y2.ujE/pzaLHNDSrtSTWju.kPwzk1eJO7W', 'Juson', 'Neil Jam', NULL, '2024-11-25 15:00:19', NULL, 1, NULL, NULL, 2),
(11, '09951491869', '$2y$10$D4njwZSxqaf3gnEJTDMr5OYdX3ld3zXNowvhTVTtY6T9ELj/QLaEC', 'Juson', 'Neil Jam', 'J', '2024-11-25 21:05:54', NULL, 1, NULL, NULL, 1),
(16, 'dap@wmsu.com', '$2y$10$d7VMjzAeUll38P.uGHLOsOQ2DvnHCkmux4.4YFbhm1/KTN3XBbSG2', 'dsd', 'Dap', 'Y', '2024-11-26 08:33:13', NULL, NULL, 1, NULL, NULL),
(17, 'dapp@wmsu.com', '$2y$10$hiHqvv5EC39/Tbh5jM1yyuSSbu4zkkBbftQ40HUmd3k4ExUwPemKO', 'pIEDAD', 'gERALDINE', 'tIMONEL', '2024-11-26 15:55:47', '2024-11-27 15:26:05', NULL, 1, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`);

--
-- Indexes for table `excuse_letter`
--
ALTER TABLE `excuse_letter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `section.id` (`section_id`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `year_adviser` (`year_adviser`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year_level` (`year_level`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `section_id` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `excuse_letter`
--
ALTER TABLE `excuse_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `professors`
--
ALTER TABLE `professors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `excuse_letter`
--
ALTER TABLE `excuse_letter`
  ADD CONSTRAINT `excuse_letter_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `excuse_letter_ibfk_2` FOREIGN KEY (`prof_id`) REFERENCES `professors` (`id`),
  ADD CONSTRAINT `excuse_letter_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`ids`),
  ADD CONSTRAINT `excuse_letter_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Constraints for table `professors`
--
ALTER TABLE `professors`
  ADD CONSTRAINT `professors_ibfk_1` FOREIGN KEY (`year_adviser`) REFERENCES `sections` (`year_level`),
  ADD CONSTRAINT `professors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ids`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
