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

include ('../../../inc/includes.php');

if(!isset($_GET["id"])) $_GET["id"] = "";
if(!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";
if(!isset($_GET["plugin_databases_databases_id"])) $_GET["plugin_databases_databases_id"] = "";

$instance=new PluginDatabasesInstance();

if (isset($_POST["add"])) {

   if ($instance->canCreate())
      $instance->add($_POST);
   Html::back();

} else if (isset($_POST["update"])) {
   
   if ($instance->canCreate())
      $instance->update($_POST);
   Html::back();

} else if (isset($_POST["delete"])) {
   
  if ($instance->canCreate())
      $instance->delete($_POST,1);
   Html::redirect(Toolbox::getItemTypeFormURL('PluginDatabasesDatabase')."?id=".$_POST["plugin_databases_databases_id"]);

} else if (isset($_POST["delete_instance"])) {
   if ($instance->canCreate()) {
      foreach ($_POST["check"] as $ID => $value) {
         $instance->delete(array("id"=>$ID),1);
      }
   }
   Html::back();

} else {

   $instance->checkGlobal(READ);
   
   $plugin = new Plugin();
   if ($plugin->isActivated("environment")) {
      Html::header(PluginDatabasesDatabase::getTypeName(2),
                     '',"assets","pluginenvironmentdisplay","databases");
   } else {
      Html::header(PluginDatabasesDatabase::getTypeName(2), '', "assets",
                   "plugindatabasesmenu");
   }
   $instance->display($_GET);
   
   Html::footer();
}

?>