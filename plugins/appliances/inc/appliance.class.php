<?php
/*
 * @version $Id: appliance.class.php 217 2015-02-17 10:25:15Z tsmr $
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


class PluginAppliancesAppliance extends CommonDBTM {

   static $types = array('Computer', 'Monitor', 'NetworkEquipment', 'Peripheral', 'Phone',
                         'Printer', 'Software');

   public $dohistory = true;
   static $rightname = "plugin_appliances";


   static function getTypeName($nb=0) {

      if ($nb > 1) {
         return _n('Appliance', 'Appliances', 2, 'appliances');
      }
      return _n('Appliance', 'Appliances', 1, 'appliances');
   }

   /**
    * Retrieve an Appliance from the database using its externalid (unique index)
    *
    * @param $extid string externalid
    *
    * @return true if succeed else false
   **/
   function getFromDBbyExternalID($extid) {
      global $DB;

      $query = "SELECT *
                FROM `".$this->getTable()."`
                WHERE `externalid` = '".$extid."'";

      if ($result = $DB->query($query)) {
         if ($DB->numrows($result) != 1) {
            return false;
         }
         $this->fields = $DB->fetch_assoc($result);
         if (is_array($this->fields) && count($this->fields)) {
            return true;
         }
      }
      return false;
   }


   function getSearchOptions() {

      $tab = array();

      $tab['common']           = _n('Appliance', 'Appliances', 2, 'appliances');

      $tab[1]['table']         = 'glpi_plugin_appliances_appliances';
      $tab[1]['field']         = 'name';
      $tab[1]['name']          = __('Name');
      $tab[1]['datatype']      = 'itemlink';
      $tab[1]['itemlink_type'] = $this->getType();

      $tab[2]['table']        = 'glpi_plugin_appliances_appliancetypes';
      $tab[2]['field']        = 'name';
      $tab[2]['name']         = __('Type');

      $tab[32]['table']       = 'glpi_states';
      $tab[32]['field']       = 'completename';
      $tab[32]['name']        = _n('Status', 'Statuses', 1);
      $tab[32]['displaytype'] = 'dropdown';
      $tab[32]['checktype']   = 'text';
      $tab[32]['injectable']  = true;

      $tab += Location::getSearchOptionsToAdd();

      $tab[4]['table']        = 'glpi_plugin_appliances_appliances';
      $tab[4]['field']        =  'comment';
      $tab[4]['name']         =  __('Comments');
      $tab[4]['datatype']     =  'text';

      $tab[5]['table']         = 'glpi_plugin_appliances_appliances_items';
      $tab[5]['field']         = 'items_id';
      $tab[5]['name']          = __('Associated items', 'appliances');
      $tab[5]['massiveaction'] = false;
      $tab[5]['forcegroupby']  =  true;
      $tab[5]['joinparams']    = array('jointype' => 'child');

      $tab[6]['table']        = 'glpi_users';
      $tab[6]['field']        = 'name';
      $tab[6]['name']         = __('User');

      $tab[8]['table']        = 'glpi_groups';
      $tab[8]['field']        = 'completename';
      $tab[8]['name']         = __('Group');
      $tab[8]['condition']    = '`is_itemgroup`';

      $tab[24]['table']       = 'glpi_users';
      $tab[24]['field']       = 'name';
      $tab[24]['linkfield']   = 'users_id_tech';
      $tab[24]['name']        = __('Technician in charge of the hardware');

      $tab[49]['table']       = 'glpi_groups';
      $tab[49]['field']       = 'completename';
      $tab[49]['linkfield']   = 'groups_id_tech';
      $tab[49]['name']        = __('Group in charge of the hardware');
      $tab[49]['condition']   = '`is_assign`';

      $tab[9]['table']         = 'glpi_plugin_appliances_appliances';
      $tab[9]['field']         = 'date_mod';
      $tab[9]['name']          = __('Last update');
      $tab[9]['massiveaction'] = false;
      $tab[9]['datatype']      = 'datetime';

      $tab[10]['table']       = 'glpi_plugin_appliances_environments';
      $tab[10]['field']       = 'name';
      $tab[10]['name']        = __('Environment', 'appliances');

      $tab[11]['table']       = 'glpi_plugin_appliances_appliances';
      $tab[11]['field']       = 'is_helpdesk_visible';
      $tab[11]['name']        = __('Associable to a ticket');
      $tab[11]['datatype']    = 'bool';

      $tab[12]['table']       = 'glpi_plugin_appliances_appliances';
      $tab[12]['field']       = 'serial';
      $tab[12]['name']        = __('Serial number');

      $tab[13]['table']       = 'glpi_plugin_appliances_appliances';
      $tab[13]['field']       = 'otherserial';
      $tab[13]['name']        = __('Inventory number');

      $tab[31]['table']       = 'glpi_plugin_appliances_appliances';
      $tab[31]['field']        = 'id';
      $tab[31]['name']         = __('ID');
      $tab[31]['massiveaction'] = false;

      $tab[80]['table']       = 'glpi_entities';
      $tab[80]['field']       = 'completename';
      $tab[80]['name']        = __('Entity');

      $tab[7]['table']         = 'glpi_plugin_appliances_appliances';
      $tab[7]['field']         = 'is_recursive';
      $tab[7]['name']          = __('Child entities');
      $tab[7]['massiveaction'] = false;
      $tab[7]['datatype']      = 'bool';

      return $tab;
   }


   function cleanDBonPurge() {

      $temp = new PluginAppliancesAppliance_Item();
      $temp->deleteByCriteria(array('plugin_appliances_appliances_id' => $this->fields['id']));

      $temp = new PluginAppliancesOptvalue();
      $temp->deleteByCriteria(array('plugin_appliances_appliances_id' => $this->fields['id']));
   }


   function defineTabs($options=array()) {

      $ong = array();
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('PluginAppliancesAppliance_Item', $ong, $options);
      $this->addStandardTab('PluginAppliancesOptvalue', $ong, $options);
      $this->addStandardTab('Ticket', $ong, $options);
      $this->addStandardTab('Item_Problem', $ong, $options);
      $this->addStandardTab('Infocom', $ong, $options);
      $this->addStandardTab('Contract_Item', $ong, $options);
      $this->addStandardTab('Document_Item', $ong, $options);
      $this->addStandardTab('Notepad', $ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }


   /**
    * Return the SQL command to retrieve linked object
    *
    * @return a SQL command which return a set of (itemtype, items_id)
   **/
   function getSelectLinkedItem() {

      return "SELECT `itemtype`, `items_id`
              FROM `glpi_plugin_appliances_appliances_items`
              WHERE `plugin_appliances_appliances_id` = '" . $this->fields['id']."'";
   }


   function showForm ($ID, $options=array()) {
      global $CFG_GLPI;

      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      $canedit = $this->can($ID, UPDATE);

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Name')."</td><td>";
      Html::autocompletionTextField($this, "name", array('size' => 34));
      echo "</td><td>"._n('Status', 'Statuses', 1)."</td><td>";
      State::dropdown(array('value' => $this->fields["states_id"]));
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Location')."</td><td>";
      if ($canedit) {
         Location::dropdown(array('value'  => $this->fields["locations_id"],
                                  'entity' => $this->fields["entities_id"]));
      } else {
         echo Dropdown::getDropdownName("glpi_locations",$this->fields["locations_id"]);
      }
      echo "</td><td>".__('Type')."</td><td>";
      Dropdown::show('PluginAppliancesApplianceType',
                      array('value'  => $this->fields["plugin_appliances_appliancetypes_id"],
                            'entity' => $this->fields["entities_id"]));
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Technician in charge of the hardware')."</td><td>";
      if ($canedit) {
         User::dropdown(array('name'   => 'users_id_tech',
                              'value'  => $this->fields['users_id_tech'],
                              'right'  => 'own_ticket',
                              'entity' => $this->fields['entities_id']));
      } else {
         echo getUsername($this->fields['users_id_tech']);
      }
      echo "</td><td>".__('Environment', 'appliances')."</td><td>";
      Dropdown::show('PluginAppliancesEnvironment',
                     array('value' => $this->fields["plugin_appliances_environments_id"]));
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Group in charge of the hardware')."</td><td>";
      if ($canedit) {
         Group::dropdown(array('name'      => 'groups_id_tech',
                               'value'     => $this->fields['groups_id_tech'],
                               'entity'    => $this->fields['entities_id'],
                               'condition' => '`is_assign`'));
      } else {
         echo Dropdown::getDropdownName("glpi_groups", $this->fields["groups_id"]);
      }
      echo "</td><td>".__('Serial number')."</td><td>";
      Html::autocompletionTextField($this,'serial');
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('User')."</td>";
      echo "<td>";
      User::dropdown(array('value'  => $this->fields["users_id"],
                           'entity' => $this->fields["entities_id"],
                           'right'  => 'all'));
      echo "</td><td>".__('Inventory number')."</td><td>";
      Html::autocompletionTextField($this,'otherserial');
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Group')."</td>";
      echo "<td>";
      Group::dropdown(array('value'     => $this->fields["groups_id"],
                            'entity'    => $this->fields["entities_id"],
                            'condition' => '`is_itemgroup`'));
      echo "</td>";
      echo "<td rowspan='4'>".__('Comments')."</td>";
      echo "<td rowspan='4' class='middle'>";
      echo "<textarea cols='45' rows='5' name='comment' >".$this->fields["comment"]."</textarea>";
      echo "</td></tr>";


      echo "<tr class='tab_bg_1'>";
      echo "<td>".__('Associable to a ticket')."</td><td>";
      Dropdown::showYesNo('is_helpdesk_visible',$this->fields['is_helpdesk_visible']);
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      // dropdown relationtype added
      echo "<td>".__('Item to link', 'appliances')."</td><td>";
      if ($canedit
          && !($ID
               && countElementsInTable(array("glpi_plugin_appliances_relations",
                                             "glpi_plugin_appliances_appliances_items"),
                                       "glpi_plugin_appliances_relations.plugin_appliances_appliances_items_id
                                          = glpi_plugin_appliances_appliances_items.id
                                        AND glpi_plugin_appliances_appliances_items.plugin_appliances_appliances_id
                                          = $ID"))) {
         PluginAppliancesRelation::dropdownType("relationtype", $this->fields["relationtype"]);
      } else {
         echo PluginAppliancesRelation::getTypeName($this->fields["relationtype"]);
         $rand    = mt_rand();
         $comment = __('Flag change forbidden. Linked items found.');
         $image   = "/pics/lock.png";
         echo "&nbsp;<img alt='' src='".$CFG_GLPI["root_doc"].$image.
               "' onmouseout=\"cleanhide('comment_relationtypes$rand')\" ".
               " onmouseover=\"cleandisplay('comment_relationtypes$rand')\">";
         echo "<span class='over_link' id='comment_relationtypes$rand'>$comment</span>";
      }
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='2' class='center'>".sprintf(__('%1$s: %2$s'), __('Last update'),
                                                     Html::convDateTime($this->fields["date_mod"]));
      echo "</td></tr>";

      $this->showFormButtons($options);

      return true;
   }


   /**
    * Show for PDF the current applicatif
    *
    * @param $pdf object for the output
   **/
   function show_PDF ($pdf) {
      global $DB;

      $pdf->setColumnsSize(50,50);
      $col1 = '<b>'.sprintf(__('%1$s %2$s'), __('ID'), $this->fields['id']).'</b>';
      if (isset($this->fields["date_mod"])) {
         $col2 = sprintf(__('%1$s: %2$s'), __('Last update'),
                         Html::convDateTime($this->fields["date_mod"]));
      } else {
         $col2 = '';
      }
      $pdf->displayTitle($col1, $col2);

      $pdf->displayLine(sprintf(__('%1$s: %2$s'), '<b><i>'.__('Name').'</i></b>',
                                $this->fields['name']),
                        sprintf(__('%1$s: %2$s'), '<b><i>'.-n('Status', 'Statuses', 1).'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_states',
                                                                      $this->fields['states_id']))));

      $pdf->displayLine(sprintf(__('%1$s: %2$s'), '<b><i>'.__('Location').'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_locations',
                                                                      $this->fields['locations_id']))),
                        sprintf(__('%1$s: %2$s'), '<b><i>'.__('Type').'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_plugin_appliances_appliancetypes',
                                                                      $this->fields['plugin_appliances_appliancetypes_id']))));

      $pdf->displayLine(sprintf(__('%1$s: %2$s'),
                                '<b><i>'.__('Technician in charge of the hardware').'</i></b>',
                                getUserName($this->fields['users_id_tech'])),
                        sprintf(__('%1$s: %2$s'),
                                '<b><i>'.__('Environment', 'appliances').'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_plugin_appliances_environments',
                                                                      $this->fields['plugin_appliances_environments_id']))));

      $pdf->displayLine(sprintf(__('%1$s: %2$s'),
                                '<b><i>'.__('Group in charge of the hardware').'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_groups',
                                                                      $this->fields['groups_id_tech']))),
                        sprintf(__('%1$s: %2$s'), '<b><i>'.__('Serial number').'</i></b>',
                                $this->fields['serial']));

      $pdf->displayLine(sprintf(__('%1$s: %2$s'), '<b><i>'.__('User').'</i></b>',
                                getUserName($this->fields['users_id'])),
                        sprintf(__('%1$s: %2$s'),
                                '<b><i>'.__('Inventory number').'</i></b>',
                                $this->fields['otherserial']));

      $pdf->displayLine(sprintf(__('%1$s: %2$s'), '<b><i>'.__('Group').'</i></b>',
                                Html::clean(Dropdown::getDropdownName('glpi_groups',
                                                                      $this->fields['groups_id']))),
                        '');

      $pdf->displayLine(sprintf(__('%1$s: %2$s'), '<b><i>'.__('Associable to a ticket').'</i></b>',
                                Dropdown::getYesNo($this->fields['is_helpdesk_visible'])),
                        sprintf(__('%1$s: %2$s'),'<b><i>'.__('Item to link').'</i></b>',
                                Html::clean(PluginAppliancesRelation::getTypeName($this->fields['relationtype']))));

      $pdf->displayText(sprintf(__('%1$s: %2$s'), '<b><i>'.__('Comments').'</i></b>',
                                $this->fields['comment']));

      $pdf->displaySpace();
   }


   /**
    * Diplay a dropdown to select an Appliance
    *
    * Parameters which could be used in options array :
    *    - name : string / name of the select (default is plugin_appliances_appliances_id)
    *    - entity : integer or array / restrict to a defined entity or array of entities
    *                   (default '' : current entity)
    *    - used : array / Already used items ID: not to display in dropdown (default empty)
    *
    * @param $options possible options
    *
    * @return nothing (HTML display)
   **/
   static function dropdown($options=array()) {
      global $DB, $CFG_GLPI;


      $p['name']    = 'plugin_appliances_appliances_id';
      $p['entity']  = '';
      $p['used']    = array();
      $p['display'] = true;

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      $where = " WHERE `glpi_plugin_appliances_appliances`.`is_deleted` = '0' ".
                       getEntitiesRestrictRequest("AND", "glpi_plugin_appliances_appliances", '', $p['entity'], true);

      $p['used'] = array_filter($p['used']);
      if (count($p['used'])) {
         $where .= " AND `id` NOT IN (0, ".implode(",",$p['used']).")";
      }

      $query = "SELECT *
                FROM `glpi_plugin_appliances_appliancetypes`
                WHERE `id` IN (SELECT DISTINCT `plugin_appliances_appliancetypes_id`
                               FROM `glpi_plugin_appliances_appliances`
                             $where)
                ORDER BY `name`";
      $result = $DB->query($query);

      $values = array(0 => Dropdown::EMPTY_VALUE);

      while ($data = $DB->fetch_assoc($result)) {
         $values[$data['id']] = $data['name'];
      }
      $rand = mt_rand();
      $out  = Dropdown::showFromArray('_appliancetype', $values, array('width'   => '30%',
                                                                     'rand'    => $rand,
                                                                     'display' => false));
      $field_id = Html::cleanId("dropdown__appliancetype$rand");

      $params   = array('appliancetype' => '__VALUE__',
                        'entity' => $p['entity'],
                        'rand'   => $rand,
                        'myname' => $p['name'],
                        'used'   => $p['used']);

      $out .= Ajax::updateItemOnSelectEvent($field_id,"show_".$p['name'].$rand,
                                            $CFG_GLPI["root_doc"]."/plugins/appliances/ajax/dropdownTypeAppliances.php",
                                            $params, false);
      $out .= "<span id='show_".$p['name']."$rand'>";
      $out .= "</span>\n";

      $params['appliancetype'] = 0;
      $out .= Ajax::updateItem("show_".$p['name'].$rand,
                               $CFG_GLPI["root_doc"]. "/plugins/appliances/ajax/dropdownTypeAppliances.php",
                               $params, false);
      if ($p['display']) {
         echo $out;
         return $rand;
      }
      return $out;
   }


   /**
    * For other plugins, add a type to the linkable types
    *
    * @since version 1.8.0
    *
    * @param $type string class name
   **/
   static function registerType($type) {

      if (!in_array($type, self::$types)) {
         self::$types[] = $type;
      }
   }


   /**
    * Type than could be linked to a Appliance
    *
    * @param $all boolean, all type, or only allowed ones (false by default)
    *
    * @return array of types
   **/
   static function getTypes($all=false) {

      if ($all) {
         return self::$types;
      }

      // Only allowed types
      $types = self::$types;

      foreach ($types as $key => $type) {
         if (!($item = getItemForItemtype($type))) {
            continue;
         }

         if (!$item->canView()) {
            unset($types[$key]);
         }
      }
      return $types;
   }


   /**
    * @param $params
    * @param $protocol
   **/
   static function methodTestAppliance($params, $protocol) {
      global $PLUGIN_HOOKS;

      if (isset ($params['help'])) {
         return array('help' => 'bool,optional');
      }

      $resp = array('glpi' => GLPI_VERSION);

      $plugin = new Plugin();
      foreach ($PLUGIN_HOOKS['webservices'] as $name => $fct) {
         if ($plugin->getFromDBbyDir($name)) {
            $resp[$name] = $plugin->fields['version'];
         }
      }

      return $resp;
   }


   /**
    * @param $params
    * @param $protocol
   **/
   static function methodListAppliances($params, $protocol) {
      global $DB, $CFG_GLPI;

      // TODO add some search options (name, type, ...)

      if (isset ($params['help'])) {
         return array(  'help'      => 'bool,optional',
                        'id2name'   => 'bool,optional',
                        'count'     => 'bool,optional',
                        'start'     => 'integer,optional',
                        'limit'     => 'integer,optional' );
      }

      if (!Session::getLoginUserID()) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTAUTHENTICATED);
      }

      $resp  = array ();
      $start = 0;
      if (isset ($params['start']) && is_numeric($params['start'])) {
         $start = $params['start'];
      }

      $limit = $CFG_GLPI["list_limit_max"];
      if (isset ($params['limit']) && is_numeric($params['limit'])) {
         $limit = $params['limit'];
      }

      $orders = array();
      if (isset ($params['order'])) {
         if (is_array($params['order'])) {
            $tab = $params['order'];
         } else {
            $tab = array($params['order']=>'DESC');
         }

         foreach ($tab as $key => $val) {
            if ($val != 'ASC') {
               $val = 'DESC';
            }

            //TODO A revoir
            if (in_array($key, array('date_mod', 'entities_id', 'externalid', 'groups_id', 'id',
                                     'name', 'users_id'))) {
               $orders[] ="`$key` $val";
            } else {
               return PluginWebservicesMethodCommon::Error($protocol,
                                                           WEBSERVICES_ERROR_BADPARAMETER, '',
                                                           'order=$key');
            }
         }
      }

      if (count($orders)) {
         $order = implode(',',$orders);
      } else {
         $order = "`name` DESC";
      }

      $where = getEntitiesRestrictRequest(' WHERE', 'glpi_plugin_appliances_appliances');

      if (isset ($params['count'])) {
         $query = "SELECT COUNT(DISTINCT `id`) AS count
                   FROM `glpi_plugin_appliances_appliances` ".
                   $where;

         foreach ($DB->request($query) as $data) {
            $resp = $data;
         }

      } else {
         $where = "";
         if (isset ($params['id2name'])) {
            // TODO : users_name and groups_name ?
            $query = "SELECT `glpi_plugin_appliances_appliances`.*,
                             `glpi_plugin_appliances_appliancetypes`.`name`
                                    AS plugin_appliances_appliancetypes_name,
                             `glpi_plugin_appliances_environments`.`name`
                                    AS plugin_appliances_environments_name
                      FROM `glpi_plugin_appliances_appliances`
                      LEFT JOIN `glpi_plugin_appliances_appliancetypes`
                        ON `glpi_plugin_appliances_appliancetypes`.`id`
                           =`glpi_plugin_appliances_appliances`.`plugin_appliances_appliancetypes_id`
                      LEFT JOIN `glpi_plugin_appliances_environments`
                        ON `glpi_plugin_appliances_environments`.`id`
                           =`glpi_plugin_appliances_appliances`.`plugin_appliances_environments_id`
                      ORDER BY ".$order."
                      LIMIT ".$start.", ".$limit;

         } else {
            // TODO review list of fields (should probably be minimal, or configurable)
            $query = "SELECT `glpi_plugin_appliances_appliances`.*
                      FROM `glpi_plugin_appliances_appliances`
                      ORDER BY ".$order."
                      LIMIT ".$start.", ".$limit;
         }

         foreach ($DB->request($query) as $data) {
            $resp[] = $data;
         }
      }
      return $resp;
   }


   static function methodDeleteAppliance($params, $protocol) {
      global $DB;

      if (isset ($params['help'])) {
         return array('help'  => 'bool,optional',
                      'force' => 'boolean,optional',
                      'id'    => 'string' );
      }

      if (!Session::getLoginUserID()) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTAUTHENTICATED);
      }

      if (!isset ($params['id'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_MISSINGPARAMETER);
      }

      $force = 0;
      if (isset($params['force'])){
         $force = 1;
      }

      $id        = $params['id'];
      $appliance = new self();
      if (!$appliance->can($id, 'd')) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTALLOWED);
      }

      if (!$appliance->delete(array("id" => $id),$force)) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_FAILED);
      }

      return array("id" => $id);
   }


   static function methodUpdateAppliance($params, $protocol) {
      global $DB;

      // TODO : add more fields + factorize field translation with methodAddAppliance

      if (isset ($params['help'])) {
         return array('help'                                  => 'bool,optional',
                      'is_helpdesk_visible'                   => 'bool,optional',
                      'is_recursive'                          => 'bool,optional',
                      'name'                                  => 'string,optional',
                      'plugin_appliances_appliancetypes_id'   => 'integer,optional',
                      'plugin_appliances_appliancetypes_name' => 'string,optional',
                      'externalid'                            => 'string,optional',
                      'id'                                    => 'string');
      }

      if (!Session::getLoginUserID()) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTAUTHENTICATED);
      }

      if (!isset($params['id']) || !is_numeric($params['id'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_MISSINGPARAMETER);
      }

      if (isset($params['is_helpdesk_visible']) && !is_numeric($params['is_helpdesk_visible'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_BADPARAMETER, '',
                                                     'is_helpdesk_visible');
      }

      if (isset($params['is_recursive']) && !is_numeric($params['is_recursive'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_BADPARAMETER, '',
                                                     'is_recursive');
      }

      $id        = intval($params['id']);
      $appliance = new self();
      if (!$appliance->can($id, UPDATE)) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTALLOWED);
      }

      $input = array('id' => $id);
      if (isset($params['name'])) {
         $input['name'] = addslashes($params['name']);
      }

      if (isset($params['externalid'])) {
         if (empty($params['externalid'])) {
            $input['externalid'] = 'NULL';
         } else {
            $input['externalid'] = addslashes($params['externalid']);
         }
      }

      // Old field name for compatibility
      if (isset($params['notes'])) {
         $input['notepad'] = addslashes($params['notes']);
      }
      foreach (array('comment', 'notepad', 'serial', 'otherserial') as $field) {
         if (isset($params[$field])) {
            $input[$field] = addslashes($params[$field]);
         }
      }

      if (isset($params['is_helpdesk_visible'])) {
         $input['is_helpdesk_visible'] = ($params['is_helpdesk_visible'] ? 1 : 0);
      }

      if (isset($params['is_recursive'])) {
         $input['is_recursive'] = ($params['is_recursive'] ? 1 : 0);
      }

      if (isset($params['plugin_appliances_appliancetypes_name'])) {
         $type   = new PluginAppliancesApplianceType();
         $input2 = array();
         $input2['entities_id']  = (isset($input['entities_id'])? $input['entities_id']
                                                                : $appliance->fields['entities_id']);
         $input2['is_recursive'] = (isset($input['is_recursive'])? $input['is_recursive']
                                                                 : $appliance->fields['entities_id']);
         $input2['name']         = addslashes($params['plugin_appliances_appliancetypes_name']);
         $input['plugin_appliances_appliancetypes_id'] = $type->import($input2);

      } else if (isset($params['plugin_appliances_appliancetypes_id'])) {
         $input['plugin_appliances_appliancetypes_id']
                     = intval($params['plugin_appliances_appliancetypes_id']);
      }

      if ($appliance->update($input)) {
         // Does not detect unicity error on externalid :(
         return $appliance->methodGetAppliance(array('id' => $id), $protocol);
      }

      return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_FAILED);
   }


   static function methodAddAppliance($params, $protocol) {
      global $DB;

      // TODO : add more fields
      if (isset ($params['help'])) {
         return array('help'                                  => 'bool,optional',
                      'name'                                  => 'string',
                      'entities_id'                           => 'integer,optional',
                      'is_helpdesk_visible'                   => 'bool,optional',
                      'is_recursive'                          => 'bool,optional',
                      'comment'                               => 'string,optional',
                      'externalid'                            => 'string,optional',
                      'plugin_appliances_appliancetypes_id'   => 'integer,optional',
                      'plugin_appliances_appliancetypes_name' => 'string,optional');
      }

      if (!Session::getLoginUserID()) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTAUTHENTICATED);
      }

      if (!isset($params['name'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_MISSINGPARAMETER);
      }

      if (isset($params['is_helpdesk_visible']) && !is_numeric($params['is_helpdesk_visible'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_BADPARAMETER, '',
                                                     'is_helpdesk_visible');
      }

      if (isset($params['is_recursive']) && !is_numeric($params['is_recursive'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_BADPARAMETER, '',
                                                     'is_recursive');
      }
      $input = array();
      $input['name'] = addslashes($params['name']);

      if (isset($params['entities_id'])) {
         $input['entities_id'] = intval($params['entities_id']);
      } else {
         $input['entities_id'] = $_SESSION["glpiactive_entity"];
      }

      if (isset($params['is_recursive'])) {
         // TODO check if canUnrecurs
         $input['is_recursive'] = ($params['is_recursive'] ? 1 : 0);
      }

      if (isset($params['externalid']) && !empty($params['externalid'])) {
         $input['externalid'] = addslashes($params['externalid']);
      }

      if (isset($params['plugin_appliances_appliancetypes_name'])) {
         $type   = new PluginAppliancesApplianceType();
         $input2 = array();
         $input2['entities_id']  = $input['entities_id'];
         $input2['is_recursive'] = $input['is_recursive'];
         $input2['name']         = addslashes($params['plugin_appliances_appliancetypes_name']);
         $input['plugin_appliances_appliancetypes_id'] = $type->import($input2);

      } else if (isset($params['plugin_appliances_appliancetypes_id'])) {
         // TODO check if this id exists and is readable and is available in appliance entity
         $input['plugin_appliances_appliancetypes_id']
                  = intval($params['plugin_appliances_appliancetypes_id']);
      }

      if (isset($params['is_helpdesk_visible'])) {
         $input['is_helpdesk_visible'] = ($params['is_helpdesk_visible'] ? 1 : 0);
      }

      // Old field name for compatibility
      if (isset($params['notes'])) {
         $input['notepad'] = addslashes($params['notes']);
      }
      foreach (array('comment', 'notepad', 'serial', 'otherserial') as $field) {
         if (isset($params[$field])) {
            $input[$field] = addslashes($params[$field]);
         }
      }

      $appliance = new self();
      if (!$appliance->can(-1, UPDATE, $input)) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTALLOWED);
      }

      $id = $appliance->add($input);
      if ($id) {
         // Return the newly created object
         return $appliance->methodGetAppliance(array('id'=>$id), $protocol);
      }

      return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_FAILED);
   }


   static function methodGetAppliance($params, $protocol) {
      global $DB;

      if (isset ($params['help'])) {
         return array(  'help'               => 'bool,optional',
                        'id2name'            => 'bool,optional',
                        'externalid OR id'   => 'string' );
      }

      if (!Session::getLoginUserID()) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTAUTHENTICATED);
      }

      if (!isset($params['externalid']) && !isset($params['id'])) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_MISSINGPARAMETER);
      }

      $appli = new self();
      $found = false;

      if (isset($params['id'])) {
         $found = $appli->getFromDB(intval($params['id']));

      } else if (isset($params['externalid'])){
         $found = $appli->getFromDBbyExternalID(addslashes($params["externalid"]));
      }

      if (!$found || !$appli->can($appli->fields["id"],READ)) {
         return PluginWebservicesMethodCommon::Error($protocol, WEBSERVICES_ERROR_NOTFOUND);
      }
      $resp = $appli->fields;

      if (isset($params['id2name'])) {
         $resp['plugin_appliances_appliancetypes_name']
            = Html::clean(Dropdown::getDropdownName('glpi_plugin_appliances_appliancetypes',
                                                    $resp['plugin_appliances_appliancetypes_id']));
         $resp['plugin_appliances_environments_name']
            = Html::clean(Dropdown::getDropdownName('glpi_plugin_appliances_environments',
                                                    $resp['plugin_appliances_environments_id']));
         $resp['users_name']
            = Html::clean(Dropdown::getDropdownName('glpi_users', $resp['users_id']));
         $resp['groups_name']
            = Html::clean(Dropdown::getDropdownName('glpi_groups', $resp['groups_id']));
      }
      return $resp;
   }


   static function updateSchema(Migration $migration) {
      global $DB;

      $migration->displayTitle(sprintf(__('%1$s: %2$s'), __('Update'), self::getTypeName(9)));
      $table = getTableForItemType(__CLASS__);

      // Version 1.6.1
      $migration->changeField($table, 'notes', 'notepad', 'text');

      // Version 1.8.0
      $migration->addKey($table, 'users_id');
      $migration->addKey($table, 'groups_id');
      $migration->addKey($table, 'plugin_appliances_appliancetypes_id');
      $migration->addKey($table, 'plugin_appliances_environments_id');

      $migration->addField($table, 'states_id', 'integer', array('after' => 'date_mod'));
      $migration->addKey($table, 'states_id');

      $migration->addField($table, 'users_id_tech', 'integer', array('after' => 'users_id'));
      $migration->addKey($table, 'users_id_tech');

      $migration->addField($table, 'groups_id_tech', 'integer', array('after' => 'groups_id'));
      $migration->addKey($table, 'groups_id_tech');

      if (TableExists("glpi_plugin_appliances_profiles")) {

         $notepad_tables = array('glpi_plugin_appliances_appliances');

         foreach ($notepad_tables as $t) {
            // Migrate data
            if (FieldExists($t, 'notepad')) {
               $query = "SELECT id, notepad
                         FROM `$t`
                         WHERE notepad IS NOT NULL
                               AND notepad <>'';";
               foreach ($DB->request($query) as $data) {
                  $iq = "INSERT INTO `glpi_notepads`
                                (`itemtype`, `items_id`, `content`, `date`, `date_mod`)
                         VALUES ('".getItemTypeForTable($t)."', '".$data['id']."',
                                 '".addslashes($data['notepad'])."', NOW(), NOW())";
                  $DB->queryOrDie($iq, "0.85 migrate notepad data");
               }
               $query = "ALTER TABLE `glpi_plugin_appliances_appliances` DROP COLUMN `notepad`;";
               $DB->query($query);
            }
         }
      }
   }

   /**
    * @since version 0.85
    *
    * @see CommonDBTM::getSpecificMassiveActions()
   **/
   function getSpecificMassiveActions($checkitem=NULL) {
      $isadmin = static::canUpdate();
      $actions = parent::getSpecificMassiveActions($checkitem);

      if ($_SESSION['glpiactiveprofile']['interface'] == 'central') {
         if ($isadmin) {
            $actions['PluginAppliancesAppliance'.MassiveAction::CLASS_ACTION_SEPARATOR.'install']    = _x('button', 'Associate');
            $actions['PluginAppliancesAppliance'.MassiveAction::CLASS_ACTION_SEPARATOR.'uninstall'] = _x('button', 'Dissociate');

            if (Session::haveRight('transfer', READ)
                     && Session::isMultiEntitiesMode()
            ) {
               $actions['PluginAppliancesAppliance'.MassiveAction::CLASS_ACTION_SEPARATOR.'transfer'] = __('Transfer');
            }
         }
      }
      return $actions;
   }

   /**
    * @since version 0.85
    *
    * @see CommonDBTM::showMassiveActionsSubForm()
   **/
   static function showMassiveActionsSubForm(MassiveAction $ma) {

      switch ($ma->getAction()) {
         case 'plugin_appliances_add_item':
            self::dropdown(array());
            echo "&nbsp;".
                 Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "install" :
            Dropdown::showAllItems("item_item", 0, 0, -1, self::getTypes(true),
                                   false, false, 'typeitem');
            echo Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "uninstall" :
            Dropdown::showAllItems("item_item", 0, 0, -1, self::getTypes(true),
                                   false, false, 'typeitem');
            echo Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
         case "transfer" :
            Dropdown::show('Entity');
            echo Html::submit(_x('button','Post'), array('name' => 'massiveaction'));
            return true;
            break;
    }
      return parent::showMassiveActionsSubForm($ma);
   }


   /**
    * @since version 0.85
    *
    * @see CommonDBTM::processMassiveActionsForOneItemtype()
   **/
   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item,
                                                       array $ids) {
      global $DB;

      $appliance_item = new PluginAppliancesAppliance_Item();

      switch ($ma->getAction()) {
         case "plugin_appliances_add_item":
            $input = $ma->getInput();
            foreach ($ids as $id) {
               $input = array('plugin_appliances_appliancetypes_id' => $input['plugin_appliances_appliancetypes_id'],
                                 'items_id'      => $id,
                                 'itemtype'      => $item->getType());
               if ($appliance_item->can(-1,UPDATE,$input)) {
                  if ($appliance_item->add($input)) {
                     $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $ids, MassiveAction::ACTION_KO);
                  }
               } else {
                  $ma->itemDone($item->getType(), $ids, MassiveAction::ACTION_KO);
               }
            }

            return;
         case "transfer" :
            $input = $ma->getInput();
            if ($item->getType() == 'PluginAppliancesAppliance') {
            foreach ($ids as $key) {
                  $item->getFromDB($key);
                  $type = PluginAppliancesApplianceType::transfer($item->fields["plugin_appliances_appliancetypes_id"], $input['entities_id']);
                  if ($type > 0) {
                     $values["id"] = $key;
                     $values["plugin_appliances_appliancetypes_id"] = $type;
                     $item->update($values);
                  }

                  unset($values);
                  $values["id"] = $key;
                  $values["entities_id"] = $input['entities_id'];

                  if ($item->update($values)) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               }
            }
            return;

         case 'install' :
            $input = $ma->getInput();
            foreach ($ids as $key) {
               if ($item->can($key, UPDATE)) {
                  $values = array('plugin_appliances_appliances_id' => $key,
                                 'items_id'      => $input["item_item"],
                                 'itemtype'      => $input['typeitem']);
                  if ($appliance_item->add($values)) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               } else {
                  $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_NORIGHT);
                  $ma->addMessage($item->getErrorMessage(ERROR_RIGHT));
               }
            }
            return;

         case 'uninstall':
            $input = $ma->getInput();
            foreach ($ids as $key) {
               if ($val == 1) {
                  if ($appliance_item->deleteItemByAppliancesAndItem($key,$input['item_item'],$input['typeitem'])) {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $key, MassiveAction::ACTION_KO);
                  }
               }
            }
            return;
      }
      parent::processMassiveActionsForOneItemtype($ma, $item, $ids);
   }
}
?>