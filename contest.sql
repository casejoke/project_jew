# ************************************************************
# Sequel Pro SQL dump
# Версия 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: localhost (MySQL 5.5.42)
# Схема: casejoke_jewish
# Время создания: 2015-10-17 18:56:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы oc_contest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oc_contest`;

CREATE TABLE `oc_contest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `maxprice` int(11) DEFAULT NULL,
  `totalprice` int(11) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `date_rate` datetime DEFAULT NULL,
  `date_result` datetime DEFAULT NULL,
  `date_finalist` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `oc_contest` WRITE;
/*!40000 ALTER TABLE `oc_contest` DISABLE KEYS */;

INSERT INTO `oc_contest` (`id`, `type`, `status`, `maxprice`, `totalprice`, `date_start`, `datetime_end`, `date_rate`, `date_result`, `date_finalist`)
VALUES
	(1,1,3,100000,200000,'2015-10-16 00:00:00','2015-10-20 00:00:00','2015-10-23 00:00:00','2015-10-24 00:00:00','2015-10-30 00:00:00');

/*!40000 ALTER TABLE `oc_contest` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы oc_contest_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oc_contest_description`;

CREATE TABLE `oc_contest_description` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL DEFAULT '',
  `meta_description` varchar(255) NOT NULL DEFAULT '',
  `meta_keyword` varchar(255) NOT NULL DEFAULT '',
  `organizer` varchar(255) NOT NULL,
  `propose` text NOT NULL,
  `location` text NOT NULL,
  `members` text NOT NULL,
  `description` text NOT NULL,
  `contacts` text NOT NULL,
  `timeline_text` text NOT NULL,
  PRIMARY KEY (`id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `oc_contest_description` WRITE;
/*!40000 ALTER TABLE `oc_contest_description` DISABLE KEYS */;

INSERT INTO `oc_contest_description` (`id`, `language_id`, `title`, `meta_title`, `meta_description`, `meta_keyword`, `organizer`, `propose`, `location`, `members`, `description`, `contacts`, `timeline_text`)
VALUES
	(1,2,'Первый конкурс','Title первого конкурса','краткое описание конкурса для поисковиков','не используются современными поисковиками','Jewish','Тестирование','Россия и СНГ','Любые участники','&lt;span style=&quot;font-weight: bold;&quot;&gt;Форматированное&lt;/span&gt; описание проекта','test@test.ru','Поторопитесь с подачей.');

/*!40000 ALTER TABLE `oc_contest_description` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы oc_contest_direction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oc_contest_direction`;

CREATE TABLE `oc_contest_direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `oc_contest_direction` WRITE;
/*!40000 ALTER TABLE `oc_contest_direction` DISABLE KEYS */;

INSERT INTO `oc_contest_direction` (`id`, `parent_id`)
VALUES
	(10,1);

/*!40000 ALTER TABLE `oc_contest_direction` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы oc_contest_direction_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oc_contest_direction_description`;

CREATE TABLE `oc_contest_direction_description` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `oc_contest_direction_description` WRITE;
/*!40000 ALTER TABLE `oc_contest_direction_description` DISABLE KEYS */;

INSERT INTO `oc_contest_direction_description` (`id`, `language_id`, `title`)
VALUES
	(10,2,'Первый конкурс'),
	(10,2,'Первый конкурс'),
	(10,2,'Развлекательный'),
	(10,2,'Общеобразовательный'),
	(10,2,'Первый конкурс');

/*!40000 ALTER TABLE `oc_contest_direction_description` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы oc_contest_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oc_contest_file`;

CREATE TABLE `oc_contest_file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `oc_contest_file` WRITE;
/*!40000 ALTER TABLE `oc_contest_file` DISABLE KEYS */;

INSERT INTO `oc_contest_file` (`file_id`, `parent_id`)
VALUES
	(1,1),
	(2,1);

/*!40000 ALTER TABLE `oc_contest_file` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
