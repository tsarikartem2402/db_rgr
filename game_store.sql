-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Гру 20 2023 р., 14:51
-- Версія сервера: 10.4.28-MariaDB
-- Версія PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `game_store`
--

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `grade` int(3) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `grade`, `text`) VALUES
(11, 2, 57, 2, '132312'),
(13, 1, 49, 5, 'bogdan'),
(15, 5, 58, 2, 'BAD'),
(16, 5, 61, 5, 'good!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!'),
(17, 1, 53, 1, '我不明白的東西'),
(18, 1, 60, 4, 'ok'),
(19, 1, 66, 5, 'top!!!'),
(20, 2, 66, 2, 'bad\r\n');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `name`, `user_id`) VALUES
(2, 'Ordersuslo', 65),
(12, 'superorder', 49),
(13, 'Order22222', 62),
(14, 'Ordersuslo', 62),
(19, 'lollol', 49);

-- --------------------------------------------------------

--
-- Структура таблиці `orders_ep`
--

CREATE TABLE `orders_ep` (
  `id_prod` bigint(20) UNSIGNED NOT NULL,
  `id_orders` bigint(20) UNSIGNED NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `orders_ep`
--

INSERT INTO `orders_ep` (`id_prod`, `id_orders`, `id`) VALUES
(1, 12, 19),
(2, 2, 1),
(2, 2, 12),
(2, 13, 20),
(5, 14, 21);

-- --------------------------------------------------------

--
-- Структура таблиці `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(40) NOT NULL,
  `ganre` varchar(40) NOT NULL,
  `price` double DEFAULT NULL,
  `id_orders` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `product`
--

INSERT INTO `product` (`id`, `Name`, `ganre`, `price`, `id_orders`) VALUES
(1, 'Poe', 'RPG', 0, 2),
(2, 'Cs1.6', 'Shooter', 0, 12),
(5, 'lol', 'nob', 55555, 0),
(10, 'lolss', 'nob', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(20) NOT NULL,
  `age` date NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `Name`, `age`, `password`) VALUES
(49, 'Bogdan24', '2003-11-18', 'zxczxczxcxzc'),
(53, 'ssss', '2005-11-20', '111111'),
(57, 'bob', '2001-06-02', '2281337'),
(58, 'Ult', '1993-11-18', 'qwerty123'),
(60, 'zxc337', '2009-08-18', 'xoxoxoxoxo2222'),
(61, 'oldbro', '1983-11-02', 'oldoldold133'),
(62, 'lol222332', '2023-11-01', 'rrrrrrrrrrr444'),
(64, 'varc', '2005-11-20', '22222222'),
(65, 'suslo', '1990-11-20', '2223242424ede'),
(66, 'name2228', '1990-09-20', '2228'),
(73, 'tsarikart', '2023-11-30', '2402'),
(74, 'hrvatska2000', '2023-11-30', '222'),
(75, 'oleg44', '2023-12-07', '44'),
(78, 'bibroid', '2006-01-14', 'zxcvbnmasd2'),
(79, 'hrvatska200022', '2023-12-08', 'abcdxsad21');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `product_id` (`product_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `orders_ep`
--
ALTER TABLE `orders_ep`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_prod` (`id_prod`,`id_orders`),
  ADD KEY `id_orders` (`id_orders`);

--
-- Індекси таблиці `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_orders` (`id_orders`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблиці `orders_ep`
--
ALTER TABLE `orders_ep`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблиці `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `orders_ep`
--
ALTER TABLE `orders_ep`
  ADD CONSTRAINT `orders_ep_ibfk_1` FOREIGN KEY (`id_orders`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ep_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
