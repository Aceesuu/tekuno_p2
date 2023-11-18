-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 06:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tekuno_p2`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `admin_id`, `role`, `action`, `timestamp`) VALUES
(21, 7, 'Admin', 'logged in', '2023-11-17 16:57:07'),
(22, 7, 'Admin', 'logged out', '2023-11-17 16:57:16'),
(23, 10, 'Inventory Manager', 'logged in', '2023-11-17 16:57:31'),
(24, 10, 'Inventory Manager', 'logged out', '2023-11-17 16:57:36'),
(25, 11, 'Order Manager', 'logged in', '2023-11-17 16:57:47'),
(26, 11, 'Order Manager', 'logged out', '2023-11-17 16:57:51'),
(27, 9, 'Customer Management', 'logged in', '2023-11-17 16:57:59'),
(28, 9, 'Customer Management', 'logged out', '2023-11-17 16:58:03'),
(29, 7, 'Admin', 'logged in', '2023-11-17 16:58:36'),
(32, 7, 'Admin', 'added product: aaaa', '2023-11-17 17:09:29'),
(33, 7, 'Admin', 'updated product: testtt', '2023-11-17 17:12:29'),
(34, 7, 'Admin', 'deleted product: 1122', '2023-11-17 17:13:43'),
(35, 7, 'Admin', 'deleted product: 1123', '2023-11-17 17:14:05'),
(36, 7, '', 'deleted product: aaaa', '2023-11-17 17:16:50'),
(37, 7, 'Admin', 'added product: dnss', '2023-11-17 17:19:12'),
(38, 7, 'Admin', 'added product: ds', '2023-11-17 17:19:40'),
(39, 7, '', 'deleted product: dnss', '2023-11-17 17:20:15'),
(40, 7, 'Admin', 'deleted product: ds', '2023-11-17 17:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `phone`, `email`, `message`) VALUES
(5, 'Jas', 'Clores', '09120562356', 'jas@gmail.com', 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `moving_average_tbl`
--

CREATE TABLE `moving_average_tbl` (
  `year` int(11) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `monthly_sales` float DEFAULT NULL,
  `month_numeric` double DEFAULT NULL,
  `moving_average` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moving_average_tbl`
--

INSERT INTO `moving_average_tbl` (`year`, `month`, `monthly_sales`, `month_numeric`, `moving_average`) VALUES
(2023, 'September', 528, 9, 578.333),
(2023, 'October', 458, 10, NULL),
(2023, 'November', 749, 11, NULL),
(2023, 'December', 684, NULL, 823),
(2024, 'January', 572, NULL, 1256),
(2024, 'February', 655, NULL, 1416),
(2024, 'March', 635, NULL, 1471),
(2024, 'April', 510, NULL, 786);

-- --------------------------------------------------------

--
-- Table structure for table `order_onsite`
--

CREATE TABLE `order_onsite` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NULL DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_onsite`
--

INSERT INTO `order_onsite` (`order_id`, `order_date`, `product_id`, `name`, `price`, `qty`, `subtotal`, `discount`, `total_price`) VALUES
(125, '2023-11-17 09:02:09', 1060, 'PVC Hose Coupling', 25.00, 1, 25.00, 0, 25.00),
(204, '2023-11-11 14:34:58', 1059, 'Ordinary PVC Faucet', 20.00, 2, 40.00, 0, 40.00),
(252, '2023-11-14 12:49:32', 1060, 'PVC Hose Coupling', 25.00, 25, 625.00, 0, 625.00),
(306, '2023-11-12 07:44:39', 1060, 'PVC Hose Coupling', 25.00, 33, 825.00, 0, 825.00),
(374, '2023-11-17 08:44:29', 1059, 'Ordinary PVC Faucet', 20.00, 1, 20.00, 0, 20.00),
(448, '2023-11-11 14:34:27', 1059, 'Ordinary PVC Faucet', 20.00, 3, 60.00, 0, 60.00),
(454, '2023-11-03 12:08:52', 1051, 'Claw Hammer Wooden Handle', 150.00, 6, 900.00, 0, 900.00),
(475, '2023-11-09 21:57:27', 1061, 'PVC Clamp', 95.00, 12, 1140.00, 0, 1140.00),
(724, '2023-11-17 08:41:59', 1051, 'Claw Hammer Wooden Handle', 160.00, 1, 160.00, 0, 160.00),
(947, '2023-11-17 09:00:13', 1059, 'Ordinary PVC Faucet', 50.00, 1, 50.00, 0, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `variation` varchar(50) NOT NULL,
  `supplier_price` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`variation_id`, `product_id`, `name`, `variation`, `supplier_price`, `price`, `qty`) VALUES
(96, 1062, 'Goose Neck PVC Faucet', 'Horizontal Entrance', 0, 150.00, 0),
(97, 1062, 'Goose Neck PVC Faucet', 'Vertical Entrace', 0, 150.00, 0),
(98, 1064, 'Omega HD PVC Faucet Crown Handle', 'With Bib', 0, 105.00, 0),
(99, 1064, 'Omega HD PVC Faucet Crown Handle', 'Without Bib', 0, 80.00, 0),
(100, 1065, 'Omega HD PVC Faucet Lever Handle ', 'With Bib', 0, 95.00, 0),
(101, 1065, 'Omega HD PVC Faucet Lever Handle ', 'Without Bib', 0, 70.00, 0),
(106, 1082, 'Coco Lumber', '2x2 cm', 25, 35.00, 50),
(107, 1082, 'Coco Lumber', '2x8 cm', 56, 66.00, 50),
(108, 1082, 'Coco Lumber', '2x10 cm', 70, 83.00, 50),
(109, 1082, 'Coco Lumber', '2x12 cm', 84, 100.00, 50),
(110, 1082, 'Coco Lumber', '2x3x8 cm', 102, 112.00, 50),
(111, 1082, 'Coco Lumber', '2x3x10 cm', 132, 140.00, 50),
(112, 1082, 'Coco Lumber', '2x3x12 cm', 155, 169.00, 50),
(113, 1087, 'Steel Bar', '9 mm', 95, 100.00, 50),
(114, 1087, 'Steel Bar', '10 mm', 135, 140.00, 40),
(115, 1087, 'Steel Bar', '12 mm', 212, 217.00, 40),
(116, 1087, 'Steel Bar', '16 mm ', 359, 364.00, 40),
(117, 1088, 'Hollow Blocks', 'Chv 4', 17, 19.00, 10),
(118, 1088, 'Hollow Blocks', 'Chv 5', 18, 22.00, 10),
(119, 1088, 'Hollow Blocks', 'Chv 6', 20, 25.00, 10),
(120, 1091, 'Nails (Per Kilo)', '1 inch', 90, 100.00, 100),
(121, 1091, 'Nails (Per Kilo)', '1/2 inches', 40, 50.00, 100),
(122, 1091, 'Nails (Per Kilo)', '2 inches', 50, 60.00, 100),
(123, 1091, 'Nails (Per Kilo)', '3 inches', 60, 70.00, 100),
(124, 1091, 'Nails (Per Kilo)', '4 inches', 60, 70.00, 100),
(125, 1048, 'PVC', '2 inches', 200, 250.00, 50),
(126, 1048, 'PVC', '3 inches', 300, 350.00, 50),
(127, 1048, 'PVC', '4 inches', 400, 450.00, 50),
(128, 1093, 'Elbow', '2 inches', 60, 80.00, 50),
(129, 1093, 'Elbow', '3 inches', 85, 113.00, 50),
(130, 1093, 'Elbow', '4 inches', 130, 150.00, 50),
(131, 1098, 'Shovel', 'Round', 200, 250.00, 20),
(132, 1098, 'Shovel', 'Square', 300, 450.00, 40),
(133, 1063, 'Blind Rivets (Per Box)', '1/8 ½ mm', 150, 180.00, 50),
(134, 1063, 'Blind Rivets (Per Box)', '1/8 ¾ mm', 170, 200.00, 60),
(135, 1099, 'Chicago Floor Strainer', 'Stainless', 70, 90.00, 55),
(136, 1099, 'Chicago Floor Strainer', 'Plastic', 20, 40.00, 45),
(137, 1057, 'Teflon Tape ', 'Small', 7, 15.00, 34),
(138, 1057, 'Teflon Tape ', 'Large', 10, 30.00, 35),
(139, 1060, 'PVC Hose Coupling', '3/4 inches', 25, 45.00, 55),
(140, 1060, 'PVC Hose Coupling', '5/8 inches', 35, 50.00, 68),
(141, 1100, 'Elbow Tee', '1/2 inches', 15, 20.00, 50),
(142, 1100, 'Elbow Tee', '3/4 inches', 20, 25.00, 55),
(143, 1061, 'PVC Clamp', 'Orange (Per Piece)', 5, 10.00, 30),
(144, 1061, 'PVC Clamp', 'Blue (Per Piece)', 5, 10.00, 60),
(145, 1061, 'PVC Clamp', 'Orange (Per Box 50pcs.)', 250, 500.00, 50),
(146, 1061, 'PVC Clamp', 'Blue (Per Box 50pcs.)', 250, 500.00, 50),
(147, 1059, 'Ordinary PVC Faucet', 'With Bib', 25, 50.00, 25),
(148, 1059, 'Ordinary PVC Faucet', 'Without Bib', 25, 50.00, 56),
(149, 1109, 'Sandflex Handsaw Blade ', '18-TPI', 40, 45.00, 79),
(150, 1109, 'Sandflex Handsaw Blade ', '24-TPI', 50, 55.00, 87),
(151, 1114, 'Paint Brush', '1/2 inches', 10, 15.00, 78),
(152, 1114, 'Paint Brush', '2 inches', 20, 25.00, 87),
(153, 1051, 'Claw Hammer Wooden Handle', 'metal', 100, 150.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `middleName` varchar(60) NOT NULL,
  `gender` varchar(60) NOT NULL,
  `contact` varchar(60) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(60) NOT NULL COMMENT 'Admin\r\nInventory Manager\r\nOrder Manager\r\nCustomer Management'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `lastName`, `firstName`, `middleName`, `gender`, `contact`, `image`, `email`, `password`, `role`) VALUES
(7, 'Estrera', 'Evalyn Grace', '', 'Female', '09123547811', 'eva.png', 'estrera.evalyngrace@gmail.com', '123456', 'Admin'),
(9, 'Puzo', 'Darwin', '', 'Male', '9123456789', '', 'darwinpuzo22@gmail.com', '123456', 'Customer Management'),
(10, 'Clores', 'Jasmin', '', 'Female', '09123456789', '', 'ksnjsmn@gmail.com', '123456', 'Inventory Manager'),
(11, 'Miñeque', 'Mhargielyn', '', 'Female', '09123456789', '', 'mhargielynmineque1@gmail.com', '123456', 'Order Manager');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cart`
--

