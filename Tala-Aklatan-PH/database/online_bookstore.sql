-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 12:47 AM
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
-- Database: `online_bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A novel about the American Dream and the moral decay of society during the 1920s.', 299.99, 'img/gatsby.jpg', '2024-11-28 12:19:40', '2024-11-28 12:23:10'),
(2, '1984', 'George Orwell', 'A dystopian novel set in a totalitarian society governed by Big Brother.', 199.99, 'img/1984.jfif', '2024-11-28 12:19:40', '2024-11-28 12:29:21'),
(3, 'To Kill a Mockingbird', 'Harper Lee', 'A classic novel that deals with racial injustice in the Deep South during the 1930s.', 249.99, 'img/to-kill-a-mockingbird.jfif', '2024-11-28 12:19:40', '2024-11-28 12:31:06'),
(4, 'The Catcher in the Rye', 'J.D. Salinger', 'A novel about teenage angst and alienation, told through the eyes of Holden Caulfield.', 179.99, 'img/catcher.jpg', '2024-11-28 12:19:40', '2024-11-28 12:32:39'),
(5, 'Moby-Dick', 'Herman Melville', 'A sea adventure story about Captain Ahab’s obsessive quest to kill the white whale, Moby Dick.', 359.99, 'img/moby.jpg', '2024-11-28 12:19:40', '2024-11-28 12:27:16'),
(6, 'Pride and Prejudice', 'Jane Austen', 'A romantic novel that deals with issues of class, marriage, and morality in 19th-century England.', 199.99, 'img/pride_and_prejudice.jpg', '2024-11-28 12:19:40', '2024-11-28 12:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`, `quantity`, `added_at`) VALUES
(2, 1, 1, 1, '2024-11-28 12:38:50'),
(7, 1, 1, 100, '2024-11-28 12:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `contact`, `shipping_method`, `shipping_date`, `payment_method`, `total_price`, `status`, `created_at`) VALUES
(1, 2, 'haha', '0994654401', 'overnight', '2024-11-25', 'cod', 879.96, 'Pending', '2024-11-28 22:07:04'),
(2, 2, 'haha', '0994654401', 'overnight', '2024-11-25', 'cod', 879.96, 'Pending', '2024-11-28 22:07:14'),
(3, 2, 'haha', '0994654401', 'overnight', '2024-11-25', 'cod', 879.96, 'Pending', '2024-11-28 22:07:26'),
(4, 2, 'haha', '0994654401', 'overnight', '2024-11-25', 'cod', 879.96, 'Pending', '2024-11-28 22:08:31'),
(5, 2, 'hahahah', '12154125', 'standard', '2024-11-19', 'credit_card', 899.97, 'Pending', '2024-11-28 22:17:35'),
(6, 2, 'gah', '0994654401', 'standard', '2024-11-14', 'credit_card', 36598.78, 'Pending', '2024-11-28 22:31:43'),
(7, 3, NULL, NULL, NULL, NULL, NULL, 599.97, 'Pending', '2024-11-28 23:28:22'),
(8, 3, NULL, NULL, NULL, NULL, NULL, 599.97, 'Pending', '2024-11-28 23:28:28'),
(9, 3, 'blk123 di makita street', '0994654401', 'standard', '2024-11-03', 'cod', 599.97, 'Pending', '2024-11-28 23:29:25'),
(10, 3, 'blk123 di makita street', '0994654401', 'standard', '2024-11-12', 'paypal', 1599.92, 'Pending', '2024-11-28 23:29:57'),
(11, 4, 'blk123 di makita street', '0994654401', 'standard', '2024-11-20', 'cod', 2249.89, 'Pending', '2024-11-28 23:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `price`) VALUES
(1, 4, 4, 1, 179.99),
(2, 4, 2, 1, 199.99),
(3, 4, 2, 1, 199.99),
(4, 4, 1, 1, 299.99),
(5, 5, 1, 1, 299.99),
(6, 5, 1, 1, 299.99),
(7, 5, 1, 1, 299.99),
(8, 6, 1, 122, 299.99),
(11, 9, 2, 3, 199.99),
(12, 10, 2, 1, 199.99),
(13, 10, 2, 1, 199.99),
(14, 10, 2, 1, 199.99),
(15, 10, 2, 1, 199.99),
(16, 10, 2, 1, 199.99),
(17, 10, 2, 1, 199.99),
(18, 10, 2, 1, 199.99),
(19, 10, 2, 1, 199.99),
(20, 11, 2, 10, 199.99),
(21, 11, 3, 1, 249.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'pat', '202cb962ac59075b964b07152d234b70', '', '2024-11-28 12:15:28'),
(2, 'eilene', '202cb962ac59075b964b07152d234b70', '', '2024-11-28 20:30:03'),
(3, 'marco', '202cb962ac59075b964b07152d234b70', '', '2024-11-28 23:25:36'),
(4, 'may', '202cb962ac59075b964b07152d234b70', '', '2024-11-28 23:34:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `book_id` (`book_id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
