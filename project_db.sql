-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 05:39 PM
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
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `username` varchar(100) NOT NULL,
  `from_to` varchar(100) DEFAULT NULL,
  `departure_arrival` varchar(100) DEFAULT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `type` varchar(9) DEFAULT NULL,
  `time_of_purchase` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`username`, `from_to`, `departure_arrival`, `price`, `type`, `time_of_purchase`) VALUES
('RAIYAN', 'DHAKA-CHITTAGONG', '11:00 PM - 06:00 AM', 700.00, 'Economy', '2024-06-21 21:38:03');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_info`
--

CREATE TABLE `ticket_info` (
  `from_to` varchar(100) NOT NULL,
  `departure_arrival` varchar(100) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `type` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_info`
--

INSERT INTO `ticket_info` (`from_to`, `departure_arrival`, `price`, `type`) VALUES
('DHAKA-CHITTAGONG', '11:00 PM - 06:00 AM', 999.00, 'Business'),
('DHAKA-CHITTAGONG', '11:00 PM - 06:00 AM', 700.00, 'Economy'),
('DHAKA-CHITTAGONG', '11:00 PM - 06:00 AM', 1200.00, 'VIP'),
('DHAKA-RAJSHAHI', '11:00 PM - 05:00 AM', 600.00, 'Business'),
('DHAKA-RAJSHAHI', '11:00 PM - 05:00 AM', 400.00, 'Economy'),
('DHAKA-RAJSHAHI', '11:00 PM - 05:00 AM', 1000.00, 'VIP'),
('DHAKA-RANGPUR', '11:00 PM - 08:00 AM', 800.00, 'Business'),
('DHAKA-SYLHET', '8:00 AM - 01:00 AM', 700.00, 'Business'),
('DHAKA-SYLHET', '8:00 AM - 01:00 AM', 500.00, 'Economy'),
('DHAKA-SYLHET', '8:00 AM - 01:00 AM', 998.00, 'VIP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `cpass` varchar(20) DEFAULT NULL,
  `phone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `pass`, `cpass`, `phone`) VALUES
('ADMIN', 'ADMIN', 'ADMIN', 111111111),
('RAIYAN', '12', '12', 1300775307);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`username`,`time_of_purchase`),
  ADD KEY `from_to` (`from_to`,`departure_arrival`,`type`);

--
-- Indexes for table `ticket_info`
--
ALTER TABLE `ticket_info`
  ADD PRIMARY KEY (`from_to`,`departure_arrival`,`type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`from_to`,`departure_arrival`,`type`) REFERENCES `ticket_info` (`from_to`, `departure_arrival`, `type`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
