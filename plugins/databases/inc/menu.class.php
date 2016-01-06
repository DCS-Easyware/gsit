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

 
class PluginDatabasesMenu extends CommonGLPI {
   static $rightname = 'plugin_databases';

   static function getMenuName() {
      return _n('Database', 'Databases', 2, 'databases');
   }

   static function getMenuContent() {
      global $CFG_GLPI;

      $menu                                           = array();
      $menu['title']                                  = self::getMenuName();
      $menu['page']                                   = "/plugins/databases/front/database.php";
      $menu['links']['search']                        = PluginDatabasesDatabase::getSearchURL(false);
      if (PluginDatabasesDatabase::canCreate()) {
         $menu['links']['add']                        = PluginDatabasesDatabase::getFormURL(false);
      }

      return $menu;
   }

   static function removeRightsFromSession() {
      if (isset($_SESSION['glpimenu']['tools']['types']['PluginDatabasesMenu'])) {
         unset($_SESSION['glpimenu']['tools']['types']['PluginDatabasesMenu']); 
      }
      if (isset($_SESSION['glpimenu']['tools']['content']['plugindatabasesmenu'])) {
         unset($_SESSION['glpimenu']['tools']['content']['plugindatabasesmenu']); 
      }
   }
}