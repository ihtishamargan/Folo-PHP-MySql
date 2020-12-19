-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2020 at 08:32 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `link_shortener`
--

-- --------------------------------------------------------

--
-- Table structure for table `short_links`
--

CREATE TABLE `short_links` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `short_code` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `short_links`
--

INSERT INTO `short_links` (`id`, `url`, `short_code`, `hits`, `date_time`) VALUES
(1, 'https://www.facebook.com/etribune/videos/705081976979186/', '47b', 0, '2020-12-19 16:30:50'),
(2, 'https://www.facebook.com/etribune/videos/705081976979186/kbhk', 'd47', 0, '2020-12-19 16:30:50'),
(3, 'https://www.facebook.com/AbdulAzizAbroPTI/videos/2910338662521627/', '136', 0, '2020-12-19 16:30:50'),
(4, 'https://www.facebook.com', '57f', 1, '2020-12-19 16:30:50'),
(5, 'http://youtube.com', '0cf', 0, '2020-12-19 16:30:50'),
(6, 'http://twitter.com', '7c0', 0, '2020-12-19 16:30:50'),
(8, 'http://twitter.com/ihtisham.ahmad', 'ef2', 1, '2020-12-19 16:30:50'),
(9, 'http://linkedin.com/ihtisham.ahmad', '404', 2, '2020-12-19 16:30:50'),
(10, 'http://instagram.com', 'e22', 0, '2020-12-19 16:30:50'),
(11, 'http://foolography.com', '443', 0, '2020-12-19 16:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'ihtisham', '$2y$10$PFDDTdvNT1xEsakZnwauMOlS1h1STAKicrj1oEfz1OR46kyGcmVqG', '2020-12-18 13:32:26');

-- --------------------------------------------------------

--
-- Table structure for table `users_links`
--

CREATE TABLE `users_links` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `short_links_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_links`
--

INSERT INTO `users_links` (`id`, `userId`, `short_links_id`) VALUES
(2, 1, 8),
(3, 1, 9),
(4, 1, 10),
(5, 1, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `short_links`
--
ALTER TABLE `short_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_links`
--
ALTER TABLE `users_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `short_links_id` (`short_links_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `short_links`
--
ALTER TABLE `short_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_links`
--
ALTER TABLE `users_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_links`
--
ALTER TABLE `users_links`
  ADD CONSTRAINT `short link` FOREIGN KEY (`short_links_id`) REFERENCES `short_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
