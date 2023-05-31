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
-- 資料表結構 `user_order`
--

CREATE TABLE `user_order` (
  `id` int(11) NOT NULL,
  `user_id` tinyint(10) NOT NULL,
  `total` int(11) NOT NULL,
  `payment_id` tinyint(3) NOT NULL,
  `delivery_id` tinyint(3) NOT NULL,
  `receiver_name` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_tel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_address` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` tinyint(3) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order`
--

INSERT INTO `user_order` (`id`, `user_id`, `total`, `payment_id`, `delivery_id`, `receiver_name`, `receiver_tel`, `receiver_address`, `status_id`, `time`) VALUES
(1, 4, 2980, 2, 1, 'May', '0988151200', '桃園', 2, '2021-12-06 11:35:39'),
(2, 4, 4508, 1, 2, 'Jay', '0988151201', '新竹', 1, '2021-12-06 11:15:39'),
(3, 7, 3541, 1, 1, 'Sam', '0988151207', '台北', 1, '2021-12-06 10:35:35'),
(4, 19, 2450, 2, 1, 'John', '0988151211', '台北', 1, '2021-12-23 11:35:39'),
(5, 3, 5187, 2, 1, 'Joe', '0988151258', '花蓮', 1, '2021-12-06 11:25:39'),
(6, 1, 2000, 2, 2, 'Nick', '0988151211', '台北', 1, '2021-12-06 09:15:39'),
(7, 8, 2226, 1, 2, 'Sandy', '0988151215', '台中', 1, '2021-12-08 11:08:39'),
(8, 13, 2000, 2, 2, 'Harry', '0988151288', '台南', 1, '2020-12-17 11:35:39'),
(9, 13, 4358, 1, 2, 'Simon', '0988151297', '新竹', 1, '2021-12-02 11:35:01'),
(10, 13, 537, 2, 1, 'Amy', '0988151254', '桃園', 1, '2021-10-24 11:40:31'),
(11, 14, 2000, 1, 1, 'Aya', '0988151205', '高雄', 4, '2021-07-04 11:35:39'),
(12, 9, 390, 2, 1, 'Carly', '0988151208', '高雄', 3, '2021-07-01 11:05:00'),
(13, 2, 2000, 2, 1, 'Sarah', '0988151209', '台中', 3, '2020-12-24 11:25:07'),
(14, 1, 2000, 2, 1, 'Anna', '0988151207', '桃園', 3, '2021-06-02 06:35:39'),
(15, 5, 2000, 2, 1, 'Vanessa', '0988151281', '新北', 3, '2021-04-03 07:35:39'),
(16, 10, 250, 2, 1, 'Jay', '0988151201', '新竹', 2, '2021-12-06 12:22:42'),
(17, 10, 2735, 1, 1, 'Amy', '0988151254', '桃園', 3, '2021-12-06 12:15:48'),
(18, 12, 179, 1, 2, 'Carly', '0988151208', '高雄', 1, '2021-11-10 12:22:55'),
(19, 18, 2000, 2, 2, 'Anna', '0988151207', '桃園', 1, '2021-12-06 09:22:42'),
(20, 3, 3650, 1, 2, 'Vanessa', '0988151281', '新北', 3, '2021-12-06 12:28:42');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
