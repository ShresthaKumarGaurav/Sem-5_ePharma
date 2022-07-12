-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2020 at 07:06 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `about`) VALUES
(1, 'Nepal Jadibuti Corp', 'Jadibuti Prali'),
(2, 'Niko', 'Nepali Brand'),
(4, 'Patanjali Foundation', 'Ayurvedic medicines and ointments'),
(6, 'Ayurveda', 'Ayurvedic and natural medicines that cure naturally');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `item_price` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `item_name`, `item_price`, `item_quantity`, `total`, `bill`) VALUES
(1, 'Paracetamol', 150, 12, 1800, 0),
(3, 'Cotton', 30, 11, 330, 0),
(4, 'Mask', 20, 41, 820, 0),
(6, 'Cough Syrup', 100, 31, 3100, 0),
(7, 'ENO', 90, 10, 900, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Cetamol', 'Used for common headaches and common fevers'),
(2, 'Acidity Regulator', 'Beneficial for acidity cure'),
(5, 'Ointment', 'Ointments are for external use only '),
(7, 'Syrup', 'Syrups are liquid medicines'),
(8, 'Balm', 'Balm are joint / muscle pain relief ointments'),
(9, 'Pain Killer', 'Relieves pain'),
(10, 'Analgesic', 'Analgesic medicines'),
(11, 'Vitamin', 'Vitamins are important elements for our body.'),
(12, 'Goods', 'Accessories used for firt aid / medical purposes');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `area` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`area`) VALUES
('Asan'),
('Swayambhu'),
('Lubhu'),
('Lagankhel'),
('Naikap'),
('Kalanki'),
('Gongabu'),
('Gaushala'),
('Chababhil'),
('Jorpati'),
('Godawari');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `buyer` text NOT NULL,
  `product_name` text NOT NULL,
  `seller` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_no` int(11) DEFAULT NULL,
  `payment_type` text NOT NULL,
  `paid` int(11) NOT NULL,
  `delivery_receiver` text NOT NULL,
  `delivery_address` text NOT NULL,
  `contact` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(20) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `completed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `pid`, `buyer`, `product_name`, `seller`, `price`, `quantity`, `total_price`, `order_no`, `payment_type`, `paid`, `delivery_receiver`, `delivery_address`, `contact`, `timestamp`, `transaction_id`, `image_path`, `completed`) VALUES
