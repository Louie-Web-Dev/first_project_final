-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 10:19 AM
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
-- Database: `first_project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory_in`
--

CREATE TABLE `inventory_in` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `toner_model` varchar(255) NOT NULL,
  `quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_in`
--

INSERT INTO `inventory_in` (`id`, `supplier`, `department`, `toner_model`, `quantity`) VALUES
(1, 'INKRITE', 'Parts Counter', 'CF226X', 25),
(2, 'ERBM', 'Sales Admin', 'CF226X', 13),
(3, 'INKRITE', 'Sales Training', 'CF226X', 6),
(4, 'INKRITE', 'Tsure', 'CF226X', 2),
(5, 'INKRITE', 'Tool Room', 'CC388X', 4),
(6, 'ERBM', 'Finance and Accounting', 'CF226X', 5),
(7, 'INKRITE', 'Service', 'CF226X', 7),
(8, 'ERBM', 'Service', 'CF226X', 1),
(9, 'INKRITE', 'Finance and Accounting', 'CF226X', 3),
(12, 'INKRITE', 'Finance and Accounting', 'CF226X', 5);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_out`
--

CREATE TABLE `inventory_out` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `toner_model` varchar(255) NOT NULL,
  `used_quantity` int(3) NOT NULL,
  `date_added` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_out`
--

INSERT INTO `inventory_out` (`id`, `supplier`, `department`, `toner_model`, `used_quantity`, `date_added`) VALUES
(7, 'INKRITE', 'Parts Counter', 'CF226X', 1, '2025-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_request`
--

CREATE TABLE `inventory_request` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `quantity` int(3) NOT NULL,
  `date_added` varchar(255) NOT NULL,
  `toner_model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_request`
--

INSERT INTO `inventory_request` (`id`, `full_name`, `supplier`, `department`, `quantity`, `date_added`, `toner_model`) VALUES
(7, 'Junnel Villaraza', 'INKRITE', 'Parts Counter', 1, '2025-06-30', 'CF226X');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transaction`
--

CREATE TABLE `inventory_transaction` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `toner_model` varchar(255) NOT NULL,
  `quantity` int(2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_transaction`
--

INSERT INTO `inventory_transaction` (`id`, `supplier`, `department`, `toner_model`, `quantity`, `date_added`) VALUES
(1, 'INKRITE', 'Parts Counter', 'CF226X', 26, '2025-07-04'),
(2, 'ERBM', 'Sales Admin', 'CF226X', 13, '2025-07-04'),
(3, 'INKRITE', 'Sales Training', 'CF226X', 6, '2025-07-04'),
(4, 'INKRITE', 'Tsure', 'CF226X', 2, '2025-07-04'),
(5, 'INKRITE', 'Tool Room', 'CC388X', 4, '2025-07-04'),
(6, 'ERBM', 'Finance and Accounting', 'CF226X', 5, '2025-07-04'),
(7, 'INKRITE', 'Service', 'CF226X', 7, '2025-07-04'),
(8, 'ERBM', 'Service', 'CF226X', 1, '2025-07-04'),
(9, 'INKRITE', 'Finance and Accounting', 'CF226X', 3, '2025-07-04'),
(12, 'INKRITE', 'Finance and Accounting', 'CF226X', 5, '2025-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `birthday`, `usertype`, `status`, `username`) VALUES
(1, 'Admin, Firstname MI.', 'Admin123@gmail.com', '$2y$10$DVjnLK6PeJT8FSl3zFL0eOuWuGNPXI.tGx29fRrXVygseln3eaCri', '0000-00-00', 'admin', 'enabled', 'admin123'),
(25, 'John wick', 'johnwick123@gmail.com', '$2y$10$nBNfxfUasvd1uRozzDxDO.8fMNKt1Pm3Q3SHsTPsDy83kRNIMllzq', NULL, 'admin', 'enabled', 'John123'),
(26, 'Sample', '', '$2y$10$4GILyGPODw1GY5u6T3nEHum2pKxJcBtIF3j.jf2I2rDkphHvb9JhO', NULL, 'admin', '', 'Usersample');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_in`
--
ALTER TABLE `inventory_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_out`
--
ALTER TABLE `inventory_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_request`
--
ALTER TABLE `inventory_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_transaction`
--
ALTER TABLE `inventory_transaction`
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
-- AUTO_INCREMENT for table `inventory_in`
--
ALTER TABLE `inventory_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventory_out`
--
ALTER TABLE `inventory_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_request`
--
ALTER TABLE `inventory_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_transaction`
--
ALTER TABLE `inventory_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
