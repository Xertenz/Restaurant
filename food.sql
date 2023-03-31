-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2023 at 12:56 AM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` tinyint NOT NULL,
  `username` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_german2_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator'),
(2, 'ahmed', '9193ce3b31332b03f7d8af056c692b84', 'Ahmed'),
(4, 'ali', '86318e52f5ed4801abe1d13d509443de', 'Ali'),
(6, 'sara', '5bd537fc3789b5482e4936968f0fde95', 'Sara'),
(7, 'maha', '06e3e081e1aa695794835cdd6a62ea1e', 'Maha');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_german2_ci DEFAULT NULL,
  `featured` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_german2_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(1, 'Carbohydrates', '1662609541-1-carbohydrates.jpg', 'Yes', 'Yes'),
(10, 'Candy', '1662609616-1-candy.jpg', 'No', 'Yes'),
(12, 'Meat', '1662610474-1-meat.jpeg', 'Yes', 'Yes'),
(13, 'Vegetable', '1662610678-1-vegetable.jpeg', 'Yes', 'No'),
(14, 'Fruits', '1662610737-1-fruits.jpeg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_german2_ci DEFAULT NULL,
  `price` float(10,2) NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_german2_ci DEFAULT NULL,
  `category_id` int NOT NULL,
  `featured` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_german2_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(3, 'Fish', 'This is just a fried fish', 12.00, '1662611316-1-fish.jpg', 12, 'Yes', 'Yes'),
(7, 'Pizza', 'This Is Pizza Food', 20.00, '1662489745-1-pizza.jpg', 1, 'No', 'No'),
(8, 'Tomato', 'Tomato best kind', 4.00, '1662611577-1-tomato.jpg', 13, 'Yes', 'Yes'),
(9, 'Hamburger', 'Hamburger with many extensions', 2.00, '1662611750-1-hamburger.jpg', 12, 'No', 'Yes'),
(10, 'Banana', 'A kilo of banana', 2.00, '1662612023-1-banana.jpg', 14, 'Yes', 'No'),
(11, 'Beef', 'A kilo of beef', 5.00, '1662612348-1-beef.jpg', 12, 'Yes', 'Yes'),
(12, 'Orange', '', 1.50, '1662612693-1-orange.jpg', 14, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `food` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `price` float NOT NULL,
  `quantity` float NOT NULL,
  `total` float NOT NULL,
  `date` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `customer_contact` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb3_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_german2_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
