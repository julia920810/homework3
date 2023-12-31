-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-12-31 06:57:12
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `commodity`
--

-- --------------------------------------------------------

--
-- 資料表結構 `commodity`
--

CREATE TABLE `commodity` (
  `id` int(50) NOT NULL,
  `name` varchar(60) NOT NULL,
  `illustrate` varchar(60) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `commodity`
--

INSERT INTO `commodity` (`id`, `name`, `illustrate`, `price`) VALUES
(1, '洗髮精', '順滑柔順保濕光澤', 299),
(2, '沐浴乳', '估溜估溜', 199),
(3, '洗面乳', '深層清潔', 128),
(7, 'sss', 'ss', 22);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `commodity`
--
ALTER TABLE `commodity`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `commodity`
--
ALTER TABLE `commodity`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
