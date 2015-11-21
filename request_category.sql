-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Ноя 21 2015 г., 20:38
-- Версия сервера: 5.5.42
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `casejoke_jewish`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oc_category_request`
--

CREATE TABLE `oc_category_request` (
  `category_request_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oc_category_request`
--

INSERT INTO `oc_category_request` (`category_request_id`, `language_id`, `name`) VALUES
(9, 2, 'Мужчины'),
(10, 2, 'Женщины'),
(11, 2, 'Любой');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_category_request`
--
ALTER TABLE `oc_category_request`
  ADD PRIMARY KEY (`category_request_id`,`language_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oc_category_request`
--
ALTER TABLE `oc_category_request`
  MODIFY `category_request_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;