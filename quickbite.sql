-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 08:34 PM
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
-- Database: `quickbite`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_order` (IN `order_id` INT(11))   BEGIN
	SELECT orh.orh_refcode AS reference_code, CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name, s.s_name AS shop_name,f.f_name AS food_name,ord.ord_buyprice AS buy_price, ord.ord_amount AS amount ,ord.ord_note AS order_note, orh.orh_ordertime AS order_time , orh.orh_pickuptime AS pickup_time
    FROM order_header orh 
    INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE orh.orh_id = order_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_order_history` (IN `customer_id` INT(11))   BEGIN
	SELECT orh.orh_refcode AS reference_code, CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name,
    s.s_name AS shop_name, orh.orh_ordertime AS order_time, orh.orh_pickuptime AS pickup_time,
    p.p_amount AS order_cost, orh.orh_orderstatus AS order_status
    FROM order_header orh INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN payment p ON orh.p_id = p.p_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE c.c_id = customer_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shop_alltime_revenue` (IN `shop_id` INT(11))   BEGIN
	SELECT SUM(ord.ord_amount*ord.ord_buyprice) AS alltime_revenue 
    FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id INNER JOIN shop s ON s.s_id = orh.s_id
    WHERE s.s_id = shop_id AND orh.orh_orderstatus = 'FNSH';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `shop_menu_revenue` (IN `shop_id` INT(11))   BEGIN
	SELECT f.f_name AS food_name, SUM(ord.ord_amount*ord.ord_buyprice) AS menu_revenue
    FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    WHERE orh.s_id = shop_id AND orh.orh_orderstatus = 'FNSH'
    GROUP BY ord.f_id ORDER BY menu_revenue DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ct_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ct_amount` int(11) NOT NULL,
  `ct_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ct_id`, `c_id`, `s_id`, `f_id`, `ct_amount`, `ct_note`) VALUES
(169, 34, 1, 54, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `c_username` varchar(45) NOT NULL,
  `c_pwd` varchar(45) NOT NULL,
  `c_firstname` varchar(45) NOT NULL,
  `c_lastname` varchar(45) NOT NULL,
  `c_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_username`, `c_pwd`, `c_firstname`, `c_lastname`, `c_email`) VALUES
(29, 'diyaa', 'Shenoy@123', 'diya', 'shenoy', 'diya@gmail.com'),
(34, 'samridhi', 'Password@123', 'Samridhi', 'S', 'samridhi@gmail.com'),
(35, 'shraddha', 'Password@123', 'Shraddha', 'Naik', 'shraddha@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `s_id` int(11) NOT NULL,
  `feedback` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`s_id`, `feedback`) VALUES
(1, 'The food was good. '),
(1, 'The juice counter is unhygienic . There are flies and dead lizards around the counter.'),
(2, 'The sandwich and biryani is really good.\r\n'),
(2, 'Please increase the stock of samosa and vadapav'),
(1, 'it was good'),
(1, 'egg fried rice was not there.'),
(1, 'very nice'),
(2, 'shit '),
(1, 'guddi rp iykyk'),
(1, 'eww horrible');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `f_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `f_price` decimal(6,2) NOT NULL,
  `f_todayavail` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Food is available to order or not',
  `f_preorderavail` tinyint(4) NOT NULL DEFAULT 1,
  `f_pic` text DEFAULT NULL,
  `f_quantity` int(11) DEFAULT 0,
  `is_special` tinyint(4) NOT NULL DEFAULT 0,
  `veg_nveg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`f_id`, `s_id`, `f_name`, `f_price`, `f_todayavail`, `f_preorderavail`, `f_pic`, `f_quantity`, `is_special`, `veg_nveg`) VALUES
