-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 10:12 PM
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
-- Database: `my_secure_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `bio`, `created_at`) VALUES
(1, 'John', 'Doe', '2005-06-15', 'male', 'A talented young dancer.', '2024-05-28 08:37:05'),
(2, 'Jane', 'Smith', '1988-11-23', 'female', 'An experienced performer and coach.', '2024-05-28 08:37:05'),
(3, 'kumara', 'kumara', '2024-06-07', 'male', 'director', '2024-06-07 12:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','excused') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `artist_id`, `date`, `status`, `created_at`) VALUES
(1, 1, '2024-05-20', 'present', '2024-05-28 08:37:05'),
(2, 2, '2024-05-20', 'absent', '2024-05-28 08:37:05'),
(3, 2, '2024-05-28', 'absent', '2024-05-28 17:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `injury_records`
--

CREATE TABLE `injury_records` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `injury_date` date NOT NULL,
  `description` text NOT NULL,
  `status` enum('ongoing','recovered') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `injury_records`
--

INSERT INTO `injury_records` (`id`, `artist_id`, `injury_date`, `description`, `status`, `created_at`) VALUES
(1, 1, '2024-04-16', 'Sprained and butter', 'recovered', '2024-05-28 08:37:05'),
(3, 1, '2024-05-28', 'aadad', 'recovered', '2024-05-28 17:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `parental_consent`
--

CREATE TABLE `parental_consent` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `consent_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parental_consent`
--

INSERT INTO `parental_consent` (`id`, `child_id`, `parent_name`, `parent_email`, `consent_date`) VALUES
(1, 7, 'Madhuwantha', 'Madhuwantha@gmail.com', '2024-06-07 19:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE `performances` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `performance_date` date NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `role_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `performances`
--

INSERT INTO `performances` (`id`, `artist_id`, `performance_date`, `event_name`, `role_description`, `created_at`) VALUES
(1, 1, '2024-06-01', 'Annual Dance Show', 'Lead dancer in the opening act', '2024-05-28 08:37:05'),
(2, 2, '2024-06-01', 'Annual Dance Show', 'Choreographer', '2024-05-28 08:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('director','coach','artist') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `age` int(255) NOT NULL,
  `parental_consent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `age`, `parental_consent`) VALUES
(1, 'director1', '$2y$10$abcdefghijklmnopqrstuv', 'director', '2024-05-28 08:37:05', 0, 0),
(2, 'piyuman98', '$2y$10$1lIZqUeJbbIJCDvEoGFq0uEA527WbND2.mOtEz4c.hptooemon9XS', 'director', '2024-05-28 08:42:53', 0, 0),
(3, '2020', '$2y$10$98p6DTyKCwKUJGARtF4MRu3QHHHPW0hOF0ex38Ql2GN/aeelgNSFy', 'director', '2024-06-07 19:22:42', 31, 1),
(4, '2024', '$2y$10$MC6D0GIPBNPtMdxw5LWHVevx8.YEPu9O9/OLAs3N7k3FlJhM2tj6i', 'director', '2024-06-07 19:36:06', 64, 1),
(5, '2021', '$2y$10$Frd46j/1UXbP9jGTjUonJOhC6M690aqsIt6lOvOjtXJHLo/2/u.qC', 'director', '2024-06-07 19:36:37', 12, 1),
(7, '2022', '$2y$10$tMUz7DefVvn.Hu6Pi5dGn.DY4rknH916pgUUsMkkok3S1U4k/CguG', 'director', '2024-06-07 19:43:48', 11, 1),
(8, '2025', '$2y$10$mHQB8V8p5xSbBiE9fD/m3.agSmOiqvewcpG.7ebJ9/WKkH4oQfvVi', '', '2024-06-07 19:51:56', 13, 1),
(9, '2023', '$2y$10$KJn4ZUQYXHmtzkHbd0IQy..WDJA4GnwbWufjOqaq4K1XoUgbRXx5y', '', '2024-06-07 19:55:04', 14, 1),
(10, '2026', '$2y$10$dfKVuoBGoMim6FINpKC72.w6s4mHOn0kQxAd1CMpWULLyGUJ4lWOW', '', '2024-06-07 19:58:29', 20, 1),
(11, '207', '$2y$10$0wz36/9NRml3Dtun0iL.qegI4MQt4aMZJ8/pQa/E6T368dJ0pJtt6', '', '2024-06-07 20:10:47', 30, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `injury_records`
--
ALTER TABLE `injury_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `parental_consent`
--
ALTER TABLE `parental_consent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `injury_records`
--
ALTER TABLE `injury_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parental_consent`
--
ALTER TABLE `parental_consent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);

--
-- Constraints for table `injury_records`
--
ALTER TABLE `injury_records`
  ADD CONSTRAINT `injury_records_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);

--
-- Constraints for table `parental_consent`
--
ALTER TABLE `parental_consent`
  ADD CONSTRAINT `parental_consent_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
