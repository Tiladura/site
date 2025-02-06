-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 07 2024 г., 15:25
-- Версия сервера: 5.7.24
-- Версия PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 3, 2, 'yo', '2024-12-04 21:17:54'),
(2, 2, 3, 'fuck youj bithc', '2024-12-04 21:18:44'),
(3, 2, 3, 'a', '2024-12-04 21:18:53'),
(4, 7, 3, 'I wnt to play tf2', '2024-12-04 21:41:50'),
(5, 3, 7, 'how are things man', '2024-12-04 21:46:38'),
(6, 3, 7, 'im good btw', '2024-12-04 21:46:44'),
(7, 3, 7, 'wanna do ielts practices together?', '2024-12-04 21:46:57'),
(8, 3, 5, 'are u gay by any cchance', '2024-12-04 23:12:20'),
(9, 5, 2, 'wanna do project together?<3', '2024-12-07 15:05:25');

-- --------------------------------------------------------

--
-- Структура таблицы `profiledata`
--

CREATE TABLE `profiledata` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sat` int(11) DEFAULT NULL,
  `act` int(11) DEFAULT NULL,
  `ielts` decimal(3,1) DEFAULT NULL,
  `emojis` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `profiledata`
--

INSERT INTO `profiledata` (`id`, `name`, `surname`, `profile_picture`, `description`, `gender`, `user_id`, `sat`, `act`, `ielts`, `emojis`) VALUES
(2, '1', '1', NULL, '1', 'Female', NULL, 800, 1, '3.5', '🍩,🍕'),
(3, 'mansur', 'zholaman', '', 'i learned at nis. im gut at this game', 'Male', NULL, 1550, 13, '9.0', '🎉,🍕'),
(5, '1', '3123', NULL, '1', 'Female', NULL, 800, 1, '3.5', '🌈,🍩'),
(6, 'ok', 'ko', NULL, 'no', 'Male', NULL, 800, 36, '5.5', '🦵,🍞'),
(7, '1', '123', NULL, '124', 'Male', NULL, 0, 13, '1.5', '😷,💞');

-- --------------------------------------------------------

--
-- Структура таблицы `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `password`) VALUES
(2, 'Tila', '123'),
(3, '15yearold', '123'),
(4, '1', '1'),
(5, 'Mansur', '123'),
(6, 'new', '123'),
(7, 'mans.zholaman@gmail.com', '123');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Индексы таблицы `profiledata`
--
ALTER TABLE `profiledata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `profiledata`
--
ALTER TABLE `profiledata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `profiledata`
--
ALTER TABLE `profiledata`
  ADD CONSTRAINT `profiledata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
