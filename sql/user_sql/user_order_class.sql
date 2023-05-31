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
-- 資料表結構 `user_order_class`
--

CREATE TABLE `user_order_class` (
  `id` int(5) NOT NULL,
  `order_id` int(5) UNSIGNED NOT NULL,
  `class_id` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order_class`
--

INSERT INTO `user_order_class` (`id`, `order_id`, `class_id`) VALUES
(1, 1, 5),
(2, 2, 4),
(3, 2, 2),
(4, 3, 4),
(5, 4, 5),
(6, 5, 5),
(7, 5, 2),
(8, 6, 4),
(9, 7, 12),
(10, 8, 3),
(11, 9, 23),
(12, 20, 17),
(13, 15, 10),
(14, 13, 2),
(15, 14, 4),
(16, 11, 19),
(17, 16, 22),
(18, 16, 16),
(19, 19, 7),
(20, 9, 14);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `user_order_class`
--
ALTER TABLE `user_order_class`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order_class`
--
ALTER TABLE `user_order_class`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
