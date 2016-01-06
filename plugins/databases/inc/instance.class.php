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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginDatabasesInstance extends CommonDBChild {

   static $rightname = "plugin_databases";

   // From CommonDBChild
   static public $itemtype = 'PluginDatabasesDatabase';
   static public $items_id = 'plugin_databases_databases_id';

   static function getTypeName($nb=0) {

      return _n('Instance','Instances',$nb, 'databases');
   }

   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if ($item->getType()=='PluginDatabasesDatabase') {
         if ($_SESSION['glpishow_count_on_tabs']) {
            return self::createTabEntry(self::getTypeName(2), self::countForItem($item));
         }
         return self::getTypeName(2);
      }
      return '';
   }
   
   static function countForItem(CommonDBTM $item) {

      return countElementsInTable('glpi_plugin_databases_instances',
                                  "`plugin_databases_databases_id` = '".$item->getID()."'");
   }
   

   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
      global $CFG_GLPI;

      if ($item->getType()=='PluginDatabasesDatabase') {
         $self = new self();

         $self->showInstances($item);
         $self->showForm("", array('plugin_databases_databases_id' => $item->getField('id'),
                                    'target' => $CFG_GLPI['root_doc']."/plugins/databases/front/instance.form.php"));
      }
      return true;
   }

   function post_getEmpty () {
      $this->fields["port"]='0';
   }

   function prepareInputForAdd($input) {
      // Not attached to reference -> not added
      if (!isset($input['plugin_databases_databases_id'])
            || $input['plugin_databases_databases_id'] <= 0) {
         return false;
      }
      return $input;
   }

   function showForm ($ID, $options=array()) {

      if (!$this->canView()) return false;

      $plugin_databases_databases_id = -1;
      if (isset($options['plugin_databases_databases_id'])) {
         $plugin_databases_databases_id = $options['plugin_databases_databases_id'];
      }

      if ($ID > 0) {
         $this->check($ID,READ);
      } else {
         $database = new PluginDatabasesDatabase();
         $database->getFromDB($plugin_databases_databases_id);
         // Create item
         $input=array('plugin_databases_databases_id'=>$plugin_databases_databases_id,
                      'entities_id' => $database->getEntityID(),
                      'is_recursive' => $database->isRecursive());
         $this->check(-1,UPDATE,$input);
      }

      $this->showFormHeader($options);

      echo "<input type='hidden' name='plugin_databases_databases_id' value='$plugin_databases_databases_id'>";
      echo "<input type='hidden' name='entities_id' value='".$this->fields["entities_id"]."'>";
      echo "<input type='hidden' name='is_recursive' value='".$this->fields["is_recursive"]."'>";

      echo "<tr class='tab_bg_1'>";

      echo "<td>".__('Name')."</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"name");
      echo "</td>";

      echo "<td>".__('Port')."</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"port");
      echo "</td>";

      echo "</tr>";

      echo "<tr class='tab_bg_1'>";

      echo "<td>".__('Path', 'databases')."</td>";
      echo "<td>";
      Html::autocompletionTextField($this,"path");
      echo "</td>";

      echo "<td></td>";
      echo "<td></td>";

      echo "</tr>";

      echo "<tr class='tab_bg_1'>";

      echo "<td colspan = '4'>";
      echo "<table cellpadding='2' cellspacing='2' border='0'><tr><td>";
      echo __('Comments')."</td></tr>";
      echo "<tr>";
      echo "<td class='center'>";
      echo "<textarea cols='125' rows='3' name='comment'>".$this->fields["comment"]."</textarea>";
      echo "</td></tr></table>";
      echo "</td>";

      echo "</tr>";

      $options['candel'] = false;
      $this->showFormButtons($options);

      return true;
   }

   /**
    * @since version 0.84
   **/
   function getForbiddenStandardMassiveAction() {

      $forbidden   = parent::getForbiddenStandardMassiveAction();
      $forbidden[] = 'update';
      return $forbidden;
   }

   function showInstances(PluginDatabasesDatabase $database) {
      global $DB,$CFG_GLPI;

      $instID = $database->fields['id'];

      if (!$database->can($instID, READ)) {
         return false;
      }

      $canedit=$database->can($instID, UPDATE);
      $rand=mt_rand();

      $query = "SELECT `glpi_plugin_databases_instances`.`name`,
                     `glpi_plugin_databases_instances`.`id`,
                     `glpi_plugin_databases_instances`.`plugin_databases_databases_id`,
                     `glpi_plugin_databases_instances`.`path`,
                     `glpi_plugin_databases_instances`.`port`,
                     `glpi_plugin_databases_instances`.`comment`
                      FROM `glpi_plugin_databases_instances` ";
      $query.= " LEFT JOIN `glpi_plugin_databases_databases`
         ON (`glpi_plugin_databases_databases`.`id` = `glpi_plugin_databases_instances`.`plugin_databases_databases_id`)";
      $query.= " WHERE `glpi_plugin_databases_instances`.`plugin_databases_databases_id` = '$instID'
        ORDER BY `glpi_plugin_databases_instances`.`name`";

      $result = $DB->query($query);
      $number = $DB->numrows($result);

      echo "<div class='spaced'>";

      if ($canedit && $number) {
         Html::openMassiveActionsForm('mass'.__CLASS__.$rand);
         $massiveactionparams = array();
         Html::showMassiveActions($massiveactionparams);
      }

      if($number!=0){
         echo "<table class='tab_cadre_fixe'>";
         echo "<tr>";

         if ($canedit && $number) {
            echo "<th width='10'>".Html::getCheckAllAsCheckbox('mass'.__CLASS__.$rand)."</th>";
         }

         echo "<th>".__('Name')."</th>";
         echo "<th>".__('Port')."</th>";
         echo "<th>".__('Path', 'databases')."</th>";
         echo "<th>".__('Comments')."</th>";

         echo "</tr>";

         Session::initNavigateListItems($this->getType(),PluginDatabasesDatabase::getTypeName(2) ." = ". $database->fields["name"]);
         $i = 0;
         $row_num=1;

         while ($data=$DB->fetch_array($result)) {

            Session::addToNavigateListItems($this->getType(),$data['id']);

            $i++;
            $row_num++;
            echo "<tr class='tab_bg_1 center'>";
            echo "<td width='10'>";
            if ($canedit) {
               Html::showMassiveActionCheckBox(__CLASS__, $data["id"]);
            }
            echo "</td>";

            echo "<td class='center'>";
            echo "<a href='".$CFG_GLPI["root_doc"]."/plugins/databases/front/instance.form.php?id=".$data["id"]."&amp;plugin_databases_databases_id=".$data["plugin_databases_databases_id"]."'>".$data["name"];
            if ($_SESSION["glpiis_ids_visible"] || empty($data["name"])) echo " (".$data["id"].")";
            echo "</a></td>";

            echo "<td class='center'>".$data["port"]."</td>";
            echo "<td class='left'>".$data["path"]."</td>";
            echo "<td class='center'>".nl2br($data["comment"])."</td>";
            echo "</tr>";
         }
         echo "</table>";
      }

      if ($canedit && $number) {
         $paramsma['ontop'] =false;
         Html::showMassiveActions($paramsma);
         Html::closeForm();
      }
      echo "</div>";
   }
}

?>