-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 12 月 09 日 11:03
-- 伺服器版本： 10.4.21-MariaDB
-- PHP 版本： 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `goals`
--

-- --------------------------------------------------------

--
-- 資料表結構 `user_order_product`
--

CREATE TABLE `user_order_product` (
  `id` int(5) UNSIGNED NOT NULL,
  `order_id` int(5) UNSIGNED NOT NULL,
  `product_id` int(3) UNSIGNED NOT NULL,
  `amount` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order_product`
--

INSERT INTO `user_order_product` (`id`, `order_id`, `product_id`, `amount`) VALUES
(1, 1, 5, 5),
(2, 1, 4, 1),
(3, 2, 5, 1),
(4, 2, 2, 1),
(5, 2, 2, 1),
(6, 3, 7, 5),
(7, 3, 6, 4),
(8, 4, 5, 3),
(9, 5, 3, 5),
(10, 10, 2, 3),
(11, 9, 6, 2),
(12, 17, 10, 1),
(13, 12, 3, 3),
(14, 15, 14, 4),
(15, 7, 8, 2),
(16, 7, 13, 7),
(17, 16, 8, 9),
(18, 17, 3, 20),
(19, 18, 2, 1),
(20, 20, 7, 10);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `user_order_product`
--
ALTER TABLE `user_order_product`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order_product`
--
ALTER TABLE `user_order_product`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
