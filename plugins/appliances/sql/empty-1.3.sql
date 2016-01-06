DROP TABLE IF EXISTS `glpi_plugin_applicatifs`;
CREATE TABLE `glpi_plugin_applicatifs` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`deleted` smallint(6) NOT NULL default '0',
	`type` tinyint(4) NOT NULL default '1',
	`comments` text,
	`notes` LONGTEXT,
	`location` INT( 4 ) NOT NULL,
	`tech` INT( 4 ) NOT NULL,
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_applicatifs_device`;
CREATE TABLE `glpi_plugin_applicatifs_device` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_applicatif` int(11) NOT NULL default '0',
	`FK_device` int(11) NOT NULL default '0',
	`device_type` int(11) NOT NULL default '0',
	PRIMARY KEY  (`ID`),
	UNIQUE KEY `FK_applicatif` (`FK_applicatif`,`FK_device`,`device_type`),
	KEY `FK_applicatif_2` (`FK_applicatif`),
	KEY `FK_device` (`FK_device`,`device_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
DROP TABLE IF EXISTS `glpi_dropdown_plugin_applicatifs_type`;
CREATE TABLE `glpi_dropdown_plugin_applicatifs_type` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_profiles`;
CREATE TABLE `glpi_plugin_applicatifs_profiles` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci default NULL,
	`interface` varchar(50) collate utf8_unicode_ci NOT NULL default 'applicatifs',
	`is_default` smallint(6) NOT NULL default '0',
	`applicatifs` char(1) default NULL,
	PRIMARY KEY  (`ID`),
	KEY `interface` (`interface`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','2','2','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','3','3','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','4','4','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','5','5','0');