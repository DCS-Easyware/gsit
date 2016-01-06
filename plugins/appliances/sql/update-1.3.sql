ALTER TABLE `glpi_plugin_applicatifs_profiles` DROP `create_applicatifs`;
ALTER TABLE `glpi_plugin_applicatifs_profiles` DROP `update_applicatifs`;
ALTER TABLE `glpi_plugin_applicatifs_profiles` DROP `delete_applicatifs`;
ALTER TABLE `glpi_plugin_applicatifs_profiles` CHANGE `is_default` `is_default` smallint(6) NOT NULL default '0';
UPDATE `glpi_plugin_applicatifs_profiles` SET `is_default` = '0' WHERE `is_default` = '1';
UPDATE `glpi_plugin_applicatifs_profiles` SET `is_default` = '1' WHERE `is_default` = '2';

ALTER TABLE `glpi_plugin_applicatifs` ADD `tech` INT( 4 ) NOT NULL ;
ALTER TABLE `glpi_plugin_applicatifs` ADD `location` INT( 4 ) NOT NULL ;
ALTER TABLE `glpi_plugin_applicatifs` ADD `FK_entities` int(11) NOT NULL default '0' AFTER `ID`;
ALTER TABLE `glpi_plugin_applicatifs` CHANGE `deleted` `deleted` smallint(6) NOT NULL default '0';
ALTER TABLE `glpi_plugin_applicatifs` CHANGE `notes` `notes` LONGTEXT ;
ALTER TABLE `glpi_plugin_applicatifs` CHANGE `comments` `comments` TEXT ;
UPDATE `glpi_plugin_applicatifs` SET `deleted` = '0' WHERE `deleted` = '1';
UPDATE `glpi_plugin_applicatifs` SET `deleted` = '1' WHERE `deleted` = '2';

ALTER TABLE `glpi_dropdown_plugin_applicatifs_type` ADD `FK_entities` int(11) NOT NULL default '0' AFTER `ID`;

INSERT INTO glpi_doc_device (FK_doc,FK_device,device_type) SELECT FK_documents,FK_applicatifs, '1200' FROM glpi_plugin_applicatifs_documents;

DROP TABLE `glpi_plugin_applicatifs_documents`;

ALTER TABLE `glpi_plugin_applicatifs_device` CHANGE `device_type` `device_type` int(11) NOT NULL default '0';

INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','2','2','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','3','3','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','4','4','0');
INSERT INTO `glpi_display` ( `ID` , `type` , `num` , `rank` , `FK_users` )  VALUES (NULL,'1200','5','5','0');