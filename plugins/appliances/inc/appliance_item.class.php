<?php
/*
 * @version $Id: appliance_item.class.php 217 2015-02-17 10:25:15Z tsmr $
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


class PluginAppliancesAppliance_Item extends CommonDBRelation {

   // From CommonDBRelation
   static public $itemtype_1 = 'PluginAppliancesAppliance';
   static public $items_id_1 = 'plugin_appliances_appliances_id';
   static public $take_entity_1 = false ;

   static public $itemtype_2 = 'itemtype';
   static public $items_id_2 = 'items_id';
   static public $take_entity_2 = true ;

   static $rightname = "plugin_appliances";

   static function getTypeName($nb=0) {

      if ($nb > 1) {
         return _n('Appliance item', 'Appliances items', 2, 'appliances');
      }
      return _n('Appliance item', 'Appliances items', 1, 'appliances');
   }


   function cleanDBonPurge() {

      $temp = new PluginAppliancesOptvalue_Item();
      $temp->deleteByCriteria(array('itemtype' => $this->fields['itemtype'],
                                    'items_id' => $this->fields['items_id']));

      $temp = new PluginAppliancesRelation();
      $temp->deleteByCriteria(array('plugin_appliances_appliances_items_id' => $this->fields['id']));
   }


   /**
    * Hook called After an item is uninstall or purge
   **/
   static function cleanForItem(CommonDBTM $item) {

      $temp = new self();
      $temp->deleteByCriteria(
         array('itemtype' => $item->getType(),
               'items_id' => $item->getField('id'))
      );
   }


   static function countForAppliance(PluginAppliancesAppliance $item) {

      $types = implode("','", $item->getTypes());
      if (empty($types)) {
         return 0;
      }
      return countElementsInTable('glpi_plugin_appliances_appliances_items',
                                  "`itemtype` IN ('".$types."')
                                   AND `plugin_appliances_appliances_id` = '".$item->getID()."'");
   }


   static function countForItem(CommonDBTM $item) {

      return countElementsInTable('glpi_plugin_appliances_appliances_items',
                                  "`itemtype`='".$item->getType()."'
                                   AND `items_id` = '".$item->getID()."'");
   }


   /**
    * Show the appliances associated with a device
    *
    * Called from the device form (applicatif tab)
    *
    * @param $item         CommonDBTMtype of the device
    * @param $withtemplate Boolean
   **/
   static function showForItem($item, $withtemplate='') {
      global $DB,$CFG_GLPI;

      $ID       = $item->getField('id');
      $itemtype = get_Class($item);
      $canread  = $item->can($ID, READ);
      $canedit  = $item->can($ID, UPDATE);

      $query = "SELECT `glpi_plugin_appliances_appliances_items`.`id` AS entID,
                       `glpi_plugin_appliances_appliances`.*
                FROM `glpi_plugin_appliances_appliances_items`,
                     `glpi_plugin_appliances_appliances`
                LEFT JOIN `glpi_entities`
                     ON (`glpi_entities`.`id` = `glpi_plugin_appliances_appliances`.`entities_id`)
                WHERE `glpi_plugin_appliances_appliances_items`.`items_id` = '".$ID."'
                      AND `glpi_plugin_appliances_appliances_items`.`itemtype` = '".$itemtype."'
                      AND `glpi_plugin_appliances_appliances_items`.`plugin_appliances_appliances_id`
                           = `glpi_plugin_appliances_appliances`.`id`".
                      getEntitiesRestrictRequest(" AND", "glpi_plugin_appliances_appliances",
                                                 'entities_id', $item->getEntityID(), true);
      $result = $DB->query($query);
      $number = $DB->numrows($result);

      $query_app = "SELECT `ID`
                    FROM `glpi_plugin_appliances_appliances_items`
                    WHERE `items_id` = '".$ID."'";
      $result_app = $DB->query($query_app);
      $number_app = $DB->numrows($result_app);

      if ($number_app >0) {
         $colsup = 1;
      } else {
         $colsup = 0;
      }

      if (Session::isMultiEntitiesMode()) {
         $colsup += 1;
      }

      echo "<div class='center'><table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='".(5+$colsup)."'>".__('Associate', 'appliances')."</th></tr>";
      echo "<tr><th>".__('Name')."</th>";
      if (Session::isMultiEntitiesMode()) {
         echo "<th>".__('Entity')."</th>";
      }
      echo "<th>".__('Group')."</th>";
      echo "<th>".__('Type')."</th>";
      if ($number_app > 0) {
         echo "<th>".__('Item to link', 'appliances')."</th>";
      }
      echo "<th>".__('Comments')."<br>".__('User fields', 'appliances')."</th>";

      if ($canedit) {
         if ($withtemplate < 2) {
            echo "<th>&nbsp;</th>";
         }
      }
      echo "</tr>";
      $used = array();
      while ($data = $DB->fetch_array($result)) {
         $appliancesID = $data["id"];
         $used[]       = $appliancesID;

         echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";
         $name = $data["name"];
         if (($withtemplate != 3)
             && $canread
             && (in_array($data['entities_id'], $_SESSION['glpiactiveentities'])
                 || $data["is_recursive"])) {

            echo "<td class='center'>";
            echo "<a href='".
                   $CFG_GLPI["root_doc"]."/plugins/appliances/front/appliance.form.php?id=".
                   $data["id"]."'>".$name;
            if ($_SESSION["glpiis_ids_visible"]) {
               printf(__('%1$s (%2$s)'), $name, $data["id"]);
            }
            echo "</a></td>";
         } else {
            echo "<td class='center'>".$name;
            if ($_SESSION["glpiis_ids_visible"]) {
               printf(__('%1$s (%2$s)'), $name, $data["id"]);
            }
            echo "</td>";
         }
         if (Session::isMultiEntitiesMode()) {
            echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",
                                                                 $data['entities_id'])."</td>";
         }
         echo "<td class='center'>".Dropdown::getDropdownName("glpi_groups", $data["groups_id"]).
              "</td>";
         echo "<td class='center'>".
                Dropdown::getDropdownName("glpi_plugin_appliances_appliancetypes",
                                          $data["plugin_appliances_appliancetypes_id"])."</td>";

         if ($number_app > 0) {
            // add or delete a relation to an applicatifs
            echo "<td class='center'>";
            PluginAppliancesRelation::showList ($data["relationtype"], $data["entID"],
                                                $item->fields["entities_id"], $canedit);
            echo "</td>";
         }

         echo "<td class='center'>".$data["comment"];
         PluginAppliancesOptvalue_Item::showList($itemtype, $ID, $appliancesID, $canedit);
         echo "</td>";

         if ($canedit) {
            echo "<td class='center tab_bg_2'>";
            Html::showSimpleForm($CFG_GLPI['root_doc'].'/plugins/appliances/front/appliance.form.php',
                                 'deleteappliance', __('Delete permanently'),
                                 array('id' => $data['entID']));
            echo "</td>";
         }
         echo "</tr>";
      }

      if ($canedit){
         $entities = "";
         if ($item->isRecursive()) {
            $entities = getSonsOf('glpi_entities', $item->getEntityID());
         } else {
            $entities = $item->getEntityID();
         }
         $limit = getEntitiesRestrictRequest(" AND", "glpi_plugin_appliances_appliances", '',
                                             $entities, true);

         $q = "SELECT COUNT(*)
               FROM `glpi_plugin_appliances_appliances`
               WHERE `is_deleted` = '0' ".
               $limit;

         $result = $DB->query($q);
         $nb = $DB->result($result,0,0);

         if (($withtemplate < 2)
             && ($nb > count($used))) {
            echo "<tr class='tab_bg_1'>";
            echo "<td class='right' colspan=5>";

            // needed to use the button "additem"
            echo "<form method='post' action=\"".$CFG_GLPI["root_doc"].
                  "/plugins/appliances/front/appliance.form.php\">";
            echo "<input type='hidden' name='item' value='".$ID."'>".
                 "<input type='hidden' name='itemtype' value='$itemtype'>";
            Dropdown::show('PluginAppliancesAppliance', array('name'   => "conID",
                                                              'entity' => $entities,
                                                              'used'   => $used));

            echo "<input type='submit' name='additem' value='".__('Add')."' class='submit'>";
            Html::closeForm();

            echo "</td>";
            echo "<td class='right' colspan='".($colsup)."'></td>";
            echo "</tr>";
         }
      }
      echo "</table></div>";
   }


   /**
    * show for PDF the applicatif associated with a device
    *
    * @param $pdf
    * @param $item
   **/
   static function pdfForItem(PluginPdfSimplePDF $pdf, CommonGLPI $item){
      global $DB, $CFG_GLPI;

      $ID       = $item->getField('id');
      $itemtype = get_Class($item);
      $canread  = $item->can($ID,READ);
      $canedit  = $item->can($ID,UPDATE);

      $pdf->setColumnsSize(100);
      $pdf->displayTitle("<b>".__('Associated appliances', 'appliances')."</b>");

      $query = "SELECT `glpi_plugin_appliances_appliances_items`.`id` AS entID,
                       `glpi_plugin_appliances_appliances`.*
                FROM `glpi_plugin_appliances_appliances_items`,
                     `glpi_plugin_appliances_appliances`
                LEFT JOIN `glpi_entities`
                     ON (`glpi_entities`.`id` = `glpi_plugin_appliances_appliances`.`entities_id`)
                WHERE `glpi_plugin_appliances_appliances_items`.`items_id` = '".$ID;"'
                      AND `glpi_plugin_appliances_appliances_items`.`itemtype` = '";$itemtype;"'
                      AND `glpi_plugin_appliances_appliances_items`.`plugin_appliances_appliances_id`
                           = `glpi_plugin_appliances_appliances`.`id`".
                      getEntitiesRestrictRequest(" AND", "glpi_plugin_appliances_appliances",
                                                 'entities_id', $item->getEntityID(), true);
      $result = $DB->query($query);
      $number = $DB->numrows($result);

      if (!$number) {
         $pdf->displayLine(__('No item found'));
      } else {
         if (Session::isMultiEntitiesMode()) {
            $pdf->setColumnsSize(30,30,20,20);
            $pdf->displayTitle('<b><i>'.__('Name'), __('Entity'), __('Group'), __('Type').'</i></b>');
         } else {
            $pdf->setColumnsSize(50,25,25);
            $pdf->displayTitle('<b><i>'.__('Name'), __('Group'),__('Type').'</i></b>');
         }

         while ($data = $DB->fetch_array($result)) {
            $appliancesID = $data["id"];
            if (Session::isMultiEntitiesMode()) {
               $pdf->setColumnsSize(30,30,20,20);
               $pdf->displayLine($data["name"],
                                 Html::clean(Dropdown::getDropdownName("glpi_entities",
                                                                       $data['entities_id'])),
                                 Html::clean(Dropdown::getDropdownName("glpi_groups",
                                                                       $data["groups_id"])),
                                 Html::clean(Dropdown::getDropdownName("glpi_plugin_appliances_appliancetypes",
                                                                       $data["plugin_appliances_appliancetypes_id"])));
            } else {
               $pdf->setColumnsSize(50,25,25);
               $pdf->displayLine($data["name"],
                                 Html::clean(Dropdown::getDropdownName("glpi_groups",
                                                                       $data["groups_id"])),
                                 Html::clean(Dropdown::getDropdownName("glpi_plugin_appliances_appliancetypes",
                                                                       $data["plugin_appliances_appliancetypes_id"])));
            }
            PluginAppliancesRelation::showList_PDF($pdf, $data["relationtype"], $data["entID"]);
            PluginAppliancesOptvalue_Item::showList_PDF($pdf, $ID, $appliancesID);
         }
      }
      $pdf->displaySpace();
   }


   static function pdfForAppliance(PluginPdfSimplePDF $pdf, PluginAppliancesAppliance $appli) {
      global $DB, $CFG_GLPI;

      $instID = $appli->fields['id'];

      if (!$appli->can($instID,"r")) {
         return false;
      }
      if (!Session::haveRight("plugin_appliances", READ)) {
         return false;
      }

      $pdf->setColumnsSize(100);
      $pdf->displayTitle('<b>'.__('Associated items', 'behaviors').'</b>');

      $query = "SELECT DISTINCT `itemtype`
                FROM `glpi_plugin_appliances_appliances_items`
                WHERE `plugin_appliances_appliances_id` = '".$instID."'
                ORDER BY `itemtype`";
      $result = $DB->query($query);
      $number = $DB->numrows($result);

      if (Session::isMultiEntitiesMode()) {
         $pdf->setColumnsSize(12,27,25,18,18);
         $pdf->displayTitle('<b><i>'.__('Type'), __('Name'), __('Entity'), __('Serial number'),
                                     __('Inventory number').'</i></b>');
      } else {
         $pdf->setColumnsSize(25,31,22,22);
         $pdf->displayTitle('<b><i>'.__('Type'), __('Name'), __('Serial number'),
                                     __('Inventory number').'</i></b>');
      }

      if (!$number) {
         $pdf->displayLine(__('No item found'));
      } else {
         for ($i=0 ; $i < $number ; $i++) {
            $type = $DB->result($result, $i, "itemtype");
            if (!($item = getItemForItemtype($type))) {
               continue;
            }

            if ($item->canView()) {
               $column = "name";
               if ($type == 'Ticket') {
                  $column = "id";
               }
               if ($type == 'KnowbaseItem') {
                  $column = "question";
               }

               $query = "SELECT `".$item->getTable()."`.*,
                                `glpi_plugin_appliances_appliances_items`.`id` AS IDD,
                                `glpi_entities`.`id` AS entity
                         FROM `glpi_plugin_appliances_appliances_items`, `".$item->getTable()."`
                         LEFT JOIN `glpi_entities`
                              ON (`glpi_entities`.`id` = `".$item->getTable()."`.`entities_id`)
                         WHERE `".$item->getTable()."`.`id`
                                    = `glpi_plugin_appliances_appliances_items`.`items_id`
                               AND `glpi_plugin_appliances_appliances_items`.`itemtype` = '".$type."'
                               AND `glpi_plugin_appliances_appliances_items`.`plugin_appliances_appliances_id`
                                    = '".$instID."' ".
                               getEntitiesRestrictRequest(" AND ",$item->getTable());

               if ($item->maybeTemplate()) {
                  $query .= " AND `".$item->getTable()."`.`is_template` = '0'";
               }
               $query.=" ORDER BY `glpi_entities`.`completename`, `".$item->getTable()."`.$column";

               if ($result_linked = $DB->query($query)) {
                  if ($DB->numrows($result_linked)) {
                     while ($data = $DB->fetch_assoc($result_linked)) {
                        if (!$item->getFromDB($data["id"])) {
                           continue;
                        }

                        if ($type == 'Ticket') {
                           $data["name"] = sprintf(__('%1$s %2$s'), __('Ticket'), $data["id"]);
                        }
                        if ($type == 'KnowbaseItem') {
                           $data["name"] = $data["question"];
                        }
                        $name = $data["name"];
                        if ($_SESSION["glpiis_ids_visible"] || empty($data["name"])) {
                           $name = sprintf(__('%1$s (%2$s)'), $name, $data["id"]);
                        }

                        if (Session::isMultiEntitiesMode()) {
                           $pdf->setColumnsSize(12,27,25,18,18);
                           $pdf->displayLine($item->getTypeName(), $name,
                                             Dropdown::getDropdownName("glpi_entities",
                                                                       $data['entities_id']),
                                             (isset($data["serial"])? $data["serial"] :"-"),
                                             (isset($data["otherserial"])?$data["otherserial"]:"-"));
                        } else {
                           $pdf->setColumnsSize(25,31,22,22);
                           $pdf->displayTitle($item->getTypeName(), $name,
                                              (isset($data["serial"])?$data["serial"]:"-"),
                                              (isset($data["otherserial"])?$data["otherserial"]:"-"));
                        }

                        PluginAppliancesRelation::showList_PDF($pdf, $appli->fields["relationtype"],
                                                               $data["IDD"]);
                        PluginAppliancesOptvalue_Item::showList_PDF($pdf, $data["id"], $instID);
                     } // Each device
                  } // numrows device
               }
            } // type right
         } // each type
      } // numrows type
      $pdf->displaySpace();
   }



   /**
    * Show the Device associated with an applicatif
    *
    * Called from the applicatif form
   **/
   static function showForAppliance(PluginAppliancesAppliance $appli) {
      global $DB,$CFG_GLPI;

      $instID = $appli->fields['id'];

      if (!$appli->can($instID, READ)) {
         return false;
      }
      $rand = mt_rand();

      $canedit = $appli->can($instID, UPDATE);

      $query = "SELECT DISTINCT `itemtype`
                FROM `glpi_plugin_appliances_appliances_items`
                WHERE `plugin_appliances_appliances_id` = '".$instID."'
                ORDER BY `itemtype`";
      $result = $DB->query($query);
      $number = $DB->numrows($result);

      $i = 0;

      if (Session::isMultiEntitiesMode()) {
         $colsup = 1;
      } else {
         $colsup = 0;
      }

      echo "<form method='post' name='appliances_form$rand' id='appliances_form$rand' action=\"".
            $CFG_GLPI["root_doc"]."/plugins/appliances/front/appliance.form.php\">";

      echo "<div class='center'><table class='tab_cadre_fixehov'>";
      echo "<tr><th colspan='".($canedit?(6+$colsup):(5+$colsup))."'>".
            __('Associated items', 'appliances')."</th></tr><tr>";
      if ($canedit) {
         echo "<th>&nbsp;</th>";
      }
      echo "<th>".__('Type')."</th>";
      echo "<th>".__('Name')."</th>";
      if (Session::isMultiEntitiesMode()) {
         echo "<th>".__('Entity')."</th>";
      }
      if ($appli->fields["relationtype"]) {
         echo "<th>".__('Item to link', 'appliances')."<br>".__('User fields', 'appliances')."</th>";
      }
      echo "<th>".__('Serial number')."</th>";
      echo "<th>".__('Inventory number')."</th>";
      echo "</tr>";

      for ($i=0 ; $i < $number ; $i++) {
         $type = $DB->result($result, $i, "itemtype");
         if (!($item = getItemForItemtype($type))) {
            continue;
         }
         if ($item->canView()) {
            $column = "name";
            if ($type == 'Ticket') {
               $column = "id";
            }
            if ($type == 'KnowbaseItem') {
               $column = "question";
            }

            $query = "SELECT `".$item->getTable()."`.*,
                             `glpi_plugin_appliances_appliances_items`.`id` AS IDD,
                             `glpi_entities`.`id` AS entity
                      FROM `glpi_plugin_appliances_appliances_items`, ".getTableForItemType($type)."
                      LEFT JOIN `glpi_entities`
                           ON (`glpi_entities`.`id` = `".$item->getTable()."`.`entities_id`)
                      WHERE `".$item->getTable()."`.`id`
                                 = `glpi_plugin_appliances_appliances_items`.`items_id`
                            AND `glpi_plugin_appliances_appliances_items`.`itemtype` = '".$type."'
                            AND `glpi_plugin_appliances_appliances_items`.`plugin_appliances_appliances_id`
                                 = '".$instID."' ".
                            getEntitiesRestrictRequest(" AND ", $item->getTable());

            if ($item->maybeTemplate()) {
               $query .= " AND `".$item->getTable()."`.`is_template` = '0'";
            }
            $query.=" ORDER BY `glpi_entities`.`completename`, `".$item->getTable()."`.$column";

            if ($result_linked = $DB->query($query)) {
               if ($DB->numrows($result_linked)) {
                  Session::initNavigateListItems($type,
                                                 _n('Appliance', 'Appliances', 2, 'appliances')."
                                                   = ".$appli->getNameID());

                  while ($data = $DB->fetch_assoc($result_linked)) {
                     $item->getFromDB($data["id"]);
                     Session::addToNavigateListItems($type,$data["id"]);
                     //TODO $ID never user - why this part ?
                     $ID = "";
                     if ($type == 'Ticket') {
                        $data["name"] = sprintf(__('%1$s %2$s'), __('Ticket'), $data["id"]);
                     }
                     if ($type == 'KnowbaseItem') {
                        $data["name"] = $data["question"];
                     }
                     if ($_SESSION["glpiis_ids_visible"] || empty($data["name"])) {
                        $ID = " (".$data["id"].")";
                     }

                     $name = $item->getLink();

                     echo "<tr class='tab_bg_1'>";
                     if ($canedit) {
                        echo "<td width='10'>";
                        $sel = "";
                        if (isset($_GET["select"]) && ($_GET["select"] == "all")) {
                           $sel = "checked";
                        }
                        echo "<input type='checkbox' name='item[".$data["IDD"]."]' value='1' $sel>";
                        echo "</td>";
                     }
                     echo "<td class='center'>".$item->getTypeName()."</td>";
                     echo "<td class='center' ".
                           (isset($data['deleted']) && $data['deleted']?"class='tab_bg_2_2'":"").">".
                           $name."</td>";
                     if (Session::isMultiEntitiesMode()) {
                        echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",
                                                                             $data['entity']).
                              "</td>";
                     }

                     if ($appli->fields["relationtype"]) {
                        echo "<td class='center'>".
                               PluginAppliancesRelation::getTypeName($appli->fields["relationtype"]).
                               "&nbsp;:&nbsp;";
                               PluginAppliancesRelation::showList($appli->fields["relationtype"],
                                                                  $data["IDD"],
                                                                  $item->fields["entities_id"],
                                                                  false);
                               PluginAppliancesOptvalue_Item::showList($type, $data["id"], $instID,
                                                                       false);
                        echo "</td>";
                     }

                     echo "<td class='center'>".(isset($data["serial"])? "".$data["serial"].""
                                                                       :"-")."</td>";
                     echo "<td class='center'>".
                           (isset($data["otherserial"])? "".$data["otherserial"]."" :"-")."</td>";
                     echo "</tr>";
                  }
               }
            }
         }
      }

      if ($canedit) {
         echo "<tr class='tab_bg_1'><td colspan='".(3+$colsup)."' class='center'>";

         echo "<input type='hidden' name='conID' value='$instID'>";
         Dropdown::showAllItems("item", 0, 0,
                                ($appli->fields['is_recursive']?-1:$appli->fields['entities_id']),
                                 $appli->getTypes());
         echo "</td>";
         echo "<td colspan='3' class='center' class='tab_bg_2'>";
         echo "<input type='submit' name='additem' value='".__('Add')."' class='submit'>";
         echo "</td></tr>";
         echo "</table></div>" ;

         Html::openArrowMassives("appliances_form$rand", true);
         Html::closeArrowMassives(array('deleteitem' => __('Delete permanently')));

      } else {
         echo "</table></div>";
      }
      Html::closeForm();
   }


   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if (!$withtemplate) {
         if (($item->getType() == 'PluginAppliancesAppliance')
             && count(PluginAppliancesAppliance::getTypes(false))) {
            if ($_SESSION['glpishow_count_on_tabs']) {
               return self::createTabEntry(_n('Associated item', 'Associated items', 2),
                                           self::countForAppliance($item));
            }
            return __('Associated item', 'Associated items', 2);

         } else if (in_array($item->getType(), PluginAppliancesAppliance::getTypes(true))
                    && Session::haveRight('plugin_appliances', READ)) {
            if ($_SESSION['glpishow_count_on_tabs']) {
               return self::createTabEntry(PluginAppliancesAppliance::getTypeName(2),
                                           self::countForItem($item));
            }
            return PluginAppliancesAppliance::getTypeName(2);
         }
      }
      return '';
   }


   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      if ($item->getType()=='PluginAppliancesAppliance') {
         self::showForAppliance($item);

      } else if (in_array($item->getType(), PluginAppliancesAppliance::getTypes(true))) {
         self::showForItem($item, $withtemplate);

      }
      return true;
   }


   static function displayTabContentForPDF(PluginPdfSimplePDF $pdf, CommonGLPI $item, $tab) {

      if ($item->getType()=='PluginAppliancesAppliance') {
         self::pdfForAppliance($pdf, $item);

      } else if (in_array($item->getType(), PluginAppliancesAppliance::getTypes(true))) {
         self::pdfForItem($pdf, $item);

      } else {
         return false;
      }
      return true;
   }

   function getFromDBbyAppliancesAndItem($plugin_appliances_appliances_id,$items_id,$itemtype) {
      global $DB;

      $query = "SELECT * FROM `".$this->getTable()."` " .
         "WHERE `plugin_appliances_appliances_id` = '" . $plugin_appliances_appliances_id . "'
         AND `itemtype` = '" . $items_id . "'
         AND `items_id` = '" . $itemtype . "'";
      if ($result = $DB->query($query)) {
         if ($DB->numrows($result) != 1) {
            return false;
         }
         $this->fields = $DB->fetch_assoc($result);
         if (is_array($this->fields) && count($this->fields)) {
            return true;
         } else {
            return false;
         }
      }
      return false;
   }

   function deleteItemByAppliancesAndItem($plugin_appliances_appliances_id,$items_id,$itemtype) {

      if ($this->getFromDBbyAppliancesAndItem($plugin_appliances_appliances_id,$items_id,$itemtype)) {
         $this->delete(array('id'=>$this->fields["id"]));
      }
   }


   
   function getLink($with_comment=0) {
      $paAppliance = new PluginAppliancesAppliance();
      $paAppliance->getFromDB($this->fields['plugin_appliances_appliances_id']);

      $itemtype = $this->fields['itemtype'];
      $item = new $itemtype();
      $item->getFromDB($this->fields['items_id']);
      return $item->getLink($with_comment)." sur ".
              $paAppliance->getLink($with_comment);
   }
}
