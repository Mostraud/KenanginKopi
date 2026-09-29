-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 10:39 AM
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
-- Database: `kenanginkopi`
--

-- --------------------------------------------------------

--
-- Table structure for table `coffee`
--

CREATE TABLE `coffee` (
  `CoffeeID` char(5) NOT NULL,
  `CoffeeName` varchar(50) NOT NULL,
  `CoffeeDesc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coffee`
--

INSERT INTO `coffee` (`CoffeeID`, `CoffeeName`, `CoffeeDesc`) VALUES
('C001', 'Ice Latte', 'Just a normal ice latte'),
('C002', 'Grimshake Coffee', 'Grimshake with coffee'),
('C003', 'Coffeeless Coffee', 'Coffee without coffee'),
('C7596', 'Kopi Asli Ngawi', 'rasakan kopi baru khas ngawi.');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `StoreID` char(5) NOT NULL,
  `StoreName` varchar(50) NOT NULL,
  `StoreLocation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`StoreID`, `StoreName`, `StoreLocation`) VALUES
('S742', 'Kopi Asli Indo', 'Bandung'),
('S896', 'kopi asli jawa', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `storecoffee`
--

CREATE TABLE `storecoffee` (
  `StoreID` char(5) NOT NULL,
  `CoffeeID` char(5) NOT NULL,
  `Price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storecoffee`
--

INSERT INTO `storecoffee` (`StoreID`, `CoffeeID`, `Price`) VALUES
('S742', 'C7596', 16700.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactiondetails`
--

CREATE TABLE `transactiondetails` (
  `TransactionID` char(5) NOT NULL,
  `CoffeeID` char(5) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Subtotal` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactiondetails`
--

INSERT INTO `transactiondetails` (`TransactionID`, `CoffeeID`, `Qty`, `Subtotal`) VALUES
('T3630', 'C7596', 1, 16700.00),
('T6363', 'C7596', 2, 33400.00),
('T7913', 'C7596', 3, 50100.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` char(5) NOT NULL,
  `UserID` char(5) DEFAULT NULL,
  `StoreID` char(5) DEFAULT NULL,
  `TransactionDate` date NOT NULL,
  `TotalPrice` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransactionID`, `UserID`, `StoreID`, `TransactionDate`, `TotalPrice`) VALUES
('T3630', 'U0002', 'S742', '2025-12-06', 16700.00),
('T6363', 'U0002', 'S742', '2025-12-06', 33400.00),
('T7913', 'U0002', 'S742', '2025-12-06', 50100.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` char(5) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(50) NOT NULL,
  `UserPassword` varchar(100) NOT NULL,
  `UserRole` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `UserName`, `UserEmail`, `UserPassword`, `UserRole`) VALUES
('U0001', 'Super Admin', 'admin123', 'admin@kenanginkopi.com', 'Admin123', 'Admin'),
('U0002', 'Alvin User', 'alvin', 'alvin@email.com', 'User123', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coffee`
--
ALTER TABLE `coffee`
  ADD PRIMARY KEY (`CoffeeID`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`StoreID`);

--
-- Indexes for table `storecoffee`
--
ALTER TABLE `storecoffee`
  ADD PRIMARY KEY (`StoreID`,`CoffeeID`),
  ADD KEY `CoffeeID` (`CoffeeID`);

--
-- Indexes for table `transactiondetails`
--
ALTER TABLE `transactiondetails`
  ADD PRIMARY KEY (`TransactionID`,`CoffeeID`),
  ADD KEY `CoffeeID` (`CoffeeID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `StoreID` (`StoreID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserEmail` (`UserEmail`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `storecoffee`
--
ALTER TABLE `storecoffee`
  ADD CONSTRAINT `storecoffee_ibfk_1` FOREIGN KEY (`StoreID`) REFERENCES `store` (`StoreID`) ON DELETE CASCADE,
  ADD CONSTRAINT `storecoffee_ibfk_2` FOREIGN KEY (`CoffeeID`) REFERENCES `coffee` (`CoffeeID`) ON DELETE CASCADE;

--
-- Constraints for table `transactiondetails`
--
ALTER TABLE `transactiondetails`
  ADD CONSTRAINT `transactiondetails_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `transactions` (`TransactionID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactiondetails_ibfk_2` FOREIGN KEY (`CoffeeID`) REFERENCES `coffee` (`CoffeeID`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`StoreID`) REFERENCES `store` (`StoreID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
