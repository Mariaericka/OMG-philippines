-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2023 at 09:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omgph`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `fullname`, `password`) VALUES
(4, 'pipi', 'mariaerickatoledo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(5, 'admin', 'Taylor Swift', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `applicant_id` int(200) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` int(200) NOT NULL,
  `position` varchar(250) NOT NULL,
  `startdate` varchar(250) NOT NULL,
  `img` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`applicant_id`, `firstname`, `lastname`, `email`, `phone`, `position`, `startdate`, `img`) VALUES
(11, 'ericka', 'toledo', 'pipi123@gmail.com', 999999, 'main dancer', 'aug 10 2024', 'ekkemr.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `priceR` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `size` enum('regular','large') NOT NULL DEFAULT 'regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `priceR`, `quantity`, `image`, `size`) VALUES
(2, 2, 1, 'caramel macchiato', 120, 95, 1, 'caramel macchiato1.png', 'regular'),
(3, 2, 2, 'regular caramel macchiato', 120, 0, 1, 'caramel macchiato1.png', 'regular'),
(62, 3, 1, 'caramel macchiato', 120, 0, 2, 'caramel macchiato1.png', 'regular'),
(63, 3, 6, 'Coffee Crumble', 80, 0, 2, 'coffee crumble4.png', 'regular'),
(64, 3, 3, 'Mocha', 80, 0, 1, 'mocha3.png', 'regular'),
(65, 3, 2, 'Cappucino', 80, 0, 1, 'cappucino2.png', 'large');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `subject`, `name`, `email`, `number`, `message`) VALUES
(3, 1, 'hallo', 'admin', 'ericka.toledo123@gmail.com', '09957820411', 'hiiii');

-- --------------------------------------------------------

--
-- Table structure for table `omg_categories`
--

CREATE TABLE `omg_categories` (
  `category_id` int(200) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `category_img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `omg_categories`
--

INSERT INTO `omg_categories` (`category_id`, `category_name`, `category_img`) VALUES
(1, 'coffee series', ''),
(2, 'yogurt', ''),
(3, 'choco', ''),
(4, 'milktea', ''),
(5, 'mango', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `status` varchar(255) DEFAULT 'Pending',
  `cancel_reason` text DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `qty`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `status`, `cancel_reason`, `order_id`) VALUES
(35, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 2) - Cappucino (80 x 1)', 640, '2023-08-04', 'pending', 'Cancelled', 'kasi malayo', '3-1691120285'),
(36, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 2) - Cappucino (80 x 1)', 640, '2023-08-04', 'pending', 'Pending', NULL, NULL),
(37, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 2) - Cappucino (80 x 1)', 640, '2023-08-04', 'pending', 'Pending', NULL, NULL),
(38, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 1)', 240, '2023-08-04', 'pending', 'Pending', NULL, NULL),
(39, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 1)', 240, '2023-08-04', 'pending', 'Pending', NULL, NULL),
(40, 3, 'monkey d luffy', '0922222222', 'parkerericka5@gmail.com', 0, 'gcash', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300', 'caramel macchiato (120 x 1)', 240, '2023-08-04', 'pending', 'Pending', NULL, '3-1691122916');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `priceR` int(10) NOT NULL,
  `description` text NOT NULL,
  `size` varchar(50) NOT NULL DEFAULT 'Regular',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `priceR`, `description`, `size`, `image`) VALUES
(1, 'caramel macchiato', 'coffee series', 120, 120, 'large caramel goodness', 'Regular', 'caramel macchiato1.png'),
(2, 'Cappucino', 'coffee series', 80, 95, 'regular ', 'Regular', 'cappucino2.png'),
(3, 'Mocha', 'coffee series', 80, 110, 'Creamy Mocha ', 'Regular', 'mocha3.png'),
(6, 'Coffee Crumble', 'coffee series', 80, 110, 'divine fusion of rich coffee flavors and delightful cookie crunch', 'Regular', 'coffee crumble4.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(1, 'admin', 'pipi123@gmail.com', '0999999999', 'c22b5f9178342609428d6f51b2c5af4c0bde6a42', ''),
(2, 'Maria Ericka Toledo', 'ericka.toledo123@gmail.com', '0995782041', 'aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d', ''),
(3, 'monkey d luffy', 'parkerericka5@gmail.com', '0922222222', '466f24c901815ee277161f3c74282cd26e780794', '604 16 de agosto, 131, pasay, metro manila, metro manila, philippines , 1300');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`applicant_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `omg_categories`
--
ALTER TABLE `omg_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `applicant_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `omg_categories`
--
ALTER TABLE `omg_categories`
  MODIFY `category_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
