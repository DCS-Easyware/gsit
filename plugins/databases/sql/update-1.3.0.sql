ALTER TABLE `glpi_plugin_sgbd` RENAME `glpi_plugin_databases_databases`;
ALTER TABLE `glpi_dropdown_plugin_sgbd_type` RENAME `glpi_plugin_databases_databasetypes`;
ALTER TABLE `glpi_dropdown_plugin_sgbd_category` RENAME `glpi_plugin_databases_databasecategories`;
ALTER TABLE `glpi_dropdown_plugin_sgbd_server_type` RENAME `glpi_plugin_databases_servertypes`;
ALTER TABLE `glpi_dropdown_plugin_sgbd_script_type` RENAME `glpi_plugin_databases_scripttypes`;
ALTER TABLE `glpi_plugin_sgbd_instances` RENAME `glpi_plugin_databases_instances`;
ALTER TABLE `glpi_plugin_sgbd_scripts` RENAME `glpi_plugin_databases_scripts`;
ALTER TABLE `glpi_plugin_sgbd_device` RENAME `glpi_plugin_databases_databases_items`;
ALTER TABLE `glpi_plugin_sgbd_profiles` RENAME `glpi_plugin_databases_profiles`;

ALTER TABLE `glpi_plugin_databases_databases` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `FK_entities` `entities_id` int(11) NOT NULL default '0',
   CHANGE `recursive` `is_recursive` tinyint(1) NOT NULL default '0',
   CHANGE `category` `plugin_databases_databasecategories_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_databasecategories (id)',
   CHANGE `type` `plugin_databases_databasetypes_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_databasetypes (id)',
   CHANGE `FK_users` `users_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_users (id)',
   CHANGE `FK_groups` `groups_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_groups (id)',
   CHANGE `server` `plugin_databases_servertypes_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_servertypes (id)',
   CHANGE `FK_enterprise` `suppliers_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_suppliers (id)',
   CHANGE `FK_glpi_enterprise` `manufacturers_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_manufacturers (id)',
   CHANGE `location` `locations_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_locations (id)',
   CHANGE `helpdesk_visible` `is_helpdesk_visible` int(11) NOT NULL default '1',
   CHANGE `notes` `notepad` longtext collate utf8_unicode_ci,
   CHANGE `comment` `comment` text collate utf8_unicode_ci,
   CHANGE `deleted` `is_deleted` tinyint(1) NOT NULL default '0',
   ADD INDEX (`name`),
   ADD INDEX (`entities_id`),
   ADD INDEX (`plugin_databases_databasecategories_id`),
   ADD INDEX (`plugin_databases_databasetypes_id`),
   ADD INDEX (`plugin_databases_servertypes_id`),
   ADD INDEX (`users_id`),
   ADD INDEX (`groups_id`),
   ADD INDEX (`suppliers_id`),
   ADD INDEX (`manufacturers_id`),
   ADD INDEX (`locations_id`),
   ADD INDEX (`date_mod`),
   ADD INDEX (`is_helpdesk_visible`),
   ADD INDEX (`is_deleted`);

ALTER TABLE `glpi_plugin_databases_databasetypes` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `FK_entities` `entities_id` int(11) NOT NULL default '0',
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `comments` `comment` text collate utf8_unicode_ci;

ALTER TABLE `glpi_plugin_databases_databasecategories` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `FK_entities` `entities_id` int(11) NOT NULL default '0',
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `comments` `comment` text collate utf8_unicode_ci;

ALTER TABLE `glpi_plugin_databases_servertypes` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `comments` `comment` text collate utf8_unicode_ci;

ALTER TABLE `glpi_plugin_databases_scripttypes` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `comments` `comment` text collate utf8_unicode_ci;

ALTER TABLE `glpi_plugin_databases_instances` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   ADD `entities_id` int(11) NOT NULL default '0',
   ADD `is_recursive` tinyint(1) NOT NULL default '0',
   CHANGE `FK_sgbd` `plugin_databases_databases_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_databases (id)',
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `path` `path` varchar(255) collate utf8_unicode_ci default NULL,
   ADD `comment` text collate utf8_unicode_ci,
   ADD INDEX (`name`),
   ADD INDEX (`plugin_databases_databases_id`);

ALTER TABLE `glpi_plugin_databases_scripts` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   ADD `entities_id` int(11) NOT NULL default '0',
   ADD `is_recursive` tinyint(1) NOT NULL default '0',
   CHANGE `FK_sgbd` `plugin_databases_databases_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_databases (id)',
   CHANGE `type` `plugin_databases_scripttypes_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_plugin_databases_scripttypes (id)',
   CHANGE `name` `name` varchar(255) collate utf8_unicode_ci default NULL,
   CHANGE `path` `path` varchar(255) collate utf8_unicode_ci default NULL,
   ADD `comment` text collate utf8_unicode_ci,
   ADD INDEX (`name`),
   ADD INDEX (`plugin_databases_databases_id`),
   ADD INDEX (`plugin_databases_scripttypes_id`);

ALTER TABLE `glpi_plugin_databases_databases_items` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   CHANGE `FK_sgbd` `plugin_databases_databases_id` int(11) NOT NULL default '0',
   CHANGE `FK_device` `items_id` int(11) NOT NULL default '0' COMMENT 'RELATION to various tables, according to itemtype (id)',
   CHANGE `device_type` `itemtype` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'see .class.php file',
   DROP INDEX `FK_sgbd`,
   DROP INDEX `FK_sgbd_2`,
   DROP INDEX `FK_device`,
   ADD UNIQUE `unicity` (`plugin_databases_databases_id`,`itemtype`,`items_id`),
   ADD INDEX `FK_device` (`items_id`,`itemtype`),
   ADD INDEX `item` (`itemtype`,`items_id`);

ALTER TABLE `glpi_plugin_databases_profiles` 
   CHANGE `ID` `id` int(11) NOT NULL auto_increment,
   ADD `profiles_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
   CHANGE `sgbd` `databases` char(1) collate utf8_unicode_ci default NULL,
   CHANGE `open_ticket` `open_ticket` char(1) collate utf8_unicode_ci default NULL,
   ADD INDEX (`profiles_id`);