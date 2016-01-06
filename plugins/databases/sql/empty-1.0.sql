DROP TABLE IF EXISTS `glpi_plugin_sgbd`;
CREATE TABLE `glpi_plugin_sgbd` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`type` int(4) NOT NULL default '0',
	`server` INT(4) NOT NULL DEFAULT '0',
	`FK_enterprise` SMALLINT(6) NOT NULL DEFAULT '0',
	`FK_glpi_enterprise` SMALLINT(6) NOT NULL DEFAULT '0',
	`location` INT(4) NOT NULL DEFAULT '0',
	`notes` LONGTEXT,
	`comment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`deleted` smallint(6) NOT NULL default '0',
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
DROP TABLE IF EXISTS `glpi_dropdown_plugin_sgbd_type`;
	CREATE TABLE `glpi_dropdown_plugin_sgbd_type` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_dropdown_plugin_sgbd_server_type`;
CREATE TABLE `glpi_dropdown_plugin_sgbd_server_type` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_dropdown_plugin_sgbd_server_type` ( `ID` , `name` , `comments`) VALUES ('1', 'Mysql','');
INSERT INTO `glpi_dropdown_plugin_sgbd_server_type` ( `ID` , `name` , `comments`) VALUES ('2', 'Oracle','');
INSERT INTO `glpi_dropdown_plugin_sgbd_server_type` ( `ID` , `name` , `comments`)  VALUES ('3', 'SQL','');

DROP TABLE IF EXISTS `glpi_plugin_sgbd_device`;
CREATE TABLE `glpi_plugin_sgbd_device` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_sgbd` int(11) NOT NULL default '0',
	`FK_device` int(11) NOT NULL default '0',
	`device_type` int(11) NOT NULL default '0',
	PRIMARY KEY  (`ID`),
	UNIQUE KEY `FK_compte` (`FK_sgbd`,`FK_device`,`device_type`),
	KEY `FK_sgbd_2` (`FK_sgbd`),
	KEY `FK_device` (`FK_device`,`device_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_sgbd_profiles`;
CREATE TABLE `glpi_plugin_sgbd_profiles` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci default NULL,
	`interface` varchar(50) collate utf8_unicode_ci NOT NULL default 'sgbd',
	`is_default` smallint(6) NOT NULL default '0',
	`sgbd` char(1) default NULL,
	PRIMARY KEY  (`ID`),
	KEY `interface` (`interface`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
INSERT INTO `glpi_display`  (`ID` , `type` , `num` , `rank` , `FK_users`)  VALUES (NULL,'2400','2','2','0');
INSERT INTO `glpi_display`  (`ID` , `type` , `num` , `rank` , `FK_users`)  VALUES (NULL,'2400','6','3','0');
INSERT INTO `glpi_display`  (`ID` , `type` , `num` , `rank` , `FK_users`)  VALUES (NULL,'2400','7','4','0');