CREATE TABLE `tb_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `variation` varchar(50) DEFAULT NULL,
  `subtotal` varchar(60) NOT NULL,
  `discount` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_cart`
--

INSERT INTO `tb_cart` (`cart_id`, `user_id`, `product_id`, `name`, `price`, `image`, `quantity`, `variation`, `subtotal`, `discount`) VALUES
(615, 1048, 1060, 'PVC Hose Coupling', 45.00, 'j1.png', 1, '3/4 inches', '45', '0'),
(616, 1048, 1108, 'Mansion Steel Brush', 69.00, 'mansion.JPG', 1, '', '69', '0'),
(617, 1045, 1111, 'Vice Grip Iron G Clam', 89.00, 'grip.JPG', 1, '', '89', '0'),
(634, 1075, 1060, 'PVC Hose Coupling', 45.00, 'j1.png', 1, '3/4 inches', '45', '0'),
(655, 1052, 1094, 'Utility Box', 30.00, 'utility box.png', 1, '', '30', '0'),
(656, 1052, 1051, 'Claw Hammer Wooden Handle', 150.00, 'claw.jpg', 5, 'metal', '750', '80'),
(657, 1080, 1082, 'Coco Lumber', 35.00, 'coco lumber.png', 5, '2x2 cm', '175', '62'),
(658, 1080, 1057, 'Teflon Tape ', 15.00, 't1.jpg', 3, 'Small', '45', '0'),
(659, 1047, 1082, 'Coco Lumber', 35.00, 'coco lumber.png', 1, '2x2 cm', '35', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(1, 'Plumbing Pipes & Accessories'),
(2, 'Electrical Pipes & Accessories'),
(3, 'Wood Products'),
(4, 'Steel Products'),
(5, 'Concreting & Masonry'),
(9, 'Hand Tools'),
(29, 'Electrical tools');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `variation` varchar(60) NOT NULL,
  `proof_image` varchar(255) NOT NULL,
  `order_status` varchar(20) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subtotal` varchar(60) NOT NULL,
  `discount` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`id`, `order_id`, `user_id`, `product_id`, `name`, `price`, `image`, `qty`, `variation`, `proof_image`, `order_status`, `order_date`, `subtotal`, `discount`) VALUES
(232, 830, 1044, 1051, 'Claw Hammer Wooden Handle', '160.00', 'claw.jpg', '1', '', '654a609e99593_aa.png', 'Complete', '2023-11-11 04:08:47', '160', '0'),
(233, 501, 1046, 1097, 'Grinding Disc', '50.00', 'grind.png', '1', '', '654a60d61ae15_download.jpg', 'Complete', '2023-10-04 16:11:00', '50', '0'),
(234, 501, 1047, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '1', '', '654a6100b4b1e_aa.png', 'Complete', '2023-09-11 16:11:00', '204', '0'),
(235, 501, 1047, 1092, 'PVC', '250.00', 'pvcc.jpg', '1', '', '654a6100b4b1e_aa.png', 'Complete', '2023-09-03 16:11:00', '250', '0'),
(236, 224, 1047, 1110, 'Wood Chisel', '74.00', 'wood.JPG', '1', '', '654a6124cabbe_aa.png', 'Complete', '2023-09-14 16:10:57', '74', '0'),
(238, 951, 1058, 1086, 'Bistay (Per Bucket)', '35.00', 'bistay.png', '1', '', '654a620fd0856_aa.png', 'Pending', '2023-11-07 16:13:03', '35', '0'),
(239, 951, 1058, 1095, 'Junction Box', '30.00', 'junction.jpg', '1', '', '654a620fd0856_aa.png', 'Pending', '2023-11-07 16:13:03', '30', '0'),
(240, 899, 1058, 1097, 'Grinding Disc', '50.00', 'grind.png', '3', '', '654a62256df5b_aa.png', 'Complete', '2023-11-07 16:16:46', '150', '0'),
(241, 481, 1058, 1108, 'Mansion Steel Brush', '69.00', 'mansion.JPG', '1', '', '654a623b9f4ce_receive.jpg', 'Cancelled', '2023-11-07 16:17:20', '69', '0'),
(243, 962, 1047, 1057, 'Teflon Tape ', '4.50', 't1.jpg', '2', '1/2', '654a63bcdd8ca_Screenshot_2023-11-06-16-29-15-57_0b2fce7a16bf2b728d6ffa28c8d60efb.jpg', 'Pending', '2023-11-07 16:20:12', '9', '0'),
(244, 962, 1047, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '1', '', '654a63bcdd8ca_Screenshot_2023-11-06-16-29-15-57_0b2fce7a16bf2b728d6ffa28c8d60efb.jpg', 'Complete', '2023-10-31 16:20:12', '204', '0'),
(245, 243, 1048, 1051, 'Claw Hammer Wooden Handle', '160.00', 'claw.jpg', '1', '', '654a696e10006_653b5391b2ad4_receive.jpg', 'To Ship', '2023-11-10 16:50:49', '160', '0'),
(246, 243, 1048, 1057, 'Teflon Tape ', '4.50', 't1.jpg', '1', '1/2', '654a696e10006_653b5391b2ad4_receive.jpg', 'To Ship', '2023-11-10 16:50:49', '4.5', '0'),
(247, 243, 1048, 1061, 'PVC Clamp', '10.00', 'pc.jpg', '1', 'Orange (Per Piece)', '654a696e10006_653b5391b2ad4_receive.jpg', 'To Ship', '2023-11-10 16:50:49', '10', '0'),
(248, 243, 1048, 1082, 'Coco Lumber', '35.00', 'coco lumber.png', '1', '2x2', '654a696e10006_653b5391b2ad4_receive.jpg', 'To Ship', '2023-11-10 16:50:49', '35', '0'),
(249, 243, 1048, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '1', '', '654a696e10006_653b5391b2ad4_receive.jpg', 'Complete', '2023-10-23 16:50:49', '204', '0'),
(250, 981, 1045, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '6', '', '654a6d53778c1_Screenshot_2023-11-06-16-29-15-57_0b2fce7a16bf2b728d6ffa28c8d60efb.jpg', 'Complete', '2023-10-09 17:14:07', '1224', '122.4'),
(251, 981, 1045, 1102, 'Elf Buhangin', '3000.00', 'elfbuha.jpg', '3', '', '654a6d53778c1_Screenshot_2023-11-06-16-29-15-57_0b2fce7a16bf2b728d6ffa28c8d60efb.jpg', 'Pending', '2023-11-11 14:31:16', '9000', '0'),
(258, 326, 1047, 1061, 'PVC Clamp', '10.00', 'pc.jpg', '4', 'Orange (Per Piece)', '654d2deb1ee87_receive.jpg', 'To Ship', '2023-11-16 17:52:56', '10', '0'),
(259, 326, 1047, 1088, 'Hollow Blocks', '19.00', 'hollow.png', '1', 'Chv 4', '654d2deb1ee87_receive.jpg', 'To Ship', '2023-11-16 17:52:56', '19', '0'),
(260, 326, 1047, 1096, 'Cutting Disc', '50.00', 'cd.png', '2', '', '654d2deb1ee87_receive.jpg', 'To Ship', '2023-11-16 17:52:56', '50', '0'),
(261, 326, 1047, 1086, 'Bistay (Per Bucket)', '35.00', 'bistay.png', '5', '', '654d2deb1ee87_receive.jpg', 'To Ship', '2023-11-16 17:52:56', '35', '0'),
(262, 326, 1047, 1088, 'Hollow Blocks', '22.00', 'hollow.png', '20', 'Chv 5', '654d2deb1ee87_receive.jpg', 'To Ship', '2023-11-16 17:52:56', '22', '0'),
(263, 875, 1048, 1082, 'Coco Lumber', '35.00', 'coco lumber.png', '1', '2x2', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '35', '0'),
(264, 875, 1048, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '204', '0'),
(265, 875, 1048, 1087, 'Steel Bar', '100.00', 'steelbar.png', '2', '9 mm', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '200', '0'),
(266, 875, 1048, 1089, 'Grava (Per Sack)', '45.00', 'Grava.jpg', '2', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '90', '0'),
(267, 875, 1048, 1090, 'GI Wire (Per Kilo)', '100.00', 'gi wire.png', '2', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '200', '0'),
(268, 875, 1048, 1092, 'PVC', '250.00', 'pvcc.jpg', '2', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '500', '0'),
(269, 875, 1048, 1094, 'Utility Box', '30.00', 'utility box.png', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '30', '0'),
(270, 875, 1048, 1097, 'Grinding Disc', '50.00', 'grind.png', '2', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '100', '0'),
(271, 875, 1048, 1099, 'Chicago Floor Strainer', '90.00', 'plassteel.jpg', '2', 'Stainless', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '180', '0'),
(272, 875, 1048, 1107, 'Cement Trowel ', '82.00', 'cement.JPG', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '82', '0'),
(273, 875, 1048, 1108, 'Mansion Steel Brush', '69.00', 'mansion.JPG', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '69', '0'),
(274, 875, 1048, 1109, 'Sandflex Handsaw Blade ', '45.00', 'sandflex.JPG', '1', '18-TPI', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '45', '0'),
(275, 875, 1048, 1111, 'Vice Grip Iron G Clam', '89.00', 'grip.JPG', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '89', '0'),
(276, 875, 1048, 1112, 'Standard Measuring Tape', '58.00', 'tape.JPG', '1', '', '654d2ecd0b8c8_receive.jpg', 'Pending', '2023-11-09 19:11:09', '58', '0'),
(277, 293, 1048, 1098, 'Shovel', '450.00', 'shov.jpg', '1', 'Square', '654d2f09301df_receive.jpg', 'To Receive', '2023-11-10 16:51:13', '450', '0'),
(278, 293, 1048, 1051, 'Claw Hammer Wooden Handle', '160.00', 'claw.jpg', '1', '', '654d2f09301df_receive.jpg', 'To Receive', '2023-11-10 16:51:13', '160', '0'),
(279, 254, 1046, 1060, 'PVC Hose Coupling', '50.00', 'j1.png', '2', '5/8 inches', '654d2f82bb5bc_receive.jpg', 'Pending', '2023-11-09 19:14:10', '100', '0'),
(280, 254, 1046, 1060, 'PVC Hose Coupling', '45.00', 'j1.png', '1', '3/4 inches', '654d2f82bb5bc_receive.jpg', 'Pending', '2023-11-09 19:14:10', '45', '0'),
(281, 254, 1046, 1083, 'Semento (Per Sack 40 Kilos)', '204.00', 'semento.png', '3', '', '654d2f82bb5bc_receive.jpg', 'Pending', '2023-11-09 19:14:10', '612', '0'),
(282, 161, 1046, 1091, 'Nails (Per Kilo)', '100.00', 'nails.jpg', '5', '1 inch', '654d2fcae82ac_receive.jpg', 'To Receive', '2023-11-10 17:38:52', '500', '50'),
(283, 161, 1046, 1100, 'Elbow Tee', '25.00', '3e64a49331d702f8be308d82b33386c7.jpg', '3', '3/4 inches', '654d2fcae82ac_receive.jpg', 'To Receive', '2023-11-10 17:38:52', '75', '0'),
(284, 793, 1049, 1082, 'Coco Lumber', '35.00', 'coco lumber.png', '3', '2x2 cm', '654d301e16af4_receive.jpg', 'Pending', '2023-11-09 19:16:46', '105', '0'),
(285, 793, 1049, 1082, 'Coco Lumber', '169.00', 'coco lumber.png', '10', '2x3x12 cm', '654d301e16af4_receive.jpg', 'Pending', '2023-11-09 19:16:46', '1690', '124'),
(286, 793, 1049, 1090, 'GI Wire (Per Kilo)', '100.00', 'gi wire.png', '3', '', '654d301e16af4_receive.jpg', 'Pending', '2023-11-09 19:16:46', '300', '0'),
(287, 496, 1049, 1089, 'Grava (Per Sack)', '45.00', 'Grava.jpg', '15', '', '654d3042f16a4_receive.jpg', 'Pending', '2023-11-09 19:17:22', '675', '67.5'),
(288, 603, 1050, 1082, 'Coco Lumber', '100.00', 'coco lumber.png', '6', '2x12 cm', '654d309585b6b_receive.jpg', 'Pending', '2023-11-09 19:18:45', '600', '74.4'),
(289, 603, 1050, 1082, 'Coco Lumber', '83.00', 'coco lumber.png', '5', '2x10 cm', '654d309585b6b_receive.jpg', 'Pending', '2023-11-09 19:18:45', '415', '62'),
(290, 624, 1050, 1088, 'Hollow Blocks', '25.00', 'hollow.png', '10', 'Chv 6', '654d30c16ecf5_receive.jpg', 'Pending', '2023-11-09 19:19:29', '250', '19'),
(291, 624, 1050, 1087, 'Steel Bar', '364.00', 'steelbar.png', '4', '16 mm ', '654d30c16ecf5_receive.jpg', 'Pending', '2023-11-09 19:19:29', '1456', '0'),
(292, 324, 1050, 1091, 'Nails (Per Kilo)', '60.00', 'nails.jpg', '7', '2 inches', '654d30fc8f146_receive.jpg', 'Pending', '2023-11-09 19:20:28', '420', '70'),
(293, 324, 1050, 1061, 'PVC Clamp', '500.00', 'pc.jpg', '1', 'Blue (Per Box 50pcs.)', '654d30fc8f146_receive.jpg', 'Pending', '2023-11-09 19:20:28', '500', '0'),
(298, 203, 1048, 1051, 'Claw Hammer Wooden Handle', '160.00', 'claw.jpg', '2', '', '654e5f04334c0_653b52c441adf_receive.jpg', 'To Receive', '2023-11-16 17:46:26', '320', '0'),
(299, 203, 1048, 1059, 'Ordinary PVC Faucet', '50.00', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '3', 'With Bib', '654e5f04334c0_653b52c441adf_receive.jpg', 'To Receive', '2023-11-16 17:46:26', '150', '0'),
(302, 257, 1047, 1057, 'Teflon Tape ', '15.00', 't1.jpg', '1', 'Small', '655044da07f44_Live Reference Service-4.png', 'Declined', '2023-11-13 11:50:16', '15', '0'),
(303, 547, 1047, 1102, 'Elf Buhangin', '3000.00', 'elfbuha.jpg', '1', '', '6550a89f6ef29_Live Reference Service-4.png', 'Pending', '2023-11-12 10:27:43', '12000', '0'),
(304, 547, 1047, 1060, 'PVC Hose Coupling', '45.00', 'j1.png', '1', '3/4 inches', '6550a89f6ef29_Live Reference Service-4.png', 'Pending', '2023-11-12 10:27:43', '45', '0'),
(305, 547, 1047, 1061, 'PVC Clamp', '10.00', 'pc.jpg', '5', 'Orange (Per Piece)', '6550a89f6ef29_Live Reference Service-4.png', 'Pending', '2023-11-12 10:27:43', '10', '0'),
(306, 631, 1047, 1063, 'Blind Rivets (Per Box)', '180.00', 'b1.jpg', '2', '1/8 ½ mm', '655369ae5f296_OIG (1).jpg', 'Pending', '2023-11-14 12:35:58', '360', '0'),
(307, 631, 1047, 1101, 'Elf Grava', '3500.00', 'elf grava.jpg', '2', '', '655369ae5f296_OIG (1).jpg', 'Pending', '2023-11-14 12:35:58', '7000', '0'),
(308, 285, 1052, 1057, 'Teflon Tape ', '15.00', 't1.jpg', '4', 'Small', '65537c002c480_background.png', 'Declined', '2023-11-14 14:08:58', '15', '0'),
(309, 285, 1052, 1060, 'PVC Hose Coupling', '45.00', 'j1.png', '2', '3/4 inches', '65537c002c480_background.png', 'Declined', '2023-11-14 14:08:58', '45', '0'),
(310, 242, 1075, 1061, 'PVC Clamp', '500.00', 'pc.jpg', '2', 'Blue (Per Box 50pcs.)', '65538321942a0_background.png', 'Cancelled', '2023-11-14 14:26:09', '1000', '0'),
(311, 750, 1076, 1057, 'Teflon Tape ', '15.00', 't1.jpg', '3', 'Small', '65538b3c49a45_sample.jpeg', 'To Ship', '2023-11-14 15:11:58', '45', '0'),
(312, 971, 1076, 1063, 'Blind Rivets (Per Box)', '180.00', 'b1.jpg', '5', '1/8 ½ mm', '65538b7e96acd_sample.jpeg', 'Cancelled', '2023-11-14 15:21:05', '900', '235'),
(313, 293, 1076, 1060, 'PVC Hose Coupling', '45.00', 'j1.png', '3', '3/4 inches', '655390cb8ed15_sample.jpeg', 'Pending', '2023-11-14 15:22:51', '135', '0'),
(314, 452, 1077, 1057, 'Teflon Tape ', '15.00', 't1.jpg', '3', 'Small', '65539ca7ca54d_2x2.jpg', 'Declined', '2023-11-14 16:17:42', '45', '0'),
(315, 452, 1077, 1082, 'Coco Lumber', '169.00', 'coco lumber.png', '2', '2x3x12 cm', '65539ca7ca54d_2x2.jpg', 'Declined', '2023-11-14 16:17:42', '338', '0'),
(316, 500, 1052, 1119, '1111111', '220.00', 'Kobe.jpg', '5', '', '6553a161c137f_371783802_1261297457912833_8881419205717480790_n.jpg', 'Pending', '2023-11-14 16:33:37', '1100', '110'),
(317, 500, 1052, 1082, 'Coco Lumber', '35.00', 'coco lumber.png', '5', '2x2 cm', '6553a161c137f_371783802_1261297457912833_8881419205717480790_n.jpg', 'Pending', '2023-11-14 16:33:37', '175', '62'),
(318, 500, 1052, 1091, 'Nails (Per Kilo)', '100.00', 'nails.jpg', '1', '1 inch', '6553a161c137f_371783802_1261297457912833_8881419205717480790_n.jpg', 'Pending', '2023-11-14 16:33:37', '100', '0'),
(319, 445, 1078, 1057, 'Teflon Tape ', '23.00', 't1.jpg', '20', 'hd', '65543fe92a2a3_123.png', 'Declined', '2023-11-15 04:07:07', '460', '30'),
(320, 445, 1078, 1086, 'Bistay (Per Bucket)', '35.00', 'bistay.png', '144', '', '65543fe92a2a3_123.png', 'Declined', '2023-11-15 04:07:07', '5040', '504'),
(321, 930, 1047, 1057, 'Teflon Tape ', '15.00', 't1.jpg', '1', 'Small', '6554d450af8a3_OIG (1).jpg', 'Pending', '2023-11-15 14:23:12', '15', '0'),
(322, 930, 1047, 1101, 'Elf Grava', '3500.00', 'elf grava.jpg', '2', '', '6554d450af8a3_OIG (1).jpg', 'Pending', '2023-11-15 14:23:12', '7000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(60) NOT NULL,
  `prod_desc` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `new_price` varchar(60) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `new_qty` int(11) NOT NULL,
  `stock` varchar(50) DEFAULT 'Instock',
  `image` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `supplier_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `name`, `category`, `prod_desc`, `price`, `new_price`, `qty`, `new_qty`, `stock`, `image`, `purchase_date`, `supplier_price`) VALUES
