-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 09:19 AM
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
-- Database: `shoe-order`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(21, 'coelen', 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(1, 'Sneakers', 'sneakers11.jpg', 'Yes', 'Yes'),
(2, 'Loafers', 'loafers.jpg', 'Yes', 'Yes'),
(3, 'Trainers', 'trainers1_.jpg', 'Yes', 'Yes'),
(4, 'Platform Shoes', 'platforms1.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `shoes` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(50,0) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `shoes`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`, `size`) VALUES
(1, '5', 670.00, 1, 2020, '2025-08-30 16:34:00', 'Ordered', 'Aaron Aranas', '09533591578', 'aranasaaron04@gmail.com', 'Yumbing', '32'),
(2, '6', 1350.00, 1, 2020, '2025-08-30 16:34:00', 'Ordered', 'Aaron Aranas', '09533591578', 'aranasaaron04@gmail.com', 'Yumbing', '32'),
(3, '6', 1350.00, 1, 1350, '2025-08-30 16:37:03', 'Ordered', 'Aaron Aranas', '09533591578', 'aranasaaron04@gmail.com', 'Yumbing', '32'),
(4, '6', 1350.00, 1, 1350, '2025-08-30 16:40:14', 'Ordered', 'Aaron Aranas', '09533591578', 'aranasaaron04@gmail.com', 'Yumbing', '32'),
(5, '9', 500.00, 1, 500, '2025-08-30 16:42:38', 'Ordered', 'Aaron Aranas', '09533591578', 'aranasaaron04@gmail.com', 'Yumbing', '32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shoe`
--

CREATE TABLE `tbl_shoe` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_shoe`
--

INSERT INTO `tbl_shoe` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(3, 'Running Shoes', 'Better than Great', 745.00, 'Shoe_1730296072.jpg', 1, 'Yes', 'Yes'),
(4, 'Classic White Sneakers', 'Comfortable and stylish white sneakers for everyday wear.', 780.00, 'Shoe_1730337997.jpg', 1, 'Yes', 'Yes'),
(5, 'Chunky Dad Sneakers', 'Bold, oversized sneakers with a thick sole, perfect for trendy streetwear.', 670.00, 'Shoe_1730338148.jpg', 1, 'Yes', 'Yes'),
(6, 'Trainers', 'High-Performance Trainers', 1350.00, 'trainers2_.jpg', 3, 'Yes', 'Yes'),
(8, 'High-Performance Runners', 'Engineered with advanced cushioning and support for intense running sessions.', 1200.00, 'Shoe_1730296072.jpg', 1, 'Yes', 'Yes'),
(9, 'Black Loafers', 'Old Classical Style', 500.00, 'Shoe_1730861313.jpg', 2, 'Yes', 'Yes'),
(11, 'Nizza RF ', 'adidas Womens Nizza RF Platform Shoe', 1200.00, 'plaformshoes.jpg', 4, 'Yes', 'Yes'),
(12, 'Womens Nizza Platform Trainers', 'adidas Originals Womens Nizza Platform Trainers Core White/​Core White/​Frozen Green', 1300.00, 'shoegreen.jpg', 4, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `email`, `password`) VALUES
(1, 'aaron', 'userexample@gmail.com', '$2y$10$/PEGpBtrgtqI7LU.BcSfi..1C3JyNzybVG03doyX6kB9COVorlC2y'),
(3, 'Landlord', 'userexample@gmail.com', '$2y$10$vuD1GU/ZhbSZXJtFAaZOXeOpl1TsaX4qBznCiyO.8gCowYhfLuPAC'),
(6, 'vince', 'user@example.com', '$2y$10$bN.dhkfY/Bp0DrHYzYgbIeJT2eYMBh9pFuFH.o.DCXEe5vMH0oO7e'),
(9, 'shawn', 'iuser@example.com', '$2y$10$3izbsRdjgzPwgGp/Jhow3.AvSuT8PsB.xAIiG8lv4Afjszg23GG1u'),
(10, 'aaron04', 'userexample1@gmail.com', '$2y$10$cHeldhbtmD4oR9FZ4U0T8eJKyVEKGQDn6NoQN6VYcnF6xyD600wr2'),
(12, 'user', 'userexample3@gmail.com', '$2y$10$zQi8uPt6OVGmMdEs6weVO.tYANSBYyg72xxL8LDocBIHtGb4JJztW'),
(13, 'aaron123', 'userexample23@gmail.com', '$2y$10$CtrAa1hqaP/uevBW1ZmQYukDjBOFfqBAVmfvb.6/gAmMlojGJctzy'),
(14, '123', 'adminarea12@gmail.c0m', '$2y$10$91dvYuRrgn5W/zZuQP/J.OF/9ISMi1skKdY2EeONvnYiqE3EAvoBu'),
(15, 'example', 'adminarea1@gmail.c0m', '$2y$10$2T8mOHt0q7aVTRXYvuJ5J.FOmbPh9stQBGfzUWay/NHe9KZZr8/UG'),
(16, 'sample', 'sample@gmail.com', '$2y$10$dZjsBKJjxHNnfFbKebQFHutk.BR8Hb4dQugfX59lgL4q/AYXL1H2.'),
(18, 'coelen', 'coelensample@gmail.com', '$2y$10$3szH6jq4gzw7sMuZ6e/13e2EAUI.CXFN0.07GrvuwVfw7mxPMCBa2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shoe`
--
ALTER TABLE `tbl_shoe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_shoe`
--
ALTER TABLE `tbl_shoe`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
