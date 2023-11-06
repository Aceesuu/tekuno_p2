-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2023 at 02:53 PM
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
  `supplier_price` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`variation_id`, `product_id`, `name`, `variation`, `supplier_price`, `price`, `qty`) VALUES
(94, 1059, 'Ordinary PVC Faucet', 'With Bib', 0, '20.00', 0),
(95, 1059, 'Ordinary PVC Faucet', 'Without Bib', 0, '20.00', 0),
(96, 1062, 'Goose Neck PVC Faucet', 'Horizontal Entrance', 0, '150.00', 0),
(97, 1062, 'Goose Neck PVC Faucet', 'Vertical Entrace', 0, '150.00', 0),
(98, 1064, 'Omega HD PVC Faucet Crown Handle', 'With Bib', 0, '105.00', 0),
(99, 1064, 'Omega HD PVC Faucet Crown Handle', 'Without Bib', 0, '80.00', 0),
(100, 1065, 'Omega HD PVC Faucet Lever Handle ', 'With Bib', 0, '95.00', 0),
(101, 1065, 'Omega HD PVC Faucet Lever Handle ', 'Without Bib', 0, '70.00', 0),
(102, 1057, 'Teflon Tape ', '1/2', 5, '4.50', 6),
(103, 1057, 'Teflon Tape ', '3/4', 0, '7.50', 0),
(105, 1049, 'Elbow#1/2', 'aa', 21, '31.00', 5),
(106, 1082, 'Coco Lumber', '2x2', 25, '35.00', 50),
(107, 1082, 'Coco Lumber', '2x8', 56, '66.00', 50),
(108, 1082, 'Coco Lumber', '2x10', 70, '83.00', 50),
(109, 1082, 'Coco Lumber', '2x12', 84, '100.00', 50),
(110, 1082, 'Coco Lumber', '2x3x8', 102, '112.00', 50),
(111, 1082, 'Coco Lumber', '2x3x10', 132, '140.00', 50),
(112, 1082, 'Coco Lumber', '2x3x12', 155, '169.00', 50),
(113, 1087, 'Steel Bar', '9 mm', 95, '100.00', 50),
(114, 1087, 'Steel Bar', '10 mm', 135, '140.00', 40),
(115, 1087, 'Steel Bar', '12 mm', 212, '217.00', 40),
(116, 1087, 'Steel Bar', '16 mm ', 359, '364.00', 40),
(117, 1088, 'Hollow Blocks', 'Chv 4', 17, '19.00', 10),
(118, 1088, 'Hollow Blocks', 'Chv 5', 18, '22.00', 10),
(119, 1088, 'Hollow Blocks', 'Chv 6', 20, '25.00', 10),
(120, 1091, 'Nails (Per Kilo)', '1\"', 90, '100.00', 100),
(121, 1091, 'Nails (Per Kilo)', '1/2\"', 40, '50.00', 100),
(122, 1091, 'Nails (Per Kilo)', '2\"', 50, '60.00', 100),
(123, 1091, 'Nails (Per Kilo)', '3\"', 60, '70.00', 100),
(124, 1091, 'Nails (Per Kilo)', '4\"', 60, '70.00', 100),
(125, 1048, 'PVC', '2\"', 200, '250.00', 50),
(126, 1048, 'PVC', '3\"', 300, '350.00', 50),
(127, 1048, 'PVC', '4\"', 400, '450.00', 50),
(128, 1093, 'Elbow', '2\"', 60, '80.00', 50),
(129, 1093, 'Elbow', '3\"', 85, '113.00', 50),
(130, 1093, 'Elbow', '4\"', 130, '150.00', 50),
(131, 1098, 'Shovel', 'Round', 200, '250.00', 20),
(132, 1098, 'Shovel', 'Square', 300, '450.00', 40),
(133, 1063, 'Blind Rivets (Per Box)', '1/8 ½\"', 150, '180.00', 50),
(134, 1063, 'Blind Rivets (Per Box)', '1/8 ¾\"', 170, '200.00', 60),
(135, 1099, 'Chicago Floor Strainer', 'Stainless', 70, '90.00', 55),
(136, 1099, 'Chicago Floor Strainer', 'Plastic', 20, '40.00', 45),
(137, 1057, 'Teflon Tape ', 'Small', 7, '15.00', 34),
(138, 1057, 'Teflon Tape ', 'Large', 10, '30.00', 35),
(139, 1060, 'PVC Hose Coupling', '3/4\"', 25, '45.00', 55),
(140, 1060, 'PVC Hose Coupling', '5/8\"', 35, '50.00', 68),
(141, 1100, 'Elbow Tee', '1/2\"', 15, '20.00', 50),
(142, 1100, 'Elbow Tee', '3/4\"', 20, '25.00', 55),
(143, 1061, 'PVC Clamp', 'Orange (Per Piece)', 5, '10.00', 30),
(144, 1061, 'PVC Clamp', 'Blue (Per Piece)', 5, '10.00', 60),
(145, 1061, 'PVC Clamp', 'Orange (Per Box 50pcs.)', 250, '500.00', 50),
(146, 1061, 'PVC Clamp', 'Blue (Per Box 50pcs.)', 250, '500.00', 50),
(147, 1059, 'Ordinary PVC Faucet', 'With Bib', 25, '50.00', 25),
(148, 1059, 'Ordinary PVC Faucet', 'Without Bib', 25, '50.00', 56),
(149, 1109, 'Sandflex Handsaw Blade ', '18-TPI', 40, '45.00', 79),
(150, 1109, 'Sandflex Handsaw Blade ', '24-TPI', 50, '55.00', 87),
(151, 1114, 'Paint Brush', '#1 1/2', 10, '15.00', 78),
(152, 1114, 'Paint Brush', '#2', 20, '25.00', 87);

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
(9, 'Hand Tools');

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
(215, 121, 1044, 1058, 'Kitchen Sink - Stainless', '350.00', 'k1.png', '1', '', '6543e66187be1_download.jpg', 'To Receive', '2023-11-05 11:03:57', '350', '0'),
(216, 121, 1044, 1056, 'Butane Torch', '600.00', 'bt.jpg', '1', '', '6543e66187be1_download.jpg', 'To Receive', '2023-11-05 11:03:57', '600', '0'),
(217, 121, 1044, 1064, 'Omega HD PVC Faucet Crown Handle', '80.00', '0013780_omega-plastic-tap-faucet-ball-type-with-hose-bib-12-in-x-4-in-pt-8125-1_625.jpeg', '1', 'Without Bib', '6543e66187be1_download.jpg', 'To Receive', '2023-11-05 11:03:57', '80', '0'),
(218, 251, 1044, 1057, 'Teflon Tape ', '7.50', 't1.jpg', '5', '3/4', '6543e6871d8b7_aa.png', 'To Ship', '2023-11-05 08:02:22', '37.5', '2.25'),
(219, 251, 1044, 1059, 'Ordinary PVC Faucet', '20.00', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '1', 'With Bib', '6543e6871d8b7_aa.png', 'To Ship', '2023-11-05 08:02:22', '20', '0'),
(220, 227, 1045, 1061, 'PVC Clamp', '95.00', 'pc.jpg', '1', '', '6543e75e4f3fd_aa.png', 'To Ship', '2023-11-05 07:12:29', '95', '0'),
(225, 419, 1042, 1058, 'Kitchen Sink - Stainless', '350.00', 'k1.png', '2', '', '65463daf68ca5_boy.jpg', 'Complete', '2023-11-05 11:09:17', '700', '0'),
(226, 419, 1042, 1064, 'Omega HD PVC Faucet Crown Handle', '80.00', '0013780_omega-plastic-tap-faucet-ball-type-with-hose-bib-12-in-x-4-in-pt-8125-1_625.jpeg', '1', 'Without Bib', '65463daf68ca5_boy.jpg', 'Complete', '2023-11-05 11:09:17', '80', '0'),
(227, 127, 1042, 1063, 'Blind Rivets', '470.00', 'b1.jpg', '1', '', '65473f21394a3_boy.jpg', 'To Ship', '2023-11-05 11:07:58', '470', '0'),
(228, 127, 1042, 1060, 'PVC Hose Coupling', '25.00', 'j1.png', '6', '', '65473f21394a3_boy.jpg', 'To Ship', '2023-11-05 11:07:58', '150', '15'),
(229, 473, 1042, 1063, 'Blind Rivets', '470.00', 'b1.jpg', '5', '', '6548fce3ab244_aa.png', 'Pending', '2023-11-06 14:49:07', '2350', '235'),
(230, 473, 1042, 1057, 'Teflon Tape ', '4.50', 't1.jpg', '1', '1/2', '6548fce3ab244_aa.png', 'Pending', '2023-11-06 14:49:07', '4.5', '0');

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
  `supplier_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `name`, `category`, `prod_desc`, `price`, `qty`, `new_qty`, `stock`, `image`, `purchase_date`, `supplier_price`) VALUES
(1051, 'Claw Hammer Wooden Handle', 'Hand Tools', 'A claw hammer with a wooden handle is a classic and versatile hand tool used for a variety of carpentry and construction tasks. It features a sturdy wooden handle for a comfortable grip and a metal head with two striking surfaces: one for driving nails and the other with a curved \"claw\" for removing nails.', '160', '39', 10, 'Instock', 'claw.jpg', '2023-11-05 09:42:22', 120),
(1057, 'Teflon Tape ', 'Plumbing Pipes & Accessories', 'Teflon tape, also known as PTFE tape, is a versatile sealing material used for creating a secure, watertight seal in plumbing and pipe connections. It is made of polytetrafluoroethylene (PTFE), a non-stick and heat-resistant material.', '15', '31', 0, 'Instock', 't1.jpg', '2023-11-06 14:49:07', 7),
(1059, 'Ordinary PVC Faucet', 'Plumbing Pipes & Accessories', 'An ordinary PVC faucet, also known as a plastic faucet, is a simple plumbing fixture designed for controlling the flow of water in various household applications. It is typically made from polyvinyl chloride (PVC) material, which is a type of plastic known for its durability and resistance to corrosion. ', '20', '65', 0, 'Instock', 'c1ae040062f3fb82814d2d0d9bf87f68.jpg', '2023-11-03 11:04:29', 15),
(1060, 'PVC Hose Coupling', 'Plumbing Pipes & Accessories', 'A PVC hose coupling is a connecting component made from durable polyvinyl chloride (PVC) material. Its primary purpose is to join or extend PVC hoses in a secure and leak-resistant manner. These couplings typically come in various shapes and sizes, with threaded or barbed ends that fit snugly into the hoses.', '25', '69', 0, 'Instock', 'j1.png', '2023-11-05 07:07:13', 20),
(1061, 'PVC Clamp', 'Plumbing Pipes & Accessories', 'A PVC clamp is a versatile fastening device made from durable PVC (polyvinyl chloride) material. It is designed to secure and support pipes, tubes, or cables in various applications. These clamps feature a simple yet effective design, typically with a hinged or two-piece construction for easy installation.', '95', '66', 1, 'Instock', 'pc.jpg', '2023-11-02 22:29:38', 90),
(1063, 'Blind Rivets (Per Box)', 'Steel Products', 'Blind rivets, also known as pop rivets, are fasteners used to join two or more materials together when you can only access one side. They consist of a cylindrical shaft with a flange at one end and a mandrel (a stem) at the other. ', '470', '67', 0, 'Instock', 'b1.jpg', '2023-11-06 14:49:07', 450),
(1082, 'Coco Lumber', 'Wood Products', 'Coco lumber is a type of construction material made from the trunk of the coconut palm tree. It is known for its strength, durability, and versatility, making it a popular choice for various building projects, especially in tropical regions. Coco lumber is typically used for framing, roofing, and various structural applications in construction.', '124', '90', 0, 'Instock', 'coco lumber.png', '2023-11-06 14:40:03', 115),
(1083, 'Semento (Per Sack 40 Kilos)', 'Concreting & Masonry', 'Semento is a category of construction material sold in 40-kilogram sacks or bags. It is commonly used for various building and masonry applications, offering strong adhesive properties and stability in construction projects.', '204', '130', 0, 'Instock', 'semento.png', '2023-11-06 14:42:37', 199),
(1086, 'Bistay (Per Bucket)', 'Concreting & Masonry', 'Bistay is a construction material typically used for reinforcing concrete structures. It consists of steel bars or mesh that adds strength and durability to concrete, making it an essential component in various building and infrastructure projects.', '35', '50', 0, 'Instock', 'bistay.png', '2023-11-05 09:04:45', 25),
(1087, 'Steel Bar', 'Steel Products', 'Steel bars are essential construction materials made of steel and commonly used to reinforce concrete structures. These bars provide strength and durability to concrete, making them a crucial component in various building and infrastructure projects. They come in various sizes and shapes, depending on their intended use in construction.', '364', '40', 0, 'Instock', 'steelbar.png', '2023-11-05 09:06:35', 359),
(1088, 'Hollow Blocks', 'Concreting & Masonry', 'Hollow blocks are building components made of concrete or other materials. They feature a hollow core, which reduces their weight and makes them ideal for constructing walls and other structural elements in construction projects. Hollow blocks are known for their affordability, ease of installation, and thermal insulation properties.', '19', '50', 0, 'Instock', 'hollow.png', '2023-11-05 09:11:00', 17),
(1089, 'Grava (Per Sack)', 'Concreting & Masonry', 'Grava is a construction material consisting of small, coarse stones or gravel typically used as a key ingredient in concrete mixes. It adds strength and stability to concrete and is often used for various construction applications, including roads, foundations, and building projects.', '45', '100', 0, 'Instock', 'Grava.jpg', '2023-11-05 09:14:50', 30),
(1090, 'GI Wire (Per Kilo)', 'Steel Products', 'GI wire, short for Galvanized Iron wire, is a type of steel wire that has been coated with a layer of zinc. This galvanization process protects the wire from corrosion and rust, making it highly durable and suitable for various applications in construction, fencing, and other industries.', '100', '100', 0, 'Instock', 'gi wire.png', '2023-11-05 09:17:18', 90),
(1091, 'Nails (Per Kilo)', 'Steel Products', 'Nails, often referred to as \"pako\" in some regions, are slender metal fasteners with a pointed end. They are commonly used in construction and carpentry to join or secure various materials together, such as wood, metal, or concrete. Nails come in different sizes and types, each suited for specific applications.', '100', '100', 0, 'Instock', 'nails.jpg', '2023-11-05 09:18:44', 90),
(1092, 'PVC', 'Plumbing Pipes & Accessories', 'PVC, or Polyvinyl Chloride, is a versatile and durable synthetic plastic material. It is commonly used in various applications, including pipes, cable insulation, vinyl flooring, and more, due to its excellent resistance to chemicals, weather, and physical wear, making it an ideal choice for both industrial and consumer products.', '250', '100', 0, 'Instock', 'pvcc.jpg', '2023-11-05 09:27:47', 200),
(1093, 'Elbow', 'Plumbing Pipes & Accessories', 'An elbow pipe is a plumbing or pipe fitting with a 90-degree bend, allowing pipes to change direction smoothly in a plumbing or piping system. It is essential for redirecting the flow of liquids or gases while maintaining a secure and leak-free connection between two pipes.', '150', '50', 0, 'Instock', 'elbow11.jpg', '2023-11-05 09:30:16', 130),
(1094, 'Utility Box', 'Electrical Pipes & Accessories', 'A utility box is a container or enclosure used to house and protect various electrical components, such as switches, outlets, or circuit breakers. It is an essential part of electrical systems, providing safety and easy access for maintenance while concealing wiring and connections. Utility boxes come in different sizes and styles to accommodate different electrical needs.', '30', '50', 0, 'Instock', 'utility box.png', '2023-11-05 09:35:51', 20),
(1095, 'Junction Box', 'Electrical Pipes & Accessories', 'A junction box is an enclosure used in electrical wiring to protect and safely contain the junction of electrical connections or splices. It provides a secure and organized space for connecting wires and helps prevent electrical hazards. Junction boxes are available in various sizes and types, depending on the specific application.', '30', '50', 0, 'Instock', 'junction.jpg', '2023-11-05 09:37:04', 20),
(1096, 'Cutting Disc', 'Concreting & Masonry', 'A cutting disc is a thin, circular abrasive tool typically used with handheld grinders or saws. It is designed for cutting various materials, including metal, stone, and concrete. Cutting discs are known for their precision and efficiency in making clean and accurate cuts in different applications, such as metalworking and construction.', '50', '60', 0, 'Instock', 'cd.png', '2023-11-05 09:40:15', 25),
(1097, 'Grinding Disc', 'Concreting & Masonry', 'A grinding disc is a flat, abrasive tool designed for use with grinders and similar machinery. It is primarily used for smoothing or shaping surfaces and removing material from workpieces, such as metal, stone, or concrete. Grinding discs are essential for tasks like sharpening tools, smoothing welds, and preparing surfaces for further finishing.', '50', '40', 0, 'Instock', 'grind.png', '2023-11-05 09:41:04', 25),
(1098, 'Shovel', 'Concreting & Masonry', 'A shovel is a manual tool with a handle and a broad, flat blade at the end. It is commonly used for digging, lifting, and moving various materials, such as soil, sand, or snow. Shovels come in different designs for specific tasks, making them essential tools in gardening, construction, and snow removal.', '450', '30', 0, 'Instock', 'shov.jpg', '2023-11-05 09:43:48', 300),
(1099, 'Chicago Floor Strainer', 'Plumbing Pipes & Accessories', 'A Chicago floor strainer is a plumbing fixture designed to be installed in a floor or low-lying area to collect and drain water or other liquids. It typically features a grated or perforated cover that allows liquid to pass through while preventing debris from clogging the drain. These strainers are commonly used in commercial and industrial settings to maintain proper drainage and prevent flooding.', '40', '60', 0, 'Instock', 'plassteel.jpg', '2023-11-06 14:30:33', 20),
(1100, 'Elbow Tee', 'Plumbing Pipes & Accessories', 'An elbow tee is a plumbing fitting that combines the features of an elbow and a tee. It has a 90-degree bend and a T-shaped configuration, allowing for a change in the direction of fluid flow while also providing a branch connection. Elbow tees are commonly used in plumbing systems to route water or gas in different directions and accommodate additional pipes or fixtures.', '20', '40', 0, 'Instock', '3e64a49331d702f8be308d82b33386c7.jpg', '2023-11-05 09:57:02', 15),
(1101, 'Elf Grava', 'Concreting & Masonry', 'The Elf Grava 1.6 size truck is a compact commercial vehicle designed for transporting goods and materials. It typically has a 1.6-ton payload capacity, making it suitable for various small to medium-sized cargo loads. The Elf Grava is known for its maneuverability, efficiency, and versatility in urban and rural settings, making it a popular choice for businesses that require reliable transportation for their goods.', '3500', '5', 0, 'Instock', 'elf grava.jpg', '2023-11-05 10:09:52', 3000),
(1102, 'Elf Buhangin', 'Concreting & Masonry', 'The Elf Buhangin 1.6 size truck is a compact commercial vehicle designed for transporting goods and materials. It typically has a 1.6-ton payload capacity, making it suitable for various small to medium-sized cargo loads. The Elf Buhangin is known for its maneuverability, efficiency, and versatility in urban and rural settings, making it a popular choice for businesses that require reliable transportation for their goods.', '3000', '6', 0, 'Instock', 'elfbuha.jpg', '2023-11-05 10:11:21', 2500),
(1106, 'Finishing Trowel ', 'Concreting & Masonry', 'A finishing trowel is a hand tool commonly used in construction and masonry work to smooth and level the surface of concrete, plaster, stucco, or other similar materials. It is an essential tool for achieving a polished and uniform finish on surfaces such as walls, ceilings, and floors.', '48', '136', 0, 'Instock', 'fin.JPG', '2023-11-06 13:09:54', 35),
(1107, 'Cement Trowel ', 'Concreting & Masonry', 'A cement trowel is a specialized hand tool used in construction and masonry for applying, spreading, and smoothing cement-based materials, such as mortar and concrete. It is designed to help tradespeople and DIY enthusiasts work with these materials efficiently and effectively. ', '82', '75', 0, 'Instock', 'cement.JPG', '2023-11-06 13:35:45', 70),
(1108, 'Mansion Steel Brush', 'Steel Products', 'A mansion steel brush, also known as a wire brush, is a hand tool used for various cleaning, surface preparation, and finishing tasks. It typically consists of a handle and a series of wire bristles attached to the head. The mansion steel brush is designed for heavy-duty cleaning and can be used in a variety of applications.', '69', '59', 0, 'Instock', 'mansion.JPG', '2023-11-06 13:38:14', 55),
(1109, 'Sandflex Handsaw Blade ', 'Steel Products', 'The Sandflex handsaw blade is a versatile cutting tool designed for various applications, such as cutting metal, plastic, and wood. It is known for its durability, flexibility, and ability to cut through a wide range of materials efficiently. ', '45', '89', 0, 'Instock', 'sandflex.JPG', '2023-11-06 13:46:24', 40),
(1110, 'Wood Chisel', 'Wood Products', 'A wood chisel is a hand tool used for cutting, shaping, and carving wood. It is an essential tool for woodworking and carpentry, enabling craftsmen to remove material or create precise, intricate details in wooden pieces. ', '74', '82', 0, 'Instock', 'wood.JPG', '2023-11-06 13:52:30', 65),
(1111, 'Vice Grip Iron G Clam', 'Electrical Pipes & Accessories', 'Vice Grip Iron G Clam is a popular brand of locking pliers and clamps, known for their ability to securely grip and hold objects in place. ', '89', '178', 0, 'Instock', 'grip.JPG', '2023-11-06 13:55:14', 75),
(1112, 'Standard Measuring Tape', 'Electrical Pipes & Accessories', 'A standard measuring tape, often referred to as a tape measure, is a flexible and portable tool used for measuring lengths and distances. It is commonly used in construction, carpentry, sewing, and various DIY projects. ', '58', '193', 0, 'Instock', 'tape.JPG', '2023-11-06 13:57:45', 45),
(1113, 'Pliers', 'Electrical Pipes & Accessories', 'Pliers are versatile hand tools used for gripping, bending, cutting, and manipulating a wide range of materials, including wires, cables, pipes, and small objects. They come in various designs and styles, each tailored for specific tasks and applications.', '115', '170', 0, 'Instock', 'pliers.JPG', '2023-11-06 13:59:31', 95),
(1114, 'Paint Brush', 'Hand Tools', 'A paint brush is a basic yet essential tool used in painting for applying paint to various surfaces, such as walls, furniture, canvases, and more. Paint brushes come in a variety of sizes, shapes, and bristle materials, each suited for different types of painting projects. ', '15', '65', 0, 'Instock', 'brush.JPG', '2023-11-06 14:15:36', 10);

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
(1044, 'Ramos', 'Sofia', 'Recto', '09789012345', 'Santolan', '1610', '890', 'Marcos Highway', 'Santolan Hills', 'Female', '2001-11-25', 'visejid728@soebing.com', 'S0f!aRamos80', 'sof.jpg', 'S0f!aRamos80', 1),
(1045, 'Dela Santos', 'Pedro', 'Loresco', '09890123456', 'Dela Paz', '1600', '567', 'Amang Rodriguez Avenue', 'Sta. Lucia Village', 'Male', '1978-04-02', 'necowo@lyft.live', 'P3droTan78', 'pedro.JPG', 'P3droTan78', 1),
(1046, 'Lim', 'Anne', '', '09345678901', 'Oranbo', '1604', '456', 'Meralco Avenue', 'Valle Verde', 'Female', '1997-08-22', 'huhyveme@afia.pro', 'Grac3An$789', 'anne.JPG', 'Grac3An$789', 1),
(1047, 'Santos', 'Maria', 'Reyes', '09123456789', 'San Antonio', '1600', '123', 'Lopez St.', 'Mabini Village', 'Female', '1989-05-15', 'viwadih198@newnime.com', 'M@ria123', 'mar.jpg', 'M@ria123', 1),
(1048, 'Tan', 'Carlos', 'Aquino', '09234567890', 'Rosario', '1609', '789', 'Ortigas Avenue', 'Rosario Heights', 'Male', '2000-12-10', 'lozybiby@clout.wiki', 'Car10s#An', 'carlos.jpg', 'Car10s#An', 1),
(1049, 'Cruz', 'Juan', 'Andres', '09456789012', 'Bagong Ilog', '1600', '321', 'Dr. Sixto Antonio Avenue', 'Springville Subdivision', 'Male', '1990-03-17', 'kugyfime@socam.me', 'Ju@nCruz90', 'juan.jpg', 'Ju@nCruz90', 1),
(1050, 'Dela Pena', 'Miguel', '', '09567890123', 'San Miguel', '1607', '222', 'Caruncho Avenue', 'San Miguel', 'Male', '1976-06-30', 'suqolo@tutuapp.bid', 'Migue1Rodrig@', 'mig.jpg', 'Migue1Rodrig@', 1),
(1051, 'Martinez', 'Klare', 'Recto', '09678901234', 'Caniogan', '1606', '654', 'Mercedes Avenue', 'Villa Raymundo', 'Female', '1983-09-05', 'poxogo@afia.pro', 'AnaMart#nez83', 'klare.jpg', 'AnaMart#nez83', 1),
(1052, 'Garcia', 'Isabella', 'Campos', '09901234567', 'Ugong', '1604', '432', 'Sixto Antonio Avenue', 'Valley Golf Subdivision', 'Female', '1986-06-30', 'popesofe@hexi.pics', 'Is@b3llaG#r', 'isa.jpg', 'Is@b3llaG#r', 1),
(1053, 'Susano', 'Gabriel', '', '09111223344', 'Malinao', '1611', '765', 'Caruncho Avenue', 'Caruncho Subdivision', 'Male', '1982-12-10', 'rufigele@tutuapp.bid', 'G@bri3l#', 'gabriel.JPG', 'G@bri3l#', 1),
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
(1074, 'Goyal', 'Rafael', 'Pineda', '09678901234', 'Caniogan', '1606', '435', 'Eusebio Avenue', 'Caniogan Village', 'Male', '1978-02-08', 'vyvoliwo@yogrow.co', 'R@fa3#lGoy', 'rafe.JPG', 'R@fa3#lGoy', 1);

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
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=523;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1115;

--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1075;

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
