-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Фев 08 2016 г., 19:50
-- Версия сервера: 5.5.34
-- Версия PHP: 5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `casejoke_antibio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oc_customer_to_promocode`
--

CREATE TABLE `oc_customer_to_promocode` (
  `customer_promocode_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `promocode_id` varchar(255) NOT NULL,
  `status` int(4) NOT NULL,
  `value` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`customer_promocode_id`),
  UNIQUE KEY `customer_stat_id` (`customer_promocode_id`),
  KEY `customer_id` (`customer_id`,`promocode_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `casejoke_jewish`.`oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'account/account', 'activatepromocode');