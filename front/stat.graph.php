<?php
/**
 * ---------------------------------------------------------------------
 * GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2015-2021 Teclib' and contributors.
 *
 * http://glpi-project.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * GLPI is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GLPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

include ('../inc/includes.php');

Html::header(__('Statistics'), $_SERVER['PHP_SELF'], "helpdesk", "stat");

Session::checkRight("statistic", READ);

// init variables && filter data
$dateRegex     = ['options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']];
$itemtypeRegex = ['options' => ['regexp' => '/^(Ticket|Problem|Change)$/']];
$typeRegex     = ['options' => ['regexp' => '/^\w+$/']];
$idRegex       = ['options' => ['regexp' => '/^\d+$/']];
$year          = date('Y') - 1;

$date1     = filter_input(INPUT_GET, 'date1', FILTER_VALIDATE_REGEXP, $dateRegex);
$date2     = filter_input(INPUT_GET, 'date2', FILTER_VALIDATE_REGEXP, $dateRegex);
$itemtype  = filter_input(INPUT_GET, 'itemtype', FILTER_VALIDATE_REGEXP, $itemtypeRegex);
$type      = filter_input(INPUT_GET, 'type', FILTER_VALIDATE_REGEXP, $typeRegex);
$id        = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_REGEXP, $idRegex);
$champ     = filter_input(INPUT_GET, 'champ', FILTER_VALIDATE_REGEXP, $idRegex);

if (is_null($itemtype) || !$itemtype) {
   exit;
}
if (is_null($type) || !$type) {
   exit;
}
if (is_null($id) || !$id) {
   exit;
}

if (is_null($date1) || !$date1) {
   $date1 = date("Y-m-d", mktime(1, 0, 0, (int)date("m"), (int)date("d"), $year));
}

if (is_null($date2) || !$date2) {
   $date2 = date("Y-m-d");
}

if (strcmp($date2, $date1) < 0) {
   $tmp   = $date1;
   $date1 = $date2;
   $date2 = $tmp;
}

if (!getItemForItemtype($itemtype)) {
   exit;
}

$item = new $itemtype();

$cleantarget = preg_replace("/[&]date[12]=[0-9-]*/", "", $_SERVER['QUERY_STRING']);
$cleantarget = preg_replace("/[&]*id=([0-9]+[&]{0,1})/", "", $cleantarget);
$cleantarget = preg_replace("/&/", "&amp;", $cleantarget);

$next    = 0;
$prev    = 0;
$title   = '';
$parent  = 0;

$showuserlink = 0;
if (Session::haveRight('user', READ)) {
   $showuserlink = 1;
}

