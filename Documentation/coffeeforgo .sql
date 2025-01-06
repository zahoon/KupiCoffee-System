-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2023 at 06:24 PM
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
CREATE DATABASE IF NOT EXISTS `coffeeforgo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `coffeeforgo`;

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
(2, 'Izzuddin', 'izz', 'izz', '0169263679', 'izzfathi03@gmail.com', 'ADMIN'),
(3, 'wan', 'wan', 'wan', '123', 'wan@gmail.com', 'STAFF');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `quantity` int(50) NOT NULL,
  `custUsername` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custUsername` varchar(45) NOT NULL,
  `custPassword` varchar(255) DEFAULT NULL,
  `custPhoneNum` varchar(45) DEFAULT NULL,
  `custEmail` varchar(45) DEFAULT NULL,
  `custAddress` varchar(255) DEFAULT NULL,
  `custStatus` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custUsername`, `custPassword`, `custPhoneNum`, `custEmail`, `custAddress`, `custStatus`) VALUES
(' wannaqib', '$2y$10$9zidikJiT.gWLDpFLRDsHuJ3QpIud4/84g.uAuX4aMgNbuc1U0KdC', '+60134658283', 'wmdnaqib@gmail.com', 'Jengka', 'ACTIVE'),
('aman ', '$2y$10$IBavLgqkgFQBGIJGrmMmtefMFWAbrlDNq8lH/QobVkfMNq88SgFPm', '0111458650', 'aman@gmail.com', 'jjalan tun', 'ACTIVE'),
('Eifwwat ', '$2y$10$HkOnvByyZLUQmJL3DO0e3OKRjgQ5cjKJhDQOoZZxzptRDOyoenaRe', '0121321334', 'Eifwwat@gmail.com', 'IM 14 ', 'DEACTIVATED'),
('hehe ', '$2y$10$bsBD2kG.Vw1pZQlayt0r.epLdbRT0jqxY05/tSgZnsxNBLUGYj/KO', '+60182906167', 'hehe@gmail.com', '131313131', 'ACTIVE'),
('hohoho ', '$2y$10$fOQEFQ6kdxCK2yOvnndrCuuGWpYIxxmlfryqX5AAy.dadexoqBhiO', '123123123213', 'hehe@gmail.com', '111, Jalan 7/2 , Taman Padi Emas, Tanjong Karang , 45500 , Selangor.', 'ACTIVE'),
('Izz', '$2y$10$TCJX/qopxCj.3eEE3dkcSuPphtgW/8RhBaTETsdar6UZJ1cmf7LSC', '60169263670', 'izzuddinfathi0@gmail.com', 'Kota Kemuning', 'ACTIVE'),
('naqib ', '$2y$10$IfwPkzTIVlIN9sioSt37uOpJ.4NsLFjx4.aqJvYVwHRJIr3fBblaC', '0123456789', 'naqib@gmail.com', 'jengka', 'ACTIVE'),
('testis ', '$2y$10$E5mCU1luZkT/MdJvhuX/Ke4pkHXIUQamfniSZ.8aDGYjnqOrwhrRC', '312313213213', 'testis@gmail.com', '25252, Jalan 7/2 , Taman Padi Emas, Tanjong Karang , 45500 , Selangor.', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menuID` int(11) NOT NULL,
  `menuType` varchar(10) NOT NULL,
  `menuName` varchar(50) NOT NULL,
  `menuPrice` decimal(4,2) NOT NULL,
  `menuDesc` varchar(750) NOT NULL,
  `menuStatus` varchar(15) NOT NULL,
  `menuImage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menuID`, `menuType`, `menuName`, `menuPrice`, `menuDesc`, `menuStatus`, `menuImage`) VALUES