(1, 4, 'shrestha', 'Mask', '', 1, 15, 15, 1, 'esewa', 1, '', '', 0, '2020-11-16 15:21:06', '', 'images/prescription/7.jpg', 2),
(24, 3, 'shrestha', 'Cotton', '', 30, 10, 300, 4, 'cod', 0, 'sample', 'maitidevi', 2147483647, '2020-11-17 04:04:55', 'null', NULL, 2),
(25, 4, 'shrestha', 'Mask', 'Ram Pharmacy', 20, 20, 400, 4, 'cod', 0, 'sample', 'maitidevi', 2147483647, '2020-11-17 04:04:55', 'null', NULL, 0),
(32, 6, 'shrestha', 'Cough Syrup', 'Ram Pharmacy', 100, 10, 1000, 5, 'cod', 0, 'sample', 'naikap', 2147483647, '2020-11-18 06:38:35', 'null', 'images/prescription/10.jpg', 1),
(33, 4, 'shrestha', 'Mask', 'Ram Pharmacy', 20, 20, 400, 4, 'cod', 0, 'sample', 'maitidevi', 2147483647, '2020-11-17 04:04:55', 'null', NULL, 2),
(34, 6, 'shrestha', 'Cough Syrup', 'Ram Pharmacy', 100, 11, 1100, 6, 'cod', 0, 'final test', 'final adrres', 2147483647, '2020-11-18 10:29:08', 'null', 'images/prescription/6.jpg', 0),
(35, 3, 'qwerty', 'Cotton', 'Sample Pharmacy', 30, 11, 330, 7, 'cod', 0, 'testing', 'testing', 2147483647, '2020-11-18 12:27:14', 'null', 'images/prescription/7.jpg', 2),
(36, 4, 'qwerty', 'Mask', 'Ram Pharmacy', 20, 24, 480, 7, 'cod', 0, 'testing', 'testing', 2147483647, '2020-11-18 12:27:14', 'null', 'images/prescription/7.jpg', 2),
(37, 4, 'qwerty', 'Mask', 'Ram Pharmacy', 20, 10, 200, 8, 'esewa', 1, 'test', 'test', 2147483647, '2020-11-18 12:30:46', '0000K6C', 'images/prescription/8.jpg', 0),
(38, 7, 'shresthaa', 'ENO', 'Ram Pharmacy', 90, 10, 900, 9, 'esewa', 1, 'sample', 'sample', 2147483647, '2020-11-19 04:32:30', '0000K7W', 'images/prescription/9.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `username` varchar(30) NOT NULL,
  `otpcode` int(11) NOT NULL,
  `timestamp` bigint(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`username`, `otpcode`, `timestamp`) VALUES
('shrestha', 481427, 1605760679);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `vendor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `registration_number` text NOT NULL,
  `district` text NOT NULL,
  `address` text NOT NULL,
  `contact` bigint(20) NOT NULL,
  `owner` text NOT NULL,
  `license` varchar(255) NOT NULL,
  `pan` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `verification` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`id`, `name`, `registration_number`, `district`, `address`, `contact`, `owner`, `license`, `pan`, `status`, `verification`, `created_at`) VALUES
(1, 'Ram Pharmacy', '4545848845', 'Kathmandu', 'Jorpati', 9800000000, 'shahid', '', '', 1, 1, '2020-11-18 16:18:01'),
(2, 'Hamro Pharmacy', '4545645456456', '', '', 0, '', '', '', 0, 0, '2020-07-26 16:20:30'),
(45, 'Sample Pharmacy', '45458488455', 'Kathmandu', 'Asan', 9800000021, 'sampleeeee', 'images/document/sampleeeee_license.jpg', 'images/document/sampleeeee_pan.jpg', 1, 0, '2020-11-17 07:49:21'),
(47, 'One Piece De pharmacy', '4545848845556', 'Kathmandu', 'Godawari', 9800000000, 'testinggg', 'images/document/testinggg_license.jpg', 'images/document/testinggg_pan.jpg', 1, 1, '2020-11-18 15:59:23'),
(48, 'Test Pharmacy', '60545455', '', 'Kalimati', 1, 'finaltest', '', '', 1, 1, '2020-11-19 00:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` text NOT NULL,
  `brand` text NOT NULL,
  `pharmacy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `price`, `stock`, `category`, `brand`, `pharmacy_id`) VALUES
(1, 'Paracetamol', 'images/product/1.jpg', 150, 56, 'Cetamol', 'Niko', 45),
(3, 'Cotton', 'images/product/2.jpg', 30, 50, 'Goods', 'Nepal Jadibuti Corp', 0),
(4, 'Mask', 'images/product/3.jpg', 20, 60, 'Goods', 'Niko', 1),
(6, 'Cough Syrup', 'images/product/5.jpg', 100, 53, 'Syrup', 'Niko', 1),
(7, 'ENO', 'images/product/6.jpg', 90, 70, 'Acidity Regulator', 'Ayurveda', 1),
(13, 'Patanjali Balm', 'images/product/7.jpg', 50, 60, 'Balm', 'Patanjali Foundation', 45),
(15, 'Glycerine', 'images/product/8.jpg', 150, 59, 'Ointment', 'Nepal Jadibuti Corp', 2),
(16, 'Vicks VapoRub', 'images/product/9.jpg', 80, 35, 'Ointment', 'Nepal Jadibuti Corp', 1),
(21, 'Aloe Vera Gel', 'images/product/17.jpg', 20, 70, 'Ointment', 'Patanjali Foundation', 0),
(22, 'Pantop', 'images/product/22.jpg', 120, 87, 'Acidity Regulator', 'Niko', 1),
(23, 'Vitamin B-complex', 'images/product/23.jpg', 160, 50, 'Vitamin', 'Ayurveda', 48);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `pname` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `seller` text NOT NULL,
  `buyer` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `pid`, `pname`, `quantity`, `total`, `seller`, `buyer`, `timestamp`) VALUES
(4, 6, 'Cough Syrup', 12, 240, '', 'Cough Syrup', '2020-11-18 04:49:15'),
(7, 6, 'Cough Syrup', 10, 200, 'Ram Pharmacy', 'shrestha', '2020-11-18 09:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `dob` date NOT NULL,
  `gender` text NOT NULL,
  `password` text NOT NULL,
  `area` text NOT NULL,
  `district` text NOT NULL,
  `contact` bigint(11) NOT NULL,
  `email` text NOT NULL,
  `transaction_code` int(11) NOT NULL,
  `status` int(11) DEFAULT 1,
  `verification` int(11) DEFAULT 0,
  `usertype` text NOT NULL,
  `admin_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `middlename`, `lastname`, `dob`, `gender`, `password`, `area`, `district`, `contact`, `email`, `transaction_code`, `status`, `verification`, `usertype`, `admin_id`, `created_at`) VALUES
