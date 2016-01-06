ALTER TABLE `glpi_plugin_databases_databases` 
   CHANGE `groups_id` `groups_id_tech` int(11) NOT NULL DEFAULT '0',
   CHANGE `users_id` `users_id_tech` int(11) NOT NULL DEFAULT '0';