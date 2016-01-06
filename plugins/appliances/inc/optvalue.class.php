<?php
/*
 * @version $Id: optvalue.class.php 217 2015-02-17 10:25:15Z tsmr $
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


class PluginAppliancesOptvalue extends CommonDBTM {


   function cleanDBonPurge() {

      $temp = new PluginAppliancesOptvalue_Item();
      $temp->deleteByCriteria(array('plugin_appliances_optvalues_id' => $this->fields['id']));
   }


   /**
    * Display list of Optvalues for an appliance
    *
    * @param $appli PluginAppliancesAppliance instance
    *
    * @return nothing (display form)
    */
   static function showForAppliance (PluginAppliancesAppliance $appli) {
      global $DB, $CFG_GLPI;

      if (!$appli->can($appli->fields['id'],READ)) {
         return false;
      }
      $canedit = $appli->can($appli->fields['id'],UPDATE);

      $rand = mt_rand();
      if ($canedit) {
         echo "<form method='post' name='optvalues_form$rand' id='optvalues_form$rand' action=\"".
               $CFG_GLPI["root_doc"]."/plugins/appliances/front/appliance.form.php\">";
      }

      echo "<div class='center'><table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='4'>".__('User fields', 'appliances')."</th></tr>\n";

      $query_app = "SELECT *
                    FROM `glpi_plugin_appliances_optvalues`
                    WHERE `plugin_appliances_appliances_id` = '".$appli->fields['id']."'
                    ORDER BY `vvalues`";

      $result_app    = $DB->query($query_app);
      $number_champs = $DB->numrows($result_app);
      $number_champs++;
      for ($i=1 ; $i <= $number_champs ; $i++) {
         if ($data = $DB->fetch_array($result_app)) {
            $champ    = $data["champ"];
            $ddefault = $data["ddefault"];
         } else {
            $champ    = '';
            $ddefault = '';
         }
         echo "<tr class='top tab_bg_1'>";

         if ($i == 1) {
            echo "<td rowspan='".$number_champs."'>"._n('Field', 'Fields', 1)."</td>";
         }
         echo "<td><input type='text' name='champ$i' value=\"".$champ."\" size='35'></td>\n";
         if ($i == 1) {
            echo "<td rowspan='".$number_champs."'>".__('Default', 'appliances')."</td>";
         }
         echo "<td><input type='text' name='ddefault$i' value=\"".$ddefault."\" size='35'></td></tr>\n";
      }

      if ($canedit) {
         echo "<tr class='tab_bg_2'><td colspan='4' class='center'>";
         echo "<input type='hidden' name='plugin_appliances_appliances_id' value='".
                $appli->fields['id']."'>\n";
         echo "<input type='hidden' name='number_champs' value='".$number_champs."'>\n";
         echo "<input type='submit' name='update_optvalues' value=\""._sx('button', 'Update')."\"
                class='submit'>";
         echo "</td></tr>\n</table></div>";
         Html::closeForm();
      } else {
         echo "</table></div>";
      }
      return true;
   }


   static function pdfForAppliance(PluginPdfSimplePDF $pdf, PluginAppliancesAppliance $appli) {
      global $DB;

      $pdf->setColumnsSize(100);
      $pdf->displayTitle('<b>'.__('User fields', 'appliances').'</b>');

      $query_app = "SELECT `champ`, `ddefault`
                    FROM `glpi_plugin_appliances_optvalues`
                    WHERE `plugin_appliances_appliances_id` = '".$appli->getID()."'
                    ORDER BY `vvalues`";
      $result_app = $DB->query($query_app);

      $opts = array();
      while ($data = $DB->fetch_array($result_app)) {
         $opts[] = '<b>'.$data["champ"].'</b>'.($data["ddefault"] ? '='.$data["ddefault"] : '');
      }
      if (count($opts)) {
         $pdf->displayLine(implode(',  ',$opts));
      } else {
         $pdf->displayLine(__('No item found'));
      }

      $pdf->displaySpace();
   }


   /**
    * Update the list of Optvalues defined for an appliance
    *
    * @param $input array of input data (form)
   **/
   function updateList($input) {
      global $DB;

      if (!isset($input['number_champs']) || !isset($input['plugin_appliances_appliances_id'])) {
         return false;
      }
      $number_champs = $input['number_champs'];

      for ($i=1 ; $i<=$number_champs ; $i++) {
         $champ    = "champ$i";
         $ddefault = "ddefault$i";

         $query_app = "SELECT `id`
                       FROM `glpi_plugin_appliances_optvalues`
                       WHERE `plugin_appliances_appliances_id`
                                 = '".$input['plugin_appliances_appliances_id']."'
                             AND `vvalues` = '".$i."'";
         $result_app = $DB->query($query_app);

         if ($data = $DB->fetch_array($result_app)) {
            // l'entrée existe déjà, il faut faire un update ou un delete
            if (empty($input[$champ])) {
               $this->delete($data);
            } else {
               $data['champ']    = $input[$champ];
               $data['ddefault'] = $input[$ddefault];
               $this->update($data);
            }

         } else if (!empty($input[$champ])) {
            // l'entrée n'existe pas
            // et la valeur saisie est non nulle -> on fait un insert
            $data = array('plugin_appliances_appliances_id' => $input['plugin_appliances_appliances_id'],
                          'champ'                           => $input[$champ],
                          'ddefault'                        => $input[$ddefault],
                          'vvalues'                         => $i);
            $this->add($data);
         }
      } // for
   }


   static function countForAppliance(PluginAppliancesAppliance $item) {

      return countElementsInTable('glpi_plugin_appliances_optvalues',
                                  "`plugin_appliances_appliances_id` = '".$item->getID()."'");
   }


   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {

      if ($item->getType()=='PluginAppliancesAppliance') {
         if ($_SESSION['glpishow_count_on_tabs']) {
            return self::createTabEntry(_n('Field', 'Fields', 2), self::countForAppliance($item));
         }
         return _n('Field', 'Fields', 2);
      }
      return '';
   }


   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      if ($item->getType()=='PluginAppliancesAppliance') {
         self::showForAppliance($item);
      }
      return true;
   }


   static function displayTabContentForPDF(PluginPdfSimplePDF $pdf, CommonGLPI $item, $tab) {

      if ($item->getType()=='PluginAppliancesAppliance') {
         self::pdfForAppliance($pdf, $item);

      } else {
         return false;
      }
      return true;
   }
}
