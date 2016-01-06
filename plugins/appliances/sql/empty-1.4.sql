-- Cette table contient la liste des applicatifs existants, avec leurs propriétés.
-- This table contains the list of all existing applicatives, with their properties.
DROP TABLE IF EXISTS `glpi_plugin_applicatifs`;
CREATE TABLE `glpi_plugin_applicatifs` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`recursive` tinyint(1) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`deleted` smallint(6) NOT NULL default '0',
	`type` tinyint(4) NOT NULL default '1',
	`comments` text,
	`notes` LONGTEXT,
	`location` INT( 4 ) NOT NULL,
	`tech` INT( 4 ) NOT NULL,
	`relationtype` INT( 4 ) NOT NULL,
	PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table contient les relations entre les applicatifs et les composants.
-- Un applicatif peut être associé a un ou plusieurs composants.
-- Un composant peut être associé a un ou plusieurs applicatifs.
-- This table contains the relations between applicatives and componants.
-- An applicative can be associated with many componants.
-- A componant can be associated with many applicatives.
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

-- Cette table contient la liste des types d'applicatifs.
-- This table contains the list of applicatives types.
DROP TABLE IF EXISTS `glpi_dropdown_plugin_applicatifs_type`;
CREATE TABLE `glpi_dropdown_plugin_applicatifs_type` (
	`ID` int(11) NOT NULL auto_increment,
	`FK_entities` int(11) NOT NULL default '0',
	`name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
	`comments` text,
	PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table contient la liste des droits (aucun, lecture, écriture)
-- associé à un profil utilisateur pour le plugin Applicatifs.
-- This table contains the list of rights (none, read, write)
-- available for a user profile in the plugin Applicatifs.
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

-- Cette table contient la liste des nature des composants à relier.
-- This table contains the possible types of relations that can be used.
DROP TABLE IF EXISTS `glpi_dropdown_plugin_applicatifs_relationtype`;
CREATE TABLE  `glpi_dropdown_plugin_applicatifs_relationtype` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `comments` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table sert à enregistrer les relations entre un composant et un applicatif.
-- This table is used to store relations between a componant and an applicative.
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_relation`;
CREATE TABLE  `glpi_plugin_applicatifs_relation` (
  `ID` int(11) NOT NULL auto_increment,
  `FK_applicatifs_device` int(11) NOT NULL,
  `FK_relation` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','2','2','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','3','3','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','4','4','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','5','5','0');