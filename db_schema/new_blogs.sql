-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2025 at 10:10 AM
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
-- Database: `new_blogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `short_description` varchar(250) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(250) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `category_id`, `title`, `short_description`, `description`, `image`, `status`, `created`, `updated`) VALUES
(1, '3', 'Too Good to Be True', 'Too Good to Be True is a gripping romantic thriller that blurs the line between love and deception. When perfection feels real, secrets are never far behind.', 'Too Good to Be True is a captivating blend of romance and psychological suspense that explores the dark side of seemingly perfect love. The story follows a protagonist who finds themselves swept off their feet by someone who appears flawless—charming', 'download.jpeg', '1', '2025-07-01 16:33:50', '0000-00-00 00:00:00'),
(2, '3', 'Twisted Love', 'Twisted Love is a dark, emotionally intense romance about obsession, betrayal, and redemption. It explores how love can both break and heal us.\r\n\r\n', 'Twisted Love is a gripping dark romance that unravels the complexities of a love rooted in pain, secrets, and emotional scars. The story follows a cold, emotionally guarded man and a bright, compassionate woman whose lives become dangerously intertwi', 'download (1).jpeg', '1', '2025-07-01 16:36:02', '0000-00-00 00:00:00'),
(3, '3', 'Twisted Games', 'Twisted Games is a slow-burn forbidden romance between a fiercely independent princess and her brooding bodyguard. Duty clashes with desire in this emotional rollercoaster.', 'Twisted Games is a sizzling forbidden romance that explores the tension between duty and desire. The story follows Bridget, a modern-day princess bound by royal expectations, and Rhys, her stoic and fiercely protective bodyguard. When Bridget unexpec', 'download (2).jpeg', '1', '2025-07-01 16:37:38', '0000-00-00 00:00:00'),
(4, '3', 'Twisted Hate', 'Twisted Hate is a fiery enemies-to-lovers romance packed with sizzling chemistry, banter, and unexpected vulnerability. Love and hate collide in this slow-burn battle of hearts.', 'Twisted Hate is an electrifying enemies-to-lovers romance that proves there\'s a fine line between passion and fury. The story centers around Jules Ambrose, a bold, no-nonsense law student, and Josh Chen, a charming doctor with a sharp tongue—and an e', 'download (3).jpeg', '1', '2025-07-01 16:38:49', '0000-00-00 00:00:00'),
(5, '3', 'Twisted Lies', 'Twisted Lies is a slow-burn fake dating romance between a mysterious billionaire and the woman who challenges everything he thought he knew about love. Lies can be dangerous—especially when hearts are on the line.\r\n\r\n', 'Twisted Lies is a compelling romance featuring a fake relationship that turns unexpectedly real. The story follows Christian Harper, a cold, enigmatic billionaire with a dark past, and Stella Alonso, a sweet, independent influencer trying to build a ', 'download (4).jpeg', '1', '2025-07-01 16:39:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `status`, `created`, `updated`) VALUES
(1, 'Non-Fictional', 1, '2025-07-01 16:19:36', '2025-07-02 21:03:18'),
(2, 'Biography', 1, '2025-07-01 16:19:48', '0000-00-00 00:00:00'),
(3, 'Romance', 1, '2025-07-01 16:19:58', '0000-00-00 00:00:00'),
(4, 'Fantasy', 1, '2025-07-01 16:23:03', '0000-00-00 00:00:00'),
(5, 'Horror', 1, '2025-07-01 16:28:16', '0000-00-00 00:00:00'),
(6, 'Mystery', 1, '2025-07-01 16:28:29', '0000-00-00 00:00:00'),
(7, 'Thriller', 1, '2025-07-01 16:28:41', '0000-00-00 00:00:00'),
(8, 'love', 1, '2025-07-02 20:53:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comments` longtext NOT NULL,
  `rating` int(100) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `name`, `comments`, `rating`, `status`, `created`) VALUES
(3, 5, 'yana ', 'its fantastic ', 3, '1', '2025-07-02 07:05:26'),
(4, 1, 'mehak', 'wowww', 3, '1', '2025-07-02 07:19:51'),
(5, 2, 'Pihu', 'i am facinated', 5, '1', '2025-07-02 07:24:54'),
(6, 4, 'Yana', 'woww', 3, '1', '2025-07-02 07:27:51'),
(7, 3, 'aastha', 'great book must read', 5, '1', '2025-07-02 07:31:06'),
(8, 3, 'pihu', 'great', 4, '1', '2025-07-02 13:28:41'),
(9, 1, 'mehu', 'Great', 4, '1', '2025-07-15 07:42:20'),
(10, 2, 'Mehak Tewari', 'woww', 4, '1', '2025-07-15 07:42:51'),
(11, 0, 'Yana', 'yess', 3, '1', '2025-07-15 07:48:01'),
(12, 4, 'mehu', 'wow', 5, '1', '2025-07-15 07:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(250) NOT NULL,
  `send_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email_id`, `subject`, `message`, `send_on`) VALUES
(1, 'Mehak Tewari', 'admin@gmail.com', 'error', 'this ', '2025-07-03 06:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `page_name`, `status`, `created`, `updated`) VALUES
(2, 'Dashboard', '1', '2025-07-15 13:08:48', '2025-07-15 13:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `status`, `created`, `updated`) VALUES
(1, 'User', '0', '2025-07-15 08:59:54', '2025-07-15 12:41:16'),
(2, 'Manager', '0', '2025-07-15 09:00:16', '2025-07-15 09:00:16'),
(3, 'Admin', '0', '2025-07-15 09:00:26', '2025-07-15 09:00:26'),
(4, 'Admin', '1', '2025-07-15 12:38:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email_address` varchar(150) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email_address`, `first_name`, `last_name`, `password`, `address`, `status`, `created`, `updated`) VALUES
(1, 'admin@gmail.com', 'Admin', 'Dev', '123456', '123 street', '1', '2025-06-29 19:12:59', '2025-07-02 21:27:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
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
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
