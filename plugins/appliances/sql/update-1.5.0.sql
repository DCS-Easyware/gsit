ALTER TABLE `glpi_plugin_applicatifs` ADD INDEX `name` (`name`);
ALTER TABLE `glpi_plugin_applicatifs` ADD INDEX `FK_entities` (`FK_entities`);
ALTER TABLE `glpi_plugin_applicatifs` ADD INDEX `deleted` (`deleted`);
ALTER TABLE `glpi_plugin_applicatifs` ADD `FK_groups` int(11) NOT NULL default '0';
ALTER TABLE `glpi_plugin_applicatifs` ADD `date_mod` datetime default NULL;
ALTER TABLE `glpi_dropdown_plugin_applicatifs_type` ADD INDEX `FK_entities` (`FK_entities`);
ALTER TABLE `glpi_plugin_applicatifs` ADD `environment` int( 4 ) NOT NULL default '0' COMMENT 'RELATION to glpi_dropdown_plugins_applicatifs_environment (ID)';

-- Cette table sert à enregistrer les champs personnalisables d'un applicatif
CREATE TABLE IF NOT EXISTS `glpi_plugin_applicatifs_optvalues` (
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
CREATE TABLE IF NOT EXISTS `glpi_plugin_applicatifs_optvalues_machines` (
  `ID` int(11) NOT NULL auto_increment, 
  `optvalue_ID` int(11) NOT NULL,
  `machine_ID` int(11) NOT NULL,
  `vvalue` varchar(50),
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `glpi_plugin_applicatifs_profiles` DROP COLUMN `interface` , DROP COLUMN `is_default`;

ALTER TABLE `glpi_plugin_applicatifs` CHANGE `tech` `FK_users` int(4);
ALTER TABLE `glpi_plugin_applicatifs_profiles` ADD `open_ticket` char(1) default NULL;

-- Cette table contient la liste des environnements des applicatifs
-- This table contains the list of applications' environments.
CREATE TABLE `glpi_dropdown_plugin_applicatifs_environment` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `comments` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ID`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;