(32435, 'PASTRY', 'Vanilla Chocolate Twist', '11.90', 'Why settle for one when you can have both! Our Vanilla Chocolate Twist suppresses the yin and yang of the vanilla custard filling and chocolate chips in its rich, buttery and flaky dough.', 'AVAILABLE', 'VANILLA_CHOCOLATE_TWIST.png'),
(36695, 'COFFEE', 'Espresso', '11.90', 'A standard Italian Espresso pulled through 9 bars of pressure & 91ºC of water.  The medium-dark roast gives hints of dark chocolate, salted caramel and a smokey aftertaste.  ZUS Blend is a 100% Specialty Grade Arabica hand-crafted blend consisting of Brazil, Papua New Guinea & Indonesia Single Origin Beans.  This ZUS blend exhibits captivating aroma, toasty, caramel flavours, low acidity, and creamy mouthfeel with a dark cocoa aftertaste.', 'AVAILABLE', 'ESPRESSO_FRAPPE.png'),
(44263, 'PASTRY', 'Chocolate Danish Roll', '9.90', 'A multi-layered, laminated sweet pastry filled with irresistible chocolate. This Danish roll is sure to cure your sweet tooth cravings.', 'AVAILABLE', 'CHOCOLATE_DANISH_ROLL.png'),
(103252, 'FRAPPE', 'Java Chip Frappé', '15.90', 'The all-time favourite of every frappé lover! A must-have in every frappé menu! Java Chip Frappé has now landed in ZUS Coffee. Get your fix of coffee & chocolate chips ice blended anytime, any day!  (Whipped cream is not served for delivery)  *Disclaimer: Whipped Cream Drizzle contains Butterly Pea Flower and is not recommended for pregnant/breastfeeding women. Kindly consume at your own risk.', 'AVAILABLE', 'JAVA_CHIP_FRAPPE.png'),
(125027, 'PASTRY', 'Chicken Slice & Cheese Croissant', '11.90', 'Croissants, the pride and symbol of French breakfast! This buttery and cheesy delight is the epitome of a great brunch. Combining parmesan, mozzarella and cheddar cheese with our secret white sauce and generously seasoned meatloaf, you’d wonder how a single Croissant can hold this much flavour!', 'AVAILABLE', 'CHICKEN_SLICE_CHEESE_CROISSANT.png'),
(134207, 'FRAPPE', 'Espresso Frappé', '15.90', 'The Classic Coffee Frappé. For the serious coffee drinker that is looking for a little fun, this double shot espresso frappé is the perfect drink to turn that scowl upside down.  (Whipped cream is not served for delivery)  *Disclaimer: Whipped Cream Drizzle contains Butterly Pea Flower and is not recommended for pregnant/breastfeeding women. Kindly consume at your own risk.', 'AVAILABLE', 'ESPRESSO_FRAPPE.png'),
(140721, 'PASTRY', 'Chocolate Fudge Cake', '14.90', 'Have you ever had such amazing chocolate that you blackout from all its goodness? That’s what you’ll experience with our Chocolate Fudge Cake!', 'AVAILABLE', 'CHOCOLATE_FUDGE_CAKE.png'),
(234506, 'PASTRY', 'Burnt Cheesecake', '15.00', 'Don’t be intimidated by its burnt top because it’s the best part of this dessert! Tastes like caramelised cheesecake with a beautiful burnt exterior and super creamy interior.', 'UNAVAILABLE', 'BURNT_CHEESECAKE.png'),
(314723, 'COFFEE', 'Café Mocha', '13.90', 'This mixture of chocolate & coffee has won the hearts of many.  For rich dessert lovers. Crafted with 100% Australian Chocolate (40% Cocoa).', 'AVAILABLE', 'MOCHA.png'),
(366572, 'HOT MEALS', 'Chicken Lasagna', '14.90', 'Sink your fork into our ZUS Premium Signature Lasagna, where every bite is out-of-this-world, much like you’re flying First Class!  Just imagine the creamy, cheesy and delicious mixture of chicken mixed with irresistible, savoury, bolognese sauce. 😋', 'AVAILABLE', 'MEAT_LASAGNA.png'),
(376529, 'FRAPPE', 'Salted Caramel Frappé', '15.90', 'A salty-sweet treat that is made better when ice is blended to perfection. There’s nothing basic about loving a classic Salted Caramel Frappé.  (Whipped cream is not served for delivery)  *Disclaimer: Whipped Cream Drizzle contains Butterly Pea Flower and is not recommended for pregnant/breastfeeding women. Kindly consume at your own risk.', 'AVAILABLE', 'SALTED_CARAMEL_FRAPPE.png'),
(395211, 'PASTRY', 'Apple Lattice', '7.00', 'This popular golden pastry has stolen hearts with its delicious apple filling and flaky exterior. As you bite down, the sound of crumbling pastry hits the ears, before a gush of sweet apple floods the tongue, tingling all your taste buds.', 'AVAILABLE', 'APPLE_LATTICE.png'),
(479742, 'COFFEE', 'Salted Caramel Latté', '12.00', 'For those who like their coffee on the milky side with an extra sweetness. Crafted with 100% Authentic French Syrup.  DID YOU KNOW?  “MONIN uses only pure essence of each ingredient in the creation of their syrups.”  This traditional Latte infused with Monin Gourmet French Syrup is for those who like their coffee with a bit more', 'AVAILABLE', 'SALTED_CARAMEL_LATTE.png'),
(480300, 'PASTRY', 'Double Chocolate Muffin', '8.90', 'Double the chocolate, double the droolicious!  Layered with gooey chocolate fudge, perfect to satisfy all your chocolate cravings.', 'AVAILABLE', 'CHOCOLATE_MUFFIN.png'),
(642125, 'HOT MEALS', 'Test', '12.00', 'Test', 'AVAILABLE', 'REAL.png'),
(649339, 'COFFEE', 'Cappucino', '11.00', 'Like drinking delicious coffee bubbles, for those who enjoy it extra foamy.  With lesser milk & more foam, if you like your coffee strong, the Cappuccino is the way to go.', 'AVAILABLE', 'CAPPUCINO.png'),
(790131, 'COFFEE', 'Americano', '8.00', 'A shot of Espresso gently poured over the water, retaining the crema of the Espresso and the aroma of the coffee. For those who enjoy taking their time.', 'AVAILABLE', 'AMERICANO.png'),
(799016, 'PASTRY', 'Banana Walnut Muffin', '8.90', 'The taste of the tropics from banana and crunchiness of walnuts; there’s a muffin for everyone!', 'AVAILABLE', 'BANANA_WALNUT_MUFFIN.png'),
(805751, 'COFFEE', 'Green Tea Latté', '10.90', 'The cup that everyone knows and loves. Blended with Pure Green Tea, fused with Milk, & Organic Sweetener.  DID YOU KNOW?  “Green Tea Latte contains no coffee. Green Tea Latte = Green Tea with Milk.”', 'AVAILABLE', 'GREEN_TEA_LATTE.png'),
(833497, 'PASTRY', 'Chicken Sausage Roll', '11.90', 'Add a bit of spice to your regular sausage roll with this firecracker. Premium German sausage wrapped in imported Australian butter puff, this is the firecracker snack to tingle your taste buds at any time of the day.', 'AVAILABLE', 'CHICKEN_SAUSAGE_ROLL.png'),
(902404, 'FRAPPE', 'Japanese Matcha Frappé', '15.90', 'Take a trip to the cool weather of Japan with this ice-blended Japanese Matcha drink made from 100% authentic Japanese Matcha Powder. One sip of this will make true matcha fans squeal in delight.  (Whipped cream is not served for delivery)  *Disclaimer: Whipped Cream Drizzle contains Butterly Pea Flower and is not recommended for pregnant/breastfeeding women. Kindly consume at your own risk.', 'AVAILABLE', 'JAPANESE_MATCHA_FRAPPE.png'),
(973361, 'COFFEE', 'Cafe Latté', '10.90', 'For those who enjoy their coffee on the milky side.  Milk is frothed between temperatures of 69-72ºC, optimum to a Barista’s touch and akin to the temperature that is suitable for our customers to drink immediately upon serving.', 'AVAILABLE', 'LATTE.png');