(1, 1, 'Half Meals', 27.00, 1, 1, '1_1.png', 139, 0, 0),
(49, 1, 'Full Meals', 37.00, 1, 1, '49_1.jpeg', 99, 0, 0),
(50, 1, 'Chicken Biryani', 82.00, 1, 1, '50_1.jpeg', 72, 0, 1),
(51, 1, 'Gobi Manchurian', 67.00, 1, 0, '51_1.jpg', 54, 0, 0),
(52, 1, 'Chicken Manchurian', 78.00, 1, 0, '52_1.jpeg', 37, 0, 1),
(53, 1, 'Chicken 65', 87.00, 1, 0, '53_1.jpeg', 50, 0, 1),
(54, 1, 'Chicken Momos', 110.00, 1, 0, '54_1.jpeg', 29, 0, 1),
(55, 1, 'Brownie', 80.00, 1, 1, '55_1.jpeg', 16, 0, 0),
(56, 1, 'Egg Fried Rice', 65.00, 1, 0, '56_1.png', 43, 0, 1),
(57, 1, 'Veg noodles', 55.00, 1, 1, '57_1.jpg', 72, 0, 0),
(58, 1, 'Triple rice', 110.00, 1, 0, '58_1.jpeg', 74, 0, 1),
(60, 2, 'Egg Biryani', 80.00, 1, 1, '60_2.jpg', 98, 0, 1),
(61, 2, 'Paneer Biryani', 75.00, 1, 1, '61_2.jpg', 37, 0, 0),
(62, 2, 'Mushroom Biryani', 75.00, 1, 1, '62_2.jpg', 65, 0, 0),
(63, 2, 'Veg Biryani', 70.00, 1, 1, '63_2.jpg', 83, 0, 0),
(64, 2, 'Schezwan Fried Rice', 75.00, 1, 1, '64_2.jpg', 53, 0, 0),
(65, 2, 'Veg Fried Rice', 55.00, 1, 1, '65_2.jpg', 35, 0, 0),
(66, 2, 'Chicken Fried Rice', 75.00, 1, 1, '66_2.jpg', 43, 0, 1),
(67, 2, 'Egg Fried Rice', 65.00, 1, 1, '67_2.jpg', 53, 0, 1),
(68, 2, 'Half meals', 50.00, 1, 1, '68_2.jpg', 76, 0, 0),
(69, 2, 'Chicken Biryani', 110.00, 1, 1, '69_2.jpg', 76, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `ord_id` int(11) NOT NULL,
  `orh_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ord_amount` int(11) NOT NULL,
  `ord_buyprice` decimal(6,2) NOT NULL COMMENT 'To keep the snapshot of selected menu cost at the time of the purchase.',
  `ord_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`ord_id`, `orh_id`, `f_id`, `ord_amount`, `ord_buyprice`, `ord_note`) VALUES
(96, 86, 1, 3, 27.00, ''),
(97, 86, 49, 1, 37.00, ''),
(98, 86, 50, 2, 82.00, ''),
(99, 87, 1, 1, 27.00, ''),
(100, 87, 56, 1, 65.00, ''),
(101, 87, 51, 2, 67.00, ''),
(102, 87, 55, 1, 80.00, ''),
(103, 88, 1, 2, 27.00, ''),
(104, 89, 1, 2, 27.00, ''),
(105, 90, 54, 3, 110.00, ''),
(106, 91, 1, 1, 27.00, ''),
(107, 92, 50, 1, 82.00, ''),
(108, 93, 1, 2, 27.00, ''),
(109, 94, 55, 3, 80.00, ''),
(110, 95, 58, 2, 110.00, ''),
(111, 96, 57, 4, 55.00, ''),
(112, 97, 51, 2, 67.00, ''),
(113, 98, 52, 3, 78.00, ''),
(114, 99, 56, 4, 65.00, ''),
(115, 100, 54, 3, 110.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_header`
--

CREATE TABLE `order_header` (
  `orh_id` int(11) NOT NULL,
  `orh_refcode` varchar(15) DEFAULT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `orh_ordertime` timestamp NOT NULL DEFAULT current_timestamp(),
  `orh_pickuptime` datetime NOT NULL,
  `orh_orderstatus` varchar(10) NOT NULL DEFAULT 'ACPT',
  `orh_finishedtime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_header`
--

INSERT INTO `order_header` (`orh_id`, `orh_refcode`, `c_id`, `s_id`, `p_id`, `orh_ordertime`, `orh_pickuptime`, `orh_orderstatus`, `orh_finishedtime`) VALUES
(86, 'b5ff83ca7c53755', 34, 1, 84, '2024-12-26 07:00:54', '2024-12-26 12:30:00', 'FNSH', '2024-12-26 17:40:39'),
(87, '2af602a1a05fd2d', 34, 1, 85, '2024-12-26 07:05:47', '2024-12-26 12:35:00', 'FNSH', '2024-12-26 17:40:42'),
(88, '7e0fe11bd31c5b6', 34, 1, 86, '2024-12-26 07:14:31', '2024-12-26 12:44:00', 'FNSH', '2024-12-26 17:40:43'),
(89, 'e61fcb48e5bf7f8', 34, 1, 87, '2024-12-26 07:15:53', '2024-12-26 12:45:00', 'FNSH', '2024-12-26 17:40:44'),
(90, 'e4f123007fc148b', 34, 1, 88, '2024-12-26 07:17:27', '2024-12-26 12:47:00', 'FNSH', '2024-12-26 17:40:45'),
(91, '5277594c380544a', 34, 1, 89, '2024-12-26 07:18:42', '2024-12-26 12:48:00', 'FNSH', '2024-12-26 17:40:46'),
(92, 'f0bb7dedab25726', 34, 1, 90, '2024-12-26 07:20:13', '2024-12-26 12:50:00', 'FNSH', '2024-12-26 17:40:47'),
(93, '478f7ecf1c498cd', 34, 1, 91, '2024-12-26 08:06:23', '2024-12-26 13:36:00', 'FNSH', '2024-12-26 17:40:48'),
(94, '7935d68a0ca9e99', 34, 1, 92, '2024-12-26 08:08:48', '2024-12-26 13:38:00', 'FNSH', '2024-12-26 17:40:49'),
(95, 'e4b7b1af91751cc', 34, 1, 93, '2024-12-26 08:11:47', '2024-12-26 13:41:00', 'FNSH', '2024-12-26 17:40:50'),
(96, '43cdd6394dff1b3', 34, 1, 94, '2024-12-26 08:14:57', '2024-12-26 13:44:00', 'FNSH', '2024-12-26 17:40:51'),
(97, '2aaf65d4a08bba4', 34, 1, 95, '2024-12-26 08:16:02', '2024-12-26 13:48:00', 'FNSH', '2024-12-26 17:40:52'),
(98, '535ebda913ab975', 34, 1, 96, '2024-12-26 08:17:16', '2024-12-26 13:51:00', 'RDPK', '0000-00-00 00:00:00'),
(99, '7f344f22532d349', 34, 1, 97, '2024-12-26 08:17:56', '2024-12-26 13:51:00', 'PREP', '0000-00-00 00:00:00'),
(100, 'e53025c4513edf9', 34, 1, 98, '2024-12-26 08:18:44', '2024-12-26 13:52:00', 'ACPT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `p_type` varchar(45) NOT NULL,
  `p_amount` decimal(7,2) NOT NULL,
  `p_detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `c_id`, `p_type`, `p_amount`, `p_detail`) VALUES
(84, 34, 'offline', 282.00, ''),
(85, 34, 'offline', 306.00, ''),
(86, 34, 'offline', 54.00, ''),
(87, 34, 'offline', 54.00, ''),
(88, 34, 'offline', 330.00, ''),
(89, 34, 'offline', 27.00, ''),
(90, 34, 'offline', 82.00, ''),
(91, 34, 'offline', 54.00, ''),
(92, 34, 'offline', 240.00, ''),
(93, 34, 'offline', 220.00, ''),
(94, 34, 'offline', 220.00, ''),
(95, 34, 'offline', 134.00, ''),
(96, 34, 'offline', 234.00, ''),
(97, 34, 'offline', 260.00, ''),
(98, 34, 'offline', 330.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `s_id` int(11) NOT NULL,
  `s_username` varchar(45) NOT NULL,
  `s_pwd` varchar(45) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_location` varchar(100) NOT NULL,
  `s_openhour` time NOT NULL,
  `s_closehour` time NOT NULL,
  `s_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Shop ready for taking an order or not (True for open, False for close)',
  `s_preorderStatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Shop is ready for tomorrow pre-order or not',
  `s_email` varchar(100) NOT NULL,
  `s_phoneno` varchar(45) NOT NULL,
  `s_pic` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`s_id`, `s_username`, `s_pwd`, `s_name`, `s_location`, `s_openhour`, `s_closehour`, `s_status`, `s_preorderStatus`, `s_email`, `s_phoneno`, `s_pic`) VALUES
(1, 'canteen', '123', 'Canteen', '', '07:00:00', '21:00:00', 1, 1, 'canteen@gmail.com', '9646445620', 'canteen.jpg'),
(2, 'mess', '123', 'Mess', 'Unit #1', '07:00:00', '21:00:00', 1, 1, 'sit@gmail.com', '8097651438', 'mess.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ct_id`),
  ADD KEY `fk_ct_c_idx` (`c_id`),
  ADD KEY `fk_ct_s_idx` (`s_id`),
  ADD KEY `fk_ct_f_idx` (`f_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_username` (`c_username`),
  ADD UNIQUE KEY `c_email` (`c_email`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `food_shop_s_id_idx` (`s_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `fk_orh_ord_idx` (`orh_id`),
  ADD KEY `fk_f_ord_idx` (`f_id`);

--
-- Indexes for table `order_header`
--
ALTER TABLE `order_header`
  ADD PRIMARY KEY (`orh_id`),
  ADD KEY `fk_orh_idx` (`c_id`),
  ADD KEY `fk_s_orh_idx` (`s_id`),
  ADD KEY `fk_p_orh_idx` (`p_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_c_fk_idx` (`c_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `order_header`
--
ALTER TABLE `order_header`
  MODIFY `orh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_ct_c` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ct_f` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ct_s` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_food_shop_id` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_f_ord` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orh_ord` FOREIGN KEY (`orh_id`) REFERENCES `order_header` (`orh_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_header`
--
ALTER TABLE `order_header`
  ADD CONSTRAINT `fk_c_orh` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_p_orh` FOREIGN KEY (`p_id`) REFERENCES `payment` (`p_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_s_orh` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_p_c` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
