-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Ноя 01 2015 г., 14:51
-- Версия сервера: 5.5.42
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `casejoke_jewish`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oc_project`
--

CREATE TABLE `oc_project` (
  `project_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `project_birthday` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `visibility` tinyint(2) NOT NULL,
  `status` int(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Структура таблицы `oc_project_description`
--

CREATE TABLE `oc_project_description` (
  `project_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `city_id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_project`
--
ALTER TABLE `oc_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Индексы таблицы `oc_project_description`
--
ALTER TABLE `oc_project_description`
  ADD PRIMARY KEY (`project_id`,`language_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oc_project`
--
ALTER TABLE `oc_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;