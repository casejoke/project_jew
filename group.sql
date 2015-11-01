CREATE TABLE `oc_init_group` (
  `init_group_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `visibility` tinyint(2) NOT NULL,
  `status` int(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_init_group`
--
ALTER TABLE `oc_init_group`
  ADD PRIMARY KEY (`init_group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oc_init_group`
--
ALTER TABLE `oc_init_group`
  MODIFY `init_group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;


--
-- Структура таблицы `oc_init_group_description`
--

CREATE TABLE `oc_init_group_description` (
  `init_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_init_group_description`
--
ALTER TABLE `oc_init_group_description`
  ADD PRIMARY KEY (`init_group_id`,`language_id`);

--
-- Структура таблицы `oc_customer_to_init_group_group`
--

CREATE TABLE `oc_customer_to_init_group_group` (
  `init_group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_customer_to_init_group_group`
--
ALTER TABLE `oc_customer_to_init_group_group`
  ADD PRIMARY KEY (`init_group_id`,`customer_id`);