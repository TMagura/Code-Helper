-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2023 at 11:17 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(14, 'JAVA '),
(22, 'KOTLIN'),
(23, 'SAM'),
(24, 'FLUTTER'),
(27, 'LARAVEL');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(32, 41, 'trymore', 'mee@gmail.com', 'iygiuiai', 'approved', '2023-06-22'),
(33, 41, 'tee', 'tee@gmail.com', 'thanks man', 'approved', '2023-06-22'),
(34, 41, 'trymore', 'trymore@gmail.com', 'man you special', 'approved', '2023-06-22'),
(35, 40, 'trymore', 'trymore@gmail.com', 'thanks man for this moment', 'approved', '2023-06-22'),
(36, 40, 'mee', 'mee@gmail.com', 'trey gucks manyama', 'approved', '2023-06-22'),
(37, 40, 'trey', 'trey@gmail.com', 'trey more thanmks ', 'approved', '2023-06-22'),
(38, 39, 'trymore', 'trey@gmail.com', 'thanks man this is nice', 'approved', '2023-06-22'),
(39, 39, 'man', 'man@gmail.com', 'moweb desing', 'approved', '2023-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(3, 19, 40),
(13, 21, 44),
(29, 19, 44),
(46, 19, 55),
(49, 19, 54),
(50, 21, 54);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) NOT NULL,
  `post_category_id` int(10) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `post_user_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `post_user_id`, `likes`) VALUES
(39, 23, 'mews', 'tee', '2023-06-26', 'image2.jpg', 'yiuiu\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'love', 0, 'draft', 59, 21, 0),
(40, 22, 'its mine', 'mee', '2023-06-27', 'image4.png', 'fhejtr', 'rtrkrrrkjr', 0, 'draft', 113, 21, 0),
(41, 23, 'happy happy wee', 'mee', '2023-06-22', 'Aug-16-database-administrator-program.jpg', 'java is the cook', 'java', 0, 'draft', 4, 19, 0),
(42, 23, 'waht about java', 'mee', '2023-06-22', 'good-software-developer-1128x635.jpg', 'trymore man ', 'java', 0, 'draft', 5, 22, 0),
(43, 22, 'my new post', 'trey', '2023-06-22', 'image1.png', 'think logical', 'about mechanichs', 0, 'draft', 2, 22, 0),
(44, 14, 'excelent', 'try', '2023-06-23', 'computer-technician-wearing-glasses-fixing-laptop-desk-with-tools-around-black-man-work-tools_155686-174.jpg', '123 go ', 'make it happen man ', 0, 'draft', 48, 21, 2),
(53, 14, 'excelent', 'try', '2023-06-23', 'computer-technician-wearing-glasses-fixing-laptop-desk-with-tools-around-black-man-work-tools_155686-174.jpg', '123 go ', 'make it happen man ', 0, 'draft', 2, 21, 0),
(54, 22, 'my new post', 'trey', '2023-06-23', 'image1.png', 'think logical', 'about mechanichs', 0, 'published', 176, 22, 2),
(56, 27, 'laravel Eloquency', 'tee', '2023-07-03', 'cc09b9f0e6b8c43bde2965544b427594.png', 'best deals for laravel 10', 'laravel codes', 0, 'published', 4, 21, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `randsalt` varchar(255) NOT NULL DEFAULT '$2y$11$aqwsedrftgyhujikolp987',
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randsalt`, `token`) VALUES
(19, 'bnn', '$2y$11$aqwsedrftgyhujikolp98uPPazQkqZaUDv5ha.OstKALrBKBsfCbG', 'triggerxx', 'mahxx', 'tri@hgmail.com', 'image4.png', 'admin', '$2y$11$aqwsedrftgyhujikolp987', ''),
(20, 'try', '$2y$12$TmzcrIeCjUnmoFJXh41uFeph1Bqp63Ja7nyOG6e568xVtPOtsRqoC', 'memo', 'mula', 't1@gmail.com', 'image2.jpg', 'admin', '$2y$11$aqwsedrftgyhujikolp987', ''),
(21, 'tee', '$2y$11$aqwsedrftgyhujikolp98uPPazQkqZaUDv5ha.OstKALrBKBsfCbG', 'trymore', 'magura', 'tee@gmail.com', 'green_ford_mustang_gt_ferrada_wheels_5k-HD.jpg', 'admin', '$2y$11$aqwsedrftgyhujikolp987', 'd4c9c8cd771b8eb724d653b22d460f3cf0d0c9a7133b0f20cf57e8306387b8927aced07047443b3933940db8d82f1ab1f8e7'),
(39, 'man', '$2y$11$aqwsedrftgyhujikolp98u/8tV7ChEnhOeI.77rlVROTJatcouDai', 'man', 'man', 'man@gmail.com', 'cube.jpg', 'admin', '$2y$11$aqwsedrftgyhujikolp987', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session_online` varchar(255) NOT NULL,
  `time_online` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session_online`, `time_online`) VALUES
(11, 'ihnmj14opgkreu3p75lsam96ms', 1687696925),
(12, 'm4lbbnm7o3f19kfprdiivpg1pv', 1687366539),
(13, 't1a7sc11qha0ils740ui8h999f', 1687715311),
(14, 'hbvemgfmlvmr5mqlicbii3ds6l', 1687856392),
(15, 'ifb3nuc56k2dpqh4t2v182rii0', 1687875545),
(16, 'erfglr36e9aread09m6ggs7ql2', 1688374756),
(17, '27u85g23v41j7p9pb6q0j6fvm7', 1688400147),
(18, '78suiqotskd38bglpssim2ivkk', 1688399328),
(19, '8nuo45sqibbsqrklunsoqb3g5u', 1688400152),
(20, 'b4ant7g4e0n57gslrl4l1hq18e', 1688546458),
(21, 'endk7rslief4ehp4tugjo3mv1i', 1688485641),
(22, 'ku18257ftcvshves08gga0ccgi', 1688547318);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
