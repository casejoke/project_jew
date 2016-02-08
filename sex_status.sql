-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Ноя 11 2015 г., 01:04
-- Версия сервера: 5.5.42
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `casejoke_jewish`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oc_sex_status`
--

CREATE TABLE `oc_sex_status` (
  `sex_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
--
-- Индексы  таблиц
--

--
-- Индексы таблицы `oc_sex_status`
--
ALTER TABLE `oc_sex_status`
  ADD PRIMARY KEY (`sex_status_id`,`language_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oc_sex_status`
--
ALTER TABLE `oc_sex_status`
  MODIFY `sex_status_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;