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

if (!isset($_GET["id"])) $_GET["id"] = "";
if (!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";

$database=new PluginDatabasesDatabase();
$database_item=new PluginDatabasesDatabase_Item();

if (isset($_POST["add"])) {

   $database->check(-1, CREATE,$_POST);
   $newID=$database->add($_POST);
   if ($_SESSION['glpibackcreated']) {
      Html::redirect($web->getFormURL()."?id=".$newID);
   }
   Html::back();

} else if (isset($_POST["delete"])) {

   $database->check($_POST['id'], DELETE);
   $database->delete($_POST);
   $database->redirectToList();

} else if (isset($_POST["restore"])) {

   $database->check($_POST['id'], PURGE);
   $database->restore($_POST);
   $database->redirectToList();

} else if (isset($_POST["purge"])) {

   $database->check($_POST['id'], PURGE);
   $database->delete($_POST,1);
   $database->redirectToList();

} else if (isset($_POST["update"])) {

   $database->check($_POST['id'], UPDATE);
   $database->update($_POST);
   Html::back();

} else if (isset($_POST["additem"])) {

   if (!empty($_POST['itemtype'])&&$_POST['items_id']>0) {
      $database_item->check(-1, UPDATE, $_POST);
      $database_item->addItem($_POST);
   }
   Html::back();

} else if (isset($_POST["deleteitem"])) {

   foreach ($_POST["item"] as $key => $val) {
         $input = array('id' => $key);
         if ($val==1) {
            $database_item->check($key, UPDATE);
            $database_item->delete($input);
         }
      }
   Html::back();

} else if (isset($_POST["deletedatabases"])) {

   $input = array('id' => $_POST["id"]);
   $database_item->check($_POST["id"], UPDATE);
   $database_item->delete($input);
   Html::back();

} else {

   $database->checkGlobal(READ);

   $plugin = new Plugin();
   if ($plugin->isActivated("environment")) {
      Html::header(PluginDatabasesDatabase::getTypeName(2),
                     '',"assets","pluginenvironmentdisplay","databases");
   } else {
      Html::header(PluginDatabasesDatabase::getTypeName(2), '', "assets",
                   "plugindatabasesmenu");
   }
   $database->display($_GET);

   Html::footer();
}

?>