switch ($type) {
   case "technicien" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Technician'),
                        $item->getAssignName($id, 'User', $showuserlink));
      break;

   case "technicien_followup" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Technician'),
                        $item->getAssignName($id, 'User', $showuserlink));
      break;

   case "suppliers_id_assign" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), Supplier::getTypeName(1),
                        $item->getAssignName($id, 'Supplier', $showuserlink));
      break;

   case "user" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), User::getTypeName(1), getUserName($id, $showuserlink));
      break;

   case "users_id_recipient" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), User::getTypeName(1), getUserName($id, $showuserlink));
      break;

   case "itilcategories_tree" :
      if (!is_null($champ) && $champ) {
         $parent = $champ;
      }
      // nobreak;

   case "itilcategories_id" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type, $parent);
      $title   = sprintf(__('%1$s: %2$s'), __('Category'),
                        Dropdown::getDropdownName("glpi_itilcategories", $id));
      break;

   case 'locations_tree' :
      if (!is_null($champ) && $champ) {
         $parent = $champ;
      }
      // nobreak;

   case 'locations_id' :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type, $parent);
      $title   = sprintf(__('%1$s: %2$s'), Location::getTypeName(1),
                        Dropdown::getDropdownName('glpi_locations', $id));
      break;

   case "type" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), _n('Type', 'Types', 1), Ticket::getTicketTypeName($id));
      break;

   case 'group_tree' :
   case 'groups_tree_assign' :
      if (!is_null($champ) && $champ) {
         $parent = $champ;
      }
      // nobreak;

   case "group" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type, $parent);
      $title   = sprintf(__('%1$s: %2$s'), Group::getTypeName(1),
                        Dropdown::getDropdownName('glpi_groups', $id));
      break;

   case "groups_id_assign" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), Group::getTypeName(1),
                        Dropdown::getDropdownName("glpi_groups", $id));
      break;

   case "priority" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Priority'), $item->getPriorityName($id));
      break;

   case "urgency" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Urgency'), $item->getUrgencyName($id));
      break;

   case "impact" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Impact'), $item->getImpactName($id));
      break;

   case "usertitles_id" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), _x('person', 'Title'),
                        Dropdown::getDropdownName("glpi_usertitles", $id));
      break;

   case "solutiontypes_id" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), SolutionType::getTypeName(1),
                        Dropdown::getDropdownName("glpi_solutiontypes", $id));
      break;

   case "usercategories_id" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), __('Category'),
                        Dropdown::getDropdownName("glpi_usercategories", $id));
      break;

   case "requesttypes_id" :
      $val1    = $id;
      $val2    = '';
      $values  = Stat::getItems($itemtype, $date1, $date2, $type);
      $title   = sprintf(__('%1$s: %2$s'), RequestType::getTypeName(1),
                        Dropdown::getDropdownName("glpi_requesttypes", $id));
      break;

   case "device" :
      $val1 = $id;
      $val2 = '';
      if (!is_null($champ) && $champ) {
         $val2 = $champ;
      }
      if ($item = getItemForItemtype($champ)) {
         $device_table = $item->getTable();
         $values       = Stat::getItems($itemtype, $date1, $date2, $champ);

         $iterator = $DB->request([
            'SELECT' => ['designation'],
            'FROM'   => $device_table,
            'WHERE'  => [
               'id' => $id
            ]
         ]);
         $current = $iterator->next();

         $title  = sprintf(__('%1$s: %2$s'),
                           $item->getTypeName(), $current['designation']);
      }
      break;

   case "comp_champ" :
      $val1  = $id;
      $val2 = '';
      if (!is_null($champ) && $champ) {
         $val2 = $champ;
         if ($item = getItemForItemtype($champ)) {
            $table  = $item->getTable();
            $values = Stat::getItems($itemtype, $date1, $date2, $champ);
            $title  = sprintf(__('%1$s: %2$s'),
                              $item->getTypeName(), Dropdown::getDropdownName($table, $id));
         }
      }
      break;

   default:
      exit;
}


// Found next and prev items
$foundkey = -1;
foreach ($values as $key => $val) {
   if ($val['id'] == $id) {
      $foundkey = $key;
   }
}

if ($foundkey >= 0) {
   if (isset($values[$foundkey+1])) {
      $next = $values[$foundkey+1]['id'];
   }
   if (isset($values[$foundkey-1])) {
      $prev = $values[$foundkey-1]['id'];
   }
}

$stat = new Stat();

echo "<div class='center'>";
echo "<table class='tab_cadre'>";
echo "<tr><td>";
if ($prev > 0) {
   echo "<a href=\"".$_SERVER['PHP_SELF']."?$cleantarget&amp;date1=".$date1."&amp;date2=".
          $date2."&amp;id=$prev\">
          <img src='".$CFG_GLPI["root_doc"]."/pics/left.png' alt=\"".__s('Previous')."\"
           title=\"".__s('Previous')."\"></a>";
}
echo "</td>";

echo "<td width='400' class='center b'>$title</td>";
echo "<td>";
if ($next > 0) {
   echo "<a href=\"".$_SERVER['PHP_SELF']."?$cleantarget&amp;date1=".$date1."&amp;date2=".
          $date2."&amp;id=$next\">
          <img src='".$CFG_GLPI["root_doc"]."/pics/right.png' alt=\"".__s('Next')."\"
           title=\"".__s('Next')."\"></a>";
}
echo "</td>";
echo "</tr>";
echo "</table></div><br>";

$target = preg_replace("/&/", "&amp;", $_SERVER["REQUEST_URI"]);

echo "<form method='get' name='form' action='$target'><div class='center'>";
echo "<table class='tab_cadre'>";
echo "<tr class='tab_bg_2'><td class='right'>".__('Start date')."</td><td>";
Html::showDateField("date1", ['value' => $date1]);
echo "</td><td rowspan='2' class='center'>";
echo "<input type='hidden' name='itemtype' value=\"".$itemtype."\">";
echo "<input type='hidden' name='type' value=\"".$type."\">";
echo "<input type='hidden' name='id' value=\"".$id."\">";
echo "<input type='submit' class='submit' value=\"".__s('Display report')."\"></td></tr>";

echo "<tr class='tab_bg_2'><td class='right'>".__('End date')."</td><td>";
Html::showDateField("date2", ['value' => $date2]);
echo "</td></tr>";
echo "</table></div>";

// form using GET method : CRSF not needed
Html::closeForm();