-- --------------------------------------------------------

--
-- Table structure for table `order details`
--

CREATE TABLE `order details` (
  `orderDetailsID` int(11) NOT NULL,
  `orderQty` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order details`
--

INSERT INTO `order details` (`orderDetailsID`, `orderQty`, `orderID`, `menuID`) VALUES
(28, 1, 148068, 395211),
(29, 1, 148068, 314723),
(30, 1, 148068, 234506),
(31, 1, 148068, 36695),
(32, 1, 148068, 366572),
(33, 1, 995326, 36695),
(34, 1, 995326, 314723),
(35, 1, 873331, 36695),
(36, 1, 532903, 36695),
(37, 1, 532903, 314723),
(38, 1, 466299, 36695),
(39, 1, 466299, 314723),
(40, 1, 466299, 479742),
(41, 1, 818529, 36695),
(42, 1, 749022, 36695);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `orderDateTime` datetime NOT NULL,
  `orderStatus` varchar(25) NOT NULL,
  `adminID` int(11) NOT NULL,
  `orderType` varchar(10) NOT NULL,
  `orderBranch` varchar(255) NOT NULL,
  `custUsername` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `orderDateTime`, `orderStatus`, `adminID`, `orderType`, `orderBranch`, `custUsername`) VALUES
(148068, '2023-06-20 23:14:10', 'Ready', 1, 'Pickup', 'A3 Library Cafe – GF, Xiamen University Malaysia, Jalan Sunsuria, Bandar Sunsuria, 43900 Sepang, Selangor.', 'Izz'),
(466299, '2023-07-04 14:33:10', 'Pending', 4, 'Delivery', 'Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan', 'Izz'),
(532903, '2023-06-22 15:19:35', 'Ready', 1, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor', 'aman '),
(749022, '2023-07-16 22:57:21', 'Cancel', 1, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor', 'naqib '),
(818529, '2023-07-04 15:10:15', 'Cancel', 1, 'Delivery', 'Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan', 'Eifwwat '),
(873331, '2023-06-22 13:15:35', 'Pending', 4, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor', 'Izz'),
(995326, '2023-06-21 06:36:39', 'Pending', 4, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor', 'Izz');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `TotalPrice` decimal(4,2) NOT NULL,
  `orderID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `orderType` varchar(10) NOT NULL,
  `orderBranch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `TotalPrice`, `orderID`, `adminID`, `orderType`, `orderBranch`) VALUES
(9241, '16.90', 818529, 1, 'Delivery', 'Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan'),
(122249, '16.90', 749022, 1, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor'),
(349145, '42.80', 466299, 4, 'Delivery', 'Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan'),
(462000, '30.80', 532903, 1, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor'),
(474714, '30.80', 995326, 4, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor'),
(632332, '62.70', 148068, 1, 'Pickup', 'A3 Library Cafe – GF, Xiamen University Malaysia, Jalan Sunsuria, Bandar Sunsuria, 43900 Sepang, Selangor.'),
(650392, '16.90', 873331, 4, 'Delivery', '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `menuID` (`menuID`),
  ADD KEY `custUsername` (`custUsername`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custUsername`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menuID`);

--
-- Indexes for table `order details`
--
ALTER TABLE `order details`
  ADD PRIMARY KEY (`orderDetailsID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `menuID` (`menuID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `custUsername` (`custUsername`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `adminID` (`adminID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order details`
--
ALTER TABLE `order details`
  MODIFY `orderDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=998543;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`menuID`) REFERENCES `menu` (`menuID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`custUsername`) REFERENCES `customer` (`custUsername`);

--
-- Constraints for table `order details`
--
ALTER TABLE `order details`
  ADD CONSTRAINT `order details_ibfk_3` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `order details_ibfk_4` FOREIGN KEY (`menuID`) REFERENCES `menu` (`menuID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`custUsername`) REFERENCES `customer` (`custUsername`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
