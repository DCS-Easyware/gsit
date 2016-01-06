CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_appliances` (
   `id` int(11) NOT NULL auto_increment,
   `entities_id` int(11) NOT NULL default '0',
   `is_recursive` tinyint(1) NOT NULL default '0',
   `name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
   `is_deleted` tinyint(1) NOT NULL default '0',
   `plugin_appliances_appliancetypes_id` int(11) NOT NULL default '0',
   `comment` text,
   `notes` LONGTEXT,
   `locations_id` INT(11) NOT NULL default '0',
   `plugin_appliances_environments_id` int(11) NOT NULL default '0',
   `users_id` int(11) NOT NULL default '0',
   `groups_id` int(11) NOT NULL default '0',
   `relationtype` INT(11) NOT NULL  default '0',
   `date_mod` datetime default NULL,
   `states_id` int(11) NOT NULL default '0',
   `is_helpdesk_visible` tinyint(1) NOT NULL default '1',
   `externalid` varchar(255) NULL,
   `serial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
   `otherserial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `entities_id` (`entities_id`),
   KEY `is_deleted` (`is_deleted`),
   KEY `name` (`name`),
   KEY `serial` (`serial`),
   KEY `otherserial` (`otherserial`),
   UNIQUE `unicity` (`externalid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_appliances_items` (
   `id` int(11) NOT NULL auto_increment,
   `plugin_appliances_appliances_id` int(11) NOT NULL default '0',
   `items_id` int(11) NOT NULL default '0',
   `itemtype` VARCHAR(100) NOT NULL default '',
   PRIMARY KEY (`id`),
   UNIQUE `unicity` (`plugin_appliances_appliances_id`,`items_id`,`itemtype`),
   KEY `plugin_appliances_appliances_id` (`plugin_appliances_appliances_id`),
   KEY `item` (`itemtype`,`items_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_appliancetypes` (
   `id` int(11) NOT NULL auto_increment,
   `entities_id` int(11) NOT NULL default '0',
   `is_recursive` tinyint(1) NOT NULL default '0',
   `name` varchar(255) collate utf8_unicode_ci NOT NULL default '',
   `comment` text,
   `externalid` varchar(255) NULL,
   PRIMARY KEY (`id`),
   KEY `name` (`name`),
   KEY `entities_id` (`entities_id`),
   UNIQUE (`externalid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_environments` (
   `id` int(11) NOT NULL auto_increment,
   `name` varchar(255) default NULL,
   `comment` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_profiles` (
   `id` int(11) NOT NULL auto_increment,
   `name` varchar(255) collate utf8_unicode_ci default NULL,
   `appliance` char(1) default NULL,
   `open_ticket` char(1) default NULL,
    PRIMARY KEY (`id`),
   KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_relations` (
   `id` int(11) NOT NULL auto_increment,
   `plugin_appliances_appliances_items_id` int(11) NOT NULL default '0',
   `relations_id` int(11) NOT NULL default '0' comment 'locations_id,domains_id or networks_id',
   PRIMARY KEY (`id`),
   KEY `plugin_appliances_appliances_items_id` (`plugin_appliances_appliances_items_id`),
   KEY `relations_id` (`relations_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_optvalues` (
   `id` int(11) NOT NULL auto_increment,
   `plugin_appliances_appliances_id` int(11) NOT NULL default '0',
   `vvalues` int(11) NOT NULL default '0',
   `champ` varchar(255) default NULL,
   `ttype` varchar(255) default NULL,
   `ddefault` varchar(255) default NULL,
   PRIMARY KEY (`id`,`vvalues`),
   KEY `plugin_appliances_appliances_id` (`plugin_appliances_appliances_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `glpi_plugin_appliances_optvalues_items` (
   `id` int(11) NOT NULL auto_increment, 
   `plugin_appliances_optvalues_id` int(11) NOT NULL default '0',
   `items_id` int(11) NOT NULL default '0',
   `itemtype` VARCHAR(100) NOT NULL default '',
   `vvalue` varchar(255) default NULL,
   PRIMARY KEY  (`id`),
   KEY `item` (`itemtype`,`items_id`),
   UNIQUE KEY `unicity` (`plugin_appliances_optvalues_id`,`itemtype`,`items_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `glpi_displaypreferences` ( `id` , `itemtype` , `num` , `rank` , `users_id` )
   VALUES (NULL,'PluginAppliancesAppliance','2','2','0'),
          (NULL,'PluginAppliancesAppliance','3','3','0'),
          (NULL,'PluginAppliancesAppliance','4','4','0'),
          (NULL,'PluginAppliancesAppliance','5','5','0');