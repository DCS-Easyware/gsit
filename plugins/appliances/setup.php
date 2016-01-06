<?php
/*
 * @version $Id: setup.php 219 2015-02-19 10:12:58Z tsmr $
 -------------------------------------------------------------------------
 appliances - Appliances plugin for GLPI
 Copyright (C) 2003-2013 by the appliances Development Team.

 https://forge.indepnet.net/projects/appliances
 -------------------------------------------------------------------------

 LICENSE

 This file is part of appliances.

 appliances is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 appliances is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with appliances. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// Init the hooks of the plugins -Needed
function plugin_init_appliances() {
   global $PLUGIN_HOOKS,$CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['appliances'] = true;

   // Params : plugin name - string type - number - attributes
   Plugin::registerClass('PluginAppliancesAppliance', array('linkuser_types'         => true,
                                                            'linkuser_tech_types'    => true,
                                                            'linkgroup_types'        => true,
                                                            'linkgroup_tech_types'   => true,
                                                            'infocom_types'          => true,
                                                            'document_types'         => true,
                                                            'contract_types'         => true,
                                                            'ticket_types'           => true,
                                                            'helpdesk_visible_types' => true));

   Plugin::registerClass('PluginAppliancesProfile', array('addtabon' => 'Profile'));
   Plugin::registerClass('PluginAppliancesEnvironment');
   Plugin::registerClass('PluginAppliancesApplianceType');
   Plugin::registerClass('PluginAppliancesAppliance_Item', array('ticket_types' => true));
   Plugin::registerClass('PluginAppliancesOptvalue');
   Plugin::registerClass('PluginAppliancesOptvalue_Item');
   Plugin::registerClass('PluginAppliancesRelation');

   if (class_exists('PluginAccountsAccount')) {
      PluginAccountsAccount::registerType('PluginAppliancesAppliance');
   }

   if (class_exists('PluginCertificatesCertificate')) {
      PluginCertificatesCertificate::registerType('PluginAppliancesAppliance');
   }

   if (class_exists('PluginDatabasesDatabase')) {
      PluginDatabasesDatabase::registerType('PluginAppliancesAppliance');
   }

   if (class_exists('PluginDomainsDomain')) {
      PluginDomainsDomain::registerType('PluginAppliancesAppliance');
   }

   if (class_exists('PluginWebapplicationsWebapplication')) {
      PluginWebapplicationsWebapplication::registerType('PluginAppliancesAppliance');
   }

   // Define the type for which we know how to generate PDF, need :
   $PLUGIN_HOOKS['plugin_pdf']['PluginAppliancesAppliance'] = 'PluginAppliancesAppliancePDF';

   $PLUGIN_HOOKS['migratetypes']['appliances'] = 'plugin_datainjection_migratetypes_appliances';

   $PLUGIN_HOOKS['change_profile']['appliances']   = array('PluginAppliancesProfile','initProfile');
   $PLUGIN_HOOKS['assign_to_ticket']['appliances'] = true;
   /*$PLUGIN_HOOKS['assign_to_ticket_dropdown']['appliances'] = true;
   $PLUGIN_HOOKS['assign_to_ticket_itemtype']['appliances'] = array('PluginAppliancesAppliance_Item');*/

   if (class_exists('PluginAppliancesAppliance')) { // only if plugin activated
      $PLUGIN_HOOKS['item_clone']['appliances']
                                       = array('Profile' => array('PluginAppliancesProfile',
                                                                  'cloneProfile'));
      $PLUGIN_HOOKS['plugin_datainjection_populate']['appliances']
                                       = 'plugin_datainjection_populate_appliances';
   }

   //if glpi is loaded
   if (Session::getLoginUserID()) {

      //if environment plugin is not installed
      $plugin = new Plugin();
      if (!$plugin->isActivated('environment')
         && Session::haveRight("plugin_appliances", READ)) {

         $PLUGIN_HOOKS['menu_toadd']['appliances'] = array('assets' => 'PluginAppliancesMenu');
      }
      $PLUGIN_HOOKS['use_massive_action']['appliances'] = 1;

      /*if (isset($_SESSION["glpi_plugin_environment_installed"])
          && ($_SESSION["glpi_plugin_environment_installed"] == 1)) {

         $_SESSION["glpi_plugin_environment_appliances"] = 1;

         // Display a menu entry ?
         if (Session::haveRight("plugin_appliances", READ)) {
            $PLUGIN_HOOKS['menu_entry']['appliances'] = false;
            $PLUGIN_HOOKS['submenu_entry']['environment']['options']['appliances']['title']
                                                      = _n('Appliance', 'Appliances', 2, 'appliances');
            $PLUGIN_HOOKS['submenu_entry']['environment']['options']['appliances']['page']
                                                      = '/plugins/appliances/front/appliance.php';
            $PLUGIN_HOOKS['submenu_entry']['environment']['options']['appliances']['links']['search']
                                                      = '/plugins/appliances/front/appliance.php';
         }

         if (Session::haveRight("plugin_appliances", CREATE)) {
            $PLUGIN_HOOKS['submenu_entry']['environment']['options']['appliances']['links']['add']
                                          = '/plugins/appliances/front/appliance.form.php';
            $PLUGIN_HOOKS['use_massive_action']['appliances'] = 1;
         }

       } else {
         // Display a menu entry ?
         if (Session::haveRight("plugin_appliances", READ)) {
            $PLUGIN_HOOKS['menu_entry']['appliances']      = 'front/appliance.php';
            $PLUGIN_HOOKS['submenu_entry']['appliances']['search'] = 'front/appliance.php';
         }

         if (Session::haveRight("plugin_appliances", CREATE)) {
            $PLUGIN_HOOKS['submenu_entry']['appliances']['add']
                                                           = 'front/appliance.form.php?new=1';
            
         }
      }*/
   }
   // Import from Data_Injection plugin
   $PLUGIN_HOOKS['data_injection']['appliances'] = "plugin_appliances_data_injection_variables";

   // Import webservice
   $PLUGIN_HOOKS['webservices']['appliances'] = 'plugin_appliances_registerMethods';

   // End init, when all types are registered
   $PLUGIN_HOOKS['post_init']['appliances'] = 'plugin_appliances_postinit';
}


// Get the name and the version of the plugin - Needed
function plugin_version_appliances() {

   return array('name'           => __('Appliances', 'appliances'),
                'version'        => '2.0.0',
                'oldname'        => 'applicatifs',
                'author'         => 'Remi Collet, Xavier Caillaud, Nelly Mahu-Lasson',
                'license'        => 'GPLv2+',
                'homepage'       => 'https://forge.indepnet.net/projects/show/appliances',
                'minGlpiVersion' => '0.85');
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_appliances_check_prerequisites() {

   if (version_compare(GLPI_VERSION,'0.85.3','lt') || version_compare(GLPI_VERSION,'0.86','ge')) {
      echo "This plugin requires GLPI >= 0.85.3 and GLPI < 0.86";
      return false;
   }
   return true;
}


// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_appliances_check_config() {
   return true;
}


function plugin_datainjection_migratetypes_appliances($types) {

   $types[1200] = 'PluginAppliancesAppliance';
   return $types;
}
?>