(1051, 'Claw Hammer Wooden Handle', 'Hand Tools', 'A claw hammer with a wooden handle is a classic and versatile hand tool used for a variety of carpentry and construction tasks. It features a sturdy wooden handle for a comfortable grip and a metal head with two striking surfaces: one for driving nails and the other with a curved \"claw\" for removing nails.', '160', '0', '23', 2, 'Instock', 'claw.jpg', '2023-11-17 09:07:07', 120),
(1057, 'Teflon Tape', 'Plumbing Pipes & Accessories', 'Teflon tape, also known as PTFE tape, is a versatile sealing material used for creating a secure, watertight seal in plumbing and pipe connections. It is made of polytetrafluoroethylene (PTFE), a non-stick and heat-resistant material.', '15', '15', '0', 10, 'Instock', 't1.jpg', '2023-11-17 10:00:07', 7),
(1059, 'Ordinary PVC Faucet', 'Plumbing Pipes & Accessories', 'An ordinary PVC faucet, also known as a plastic faucet, is a simple plumbing fixture designed for controlling the flow of water in various household applications. It is typically made from polyvinyl chloride (PVC) material, which is a type of plastic known for its durability and resistance to corrosion. ', '50', '0', '98', 1, 'Instock', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '2023-11-17 09:00:13', 40),
(1060, 'PVC Hose Coupling', 'Plumbing Pipes & Accessories', 'A PVC hose coupling is a connecting component made from durable polyvinyl chloride (PVC) material. Its primary purpose is to join or extend PVC hoses in a secure and leak-resistant manner. These couplings typically come in various shapes and sizes, with threaded or barbed ends that fit snugly into the hoses.', '25', '0', '49', 0, 'Instock', 'j1.png', '2023-11-17 09:02:09', 20),
(1061, 'PVC Clamp', 'Plumbing Pipes & Accessories', 'A PVC clamp is a versatile fastening device made from durable PVC (polyvinyl chloride) material. It is designed to secure and support pipes, tubes, or cables in various applications. These clamps feature a simple yet effective design, typically with a hinged or two-piece construction for easy installation.', '95', '0', '37', 1, 'Instock', 'pc.jpg', '2023-11-14 14:24:33', 90),
(1063, 'Blind Rivets (Per Box)', 'Steel Products', 'Blind rivets, also known as pop rivets, are fasteners used to join two or more materials together when you can only access one side. They consist of a cylindrical shaft with a flange at one end and a mandrel (a stem) at the other. ', '470', '0', '60', 0, 'Instock', 'b1.jpg', '2023-11-14 15:00:14', 450),
(1082, 'Coco Lumber', 'Wood Products', 'Coco lumber is a type of construction material made from the trunk of the coconut palm tree. It is known for its strength, durability, and versatility, making it a popular choice for various building projects, especially in tropical regions. Coco lumber is typically used for framing, roofing, and various structural applications in construction.', '124', '0', '49', 20, 'Instock', 'coco lumber.png', '2023-11-14 16:33:37', 115),
(1083, 'Semento (Per Sack 40 Kilos)', 'Concreting & Masonry', 'Semento is a category of construction material sold in 40-kilogram sacks or bags. It is commonly used for various building and masonry applications, offering strong adhesive properties and stability in construction projects.', '204', '0', '117', 0, 'Instock', 'semento.png', '2023-11-09 19:14:10', 199),
(1086, 'Bistay (Per Bucket)', 'Concreting & Masonry', 'Bistay is a construction material typically used for reinforcing concrete structures. It consists of steel bars or mesh that adds strength and durability to concrete, making it an essential component in various building and infrastructure projects.', '35', '50', '50', 30, 'Instock', 'bistay.png', '2023-11-17 05:20:15', 25),
(1087, 'Steel Bar', 'Steel Products', 'Steel bars are essential construction materials made of steel and commonly used to reinforce concrete structures. These bars provide strength and durability to concrete, making them a crucial component in various building and infrastructure projects. They come in various sizes and shapes, depending on their intended use in construction.', '364', '0', '34', 0, 'Instock', 'steelbar.png', '2023-11-09 19:19:29', 359),
(1088, 'Hollow Blocks', 'Concreting & Masonry', 'Hollow blocks are building components made of concrete or other materials. They feature a hollow core, which reduces their weight and makes them ideal for constructing walls and other structural elements in construction projects. Hollow blocks are known for their affordability, ease of installation, and thermal insulation properties.', '19', '0', '50', 5, 'Instock', 'hollow.png', '2023-11-17 05:20:34', 17),
(1089, 'Grava (Per Sack)', 'Concreting & Masonry', 'Grava is a construction material consisting of small, coarse stones or gravel typically used as a key ingredient in concrete mixes. It adds strength and stability to concrete and is often used for various construction applications, including roads, foundations, and building projects.', '45', '0', '83', 0, 'Instock', 'Grava.jpg', '2023-11-09 19:17:22', 30),
(1090, 'GI Wire (Per Kilo)', 'Steel Products', 'GI wire, short for Galvanized Iron wire, is a type of steel wire that has been coated with a layer of zinc. This galvanization process protects the wire from corrosion and rust, making it highly durable and suitable for various applications in construction, fencing, and other industries.', '100', '0', '95', 0, 'Instock', 'gi wire.png', '2023-11-09 19:16:46', 90),
(1091, 'Nails (Per Kilo)', 'Steel Products', 'Nails, often referred to as \"pako\" in some regions, are slender metal fasteners with a pointed end. They are commonly used in construction and carpentry to join or secure various materials together, such as wood, metal, or concrete. Nails come in different sizes and types, each suited for specific applications.', '100', '0', '87', 1, 'Instock', 'nails.jpg', '2023-11-14 16:33:37', 90),
(1092, 'PVC', 'Plumbing Pipes & Accessories', 'PVC, or Polyvinyl Chloride, is a versatile and durable synthetic plastic material. It is commonly used in various applications, including pipes, cable insulation, vinyl flooring, and more, due to its excellent resistance to chemicals, weather, and physical wear, making it an ideal choice for both industrial and consumer products.', '250', '0', '94', 0, 'Instock', 'pvcc.jpg', '2023-11-09 19:11:09', 200),
(1093, 'Elbow', 'Plumbing Pipes & Accessories', 'An elbow pipe is a plumbing or pipe fitting with a 90-degree bend, allowing pipes to change direction smoothly in a plumbing or piping system. It is essential for redirecting the flow of liquids or gases while maintaining a secure and leak-free connection between two pipes.', '150', '0', '50', 0, 'Instock', 'elbow11.jpg', '2023-11-05 09:30:16', 130),
(1094, 'Utility Box', 'Electrical Pipes & Accessories', 'A utility box is a container or enclosure used to house and protect various electrical components, such as switches, outlets, or circuit breakers. It is an essential part of electrical systems, providing safety and easy access for maintenance while concealing wiring and connections. Utility boxes come in different sizes and styles to accommodate different electrical needs.', '30', '0', '49', 1, 'Instock', 'utility box.png', '2023-11-12 09:26:30', 20),
(1095, 'Junction Box', 'Electrical Pipes & Accessories', 'A junction box is an enclosure used in electrical wiring to protect and safely contain the junction of electrical connections or splices. It provides a secure and organized space for connecting wires and helps prevent electrical hazards. Junction boxes are available in various sizes and types, depending on the specific application.', '30', '0', '49', 12, 'Instock', 'junction.jpg', '2023-11-12 10:30:36', 20),
(1096, 'Cutting Disc', 'Concreting & Masonry', 'A cutting disc is a thin, circular abrasive tool typically used with handheld grinders or saws. It is designed for cutting various materials, including metal, stone, and concrete. Cutting discs are known for their precision and efficiency in making clean and accurate cuts in different applications, such as metalworking and construction.', '50', '0', '58', 0, 'Instock', 'cd.png', '2023-11-09 19:07:23', 25),
(1097, 'Grinding Disc', 'Concreting & Masonry', 'A grinding disc is a flat, abrasive tool designed for use with grinders and similar machinery. It is primarily used for smoothing or shaping surfaces and removing material from workpieces, such as metal, stone, or concrete. Grinding discs are essential for tasks like sharpening tools, smoothing welds, and preparing surfaces for further finishing.', '50', '0', '34', 0, 'Instock', 'grind.png', '2023-11-09 19:11:09', 25),
(1098, 'Shovel', 'Concreting & Masonry', 'A shovel is a manual tool with a handle and a broad, flat blade at the end. It is commonly used for digging, lifting, and moving various materials, such as soil, sand, or snow. Shovels come in different designs for specific tasks, making them essential tools in gardening, construction, and snow removal.', '450', '0', '29', 3, 'Instock', 'shov.jpg', '2023-11-12 09:28:18', 300),
(1099, 'Chicago Floor Strainer', 'Plumbing Pipes & Accessories', 'A Chicago floor strainer is a plumbing fixture designed to be installed in a floor or low-lying area to collect and drain water or other liquids. It typically features a grated or perforated cover that allows liquid to pass through while preventing debris from clogging the drain. These strainers are commonly used in commercial and industrial settings to maintain proper drainage and prevent flooding.', '40', '0', '58', 0, 'Instock', 'plassteel.jpg', '2023-11-09 19:11:09', 20),
(1100, 'Elbow Tee', 'Plumbing Pipes & Accessories', 'An elbow tee is a plumbing fitting that combines the features of an elbow and a tee. It has a 90-degree bend and a T-shaped configuration, allowing for a change in the direction of fluid flow while also providing a branch connection. Elbow tees are commonly used in plumbing systems to route water or gas in different directions and accommodate additional pipes or fixtures.', '20', '0', '37', 0, 'Instock', '3e64a49331d702f8be308d82b33386c7.jpg', '2023-11-09 19:15:22', 15),
(1101, 'Elf Grava', 'Concreting & Masonry', 'The Elf Grava 1.6 size truck is a compact commercial vehicle designed for transporting goods and materials. It typically has a 1.6-ton payload capacity, making it suitable for various small to medium-sized cargo loads. The Elf Grava is known for its maneuverability, efficiency, and versatility in urban and rural settings, making it a popular choice for businesses that require reliable transportation for their goods.', '3500', '0', '50', 0, 'Instock', 'elf grava.jpg', '2023-11-17 05:21:01', 3000),
(1102, 'Elf Buhangin', 'Concreting & Masonry', 'The Elf Buhangin 1.6 size truck is a compact commercial vehicle designed for transporting goods and materials. It typically has a 1.6-ton payload capacity, making it suitable for various small to medium-sized cargo loads. The Elf Buhangin is known for its maneuverability, efficiency, and versatility in urban and rural settings, making it a popular choice for businesses that require reliable transportation for their goods.', '3000', '0', '50', 0, 'Instock', 'elfbuha.jpg', '2023-11-17 05:21:20', 2500),
(1106, 'Finishing Trowel ', 'Concreting & Masonry', 'A finishing trowel is a hand tool commonly used in construction and masonry work to smooth and level the surface of concrete, plaster, stucco, or other similar materials. It is an essential tool for achieving a polished and uniform finish on surfaces such as walls, ceilings, and floors.', '48', '0', '136', 0, 'Instock', 'fin.JPG', '2023-11-06 13:09:54', 35),
(1107, 'Cement Trowel ', 'Concreting & Masonry', 'A cement trowel is a specialized hand tool used in construction and masonry for applying, spreading, and smoothing cement-based materials, such as mortar and concrete. It is designed to help tradespeople and DIY enthusiasts work with these materials efficiently and effectively. ', '82', '0', '74', 0, 'Instock', 'cement.JPG', '2023-11-09 19:11:09', 70),
(1108, 'Mansion Steel Brush', 'Steel Products', 'A mansion steel brush, also known as a wire brush, is a hand tool used for various cleaning, surface preparation, and finishing tasks. It typically consists of a handle and a series of wire bristles attached to the head. The mansion steel brush is designed for heavy-duty cleaning and can be used in a variety of applications.', '69', '0', '57', 0, 'Instock', 'mansion.JPG', '2023-11-09 19:11:09', 55),
(1109, 'Sandflex Handsaw Blade ', 'Steel Products', 'The Sandflex handsaw blade is a versatile cutting tool designed for various applications, such as cutting metal, plastic, and wood. It is known for its durability, flexibility, and ability to cut through a wide range of materials efficiently. ', '45', '0', '88', 0, 'Instock', 'sandflex.JPG', '2023-11-09 19:11:09', 40),
(1110, 'Wood Chisel', 'Wood Products', 'A wood chisel is a hand tool used for cutting, shaping, and carving wood. It is an essential tool for woodworking and carpentry, enabling craftsmen to remove material or create precise, intricate details in wooden pieces. ', '74', '0', '81', 0, 'Instock', 'wood.JPG', '2023-11-07 16:09:08', 65),
(1111, 'Vice Grip Iron G Clam', 'Electrical Pipes & Accessories', 'Vice Grip Iron G Clam is a popular brand of locking pliers and clamps, known for their ability to securely grip and hold objects in place. ', '89', '0', '177', 0, 'Instock', 'grip.JPG', '2023-11-09 19:11:09', 75),
(1112, 'Standard Measuring Tape', 'Electrical Pipes & Accessories', 'A standard measuring tape, often referred to as a tape measure, is a flexible and portable tool used for measuring lengths and distances. It is commonly used in construction, carpentry, sewing, and various DIY projects. ', '58', '0', '192', 0, 'Instock', 'tape.JPG', '2023-11-09 19:11:09', 45),
(1113, 'Pliers', 'Electrical Pipes & Accessories', 'Pliers are versatile hand tools used for gripping, bending, cutting, and manipulating a wide range of materials, including wires, cables, pipes, and small objects. They come in various designs and styles, each tailored for specific tasks and applications.', '115', '0', '169', 0, 'Instock', 'pliers.JPG', '2023-11-07 16:09:08', 95),
(1114, 'Paint Brush', 'Hand Tools', 'A paint brush is a basic yet essential tool used in painting for applying paint to various surfaces, such as walls, furniture, canvases, and more. Paint brushes come in a variety of sizes, shapes, and bristle materials, each suited for different types of painting projects. ', '15', '0', '70', 0, 'Instock', 'brush.JPG', '2023-11-09 21:30:44', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_refund`
--

CREATE TABLE `tb_refund` (
  `refund_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `gcash_name` varchar(60) NOT NULL,
  `gcash_number` varchar(60) NOT NULL,
  `transaction_amount` varchar(60) NOT NULL,
  `reason` text NOT NULL,
  `refund_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(60) NOT NULL DEFAULT 'Pending',
  `message` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_refund`
--

INSERT INTO `tb_refund` (`refund_id`, `order_id`, `gcash_name`, `gcash_number`, `transaction_amount`, `reason`, `refund_date`, `status`, `message`) VALUES
(18, 257, 'Maria Santos', '09122165488', '56.80', 'Wrong Product', '2023-11-16 09:31:04', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `barangay` varchar(60) NOT NULL,
  `postal` varchar(60) NOT NULL,
  `houseNo` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `village` varchar(60) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `bdate` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `confirm` varchar(50) NOT NULL,
  `status` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `lastName`, `firstName`, `middleName`, `contact`, `barangay`, `postal`, `houseNo`, `street`, `village`, `gender`, `bdate`, `email`, `password`, `image`, `confirm`, `status`) VALUES
(1044, 'Ramos', 'Sofia', 'Recto', '09789012345', 'Santolan', '1610', '890', 'Marcos Highway', 'Santolan Hills', 'Female', '2001-11-25', 'visejid728@soebing.com', 'S0f!aRamos80', 'sof.jpg', 'S0f!aRamos80', 1),
(1045, 'Dela Santos', 'Pedro', 'Loresco', '09890123456', 'Dela Paz', '1600', '567', 'Amang Rodriguez Avenue', 'Sta. Lucia Village', 'Male', '1978-04-02', 'necowo@lyft.live', 'P3droTan78', 'pedro.JPG', 'P3droTan78', 1),
(1046, 'Lim', 'Anne', '', '09345678901', 'Oranbo', '1604', '456', 'Meralco Avenue', 'Valle Verde', 'Female', '1997-08-22', 'huhyveme@afia.pro', 'Grac3An$789', 'anne.JPG', 'Grac3An$789', 1),
(1047, 'Santos', 'Maria', 'Reyes', '09123456789', 'San Antonio', '1600', '123', 'Lopez St.', 'Mabini Village', 'Female', '1989-05-15', 'viwadih198@newnime.com', 'M@ria123', 'mar.jpg', 'M@ria123', 1),
(1048, 'Tan', 'Carlos', 'Aquino', '09234567890', 'Rosario', '1609', '789', 'Ortigas Avenue', 'Rosario Heights', 'Male', '2000-12-10', 'lozybiby@clout.wiki', 'Car10s#An', 'carlos.jpg', 'Car10s#An', 1),
(1049, 'Cruz', 'Juan', 'Andres', '09456789012', 'Bagong Ilog', '1600', '321', 'Dr. Sixto Antonio Avenue', 'Springville Subdivision', 'Male', '1990-03-17', 'kugyfime@socam.me', 'Ju@nCruz90', 'juan.jpg', 'Ju@nCruz90', 1),
(1050, 'Luna', 'Antonio', '', '09567890123', 'San Miguel', '1607', '222', 'Caruncho Avenue', 'San Miguel', 'Male', '1976-06-30', 'suqolo@tutuapp.bid', 'Migue1Rodrig@', 'mig.jpg', 'Migue1Rodrig@', 1),
(1051, 'Martinez', 'Klare', 'Recto', '09678901234', 'Caniogan', '1606', '654', 'Mercedes Avenue', 'Villa Raymundo', 'Female', '1983-09-05', 'poxogo@afia.pro', 'AnaMart#nez83', 'klare.jpg', 'AnaMart#nez83', 1),
(1052, 'Garcia', 'Isabella', 'Campos', '09901234567', 'Ugong', '1604', '432', 'Sixto Antonio Avenue', 'Valley Golf Subdivision', 'Female', '1986-06-30', 'popesofe@hexi.pics', 'Is@b3llaG#r', 'isa.jpg', 'Is@b3llaG#r', 1),
(1053, 'Aguilar', 'Freddy', '', '09111223344', 'Malinao', '1611', '765', 'Caruncho Avenue', 'Caruncho Subdivision', 'Male', '1982-12-10', 'rufigele@tutuapp.bid', 'G@bri3l#', 'gabriel.JPG', 'G@bri3l#', 1),
(1054, 'asd', 'ds', 'ds', '09554123011', 'Sagad', '1600', '221', 'cds', 'dfd', 'Female', '2001-02-01', 'evalyn@gmail.com', '11aA@1111', '', '11aA@1111', 0),
(1055, 'Montemayor', 'Theresa', 'Capas', '09122334455', 'San Joaquin', '1600', '111', 'Dr. Sixto Antonio ', 'Rosal Village', 'Female', '2002-05-15', 'daluri@tutuapp.bid', 'M@riaTh3', 'thers.JPG', 'M@riaTh3', 1),
(1056, 'Amancio', 'Daniel', 'Areman', '09133445566', 'Kalawaan', '1612', '876', 'Marcos Highway', 'Kalawaan Village', 'Male', '2001-08-12', 'zugili@clout.wiki', 'D@ni3lLu', 'dan.JPG', 'D@ni3lLu', 1),
(1057, 'Maredo', 'Jose', 'Rosales', '09144556677', 'Maybunga', '1607', '234', 'Dr. Pilapil Street', 'San Miguel Village', 'Male', '1981-11-25', 'jyzemana@yogrow.co', 'J0seLui$81', 'jose.JPG', 'J0seLui$81', 1),
(1058, 'Rodriguez', 'Jasper', 'Murias', '09166778899', 'Pineda', '1607', '654', 'San Guillermo Street', 'Pineda Village', 'Male', '1999-09-05', 'wynobozo@yogrow.co', 'J@3perRo', 'jas.JPG', 'J@3perRo', 1),
(1059, 'Rey', 'Elena', 'Lubiano', '09155667788', 'Santo Tomas', '1612', '543', 'Eusebio Avenue', 'Sto. Tomas Village', 'Female', '1979-07-11', 'bedatu@afia.pro', 'El3n@reys', 'elena.JPG', 'El3n@reys', 1),
(1060, 'Ramos', 'Ana', 'Conde', '09177889900', 'San Nicolas', '1600', '432', 'Caruncho Avenue', 'San Nicolas Village', 'Female', '1996-04-30', 'sazuryro@yogrow.co', 'An@R@m0s7', 'ana.JPG', 'An@R@m0s7', 1),
(1061, 'Mariano', 'Luis', 'Valdez', '09188990011', 'Manggahan', '1611', '876', 'Mercedes Avenue', 'Manggahan Village', 'Male', '2004-11-28', 'cibepihe@yogrow.co', 'Lu3s#Mar', 'lu.JPG', 'Lu3s#Mar', 1),
(1062, 'Zulueta', 'Angelo', 'Galang', '09112788916', 'Rosario', '1609', '456', 'Ortigas Avenue', 'Rosario Subdivision', 'Male', '1985-12-13', 'tovulu@afia.pro', 'Ang3l0$Z', 'angelo.JPG', 'Ang3l0$Z', 1),
(1063, 'Estacio', 'Aaron', 'Escobal', '09786218996', 'Caniogan', '1606', '890', 'Marcos Highway', 'Caniogan Heights', 'Male', '1979-06-19', 'rybufu@clout.wiki', '3stacI*ga', 'aaron.JPG', '3stacI*ga', 1),
(1064, 'Maligsay', 'Janine', '', '09456789012', 'San Joaquin', '1601', '723', 'Dr. Sixto Antonio Avenue', 'San Joaquin Village', 'Female', '2005-04-03', 'pugoqula@yogrow.co', 'J@anin3M', 'janine.JPG', 'J@anin3M', 1),
(1065, 'Matias', 'Sonia', 'Monza', '09567890123', 'Pinagbuhatan', '1602', '679', 'Mercedes Avenue', 'Pinagbuhatan Village', 'Female', '1995-07-18', 'rucupo@lyft.live', '$oni4@Mat', 'sonia.JPG', '$oni4@Mat', 1),
(1066, 'Cordova', 'Paul', 'Manarin', '09789012345', 'Manggahan', '1611', '871', 'F. Legaspi Street', 'Manggahan Village', 'Male', '1988-09-09', 'jisuhi@clout.wiki', 'P@ul89co', 'paul.JPG', 'P@ul89co', 1),
(1067, 'Fernandez', 'Allen', '', '09890123456', 'Santa Lucia', '1608', '456', 'C. Raymundo Avenue', 'Santa Lucia Village', 'Male', '1983-11-25', 'zupenify@socam.me', '@LLenFer56', 'allen.JPG', '@LLenFer56', 1),
(1068, 'Aquino', 'Grave', 'Nerecina', '09123456789', 'Maybunga', '1603', '990', 'Sandoval Avenue', 'Maybunga Village', 'Male', '1989-04-29', 'fipareci@socam.me', 'Gra34@Ne', 'grave.JPG', 'Gra34@Ne', 1),
(1069, 'Alcaraz', 'Noreen', 'Viray', '09345678901', 'Santo Tomas', '1604', '843', 'Mercedes Avenue', 'Santo Tomas Village', 'Female', '1977-03-11', 'datykeqy@hexi.pics', 'nOr33n@l', 'nor.JPG', 'nOr33n@l', 1),
(1070, 'Suarez', 'Ralph', 'Tomas', '09456789012', 'Palatiw', '1613', '972', 'M. Concepcion Street', 'Palatiw Village', 'Male', '2000-12-07', 'fedujefu@tutuapp.bid', 'R@LP762sU', 'ralph.JPG', 'R@LP762sU', 1),
(1071, 'Ong', 'Nicole', 'Tamayo', '09567890123', 'Santa Rosa', '1612', '657', 'Caruncho Avenue', 'Sta. Rosa Village', 'Female', '2001-01-22', 'dipetiry@socam.me', 'Nic0l3Ong@', 'nicole.JPG', 'Nic0l3Ong@', 1),
(1072, 'Austria', 'Francis', 'Francis Manalo', '09789012345', 'Bagong Katipunan', '1607', '569', 'Caruncho Avenue', 'Bagong Katipunan Village', 'Male', '1994-10-30', 'vipobupa@lyft.live', 'Fr@nc3Ma5', 'francis.JPG', 'Fr@nc3Ma5', 1),
(1073, 'Pastrana', 'Karen', '', '09123456789', 'Rosario', '1609', '754', 'Ortigas Avenue', 'Rosario Village', 'Female', '1987-08-22', 'sawujyle@lyft.live', 'K@r3nPAS36', 'karen.JPG', 'K@r3nPAS36', 1),
(1074, 'Goyal', 'Rafael', 'Pineda', '09678901232', 'Caniogan', '1606', '435', 'Eusebio Avenue', 'Caniogan Village', 'Male', '1978-02-08', 'vyvoliwo@yogrow.co', 'R@fa3#lGoy', 'rafe.JPG', 'R@fa3#lGoy', 1),
(1075, 'Tindugan', 'Paul Justine', 'Danico', '09610450111', 'Manggahan', '1611', '1680', 'Kaagapay', 'Karangalan Village ', 'Male', '1999-09-01', 'justinetindugan09@gmail.com', '#Tindugan09610450111', 'BEBE..jpg', '#Tindugan09610450111', 1),
(1076, 'Revilloza', 'Rommel', 'Tanguilig', '09617507671', 'Rosario', '1609', 'Blk 2 Lot 3 unit A', 'Ciudad del mejia ', 'Ciudad del mejia Executive Village', 'Male', '2002-05-06', 'rommel.revilloza6@gmail.com', '@Mel12345', 'download.jfif', '@Mel12345', 1),
(1077, 'Monteagudo', 'kathmae', 'santos', '1234567896', 'Santo Tomas', '1550', '123', 'Aglipay st. Brgy Poblacion', 'efefrge', 'Female', '1998-10-15', 'kathmae.monteagudo@my.jru.edu', 'Luna@1234', '', 'Luna@1234', 1),
(1078, 'cabugnason', 'john vincent ', 'mallari', '09616241168', 'Rosario', '1609', '4473', 'Mercury St.', 'Rosario', 'Male', '2002-09-28', 'johnvincent.cabugnason@my.jru.edu', '3Mvll@3um', '', '@Mvll2u2m', 1),
(1079, 'cvc', 'vc', 'v', '3533663665', 'San Antonio', '1600', 'vcvf', 'gfgf', 'hggh', 'Female', '2001-01-01', '8c7c0f6554d9b8@theeyeoftruth.com', '123456Aa@', '', '123456Aa@', 1),
(1080, 'cruz', 'chuck joshua', 'pahati', '09150314884', 'Kalawaan', '1600', '774', 'R.Castillo st. kalawaan', '', 'Male', '2000-10-24', 'chuckjoshuacruz2000@gmail.com', '@Ateneo02', '', '@Ateneo02', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_onsite`
--
ALTER TABLE `order_onsite`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`variation_id`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USER_ID` (`user_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tb_refund`
--
ALTER TABLE `tb_refund`
  ADD PRIMARY KEY (`refund_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_onsite`
--
ALTER TABLE `order_onsite`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=997;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=661;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1127;

--
-- AUTO_INCREMENT for table `tb_refund`
--
ALTER TABLE `tb_refund`
  MODIFY `refund_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1081;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`admin_id`);

--
-- Constraints for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD CONSTRAINT `tb_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
