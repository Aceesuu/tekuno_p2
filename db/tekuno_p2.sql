-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2023 at 12:53 PM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u377814293_tekuno_p2`
--

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
(454, '2023-11-03 12:08:52', 1051, 'Claw Hammer Wooden Handle', '150.00', 6, '900.00', 0, '900.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `variation` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`variation_id`, `product_id`, `name`, `variation`, `price`, `qty`) VALUES
(94, 1059, 'Ordinary PVC Faucet', 'With Bib', '20.00', 0),
(95, 1059, 'Ordinary PVC Faucet', 'Without Bib', '20.00', 0),
(96, 1062, 'Goose Neck PVC Faucet', 'Horizontal Entrance', '150.00', 0),
(97, 1062, 'Goose Neck PVC Faucet', 'Vertical Entrace', '150.00', 0),
(98, 1064, 'Omega HD PVC Faucet Crown Handle', 'With Bib', '105.00', 0),
(99, 1064, 'Omega HD PVC Faucet Crown Handle', 'Without Bib', '80.00', 0),
(100, 1065, 'Omega HD PVC Faucet Lever Handle ', 'With Bib', '95.00', 0),
(101, 1065, 'Omega HD PVC Faucet Lever Handle ', 'Without Bib', '70.00', 0),
(102, 1057, 'Teflon Tape ', '1/2', '4.50', 0),
(103, 1057, 'Teflon Tape ', '3/4', '7.50', 0);

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
(7, 'Estrera', 'Evalyn Grace', 'Middle Name', 'Female', '09123547811', '', 'estrera.evalyngrace@gmail.com', '123456', 'Admin'),
(8, 'ds', 'ds', 'ds', 'Female', '6552', '', 'aaa@gmail.com', '123456', '');

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
(8, 'Chemicals'),
(9, 'Hand Tools'),
(10, 'Drywall & Ceiling');

-- --------------------------------------------------------

--
-- Table structure for table `tb_inventory`
--

CREATE TABLE `tb_inventory` (
  `int_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `int_qty` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_inventory`
--

INSERT INTO `tb_inventory` (`int_id`, `product_id`, `name`, `int_qty`, `purchase_date`) VALUES
(11, 1007, 'Saw', 10, '2023-10-10'),
(12, 1004, 'Steel Bar', 5, '2023-10-10'),
(13, 1025, 'Wrench', 10, '2023-10-11');

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
(211, 729, 1042, 1059, 'Ordinary PVC Faucet', '20.00', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '1', 'With Bib', '654364bb949ac_aa.png', 'Pending', '2023-11-02 08:58:35', '20', '0'),
(212, 729, 1042, 1056, 'Butane Torch', '600.00', 'bt.jpg', '1', '', '654364bb949ac_aa.png', 'Pending', '2023-11-02 08:58:35', '600', '0'),
(213, 955, 1042, 1059, 'Ordinary PVC Faucet', '20.00', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '1', 'With Bib', '6543cab189240_aa.png', 'Pending', '2023-11-02 16:13:37', '20', '0'),
(214, 955, 1042, 1056, 'Butane Torch', '600.00', 'bt.jpg', '1', '', '6543cab189240_aa.png', 'Pending', '2023-11-02 16:13:37', '600', '0'),
(215, 121, 1044, 1058, 'Kitchen Sink - Stainless', '350.00', 'k1.png', '1', '', '6543e66187be1_download.jpg', 'Pending', '2023-11-02 18:11:45', '350', '0'),
(216, 121, 1044, 1056, 'Butane Torch', '600.00', 'bt.jpg', '1', '', '6543e66187be1_download.jpg', 'Pending', '2023-11-02 18:11:45', '600', '0'),
(217, 121, 1044, 1064, 'Omega HD PVC Faucet Crown Handle', '80.00', '0013780_omega-plastic-tap-faucet-ball-type-with-hose-bib-12-in-x-4-in-pt-8125-1_625.jpeg', '1', 'Without Bib', '6543e66187be1_download.jpg', 'Pending', '2023-11-02 18:11:45', '80', '0'),
(218, 251, 1044, 1057, 'Teflon Tape ', '7.50', 't1.jpg', '5', '3/4', '6543e6871d8b7_aa.png', 'Pending', '2023-11-02 18:12:23', '37.5', '2.25'),
(219, 251, 1044, 1059, 'Ordinary PVC Faucet', '20.00', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '1', 'With Bib', '6543e6871d8b7_aa.png', 'Pending', '2023-11-02 18:12:23', '20', '0'),
(220, 227, 1045, 1061, 'PVC Clamp', '95.00', 'pc.jpg', '1', '', '6543e75e4f3fd_aa.png', 'Pending', '2023-11-02 18:15:58', '95', '0'),
(225, 419, 1042, 1058, 'Kitchen Sink - Stainless', '350.00', 'k1.png', '2', '', '65463daf68ca5_boy.jpg', 'Pending', '2023-11-04 12:48:47', '700', '0'),
(226, 419, 1042, 1064, 'Omega HD PVC Faucet Crown Handle', '80.00', '0013780_omega-plastic-tap-faucet-ball-type-with-hose-bib-12-in-x-4-in-pt-8125-1_625.jpeg', '1', 'Without Bib', '65463daf68ca5_boy.jpg', 'Pending', '2023-11-04 12:48:47', '80', '0');

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
  `qty` varchar(100) NOT NULL,
  `new_qty` int(11) NOT NULL,
  `stock` varchar(50) DEFAULT 'Instock',
  `image` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `exp_date` date NOT NULL,
  `supplier_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `name`, `category`, `prod_desc`, `price`, `qty`, `new_qty`, `stock`, `image`, `purchase_date`, `exp_date`, `supplier_price`) VALUES
