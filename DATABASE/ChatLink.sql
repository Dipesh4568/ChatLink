-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2023 at 04:23 PM
-- Server version: 11.0.2-MariaDB
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ChatLink`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `from_id`, `to_id`, `message`, `opened`, `created_at`) VALUES
(1, 2, 1, 'hyy', 0, '2023-07-14 21:33:48'),
(2, 6, 5, 'fdfd', 0, '2023-07-17 19:08:25'),
(3, 6, 1, 'hyy', 0, '2023-07-17 20:00:43'),
(4, 6, 5, 'dfkjd', 0, '2023-07-18 08:02:03'),
(5, 6, 5, 'fdf', 0, '2023-07-18 08:09:19'),
(6, 6, 5, 'dfdf', 0, '2023-07-18 08:09:28'),
(7, 6, 5, 'sfjdf', 0, '2023-07-18 08:24:44'),
(8, 6, 5, 'fdkfd', 0, '2023-07-18 08:24:47'),
(9, 6, 5, 'dkjfjd', 0, '2023-07-18 08:24:52'),
(10, 6, 5, 'kdjfsd', 0, '2023-07-18 08:30:52'),
(11, 6, 5, 'djkfjsd', 0, '2023-07-18 08:30:53'),
(12, 7, 6, 'hyy', 1, '2023-07-18 08:38:43'),
(13, 6, 7, 'hyy', 1, '2023-07-18 08:46:24'),
(14, 7, 6, 'ffd', 1, '2023-07-18 09:03:24'),
(15, 6, 7, 'hyy', 1, '2023-07-18 09:58:56'),
(16, 7, 6, 'hy', 1, '2023-07-18 09:59:12'),
(17, 6, 7, 'hyy', 1, '2023-07-18 10:03:03'),
(18, 7, 6, 'hy', 1, '2023-07-18 10:03:13'),
(19, 6, 7, 'hyy', 1, '2023-07-18 10:03:36'),
(20, 7, 6, 'hello', 1, '2023-07-18 10:03:44'),
(21, 6, 7, 'sk', 1, '2023-07-18 10:04:02'),
(22, 7, 6, 'hyy', 1, '2023-07-18 10:07:57'),
(23, 6, 7, 'hyy', 1, '2023-07-18 10:08:12'),
(24, 6, 7, 'dkfjshdf', 1, '2023-07-18 10:08:13'),
(25, 6, 7, 'sdlfsdfkj', 1, '2023-07-18 10:08:14'),
(26, 6, 7, 'hy', 1, '2023-07-18 10:09:38'),
(27, 7, 6, 'hello', 1, '2023-07-18 10:19:30'),
(28, 7, 6, 'sk', 1, '2023-07-18 10:19:34'),
(29, 7, 6, 'djfkdf', 1, '2023-07-18 10:21:56'),
(30, 6, 7, 'dfkjd', 1, '2023-07-18 11:00:42'),
(31, 7, 1, 'hyy', 0, '2023-07-18 19:12:01'),
(32, 7, 5, 'hy', 0, '2023-07-18 19:15:33'),
(33, 8, 1, 'hyy', 0, '2023-07-18 19:19:34'),
(34, 8, 1, 'hyy', 0, '2023-07-18 19:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `user_1`, `user_2`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 2, 3),
(4, 6, 7),
(5, 7, 1),
(6, 7, 5),
(7, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `p_p` varchar(255) DEFAULT 'user-default.png',
  `last_seen` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `p_p`, `last_seen`) VALUES
(1, 'Demo', 'Demo1', '$2y$10$F4Vps7D20pRO2xqu4IYIXutX9vkuCjhCTp3pym3FAi6UHqLQ6xRSC', 'user-default.png', '2023-07-15 13:38:27'),
(5, 'Dipesh', 'Dipesh_8', '$2y$10$cHGFM4s9uXb0tvUXy6WeR.zJL8kTWiLOwWb7XXrjpd3kTupGn3hiG', 'Dipesh_8.png', '2023-07-16 09:56:34'),
(6, 'Sample', 'Sample1', '$2y$10$rsAk9hZwY4J5lBwGexPjzevVtbcsjcUfwtBZObfPFZj.os14VK2sK', 'user-default.png', '2023-07-18 21:29:37'),
(7, 'Dipesh', 'Dipesh_7297', '$2y$10$GjcW/IMzOH3ocLkWftViVeLtQUwNSuaixfTLf4BRDgLolBcKnjBPu', 'Dipesh_7297.jpg', '2023-07-18 19:17:56'),
(8, 'new', 'New_1', '$2y$10$9WaMGnhUyd5gmOFDvj4CGeNB2KRKE1lF2yLWzuZaFdRJlMmvSKrua', 'New_1.jpg', '2023-07-18 21:26:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
