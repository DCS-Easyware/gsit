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
$dateRegex = ['options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']];
$itemtypeRegex  = ['options' => ['regexp' => '/^\w+$/']];
$year      = date('Y') - 1;

$date1     = filter_input(INPUT_GET, 'date1', FILTER_VALIDATE_REGEXP, $dateRegex);
$date2     = filter_input(INPUT_GET, 'date2', FILTER_VALIDATE_REGEXP, $dateRegex);
$itemtype  = filter_input(INPUT_GET, 'itemtype', FILTER_VALIDATE_REGEXP, $itemtypeRegex);

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

Stat::title();

if (is_null($itemtype) || !$itemtype) {
   exit;
}

$item = getItemForItemtype($itemtype);
if (!$item) {
   exit;
}

$stat = new Stat();

$stat->displaySearchForm(
   $itemtype,
   $date1,
   $date2
);

///////// Stats nombre intervention
$values = [];
// Total des interventions
$values['total']  = Stat::constructEntryValues($itemtype, 'inter_total', $date1, $date2);
// Total des interventions résolues
$values['solved'] = Stat::constructEntryValues($itemtype, 'inter_solved', $date1, $date2);
// Total des interventions closes
$values['closed'] = Stat::constructEntryValues($itemtype, 'inter_closed', $date1, $date2);
// Total des interventions closes
$values['late']   = Stat::constructEntryValues($itemtype, 'inter_solved_late', $date1, $date2);

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
$values['avgsolved'] = Stat::constructEntryValues($itemtype, 'inter_avgsolvedtime', $date1, $date2);
// Pass to hour values
foreach ($values['avgsolved'] as &$val) {
   $val = round($val / HOUR_TIMESTAMP, 2);
}

//Temps moyen de cloture d'intervention
$values['avgclosed'] = Stat::constructEntryValues($itemtype, 'inter_avgclosedtime', $date1, $date2);
// Pass to hour values
foreach ($values['avgclosed'] as &$val) {
   $val = round($val / HOUR_TIMESTAMP, 2);
}
//Temps moyen d'intervention reel
$values['avgactiontime'] = Stat::constructEntryValues($itemtype, 'inter_avgactiontime', $date1, $date2);

// Pass to hour values
foreach ($values['avgactiontime'] as &$val) {
   $val =  round($val / HOUR_TIMESTAMP, 2);
}

$stat->displayLineGraph(
   __('Average time') . " - " .  _n('Hour', 'Hours', Session::getPluralNumber()),
   array_keys($values['avgsolved']), [
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
   ]
);

if ($itemtype == 'Ticket') {

   ///////// Satisfaction
   $values = [];
   $values['opensatisfaction']   = Stat::constructEntryValues('Ticket', 'inter_opensatisfaction', $date1, $date2);
   $values['answersatisfaction'] = Stat::constructEntryValues('Ticket', 'inter_answersatisfaction', $date1, $date2);

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
   $values['avgsatisfaction'] = Stat::constructEntryValues('Ticket', 'inter_avgsatisfaction', $date1, $date2);

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
