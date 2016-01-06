<?php
/*
 * @version $Id: appliancetype.class.php 217 2015-02-17 10:25:15Z tsmr $
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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}


class PluginAppliancesApplianceType extends CommonDropdown {

   static $rightname = "plugin_appliances";

   static function getTypeName($nb=0) {
      return __('Type of appliance', 'appliances');
   }


   function prepareInputForAdd($input) {

      if (array_key_exists('externalid',$input) && !$input['externalid']) {
         // INSERT NULL as this value is an UNIQUE index
         unset($input['externalid']);
      }
      return $input;
   }


   static function transfer($ID, $entity) {
      global $DB;

      $temp = new self();
      if (($ID <= 0) || !$temp->getFromDB($ID)) {
         return 0;
      }

      $query = "SELECT `id`
                FROM `".$temp->getTable()."`
                WHERE `entities_id` = '".$entity."'
                      AND `name` = '".addslashes($temp->fields['name'])."'";

      foreach ($DB->request($query) as $data) {
         return $data['id'];
      }
      $input                = $temp->fields;
      $input['entities_id'] = $entity;
      unset($input['id']);
      return $temp->add($input);
   }
}
?>