(1048, 'PVC', 'Plumbing Pipes & Accessories', 'The VPC 1/2 is recommended for use in portable water pressure applications. It can be used underground in systems that do not go lower than 33f.', '100', '84', 10, 'Instock', 'pvc.jpg', '2023-11-02 17:24:16', '0000-00-00', 90),
(1049, 'Elbow#1/2', 'Plumbing Pipes & Accessories', 'An elbow is a pipe fitting installed between two lengths of pipe or tubing to allow a change of direction, usually a 90° or 45° angle, though 22.5° elbows are also made. The ends may be machined for butt welding, threaded (usually female), or socketed, etc.', '20', '34', 1, 'Instock', 'elbow.jpg', '2023-11-03 12:00:59', '2023-10-06', 15),
(1051, 'Claw Hammer Wooden Handle', 'Hand Tools', 'A claw hammer with a wooden handle is a classic and versatile hand tool used for a variety of carpentry and construction tasks. It features a sturdy wooden handle for a comfortable grip and a metal head with two striking surfaces: one for driving nails and the other with a curved \"claw\" for removing nails.', '150', '39', 10, 'Instock', 'claw.jpg', '2023-11-03 12:08:52', '0000-00-00', 100),
(1052, 'Butane Gas', 'Chemicals', 'Butane gas is a highly flammable and colorless hydrocarbon gas commonly used as a fuel source. It is typically stored in pressurized containers and is widely employed in portable devices such as lighters, camping stoves, and butane torches.', '75', '94', 0, 'Instock', 'butane gas.jpg', '2023-11-03 12:06:29', '2025-01-25', 70),
(1053, 'Safari Submeter Analog', 'Electrical Pipes & Accessories', 'The Safari SY-168 Electric Sub-Meter (60Amp) is for a new homeowners, apartment or boarding house owners, who wish to monitor the monthly power consumption of their tenants, or to monitor the power sub-use of a big appliance. It is an investment this is needed by everyone to ensure that you are billed correctly for your electricity use. The Safari SY-168 Electric Sub-Meter (60Amp) is offered at the most reasonable price with guaranteed good quality.', '500', '0', 0, 'Instock', 'ss.jpg', '2023-11-01 17:49:16', '0000-00-00', 450),
(1054, 'Chicago Floor Strainer - Stainless', 'Plumbing Pipes & Accessories', 'A Chicago floor strainer in stainless steel is a robust and corrosion-resistant drain fixture designed for commercial and industrial applications. It is typically installed in the floor to effectively collect and drain water or other fluids. The stainless steel construction ensures durability and longevity, making it suitable for high-traffic areas.', '28', '0', 0, 'Instock', 'cc.jpg', '2023-11-01 17:52:34', '0000-00-00', 20),
(1055, 'Water Meter', 'Plumbing Pipes & Accessories', 'A water meter is a device used to measure the volume of water consumed in residential, commercial, and industrial settings. Typically installed in water supply lines, it records the usage of water in cubic meters or gallons. ', '250', '-1', 0, 'Instock', 'ww.png', '2023-11-01 21:57:10', '0000-00-00', 220),
(1056, 'Butane Torch', 'Chemicals', 'ahah', '600', '41', 0, 'Instock', 'bt.jpg', '2023-11-03 10:35:37', '2025-01-25', 550),
(1057, 'Teflon Tape ', 'Plumbing Pipes & Accessories', 'Teflon tape, also known as PTFE tape, is a versatile sealing material used for creating a secure, watertight seal in plumbing and pipe connections. It is made of polytetrafluoroethylene (PTFE), a non-stick and heat-resistant material.', '4.50', '32', 0, 'Instock', 't1.jpg', '2023-11-02 18:12:23', '0000-00-00', 4),
(1058, 'Kitchen Sink - Stainless', 'Plumbing Pipes & Accessories', 'A stainless steel kitchen sink is a sleek and durable fixture for your kitchen. Crafted from high-quality stainless steel, it offers a hygienic and easy-to-clean surface for washing dishes and food prep. ', '350', '97', 0, 'Instock', 'k1.png', '2023-11-04 12:48:47', '0000-00-00', 320),
(1059, 'Ordinary PVC Faucet', 'Plumbing Pipes & Accessories', 'An ordinary PVC faucet, also known as a plastic faucet, is a simple plumbing fixture designed for controlling the flow of water in various household applications. It is typically made from polyvinyl chloride (PVC) material, which is a type of plastic known for its durability and resistance to corrosion. ', '20', '65', 0, 'Instock', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '2023-11-03 11:04:29', '0000-00-00', 15),
(1060, 'PVC Hose Coupling', 'Plumbing Pipes & Accessories', 'A PVC hose coupling is a connecting component made from durable polyvinyl chloride (PVC) material. Its primary purpose is to join or extend PVC hoses in a secure and leak-resistant manner. These couplings typically come in various shapes and sizes, with threaded or barbed ends that fit snugly into the hoses.', '25', '75', 0, 'Instock', 'j1.png', '2023-11-02 08:56:13', '0000-00-00', 20),
(1061, 'PVC Clamp', 'Plumbing Pipes & Accessories', 'A PVC clamp is a versatile fastening device made from durable PVC (polyvinyl chloride) material. It is designed to secure and support pipes, tubes, or cables in various applications. These clamps feature a simple yet effective design, typically with a hinged or two-piece construction for easy installation.', '95', '66', 1, 'Instock', 'pc.jpg', '2023-11-02 22:29:38', '0000-00-00', 90),
(1062, 'Goose Neck PVC Faucet', 'Plumbing Pipes & Accessories', 'A goose neck PVC faucet, also known as a swan-neck faucet, is a specific type of plumbing fixture designed for various outdoor water applications, such as gardens and yards.', '150', '36', 0, 'Instock', 'b82489054b50e9eebcf57325fdeacf07.jpg', '2023-11-03 10:35:13', '0000-00-00', 100),
(1063, 'Blind Rivets', 'Drywall & Ceiling', 'Blind rivets, also known as pop rivets, are fasteners used to join two or more materials together when you can only access one side. They consist of a cylindrical shaft with a flange at one end and a mandrel (a stem) at the other. ', '470', '73', 0, 'Instock', 'b1.jpg', '2023-11-01 18:04:25', '0000-00-00', 450),
(1064, 'Omega HD PVC Faucet Crown Handle', 'Plumbing Pipes & Accessories', 'The \"Omega HD PVC Faucet Crown Handle,\" it is likely made of polyvinyl chloride (PVC), a durable plastic suitable for outdoor use.', '105', '75', 0, 'Instock', '0013780_omega-plastic-tap-faucet-ball-type-with-hose-bib-12-in-x-4-in-pt-8125-1_625.jpeg', '2023-11-04 12:48:47', '0000-00-00', 95),
(1065, 'Omega HD PVC Faucet Lever Handle ', 'Plumbing Pipes & Accessories', 'The \"Omega HD PVC Faucet Lever Handle\" handles are typically made from durable polyvinyl chloride (PVC) plastic. This material is known for its resistance to corrosion, making it suitable for outdoor use. The lever handle is designed in a lever or handle shape, providing a convenient and ergonomic grip for easy operation.', '95', '73', 0, 'Instock', 'water-tap79.jpg', '2023-11-01 18:06:33', '0000-00-00', 90),
(1066, 'Cocolumber', 'Wood Products', '', '99', '100', 0, 'Instock', 'lumber-stock-photo.jpg', '2023-11-01 18:07:23', '0000-00-00', 200);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock`
--

CREATE TABLE `tb_stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `qty` int(11) NOT NULL,
  `supplier_price` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date_purchase` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_stock`
