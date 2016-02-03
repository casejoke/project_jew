INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/group', 'list-group');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/view', 'view-group');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/edit', 'edit-group');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/invite', 'group-invite');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/invite/invite', 'invite-user');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/invite/uninvite', 'uninvite-user');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'group/invite/agree', 'user-agree-invite');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'account/info', 'user');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'account/customers', 'list-user');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'project/project', 'list-project');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'project/view', 'view-project');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'project/edit', 'edit-project');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'tool/upload', 'upload-file');
INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'account/account/upload', 'upload-avatar');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'material/material', 'list-materials');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'information/news', 'list-news');

INSERT INTO `oc_url_alias` (`url_alias_id`, `query`, `keyword`) VALUES (NULL, 'contest/contest', 'list-contest');





ALTER TABLE `oc_customer` ADD `customer_expert` TINYINT NOT NULL AFTER `customer_group_id`;


///********************///

ALTER TABLE `oc_contest_field_description` ADD `description` TEXT NOT NULL AFTER `name`;