(1, 'shrestha', 'Gaurav', '', 'Shrestha', '1999-03-09', 'male', 'e67ed91b512d4579faed79c9dd162f35', 'Asan', 'Lalitpur', 9860484232, 'shresthagaurav3@gmail.com', 0, 1, 1, 'SuperAdmin', 0, '2020-11-19 01:50:03'),
(2, 'shahid', 'Shahid', '', 'Rehman', '1995-05-16', 'male', '5e8ff9bf55ba3508199d22e984129be6', 'Kalimati', 'Kathmandu', 9812345678, 'shahid@gmail.com', 0, 1, 1, 'Admin', 1, '2020-11-19 01:26:36'),
(27, 'qwerty', 'KIWI', '', '', '0000-00-00', '', '7694f4a66316e53c8cdd9d9954bd611d', '', '', 0, '', 0, 1, 1, 'Buyer', 0, '2020-11-19 01:28:36'),
(62, 'sampleeeee', 'sample', 'sample', 'sample', '2019-01-01', 'male', '7694f4a66316e53c8cdd9d9954bd611d', 'Asan', 'Kathmandu', 9800000021, 'shresthag@gmail.com', 0, 1, 1, 'Admin', 45, '2020-11-19 01:28:51'),
(63, 'testingg', 'monkey', 'd...', 'luffy', '2016-01-01', 'male', '7694f4a66316e53c8cdd9d9954bd611d', 'Asan', 'Kathmandu', 9800000028, 'shresth@gmail.com', 0, 1, 1, 'Buyer', 0, '2020-11-19 01:28:55'),
(64, 'testinggg', 'tesster', '', 'tester', '2017-01-31', 'male', '7694f4a66316e53c8cdd9d9954bd611d', 'Asan', 'Kathmandu', 9800000000, 'shres@gmail.com', 0, 1, 1, 'Admin', 47, '2020-11-19 01:29:00'),
(65, 'finaltest', 'final', '', 'finasl', '2020-01-01', 'male', '2a1585a864d9e67627c6ae04c807a2c5', 'Asan', 'Kathmandu', 9812345678, 'tesdt@test.com', 0, 1, 1, 'Admin', 48, '2020-11-19 01:29:19'),
(69, 'okayyyyyy', 'test', '', 'tesdt', '2020-01-01', 'male', '25d55ad283aa400af464c76d713c07ad', 'Asan', 'Lalitpur', 9800000006, 'shresthagaurav3@gmail.com', 0, 1, 1, 'Buyer', 0, '2020-11-19 01:50:40'),
(70, 'shresthaa', 'sample', '', 'sample', '2019-12-01', 'male', '25d55ad283aa400af464c76d713c07ad', 'Asan', 'Kathmandu', 9800000001, 'shresthagaurav3@gmail.com', 0, 1, 1, 'Buyer', 0, '2020-11-19 04:29:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
