-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-12-10 23:32:18
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
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` tinyint(4) UNSIGNED NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_time` date DEFAULT NULL,
  `valid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `birthday`, `gender`, `address`, `created_time`, `valid`) VALUES
(1, 'May', '1234', 'May@test.com', '1995-12-22', 2, '台南', '2021-12-10', 1),
(2, 'Jay', '1235', 'Jay@test.com', '1955-12-02', 1, '花蓮', '2021-12-02', 1),
(3, 'Sam', '1236', 'Sam@test.com', '1966-01-01', 1, '台北', '2021-12-01', 1),
(4, 'John', '1237', 'John@test.com', '1993-02-05', 1, '台北', '2021-12-10', 1),
(5, 'Joe', '1238', 'Joe@test.com', '1987-05-08', 1, '新北', '2021-10-11', 1),
(6, 'Nick', '1239', 'Jay@test.com', '1982-06-05', 1, '台北', '2021-11-14', 1),
(7, 'Sandy', '1240', 'Sandy@test.com', '1975-02-07', 2, '台中', '1899-11-20', 1),
(8, 'Harry', '1241', 'Harry@test.com', '1977-01-31', 1, '台南', '2021-10-03', 1),
(9, 'Simon', '1242', 'Simon@test.com', '1978-02-28', 1, '桃園', '2021-11-23', 1),
(10, 'Amy', '1243', 'Amy@test.com', '1963-05-07', 2, '桃園', '2021-11-21', 1),
(11, 'Aya', '1244', 'Aya@test.com', '1971-05-02', 2, '高雄', '2021-11-22', 1),
(12, 'Carly', '1245', 'Carly@test.com', '1999-04-30', 2, '高雄', '2021-11-08', 1),
(13, 'Sarah', '1246', 'Sarah@test.com', '2001-08-17', 2, '台中', '2021-11-15', 1),
(14, 'Anna', '1247', 'Anna@test.com', '2003-11-01', 2, '桃園', '2021-11-15', 1),
(15, 'Vanessa', '1248', 'Vanessa@test.com', '2002-01-31', 2, '新北', '2021-11-16', 1),
(16, 'admin', '123', '12345@test.com', '2021-12-17', 1, '桃園', '2021-12-09', 1),
(17, 'Charlie', '1249', 'Charlie@test.com', '1995-12-21', 1, '新竹', '2021-12-13', 1),
(18, 'Johnson', '1250', 'Johnson@test.com', '1990-02-11', 1, '花蓮', '2021-12-08', 1),
(19, 'Alice', '1251', 'Alice@test.com', '1985-01-03', 2, '高雄', '2021-12-13', 1),
(20, 'Cathy', '1252', 'Cathy@test.com', '2000-05-03', 2, '新北', '2021-12-06', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
