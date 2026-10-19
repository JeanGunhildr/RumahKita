-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2026 at 06:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumahkita`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` varchar(12) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `property_type` enum('minimalis','cluster','villa','apartemen') NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `bedrooms` tinyint(3) UNSIGNED DEFAULT NULL,
  `bathrooms` tinyint(3) UNSIGNED DEFAULT NULL,
  `building_area` decimal(10,2) DEFAULT NULL,
  `land_area` decimal(10,2) DEFAULT NULL,
  `certificate_type` varchar(50) DEFAULT NULL,
  `status` enum('draft','pending','active','sold','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `user_id`, `title`, `description`, `property_type`, `price`, `address`, `city`, `province`, `bedrooms`, `bathrooms`, `building_area`, `land_area`, `certificate_type`, `status`, `created_at`, `updated_at`) VALUES
('PR-643A81', 1, '<script>alert(\"xss\")</script>', 'Deskripsi', 'minimalis', 99999999.00, 'Jl. Jenderal Soedirman', 'Purwokerto', 'Jawa Tengah', 3, 3, 120.00, 150.00, 'SHM', 'active', '2026-10-19 16:41:10', '2026-10-19 16:41:10'),
('PR-DEF9F1', 1, 'Rumah Minimalis Modern Purwokerto', 'Rumah minimalis dengan desain modern dan pencahayaan alami yang baik. Memiliki ruang tamu nyaman, tiga kamar tidur, serta halaman depan yang dapat dimanfaatkan sebagai taman.', 'minimalis', 650000000.00, 'Jl. HR Bunyamin No. 25', 'Purwokerto', 'Jawa Tengah', 3, 3, 120.00, 148.00, 'SHM', 'active', '2026-10-19 16:09:33', '2026-10-19 16:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `property_facilities`
--

CREATE TABLE `property_facilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` varchar(12) NOT NULL,
  `facility_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_facilities`
--

INSERT INTO `property_facilities` (`id`, `property_id`, `facility_name`) VALUES
(1, 'PR-DEF9F1', 'Kolam Renang'),
(2, 'PR-DEF9F1', 'AC Tiap Kamar'),
(3, 'PR-DEF9F1', 'Taman Asri'),
(4, 'PR-643A81', 'Garasi Mobil'),
(5, 'PR-643A81', 'Taman Asri');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` varchar(12) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `is_primary`, `created_at`) VALUES
(1, 'PR-DEF9F1', 'public/uploads/properties/prop_1792426173_a42fa122.jpeg', 1, '2026-10-19 16:09:33'),
(2, 'PR-643A81', 'public/uploads/properties/prop_1792428070_e38a352c.jpeg', 1, '2026-10-19 16:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$AU.au26XGVFtVnvGDtN4W.TaFg64/OIJykggCK4RHxScJn/ObQStG', '081234567890', 'admin', '2026-10-19 14:16:41'),
(2, 'User Pengujian', 'user@gmail.com', '$2y$10$tixnUgn5IBGDzDu6HD.OhejujKLNlr8oAhKKHD642e7Klwb9prdkG', '081234567891', 'user', '2026-10-19 14:43:30'),
(8, 'Budi Santoso', 'budi@gmail.com', '$2y$10$kttzuQEQoHHJ81A6QrJetOB8dpt0GM4GurO4yPtI6wewIY7UkHxSa', '081728172817', 'user', '2026-10-19 16:47:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `property_facilities`
--
ALTER TABLE `property_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `property_facilities`
--
ALTER TABLE `property_facilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `property_facilities`
--
ALTER TABLE `property_facilities`
  ADD CONSTRAINT `property_facilities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
