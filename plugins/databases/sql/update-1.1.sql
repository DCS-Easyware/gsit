ALTER TABLE `glpi_plugin_sgbd` ADD `recursive` tinyint(1) NOT NULL default '0' AFTER `FK_entities`;

DROP TABLE IF EXISTS `glpi_plugin_sgbd_instances`;
CREATE TABLE `glpi_plugin_sgbd_instances` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_sgbd` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`port` INT(11) NOT NULL DEFAULT '0',
	`path` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_sgbd_scripts`;
CREATE TABLE `glpi_plugin_sgbd_scripts` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_sgbd` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`path` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`type` int(11) NOT NULL default '0',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_dropdown_plugin_sgbd_script_type`;
CREATE TABLE `glpi_dropdown_plugin_sgbd_script_type` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `glpi_plugin_sgbd_device` DROP INDEX `FK_compte` ,
ADD UNIQUE `FK_sgbd` ( `FK_sgbd` , `FK_device` , `device_type` );