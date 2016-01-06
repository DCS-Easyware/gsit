<?php
/*
 * @version $Id: optvalue.class.php 206 2013-06-13 10:29:37Z tsmr $
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

 
class PluginAppliancesMenu extends CommonGLPI {
   static $rightname = 'plugin_appliances';

   static function getMenuName() {
      return _n('Appliance', 'Appliances', 2, 'appliances');
   }

   static function getMenuContent() {
      global $CFG_GLPI;

      $menu                                           = array();
      $menu['title']                                  = self::getMenuName();
      $menu['page']                                   = "/plugins/appliances/front/appliance.php";
      $menu['links']['search']                        = PluginAppliancesAppliance::getSearchURL(false);
      if (PluginAppliancesAppliance::canCreate()) {
         $menu['links']['add']                        = PluginAppliancesAppliance::getFormURL(false);
      }

      return $menu;
   }

   static function removeRightsFromSession() {
      if (isset($_SESSION['glpimenu']['tools']['types']['PluginAppliancesMenu'])) {
         unset($_SESSION['glpimenu']['tools']['types']['PluginAppliancesMenu']); 
      }
      if (isset($_SESSION['glpimenu']['tools']['content']['pluginappliancesmenu'])) {
         unset($_SESSION['glpimenu']['tools']['content']['pluginappliancesmenu']); 
      }
   }
}