--

INSERT INTO `tb_stock` (`stock_id`, `product_id`, `name`, `qty`, `supplier_price`, `price`, `date_purchase`) VALUES
(1, 1048, 'PVC', 20, 150, 100, '2023-10-31 15:59:27'),
(2, 1049, 'Elbow', 50, 120, 20, '2023-10-31 15:59:35'),
(3, 1048, 'PVC', 50, 150, 100, '2023-10-31 16:01:34');

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
(1042, 'Kim', 'Sunoo', '', '09215125451', 'Rosario', '1601', '116', 'Banana St.', 'Ramos', 'Male', '2003-06-24', 'xakotozu@tutuapp.bid', '123456Aa@', '', '123456Aa@', 1),
(1044, 'Ramos', 'Sofia', 'Recto', '09789012345', 'Santolan', '1610', '890', 'Marcos Highway', 'Santolan Hills', 'Female', '2001-11-25', 'visejid728@soebing.com', 'S0f!aRamos80', 'pic.jpg', 'S0f!aRamos80', 1),
(1045, 'Dela Santos', 'Pedro', 'Loresco', '09890123456', 'Dela Paz', '1600', '567', 'Amang Rodriguez Avenue', 'Sta. Lucia Village', 'Male', '1978-04-02', 'necowo@lyft.live', 'P3droTan78', 'pedro.JPG', 'P3droTan78', 1),
(1046, 'Lim', 'Anne', '', '09345678901', 'Oranbo', '1604', '456', 'Meralco Avenue', 'Valle Verde', 'Female', '1997-08-22', 'huhyveme@afia.pro', 'Grac3An$789', 'anne.JPG', 'Grac3An$789', 1),
(1047, 'Santos', 'Maria', 'Reyes', '09123456789', 'San Antonio', '1600', '123', 'Lopez St.', 'Mabini Village', 'Female', '1989-05-15', 'viwadih198@newnime.com', 'M@ria123', 'mar.jpg', 'M@ria123', 1),
(1048, 'Tan', 'Carlos', 'Aquino', '09234567890', 'Rosario', '1609', '789', 'Ortigas Avenue', 'Rosario Heights', 'Male', '2000-12-10', 'lozybiby@clout.wiki', 'Car10s#An', 'carlos.jpg', 'Car10s#An', 1),
(1049, 'Cruz', 'Juan', 'Andres', '09456789012', 'Bagong Ilog', '1600', '321', 'Dr. Sixto Antonio Avenue', 'Springville Subdivision', 'Male', '1990-03-17', 'kugyfime@socam.me', 'Ju@nCruz90', 'juan.jpg', 'Ju@nCruz90', 1),
(1050, 'Rodriguez', 'Miguel', '', '09567890123', 'San Miguel', '1607', '222', 'Caruncho Avenue', 'San Miguel', 'Male', '1976-06-30', 'suqolo@tutuapp.bid', 'Migue1Rodrig@', 'mig.jpg', 'Migue1Rodrig@', 1),
(1051, 'Martinez', 'Klare', 'Recto', '09678901234', 'Caniogan', '1606', '654', 'Mercedes Avenue', 'Villa Raymundo', 'Female', '1983-09-05', 'poxogo@afia.pro', 'AnaMart#nez83', 'klare.jpg', 'AnaMart#nez83', 1),
(1052, 'Garcia', 'Isabella', 'Campos', '09901234567', 'Ugong', '1604', '432', 'Sixto Antonio Avenue', 'Valley Golf Subdivision', 'Female', '1986-06-30', 'popesofe@hexi.pics', 'Is@b3llaG#r', 'isa.jpg', 'Is@b3llaG#r', 1),
(1053, 'Susano', 'Gabriel', '', '09111223344', 'Malinao', '1611', '765', 'Caruncho Avenue', 'Caruncho Subdivision', 'Male', '1982-12-10', 'rufigele@tutuapp.bid', 'G@bri3l#', 'gabriel.JPG', 'G@bri3l#', 1);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  ADD PRIMARY KEY (`int_id`);

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
-- Indexes for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_onsite`
--
ALTER TABLE `order_onsite`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=997;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=521;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_inventory`
--
ALTER TABLE `tb_inventory`
  MODIFY `int_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1082;

--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1054;

--
-- Constraints for dumped tables
--

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
