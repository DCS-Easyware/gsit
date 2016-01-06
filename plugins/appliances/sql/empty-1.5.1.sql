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
	`environment` tinyint(4) NOT NULL default '1',
	`FK_users` INT( 4 ) NOT NULL,
	`FK_groups` int(11) NOT NULL default '0',
	`relationtype` INT( 4 ) NOT NULL,
	`date_mod` datetime default NULL,
	`state` int( 4 ) NOT NULL default '0' COMMENT 'RELATION to glpi_dropdown_plugin_applicatifs_state (ID)',
	`helpdesk_visible` int(11) NOT NULL default '1',
	PRIMARY KEY  (`ID`),
	KEY `FK_entities` (`FK_entities`),
	KEY `deleted` (`deleted`),
	KEY `name` (`name`)
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
	KEY `name` (`name`),
	KEY `FK_entities` (`FK_entities`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table contient la liste des environnements des applicatifs
-- This table contains the list of applications' environments.
DROP TABLE IF EXISTS `glpi_dropdown_plugin_applicatifs_environment`;
CREATE TABLE `glpi_dropdown_plugin_applicatifs_environment` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `comments` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ID`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table contient la liste des droits (aucun, lecture, écriture)
-- associé à un profil utilisateur pour le plugin Applicatifs.
-- This table contains the list of rights (none, read, write)
-- available for a user profile in the plugin Applicatifs.
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_profiles`;
CREATE TABLE `glpi_plugin_applicatifs_profiles` (
	`ID` int(11) NOT NULL auto_increment,
	`name` varchar(255) collate utf8_unicode_ci default NULL,
	`applicatifs` char(1) default NULL,
    `open_ticket` char(1) default NULL,
    PRIMARY KEY  (`ID`),
	KEY `name` (`name`)
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

-- Cette table sert à enregistrer les champs personnalisables d'un applicatif
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_optvalues`;
CREATE TABLE  `glpi_plugin_applicatifs_optvalues` (
  `ID` int(11) NOT NULL auto_increment,
  `applicatif_ID` int(11) NOT NULL,
  `vvalues` int(11) NOT NULL,
  `champ` varchar(50),
  `ttype` varchar(50),
  `ddefault` varchar(50),
  PRIMARY KEY  (`ID`,`vvalues`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table sert à enregistrer, pour chaque liaison machine-applicatif
-- la valeur des champs personnalisables définis pour l'applicatif
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_optvalues_machines`;
CREATE TABLE  `glpi_plugin_applicatifs_optvalues_machines` (
  `ID` int(11) NOT NULL auto_increment, 
  `optvalue_ID` int(11) NOT NULL,
  `machine_ID` int(11) NOT NULL,
  `vvalue` varchar(50),
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `optvalue_ID` (`optvalue_ID`,`machine_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','2','2','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','3','3','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','4','4','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','5','5','0');