-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 12 月 07 日 03:46
-- 伺服器版本： 10.4.21-MariaDB
-- PHP 版本： 8.0.13

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
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nutrition` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(5) UNSIGNED NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `products_category` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `ingredients`, `nutrition`, `price`, `image`, `valid`, `products_category`) VALUES
(1, '叢林能量碗', '糙米和黑豆的組合構成了完整的蛋白質，富含所有 9 種必需氨基酸。撒上輕蒸、鬆脆的西蘭花，上面撒上黑芝麻和烤杏仁。', '有機糙米、有機黑豆、西蘭花、杏仁、黑芝麻、是拉差辣椒醬、有機大豆調味料、有機椰子糖、米醋、海鹽、黑胡椒', '379 卡路里 - 14 克蛋白質 - 8 克脂肪 - 68 克碳水化合物', 110, 'jungle_bowl.jpeg', 1, 1),
(2, '陽光能量碗', '我們能量碗系列中最陽光的一面。有機藜麥與大蒜羽衣甘藍拌勻，淋上薑黃花椰菜、特級初榨橄欖油、鷹嘴豆和烤無鹽南瓜籽。', '有機藜麥、羽衣甘藍、花椰菜、薑黃、辣椒粉、鷹嘴豆、檸檬汁、米醋、新鮮大蒜、鷹嘴豆、烤有機南瓜子、特級初榨橄欖油、海鹽和黑胡椒。', '431 卡路里 - 15 克蛋白質 - 20 克脂肪 - 48 克碳水化合物', 110, 'sunshine_bowl.jpeg', 1, 1),
(3, '奶油咖哩豆腐卷', '用檸檬汁和葡萄籽油製成，用咖哩粉調味，烤花椰菜，烤豆腐，增強免疫力的杏子，包裹在有機素食玉米餅中。', '長葉萵苣、烤箱烤豆腐塊、烤花椰菜、葡萄籽油、營養酵母、鷹嘴豆水、杏乾、咖哩粉、辣椒醬、新鮮檸檬汁、純楓糖漿、薑黃、海鹽、黑胡椒。', '644 卡路里 - 19 克蛋白質 - 33 克脂肪 - 67 克碳水化合物', 130, 'curry_tofuwrap.jpeg', 1, 1),
(4, '清蒸蔬菜佐甜辣豆豉', '烤豆豉加入甜辣醬、大蒜炒羽衣甘藍和蒸的西蘭花。清淡清淡的一餐，充滿風味和營養。', '有機豆豉、有機大豆調味料、米醋、生薑、大蒜、是拉差辣椒醬、椰子糖、炒大蒜羽衣甘藍、蒸西蘭花、特級初榨橄欖油、海鹽、黑胡椒。', '470 卡路里 - 32 克蛋白質 - 31 克脂肪 - 32 克碳水化合物', 179, 'veg_tempeh.jpeg', 1, 1),
(5, '招牌沙拉捲', '您可以獲得食用紫色、橙色和綠色、歐米茄和蛋白質包裝的大麻籽以及抗氧化的全南瓜籽的所有營養成分。更不用說我們用特級初榨橄欖油和促進血清素的鷹嘴豆從頭開始製作的奶油自製鷹嘴豆泥。這個捲充分包含了植物和蛋白質。', '有機全麥純素玉米餅、自製鷹嘴豆泥（鷹嘴豆、芝麻醬、特級初榨橄欖油、新鮮大蒜、辣椒粉、海鹽、黑胡椒）、胡蘿蔔絲和甜菜絲、紅洋蔥、南瓜子、大麻心。', '690 卡路里 - 18 克蛋白質 - 28 克脂肪 - 81 克碳水化合物', 130, 'signature_wrap.jpeg', 1, 2),
(6, '烤蔬菜佐香醋鮭魚', '奶油土豆、西紅柿、羽衣甘藍、用濃郁的香醋調味的胡蘿蔔等蔬菜放入烤箱烤至完美。用迷迭香、羅勒調味，然後倒入有益心臟健康的特級初榨橄欖油。', '野生銀鮭魚、香醋、特級初榨橄欖油、迷迭香、羅勒、海鹽、黑胡椒、小土豆、有機胡蘿蔔、西紅柿、有機綠色羽衣甘藍。', '720 卡路里 - 33 克蛋白質 - 37 克脂肪 - 65 克碳水化合物', 230, 'salmon.jpeg', 1, 3),
(7, '凱薩沙拉佐燻炙雞胸', '用我們自製的奶油和豐富的植物基凱撒醬按摩綠色羽衣甘藍和鬆脆的羅馬生菜。上面是鬆脆的鷹嘴豆麵包丁、燻炙的雞胸肉和核桃帕爾馬干酪，不含麩質、乳製品或精製碳水化合物。', '有機綠色羽衣甘藍、生菜碎、芝麻醬、第戎芥末、檸檬汁、大蒜粉、雞胸肉、辣椒粉、牛至、洋蔥粉、鷹嘴豆、營養酵母、核桃、特級初榨橄欖油、是拉差辣椒醬、海鹽、黑胡椒。', '565 卡路里 - 52 克蛋白質 - 24 克脂肪 - 26 克碳水化合物 ', 150, 'chicken_salad.jpeg', 1, 3),
(8, '土耳其肉丸佐清蒸蔬菜', '甜辣的火雞肉丸，配上清蒸西蘭花和大蒜炒羽衣甘藍。 這種低碳水化合物膳食含有蛋白質、纖維、維生素和礦物質。', '火雞瘦肉、糙米粉、大蒜粉、新鮮歐芹、黃洋蔥、亞麻粉、布拉格大豆調味料、是拉差辣椒醬、米醋、芝麻油、生薑、新鮮大蒜、椰子糖、羽衣甘藍、西蘭花、特級初榨橄欖油、海鹽、黑胡椒。', '515 卡路里 - 38 克蛋白質 - 25 克脂肪 - 51 克碳水化合物', 179, 'veg_meatball.jpeg', 1, 3),
(9, '招牌雞肉捲', '您可以獲得食用紫色、橙色和綠色的所有營養成分。更不用說我們用特級初榨橄欖油和促進血清素的鷹嘴豆從頭開始製作的奶油自製鷹嘴豆泥。這個捲充分包含了植物和蛋白質。', '有機全麥純素玉米餅、烤箱烤雞胸肉、是拉差辣椒醬、特級初榨橄欖油、自製鷹嘴豆泥（鷹嘴豆、芝麻醬、有機新鮮檸檬汁、新鮮大蒜、特級初榨橄欖油、辣椒粉、海鹽、黑胡椒）、有機春季混合物、胡蘿蔔、甜菜、黃瓜、紅洋蔥、海鹽和黑胡椒。', '790 卡路里 - 33 克蛋白質 - 30 克脂肪 - 81 克碳水化合物', 165, 'classic_chicken.jpeg', 1, 2),
(10, '泰式麵條沙拉', '這些美味的拉麵風格的麵條由有機小米和糙米製成，搭配我們辛辣濃郁的泰式醬料，混合營養豐富的紫甘藍、維生素 C 包裝的紅甜椒、有機胡蘿蔔、纖維包裝的豌豆和鬆脆的花生沙拉很快就會成為您的最愛之一。', '有機小米糙米粉、胡蘿蔔、捲心菜、紅辣椒、豌豆和花生。\n香辣泰式辣椒醬：布拉格大豆調味料、米醋、特級初榨橄欖油、是拉差辣椒醬、有機椰子糖、辣椒片。', '500 卡路里 - 15 克蛋白質 - 16 克脂肪 - 68 克碳水化合物', 113, 'thai_salad.jpeg', 1, 1),
(11, '低碳雞肉沙拉', '32克的蛋白質配上滿滿的深綠色蔬菜以及色彩繽紛的生菜，好吃到讓你的脂肪哭出來。帶給正在吃低碳、生酮、或是想吃好吃沙拉的人。', '雞胸 100g、美生菜 40g、甜椒 10g、番茄 10g、綠花椰菜 80g、菠菜 70g', '197 卡路里 - 32 克蛋白質 - 5 克脂肪 - 5 克纖維 - 14 克碳水化合物', 170, 'salad-chicken.jpeg', 1, 2),
(12, '雞肉肌肉餐', '38克的蛋白質加上滿滿的蔬菜，以及加了超級食物 ” 薑黃 ”，的薑黃飯，再配上特製醬料讓你的肌肉充滿生命。帶給想要增肌的人。', '雞胸 100g、美生菜 40g、甜椒 10g、番茄 10g、綠花椰菜 80g、菠菜 70g', '578 卡路里 - 38 克蛋白質 - 8 克脂肪 - 5 克纖維 - 95 克碳水化合物', 135, 'chicken-gain.jpeg', 1, 3),
(13, '鮭魚菲力全餐', '入口即化的鮭魚菲力，配了滿滿的深綠色蔬菜，帶走你煩躁的心情。', '鮭魚 150g、綠花椰菜 80g、菠菜 70g、飯 100g、番茄 10g', '572 卡路里 - 40 克蛋白質 - 23 克脂肪 - 5 克纖維 - 51 克碳水化合物', 246, 'salmon_veg.jpeg', 1, 3),
(14, '嫩雞輕沙拉', '32克的蛋白質配上滿滿的深綠色蔬菜以及色彩繽紛的生菜，好吃到讓你的脂肪哭出來。帶給正在吃低碳、生酮、或是想吃好吃沙拉的人。\r\n', '美生菜、甜椒、番茄、紅蘿蔔、羅美、紫高麗菜和小黃瓜，醬料可從優格白醬、辣醬、油醋醬三選一', '197 卡路里 - 32 克蛋白質 - 5 克脂肪 - 5 克纖維 - 14 克碳水化合物', 157, 'soft-chicken.jpeg', 1, 2),
(15, 'ab', 'bc', 'cd', 'de', 12, 'salmon.jpeg', 2, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
