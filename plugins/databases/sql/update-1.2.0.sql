RENAME TABLE `glpi_dropdown_plugin_sgbd_type` TO `glpi_dropdown_plugin_sgbd_category`;

DROP TABLE IF EXISTS `glpi_dropdown_plugin_sgbd_type`;
CREATE TABLE `glpi_dropdown_plugin_sgbd_type` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `glpi_plugin_sgbd_profiles` ADD `open_ticket` char(1) default NULL;

ALTER TABLE `glpi_plugin_sgbd` CHANGE `type` `category` INT( 4 ) NOT NULL DEFAULT '0';
ALTER TABLE `glpi_plugin_sgbd` ADD `type` INT( 4 ) NOT NULL AFTER `category` ;
ALTER TABLE `glpi_plugin_sgbd` ADD `FK_users` INT( 4 ) NOT NULL AFTER `type`;
ALTER TABLE `glpi_plugin_sgbd` ADD `FK_groups` INT( 11 ) NOT NULL AFTER `FK_users`;
ALTER TABLE `glpi_plugin_sgbd_profiles` DROP COLUMN `interface`, DROP COLUMN `is_default`;