-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 09:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelancer`
--

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `buyer_email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pricing` decimal(10,2) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `buyer_email`, `title`, `description`, `pricing`, `picture_path`, `created_at`, `updated_at`) VALUES
(9, 'bilalzhd0@gmail.com', 'Website Designing', 'I will create a website for you', 10.10, '../assets/images/service_pictures/promo-docs.jpeg', '2023-12-20 16:44:01', '2023-12-20 16:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `address`, `phone`, `country`, `bio`, `password`, `profile_picture`) VALUES
(3, 'Bilal Zahid', 'bilalzhd0@gmail.com', 'seller', 'House No. 20/16, Street No.3 Near Hafiz General Store, Kareem Town, Hilal Road, People\'s Colony No', '03132979209', '', 'Hello world', '$2y$10$X3nt9cEyGHnAEoj9fvOZwOw4s8IrDtnd6lRbqvpHr9/ayUcuTI7Ki', '../assets/images/uploads/promo-docs.jpeg'),
(6, 'Ahmed Afzal', 'ahmedafz1437@gmail.com', 'buyer', 'abc street', '0301110220', '', 'Hello world', '$2y$10$3VR3Plh6hH5le5oYA8JWNOWbvi/WJY6AYL6HcnbjSegiklO0W6sMq', ''),
(7, 'admin', 'admin@freelancer.com', 'admin', 'abc street', '00', 'usa', 'Admin', '$2y$10$94XXfDxu6XtM2d2TZG9iKezUkug4wYkZCADg.Y9A3qaI6H8LASOkm', './assets/images/uploads/admin.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services`
--
ALTER TABLE `services`
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
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
