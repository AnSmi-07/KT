-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 07 2026 г., 22:49
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `K-TOVARIKI`
--

-- --------------------------------------------------------

--
-- Структура таблицы `KT_orders`
--

CREATE TABLE `KT_orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `order_date` date NOT NULL COMMENT 'Дата получения товара',
  `status` enum('new','in_progress','completed') NOT NULL DEFAULT 'new',
  `review` text,
  `review_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `KT_orders`
--

INSERT INTO `KT_orders` (`id`, `user_id`, `product_id`, `order_date`, `status`, `review`, `review_date`, `created_at`) VALUES
(1, 1, 1, '2026-09-12', 'completed', 'hbbbb', '2026-09-07 19:42:29', '2026-09-07 19:42:14');

-- --------------------------------------------------------

--
-- Структура таблицы `KT_products`
--

CREATE TABLE `KT_products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `KT_products`
--

INSERT INTO `KT_products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Нож канцелярский', 'Острый и надёжный нож для бумаги', '150.00', 'img1.jpg', '2026-09-07 19:33:58'),
(2, 'Ручка шариковая', 'Пишет безотказно', '50.00', 'img2.jpg', '2026-09-07 19:33:58'),
(3, 'Тетрадь 48 листов', 'Клетка, обложка зелёная', '80.00', 'img3.jpg', '2026-09-07 19:33:58');

-- --------------------------------------------------------

--
-- Структура таблицы `KT_users`
--

CREATE TABLE `KT_users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `KT_users`
--

INSERT INTO `KT_users` (`id`, `login`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'Admin', '282d61b13b564a60c3cb32f8bda89758', 'admin@konztov.ru', 1, '2026-09-07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `KT_orders`
--
ALTER TABLE `KT_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `KT_products`
--
ALTER TABLE `KT_products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `KT_users`
--
ALTER TABLE `KT_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `KT_orders`
--
ALTER TABLE `KT_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `KT_products`
--
ALTER TABLE `KT_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `KT_users`
--
ALTER TABLE `KT_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `KT_orders`
--
ALTER TABLE `KT_orders`
  ADD CONSTRAINT `kt_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `KT_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kt_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `KT_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
