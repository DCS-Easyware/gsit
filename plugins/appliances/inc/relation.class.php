<?php
/*
 * @version $Id: relation.class.php 203 2013-03-11 15:34:32Z yllen $
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

/**
 * This is a special relation between
 *    a glpi_application_items
 *    a dropdwn (glpi_locations, glpi_domains, glpi_networks)
**/
class PluginAppliancesRelation extends CommonDBTM {


   static function getTypeTable ($value) {

      switch ($value) {
         case 1 : // Location
            $name = "glpi_locations";
            break;

         case 2 : // Réseau
            $name = "glpi_networks";
            break;

         case 3 : // Domain
            $name = "glpi_domains";
            break;

         default:
            $name ="";
      }
      return $name;
   }


   static function getItemType ($value) {

      switch ($value) {
         case 1 : // Location
            $name = "Location";
            break;

         case 2 : // Réseau
            $name = "Network";
            break;

         case 3 : // Domain
            $name = "Domain";
            break;

         default:
            $name ="";
      }
      return $name;
   }


   static function getTypeName($value=0) {

      switch ($value) {
         case 1 : // Location
            $name = __('Location');
            break;

         case 2 : // Réseau
            $name = _n('Network', 'Networks', 1);
            break;

         case 3 : // Domain
            $name = _n('Domain', 'Domains', 1);
            break;

         default :
            $name = "&nbsp;";
      }
      return $name;
   }


   static function dropdownType($myname, $value=0) {

      Dropdown::showFromArray($myname, array (0 => Dropdown::EMPTY_VALUE,
                                              1 => __('Location'),
                                              2 => _n('Network', 'Networks', 1),
                                              3 => _n('Domain', 'Domains', 1)),
                              array ('value' => $value));
   }


   /**
    * Show the relation for a device/applicatif
    *
    * Called from PluginAppliancesAppliance->showItem and PluginAppliancesAppliance::showAssociated
    *
    * @param $drelation_type : type of the relation
    * @param $relID ID of the relation
    * @param $entity, ID of the entity of the device
    * @param $canedit, if user is allowed to edit the relation
    *    - canedit the device if called from the device form
    *    - must be false if called from the applicatif form
   **/
   static function showList($relationtype, $relID, $entity, $canedit) {
      global $DB, $CFG_GLPI;

      if (!$relationtype) {
         return false;
      }

      // selects all the attached relations
      $itemtype = PluginAppliancesRelation::getItemType($relationtype);
      $title    = PluginAppliancesRelation::getTypeName($relationtype);

      if ($itemtype == 'Location') {
         $sql_loc = "SELECT `glpi_plugin_appliances_relations`.`id`,
                            `completename` AS dispname ";
      } else {
         $sql_loc = "SELECT `glpi_plugin_appliances_relations`.`id`,
                            `name` AS dispname ";
      }
      $sql_loc .= "FROM `".getTableForItemType($itemtype)."` ,
                        `glpi_plugin_appliances_relations`,
                        `glpi_plugin_appliances_appliances_items`
                   WHERE `".getTableForItemType($itemtype)."`.`id`
                                    = `glpi_plugin_appliances_relations`.`relations_id`
                         AND `glpi_plugin_appliances_relations`.`plugin_appliances_appliances_items_id`
                                    = `glpi_plugin_appliances_appliances_items`.`id`
                         AND `glpi_plugin_appliances_appliances_items`.`id` = '".$relID."'";

      $result_loc = $DB->query($sql_loc);
      $number_loc = $DB->numrows($result_loc);

      if ($canedit) {
         echo "<form method='post' name='relation' action='".
               $CFG_GLPI["root_doc"]."/plugins/appliances/front/appliance.form.php'>";
         echo "<br><input type='hidden' name='deviceID' value='".$relID."'>";

         $i        = 0;
         $itemlist = "";
         $used     = array();

         if ($number_loc >0) {
            echo "<table>";
            while ($i < $number_loc) {
               $res = $DB->fetch_array($result_loc);
               echo "<tr><td class=top>";
               // when the value of the checkbox is changed, the corresponding hidden variable value
               // is also changed by javascript
               echo "<input type='checkbox' name='itemrelation[".$res["id"]. "]' value='1'></td><td>";
               echo $res["dispname"];
               echo "</td></tr>";
               $i++;
            }
            echo "</table>";
            echo "<input type='submit' name='dellieu' value='"._sx('button', 'Delete permanently')."'
                   class='submit'>".
                  "<br><br>";
         }

         echo "$title&nbsp;:&nbsp;";

         Dropdown::show($itemtype, array('name'   => "tablekey[" . $relID . "]",
                                         'entity' => $entity,
                                         'used'   => $used));
         echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='addlieu' value=\""._sx('button', 'Add').
               "\" class='submit'><br>&nbsp;";
         Html::closeForm();

      } else if ($number_loc > 0) {
         while ($res = $DB->fetch_array($result_loc)) {
            echo $res["dispname"]."<br>";
         }
      } else {
         echo "&nbsp;";
      }
   }


   /**
    * Show for PDF the relation for a device/applicatif
    *
    * @param $pdf object for the output
    * @param $drelation_type : type of the relation
    * @param $relID ID of the relation
   **/
   static function showList_PDF($pdf, $relationtype, $relID) {
      global $DB, $CFG_GLPI;

      if (!$relationtype) {
         return false;
      }

      // selects all the attached relations
      $tablename = PluginAppliancesRelation::getTypeTable($relationtype);
      $title     = PluginAppliancesRelation::getTypeName($relationtype);

      if ($tablename=='glpi_locations') {
         $sql_loc = "SELECT `glpi_plugin_appliances_relations`.`id`,
                            `completename` AS dispname ";
      } else {
         $sql_loc = "SELECT `glpi_plugin_appliances_relations`.`id`,
                            `name` AS dispname ";
      }
      $sql_loc .= "FROM `".$tablename."` ,
                        `glpi_plugin_appliances_relations`,
                        `glpi_plugin_appliances_appliances_items`
                   WHERE `".$tablename."`.`id` = `glpi_plugin_appliances_relations`.`relations_id`
                         AND `glpi_plugin_appliances_relations`.`plugin_appliances_appliances_items_id`
                                 = `glpi_plugin_appliances_appliances_items`.`id`
                         AND `glpi_plugin_appliances_appliances_items`.`id` = '".$relID."'";
      $result_loc = $DB->query($sql_loc);

      $opts = array();
      while ($res = $DB->fetch_array($result_loc)) {
         $opts[] = $res["dispname"];
      }
      $pdf->setColumnsSize(100);
      $pdf->displayLine(sprintf(__('%1$s: %2$s'),
                                "<b><i>".__('Item to link', 'appliances')."$title </i> </b>",
                                implode(', ',$opts)));

   }

}
?>