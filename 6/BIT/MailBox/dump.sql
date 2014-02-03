-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 03 2013 г., 16:21
-- Версия сервера: 5.6.11-log
-- Версия PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `mailbox`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`,`path`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `filename`, `path`) VALUES
(15, 'apache-tomcat-7.0.39.tar.gz', 'usrE855.tmp');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUserOwner` int(11) NOT NULL,
  `idUserFrom` int(11) NOT NULL,
  `idUserTo` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT 'No subject',
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `fileId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `idUserTo` (`idUserTo`),
  KEY `idUserFrom` (`idUserFrom`),
  KEY `idUserOwner` (`idUserOwner`),
  KEY `fileId` (`fileId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `idUserOwner`, `idUserFrom`, `idUserTo`, `theme`, `message`, `time`, `isRead`, `fileId`) VALUES
(1, 1, 2, 1, 'No subject', '123', '2013-04-29 12:47:29', 1, NULL),
(2, 1, 2, 1, 'Interesting subject', '123123', '2013-04-29 12:48:48', 1, NULL),
(3, 2, 2, 1, 'No subject', '123', '2013-04-29 12:47:29', 1, NULL),
(10, 1, 1, 2, 'ololo " AND 1=1', '<h1>Веселый заголовок</h1><p>Кабы не было зимы</p><ol><li>в городах</li><li>и селах</li></ol><p>Никогда б не знали мы <a href="http://google.com">этих дней веселых</a><br></p>', '2013-05-03 06:53:14', 0, NULL),
(13, 1, 1, 2, 'Test', 'test', '2013-05-03 07:06:33', 1, NULL),
(14, 2, 1, 2, 'Test', 'test', '2013-05-03 07:06:33', 1, NULL),
(16, 2, 1, 2, 'Без темы', '', '2013-05-03 09:15:44', 1, NULL),
(17, 1, 1, 2, '123', '1321321', '2013-05-03 09:45:17', 1, NULL),
(18, 2, 1, 2, '123', '1321321', '2013-05-03 09:45:17', 1, NULL),
(19, 2, 1, 2, '32131', '', '2013-05-03 09:48:37', 1, NULL),
(20, 1, 1, 2, '32131', '', '2013-05-03 09:48:37', 1, NULL),
(21, 1, 2, 1, 'Video', 'Video Example', '2013-05-03 09:51:15', 0, NULL),
(22, 2, 2, 1, 'Video', 'Video Example', '2013-05-03 09:51:15', 1, NULL),
(23, 2, 1, 2, 'Test1', '', '2013-05-03 11:59:36', 0, NULL),
(25, 2, 1, 2, 'Test2', '', '2013-05-03 12:00:03', 0, NULL),
(29, 2, 1, 2, 'Vikusha', '<h1>Vikusha molodets!!!!</h1><p><br></p><ol><li>odin</li><li>dva<br></li></ol>', '2013-05-03 12:43:54', 0, 15),
(30, 1, 1, 2, 'Vikusha', '<h1>Vikusha molodets!!!!</h1><p><br></p><ol><li>odin</li><li>dva<br></li></ol>', '2013-05-03 12:43:54', 1, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `lastTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `isActive`, `lastTime`, `hash`) VALUES
(1, 'admin', '3570be', 1, '2013-05-03 12:52:46', 'bd5860585cd8a83f86a1cd466a3842f8'),
(2, 'ivan.ivanov', 'ivanov.ivan', 1, '2013-05-03 15:07:12', 'd587088f71742b8d8291a5c43730fc4a');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idUserFrom`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idUserTo`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`) ON DELETE SET NULL;