///////// Stats nombre intervention
// Total des interventions
$values['total']  = Stat::constructEntryValues($itemtype, 'inter_total', $date1, $date2, $type, $val1, $val2);
// Total des interventions résolues
$values['solved'] = Stat::constructEntryValues($itemtype, 'inter_solved', $date1, $date2, $type, $val1, $val2);
// Total des interventions closes
$values['closed'] = Stat::constructEntryValues($itemtype, 'inter_closed', $date1, $date2, $type, $val1, $val2);
// Total des interventions closes
$values['late']   = Stat::constructEntryValues($itemtype, 'inter_solved_late', $date1, $date2, $type, $val1, $val2);


$stat->displayLineGraph(
   _x('Quantity', 'Number') . " - " . $item->getTypeName(Session::getPluralNumber()),
   array_keys($values['total']), [
      [
         'name' => _nx('ticket', 'Opened', 'Opened', Session::getPluralNumber()),
         'data' => $values['total']
      ], [
         'name' => _nx('ticket', 'Solved', 'Solved', Session::getPluralNumber()),
         'data' => $values['solved']
      ], [
         'name' => __('Late'),
         'data' => $values['late']
      ], [
         'name' => __('Closed'),
         'data' => $values['closed']
      ]
   ]
);

$values = [];
//Temps moyen de resolution d'intervention
$values['avgsolved'] = Stat::constructEntryValues($itemtype, 'inter_avgsolvedtime', $date1, $date2, $type, $val1, $val2);
// Pass to hour values
foreach ($values['avgsolved'] as $key => &$val) {
   $val = round($val / HOUR_TIMESTAMP, 2);
}
//Temps moyen de cloture d'intervention
$values['avgclosed'] = Stat::constructEntryValues($itemtype, 'inter_avgclosedtime', $date1, $date2, $type, $val1, $val2);
// Pass to hour values
foreach ($values['avgclosed'] as $key => &$val) {
   $val = round($val / HOUR_TIMESTAMP, 2);
}
//Temps moyen d'intervention reel
$values['avgactiontime'] = Stat::constructEntryValues($itemtype, 'inter_avgactiontime', $date1, $date2, $type, $val1, $val2);
// Pass to hour values
foreach ($values['avgactiontime'] as $key => &$val) {
   $val = round($val / HOUR_TIMESTAMP, 2);
}

$series = [
   [
      'name' => __('Closure'),
      'data' => $values['avgsolved']
   ], [
      'name' => __('Resolution'),
      'data' => $values['avgclosed']
   ], [
      'name' => __('Real duration'),
      'data' => $values['avgactiontime']
   ]
];

if ($itemtype == 'Ticket') {
   //Temps moyen de prise en compte de l'intervention
   $values['avgtaketime'] = Stat::constructEntryValues($itemtype, 'inter_avgtakeaccount', $date1, $date2, $type, $val1, $val2);
   // Pass to hour values
   foreach ($values['avgtaketime'] as $key => &$val) {
      $val = round($val / HOUR_TIMESTAMP, 2);
   }

   $series[] = [
      'name' => __('Take into account'),
      'data' => $values['avgtaketime']
   ];
}

$stat->displayLineGraph(
   __('Average time') . " - " .  _n('Hour', 'Hours', Session::getPluralNumber()),
   array_keys($values['avgsolved']),
   $series
);

if ($itemtype == 'Ticket') {
   $values = [];
   ///////// Satisfaction
   $values['opensatisfaction']   = Stat::constructEntryValues($itemtype, 'inter_opensatisfaction', $date1, $date2, $type, $val1, $val2);

   $values['answersatisfaction'] = Stat::constructEntryValues($itemtype, 'inter_answersatisfaction', $date1, $date2, $type, $val1, $val2);

   $stat->displayLineGraph(
      __('Satisfaction survey') . " - " .  __('Tickets'),
      array_keys($values['opensatisfaction']), [
         [
            'name' => _nx('survey', 'Opened', 'Opened', Session::getPluralNumber()),
            'data' => $values['opensatisfaction']
         ], [
            'name' => _nx('survey', 'Answered', 'Answered', Session::getPluralNumber()),
            'data' => $values['answersatisfaction']
         ]
      ]
   );

   $values = [];
   $values['avgsatisfaction'] = Stat::constructEntryValues($itemtype, 'inter_avgsatisfaction', $date1, $date2, $type, $val1, $val2);

   $stat->displayLineGraph(
      __('Satisfaction'),
      array_keys($values['avgsatisfaction']), [
         [
            'name' => __('Satisfaction'),
            'data' => $values['avgsatisfaction']
         ]
      ]
   );
}
Html::footer();
