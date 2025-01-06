-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 05:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeforgo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `adminName` varchar(45) NOT NULL,
  `adminUsername` varchar(45) NOT NULL,
  `adminPassword` varchar(45) NOT NULL,
  `adminPhoneNum` varchar(45) NOT NULL,
  `adminEmail` varchar(45) NOT NULL,
  `adminType` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminUsername`, `adminPassword`, `adminPhoneNum`, `adminEmail`, `adminType`) VALUES
(1, 'eiman', 'admin', '123', '0182906167', '2021466508@student.uitm.edu.my', 'ADMIN'),
(2, 'Izzuddin', 'izz', 'izz', '0169263679', 'izzfathi03@gmail.com', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `coffee`
--

CREATE TABLE `coffee` (
  `coffeeID` int(11) NOT NULL,
  `coffeeName` varchar(45) NOT NULL,
  `coffeePrice` decimal(15,2) NOT NULL,
  `coffeeType` varchar(45) NOT NULL,
  `coffeeDesc` varchar(45) NOT NULL,
  `coffeeOrigin` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custID` int(11) NOT NULL,
  `custUsername` varchar(45) NOT NULL,
  `custPassword` varchar(45) DEFAULT NULL,
  `custPhoneNum` varchar(45) DEFAULT NULL,
  `custEmail` varchar(45) DEFAULT NULL,
  `custAddress` varchar(255) DEFAULT NULL,
  `custStatus` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custID`, `custUsername`, `custPassword`, `custPhoneNum`, `custEmail`, `custAddress`, `custStatus`) VALUES
(2, 'hehe', '123', '123', 'lyrien_anx@yahoo.com', 'a', 'ACTIVE'),
(3, 'izz', '$2y$10$5x2JINSSMiOfOlm5n2ln8ujZEq0Pz87LuJXLOw', '4123', 'izz@gmail.com', 'b', 'ACTIVE'),
(4, 'damien2033', '2003', '5123412312', 'damieneiman@gmail.com', 'c', 'ACTIVE'),
(5, 'test', '$2y$10$eabLDaBl/zA56mqjkDWFD.sfGqHKRR/tjC4DlC', '1023123213', 'lyrien_anx@yahoo.com', 'd', 'ACTIVE'),
(6, 'hoho', '123', '123', '2021466508@student.uitm.edu.my', '31, Jalan 7/2 , Taman Padi Emas, Tanjong Karang , 45500 , Selangor.', 'ACTIVE'),
(7, 'wan', '$2y$10$ojbe8g8uFpUaSM5ZDDR8oOSDwIFC938zGR0ZrL', '1213123', 'damda@gmail.com', '21, Jalan 7/2 , Taman Padi Emas, Tanjong Karang , ', 'ACTIVE'),
(8, '123', '$2y$10$qr5IhQc0yepbTOOR.K8bduEFgLhZ1dDdIbcA0l', '123', '123@gmail.com', '321', 'ACTIVE'),
(9, 'Udin', '$2y$10$nWKZuaosKP1pnz5bnPimeeFiHpkPiTMATzpGzR', '0169263679', 'izzuddinfathi0@gmail.com', 'taman asma', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `order details`
--

CREATE TABLE `order details` (
  `orderDetailsID` int(11) NOT NULL,
  `orderQty` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `coffeeID` int(11) NOT NULL,
  `pastryID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `orderTime` datetime NOT NULL,
  `orderStatus` varchar(25) NOT NULL,
  `custID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pastry`
--

CREATE TABLE `pastry` (
  `pastryID` int(11) NOT NULL,
  `pastryName` varchar(45) NOT NULL,
  `pastryPrice` varchar(45) NOT NULL,
  `pastryDesc` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `Tender` decimal(2,0) NOT NULL,
  `TotalPrice` decimal(2,0) NOT NULL,
  `Balance` decimal(2,0) NOT NULL,
  `orderID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `coffee`
--
ALTER TABLE `coffee`
  ADD PRIMARY KEY (`coffeeID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `order details`
--
ALTER TABLE `order details`
  ADD PRIMARY KEY (`orderDetailsID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `coffeeID` (`coffeeID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `pastryID` (`pastryID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `pastry`
--
ALTER TABLE `pastry`
  ADD PRIMARY KEY (`pastryID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `orderID` (`orderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coffee`
--
ALTER TABLE `coffee`
  MODIFY `coffeeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order details`
--
ALTER TABLE `order details`
  MODIFY `orderDetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pastry`
--
ALTER TABLE `pastry`
  MODIFY `pastryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order details`
--
ALTER TABLE `order details`
  ADD CONSTRAINT `order details_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`),
  ADD CONSTRAINT `order details_ibfk_2` FOREIGN KEY (`coffeeID`) REFERENCES `coffee` (`coffeeID`),
  ADD CONSTRAINT `order details_ibfk_3` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `order details_ibfk_4` FOREIGN KEY (`pastryID`) REFERENCES `pastry` (`pastryID`),
  ADD CONSTRAINT `order details_ibfk_5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `customer` (`custID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
