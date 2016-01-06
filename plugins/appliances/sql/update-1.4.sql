ALTER TABLE `glpi_plugin_applicatifs` ADD `recursive` tinyint(1) NOT NULL default '0' AFTER `FK_entities`;
ALTER TABLE `glpi_plugin_applicatifs` ADD `relationtype` INT( 4 ) NOT NULL AFTER `tech`;

-- Cette table contient la liste des nature des composants à relier.
-- This table contains the possible types of relations that can be used.
DROP TABLE IF EXISTS `glpi_dropdown_plugin_applicatifs_relationtype`;
CREATE TABLE  `glpi_dropdown_plugin_applicatifs_relationtype` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `comments` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Cette table sert à enregistrer les relation entre un composant et un applicatif.
-- This table is used to store relations between a componant and an applicative.
DROP TABLE IF EXISTS `glpi_plugin_applicatifs_relation`;
CREATE TABLE  `glpi_plugin_applicatifs_relation` (
  `ID` int(11) NOT NULL auto_increment,
  `FK_applicatifs_device` int(11) NOT NULL,
  `FK_relation` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;