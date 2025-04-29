-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 11:30 AM
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
-- Database: `styleheaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `size` varchar(10) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `harga`, `quantity`, `size`, `added_at`) VALUES
(91, 4, 40, 1200000.00, 1, 'XXL', '2025-04-15 12:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `looks`
--

CREATE TABLE `looks` (
  `id` int(11) NOT NULL,
  `look_name` varchar(255) DEFAULT NULL,
  `look_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `looks`
--

INSERT INTO `looks` (`id`, `look_name`, `look_image`) VALUES
(4, 'Vacation Casual', 'T0084041802-p.jpg'),
(5, 'Casual Summer Elegance', 'T0466987201-p.jpg'),
(6, 'Modern Vintage Street', '04365416105-a1.jpg'),
(7, 'Minimalist Chic', '04365416105-e1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `look_produk`
--

CREATE TABLE `look_produk` (
  `id` int(11) NOT NULL,
  `look_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `look_produk`
--

INSERT INTO `look_produk` (`id`, `look_id`, `produk_id`) VALUES
(3, 4, 87),
(4, 4, 88),
(5, 5, 91),
(6, 5, 92),
(7, 6, 89),
(8, 6, 90),
(9, 7, 93),
(10, 7, 94);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('Pending','Diproses','Dikirim','Selesai','Dibatalkan') DEFAULT 'Pending',
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_penerima` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `alamat_pengiriman` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_harga`, `status`, `tanggal_pesanan`, `nama_penerima`, `bukti_transfer`, `alamat_pengiriman`) VALUES
(19, 4, 8696000.00, 'Selesai', '2025-04-04 14:06:24', 'Wulan', '1743775584_Screenshot 2025-04-04 202232.png', 'Margorejo, Pati'),
(25, 4, 2349999.00, 'Selesai', '2025-04-04 23:41:55', 'Nanda', '1743835315_Screenshot 2025-03-30 163541.png', 'Desa Giling RT 2 RW 6 Kecamatan Gunungwungkal Kabupaten Pati'),
(26, 4, 14399989.00, 'Selesai', '2025-04-05 06:07:15', 'Dhoni Tri', '1743858435_Screenshot (95).png', 'Jetis Kulon Gg VIII F No.34A, Wonokromo, Surabaya'),
(27, 4, 1747000.00, 'Selesai', '2025-04-07 21:26:52', 'Marlina', '1744086412_astronaut-67644_1920.jpg', 'Mojokerto, Jawa Timur'),
(28, 4, 1060000.00, 'Diproses', '2025-04-08 05:43:03', 'Munawaroh', '1744116183_download.jpeg', 'Wonokromo, Surabaya'),
(29, 4, 2273000.00, 'Diproses', '2025-04-13 20:00:19', 'Nanda', '1744599619_Free Photo _ Soccer field  high angle.jpeg', 'Surabaya'),
(30, 4, 1300000.00, 'Selesai', '2025-04-14 20:26:33', 'Dhoni', '1744687593_20230928_172434.jpg', 'jiji'),
(31, 4, 999000.00, 'Diproses', '2025-04-14 20:32:40', 'Wan Khodir', '1744687960_Firefly 20240812190620.png', 'Street arhamuj baihatil mustofa, Saudi Arabia');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `harga_satuan`, `quantity`, `size`) VALUES
(18, 19, 48, 649000.00, 1, 'S'),
(19, 19, 28, 950000.00, 1, 'L'),
(21, 25, 28, 950000.00, 1, 'XL'),
(22, 25, 49, 1299999.00, 1, 'XXL'),
(23, 26, 49, 1299999.00, 11, 'XL'),
(24, 27, 43, 549000.00, 1, 'S'),
(25, 27, 43, 549000.00, 2, 'M'),
(26, 28, 53, 480000.00, 1, 'XL'),
(27, 28, 53, 480000.00, 1, 'S'),
(28, 29, 26, 45000.00, 1, 'XL'),
(29, 29, 26, 45000.00, 2, 'M'),
(30, 29, 40, 1200000.00, 1, 'L'),
(31, 29, 51, 419000.00, 2, 'L'),
(32, 30, 36, 1200000.00, 1, 'M'),
(33, 31, 46, 899000.00, 1, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` varchar(1000) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `waktutambah` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `deskripsi`, `stok`, `gambar`, `waktutambah`) VALUES
(26, 'Boys Scripted Polo', 'Kids', 45000.00, '-Regular fit, -92% polyester (recycled), 8% elastane, -Threem, -button polo collar. -Raised 3 Bar Logo', 297, 'is9706_2_apparel_photography_front20center20view_grey.jpg', '2025-04-14 03:00:19'),
(28, 'Manchester United 24/25 Home Jersey Kids', 'Kids', 950000.00, '-Regular fit\r\n-100% polyester (recycled\r\n-Mesh side panel\r\n-Crewneck\r\n-AEROREADY', 122, 'it1972_fr_torso_ecom.jpg', '2025-04-08 12:33:32'),
(35, 'David Beckham Originals Jersey', 'Men', 1200000.00, 'Slim fit\\r\\nProduct code: IX5463\\r\\n63% cotton, 37% polyester (recycled)', 100, 'ix5463_2_apparel_photography_front20center20view_grey.jpg', '2025-04-08 13:15:29'),
(36, 'Manchester United 24/25 Away Jersey', 'Men', 1200000.00, 'Slim fit\\r\\n100% polyester (recycled)\\r\\nMesh side panels\\r\\nOne-button polo collar\\r\\nAEROREADY', 397, 'iu1390_2_apparel_photography_front20center20view_grey.jpg', '2025-04-15 03:26:33'),
(37, 'Club Tennis Climacool Skirt', 'Women', 550000.00, 'Regular fit\\r\\n90% polyester (recycled), 10% elastane\\r\\nIntegrated inner leggings\\r\\nWide elastic waist\\r\\nCLIMACOOL', 70, 'jn1969_1_apparel_photography_front_center_view_grey.jpg', '2025-03-08 04:20:02'),
(39, 'Essentials Contemporary Logo Fleece Barrel Pants', 'Women', 800000.00, 'Loose fit\\r\\n55% cotton, 36% polyester (recycled), 9% viscose\\r\\nHigh rise\\r\\nDrawstring closure\\r\\nSide pockets', 36, 'jd9974_2_apparel_photography_front20center20view_grey.jpg', '2025-03-08 04:21:35'),
(40, 'Adicolor SST Tracksuit', 'Kids', 1200000.00, 'Regular fit\\r\\n100% recycled polyester tricot\\r\\nTop: Ribbed cuffs and hem\\r\\nTop: Full zip with ribbed bomber collar\\r\\nTop: Side pockets', 29, 'ir6923_2_apparel_photography_front_view_grey.jpg', '2025-04-14 03:00:19'),
(41, 'adidas Disney Mickey Mouse Track Top', 'Kids', 860000.00, 'Regular fit\\r\\n67% cotton, 33% polyester (recycled)\\r\\n©Disney\\r\\nProduct code: IV9621\\r\\nFull zip with hood\\r\\nSide pockets\\r\\nContains a minimum of 70% recycled and renewable content', 120, 'iv9621_2_apparel_photography_front20center20view_grey.jpg', '2025-04-08 04:12:11'),
(42, 'Ultimate Running Reflective 2-in-1 Shorts', 'Men', 1000000.00, 'Regular fit\\\\r\\\\n84% polyester (recycled), 16% elastane\\\\r\\\\nInner phone pocket\\\\r\\\\nProduct code: JD7800\\\\r\\\\nDrawcord on elastic waist\\\\r\\\\nCLIMACOOL+\\\\r\\\\nReflective logo', 62, 'jd7800_1_apparel_photography_front_center_view_grey.jpg', '2025-03-17 03:39:21'),
(43, 'Women\\\'s Oversized Shirt', 'Women', 549000.00, 'Made from midweight cotton and with a roomy fit, this tee gives you a perfectly relaxed look.Colour Country/Region of Origin: China', 28, 'AS+W+NSW+DANCE+OS+TEE.png', '2025-04-08 04:26:52'),
(44, 'Nike Women by YOON Women\'s Short-Sleeve Polo', 'Women', 759000.00, 'Vintage varsity vibes get a refresh in this slim-fitting polo. The midweight fabric with a bit of texture has some structure and enough stretch to give you a body-skimming fit with a comfortable feel.\r\n\r\n\r\nColour Shown: White/Armoury Navy\r\nStyle: FZ0277-100\r\nCountry/Region of Origin: China', 26, 'AS+W+NSW+YOON+SS+POLO+TOP.png', '2025-04-14 02:30:51'),
(46, 'Older Kids\' Nike Dri-FIT Football Replica Shirt', 'Kids', 899000.00, 'We updated the most iconic kit in the football world with an all-over print that celebrates Brazil\\\'s architecture, music and natural wonders. Look inside the shirt for a hidden detail celebrating national pride.\\r\\n\\r\\n\\r\\nColour Shown: Dynamic Yellow/Lemon Chiffon/Green Spark\\r\\nStyle: FJ4409-706\\r\\nCountry/Region of Origin: Indonesia', 28, 'CBF+Y+NK+DF+STAD+JSY+SS+HM.png', '2025-04-23 14:49:36'),
(47, 'Older Kids\\\' T-Shirt', 'Kids', 219000.00, 'You can\\\'t go wrong with classic Nike style. Made from soft and breathable cotton, this tee has an easy fit that\\\'s perfect for all your daily adventures.\\r\\n\\r\\n\\r\\nColour Shown: Aster Pink\\r\\nStyle: FZ5177-629\\r\\nCountry/Region of Origin: China', 23, 'K+NSW+TEE+EMB+FUTURA+LBR.png', '2025-03-08 04:31:22'),
(48, 'Woven Full-Zip Jacket', 'Kids', 649000.00, 'Not only is this jacket your ticket to having fun outside, but it\\\'s also something of a time machine. To create it, we drew inspiration from vintage athletic apparel. But this oversized layer is anything but outdated. Made from lightweight water-repellent fabric, it\\\'s ready to play come rain or shine—just like you! Plus, zip pockets help keep snacks and other essential items secure as you run and jump.\\r\\n\\r\\n\\r\\nColour Shown: Cargo Khaki/Oil Green/Light Bone\\r\\nStyle: FN9134-325\\r\\nCountry/Region of Origin: Vietnam', 45, 'K+NSW+AMPLIFY+WOVEN+FZ.png', '2025-04-08 15:20:51'),
(49, 'Women\'s Dri-FIT Oversized 1/2-Zip Top', 'Women', 1299999.00, 'Extraordinarily soft and smooth, our ImpossiblySoft fabric feels made for all-day motion. It\'s a double-knit material that adds structure to this top while wicking sweat—for comfort that doesn\'t quit.\r\nColour Shown: Black/Dark Smoke Grey\r\nStyle: HQ8189-010\r\nCountry/Region of Origin: China', 12, 'AS+W+NK+24.7+DF+HZ+TOP+SOFT.png', '2025-04-23 14:49:48'),
(50, 'Liverpool F.C. 2024/25 Stadium Home Men\\\'s Nike Dri-FIT Football Replica Shirt', 'Men', 999999.00, 'Our Stadium collection pairs replica design details with sweat-wicking technology to give you a game-ready look inspired by your favourite team.\\r\\n\\r\\n\\r\\nColour Shown: Gym Red/White/Chrome Yellow\\r\\nStyle: FN8798-688\\r\\nCountry/Region of Origin: Georgia', 12, 'LFC+M+NK+DF+JSY+SS+STAD+HM.png', '2025-04-05 03:35:00'),
(51, 'Nike Academy Men\\\'s Football Shorts', 'Men', 419000.00, 'These shorts have a classic fit with lightweight, sweat-wicking fabric. Mesh panels on the side help keep you cool through every drill and practice game.\\r\\n\\r\\n\\r\\nColour Shown: Photon Dust/White/Dynamic Turquoise\\r\\nStyle: FZ0388-025\\r\\nCountry/Region of Origin: Thailand', 41, 'AS+M+NK+ACD23+SHORT+WP+GX+HBR.png', '2025-04-14 03:00:19'),
(52, 'Kids Groundwork Overalls', 'Kids', 1123500.00, '0', 12, '1741410429_Kids-Groundwork-Overalls.png', '2025-03-08 05:07:09'),
(53, 'Drew Rib Tank', 'Women', 480000.00, 'Rib Tank untuk wanita', 17, '1741410552_Drew-Rib-Tank.png', '2025-04-08 12:43:03'),
(84, 'TEXTURED STRUCTURE SHIRT', 'Men', 799000.00, 'Relaxed fit shirt made of a cotton blend. Featuring a camp collar, short sleeves, a split hem and a button-up front.', 40, '680912631827d_07545472431-p.jpg', '2025-04-23 16:16:35'),
(85, 'TEXTURED COTTON SHIRT', 'Men', 1099000.00, 'Regular fit cotton shirt. Open spread collar and long sleeves with buttoned cuffs. Button-up front.', 10, '680913406fa38_00975500250-p.jpg', '2025-04-23 16:20:16'),
(86, 'Knitted Pajama Set', 'Women', 649000.00, 'Bahan: 64% Polyester, 34% Viscose, 2% Elastane\r\nPetunjuk Perawatan: Machine Wash Cold', 42, '680914bd789b5_trendyol-2914-9966554-1.webp', '2025-04-23 16:26:37'),
(87, 'TEXTURED CROCHET SHIRT', 'Men', 800000.00, 'Relaxed fit shirt made of open textured fabric. Camp collar and short sleeves. Button-up front.', 30, '68092e6e47e17_07200307086-e1.jpg', '2025-04-23 18:16:14'),
(88, '100% LINEN TROUSERS WITH STRIPES', 'Men', 739000.00, 'Relaxed fit linen trousers. Featuring an elasticated waistband with adjustable drawstrings, side pockets and back pocket detail. Contrasting stripes on the legs.', 30, '68092ec3d88c6_01618206251-000-e1.jpg', '2025-04-23 18:17:39'),
(89, 'STRIPED TEXTURED JACKET', 'Men', 999900.00, 'Relaxed fit jacket in cotton fabric. Featuring a lapel collar, long sleeves, welt pockets at the hip, elasticated trims and a zip-up front.', 35, '680932ec9c8ea_04365416105-e1.jpg', '2025-04-23 18:35:24'),
(90, 'RIB KNITTED TANK', 'Men', 629000.00, 'Relaxed fit knitted tank top in cotton yarn. Features a round neckline and sleeveless design.', 78, '68093314a6c9b_03166422251-e1.jpg', '2025-04-23 18:36:04'),
(91, 'TEXTURED POLO SHIRT', 'Men', 1029000.00, 'Relaxed fit cotton shirt. Featuring a button-down collar, long sleeves with buttoned cuffs and side vents at the hem.', 64, '680933621db1d_02688106904-e1.jpg', '2025-04-23 18:37:22'),
(92, 'TEXTURED LINEN SUIT TROUSERS', 'Men', 830000.00, 'Slim fit trousers in a linen blend. Featuring a pleated front waistband, front pockets, rear welt pockets and zip fly and top button fastening.', 32, '680933956d04a_04669872075-e1.jpg', '2025-04-23 18:38:13'),
(93, 'KNITTED STRAPPY TOP', 'Women', 449000.00, 'V-neck top with thin straps.', 35, '68093b42222af_05536045712-e1.jpg', '2025-04-23 19:10:58'),
(94, 'ZW COLLECTION WIDE-LEG LOW-RISE JEANS', 'Women', 750000.00, 'Low-rise jeans with belt loops. Five pockets. Wide leg. Front zip and button fastening.', 25, '68093b7b22745_09632076251-e1.jpg', '2025-04-23 19:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'alif', '$2y$10$tNTaIZL2Rx406ummOf1CCOIhNw2sjdqVyUWVWSLrqeRhigsolHGky', '2025-03-07 23:22:53'),
(2, 'jamal', '$2y$10$j9lrrsNPOCY/FG0FQI0CZe38GzRtdA9Hq0kjKZsntFn/nVvMI//ra', '2025-03-07 23:27:39'),
(3, 'doni', '$2y$10$aG1ss0w.NsQT6dtlQBO6.urTQ3UZAs64S5RzkWIMFB50TSWvx2E4e', '2025-03-08 02:29:03'),
(4, 'nanda', '$2y$10$lFJfNahq/h49ubZp4ISREuGMNYlBDKxSP1ZkjGmoHNXMRVkGnG9oa', '2025-03-08 15:06:19'),
(5, 'nandaprihadi', '$2y$10$xU9R8aR6ccsvdY5P125.J.G6/N3HD9HXPZDLs39El5WT67LDvwdBq', '2025-03-23 23:46:27'),
(6, 'paijo', '$2y$10$45zY/fr3JKWlwdfwYkJSru2tmS6WMOR4ee7bIXKU/GVFcBYyT8LeW', '2025-03-24 15:24:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_ibfk_1` (`product_id`);

--
-- Indexes for table `looks`
--
ALTER TABLE `looks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `look_produk`
--
ALTER TABLE `look_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `look_id` (`look_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `looks`
--
ALTER TABLE `looks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `look_produk`
--
ALTER TABLE `look_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `look_produk`
--
ALTER TABLE `look_produk`
  ADD CONSTRAINT `look_produk_ibfk_1` FOREIGN KEY (`look_id`) REFERENCES `looks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `look_produk_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
