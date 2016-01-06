<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 Databases plugin for GLPI
 Copyright (C) 2003-2011 by the databases Development Team.

 https://forge.indepnet.net/projects/databases
 -------------------------------------------------------------------------

 LICENSE

 This file is part of databases.

 Databases is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Databases is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Databases. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// Init the hooks of the plugins -Needed
function plugin_init_databases() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['databases'] = true;
   $PLUGIN_HOOKS['change_profile']['databases'] = array('PluginDatabasesProfile', 'initProfile');
   $PLUGIN_HOOKS['assign_to_ticket']['databases'] = true;

   //$PLUGIN_HOOKS['assign_to_ticket_dropdown']['databases'] = true;
   //$PLUGIN_HOOKS['assign_to_ticket_itemtype']['databases'] = array('PluginDatabasesDatabase_Item');

   Plugin::registerClass('PluginDatabasesDatabase', array(
         'linkgroup_tech_types'   => true,
         'linkuser_tech_types'    => true,
         'document_types'         => true,
         'ticket_types'           => true,
         'helpdesk_visible_types' => true,
         'addtabon'               => 'Supplier'
   ));
   Plugin::registerClass('PluginDatabasesProfile',
                         array('addtabon' => 'Profile'));

   Plugin::registerClass('PluginDatabasesDatabase_Item',
                         array('ticket_types' => true));

   //Plugin::registerClass('PluginDatabasesDatabase_Item',
   //                      array('ticket_types' => true));

   if (class_exists('PluginAccountsAccount')) {
      PluginAccountsAccount::registerType('PluginDatabasesDatabase');
   }

   if (Session::getLoginUserID()) {

      $plugin = new Plugin();
      if (!$plugin->isActivated('environment')
         && Session::haveRight("plugin_databases", READ)) {

         $PLUGIN_HOOKS['menu_toadd']['databases'] = array('assets'   => 'PluginDatabasesMenu');
      }

      if (Session::haveRight("plugin_databases", UPDATE)) {
         $PLUGIN_HOOKS['use_massive_action']['databases']=1;
      }

      if (class_exists('PluginDatabasesDatabase_Item')) { // only if plugin activated
         $PLUGIN_HOOKS['plugin_datainjection_populate']['databases'] = 'plugin_datainjection_populate_databases';
      }

      // End init, when all types are registered
      $PLUGIN_HOOKS['post_init']['databases'] = 'plugin_databases_postinit';

      // Import from Data_Injection plugin
      $PLUGIN_HOOKS['migratetypes']['databases'] = 'plugin_datainjection_migratetypes_databases';
   }
}

// Get the name and the version of the plugin - Needed
function plugin_version_databases() {

   return array (
      'name' => _n('Database', 'Databases', 2, 'databases'),
      'version' => '1.8.1',
      'author'  => "<a href='http://infotel.com/services/expertise-technique/glpi/'>Infotel</a>",
      'oldname' => 'sgbd',
      'license' => 'GPLv2+',
      'homepage'=>'https://github.com/InfotelGLPI/databases',
      'minGlpiVersion' => '0.90',
   );

}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_databases_check_prerequisites() {
   if (version_compare(GLPI_VERSION,'0.90','lt') || version_compare(GLPI_VERSION,'0.91','ge')) {
      _e('This plugin requires GLPI >= 0.90', 'databases');
      return false;
   }
   return true;
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_databases_check_config() {
   return true;
}

function plugin_datainjection_migratetypes_databases($types) {
   $types[2400] = 'PluginDatabasesDatabase';
   return $types;
}

?>
