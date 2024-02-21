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

Html::header(__('Statistics'), '', "helpdesk", "stat");

Session::checkRight("statistic", READ);

// init variables && filter data
$dateRegex      = ['options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']];
$itemtypeRegex  = ['options' => ['regexp' => '/^\w+$/']];
$idRegex        = ['options' => ['regexp' => '/^\d+$/']];
$showgraphRegex = ['options' => ['regexp' => '/^(0|1)$/']];
$year           = date('Y') - 1;

$date1     = filter_input(INPUT_GET, 'date1', FILTER_VALIDATE_REGEXP, $dateRegex);
$date2     = filter_input(INPUT_GET, 'date2', FILTER_VALIDATE_REGEXP, $dateRegex);
$showgraph = filter_input(INPUT_GET, 'showgraph', FILTER_VALIDATE_REGEXP, $showgraphRegex);
$start     = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_REGEXP, $idRegex);
$dropdown  = filter_input(INPUT_GET, 'dropdown', FILTER_VALIDATE_REGEXP, $itemtypeRegex);
$itemtype  = filter_input(INPUT_GET, 'itemtype', FILTER_VALIDATE_REGEXP, $itemtypeRegex);

if (is_null($showgraph) || $showgraph === false) {
   $showgraph = 0;
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

if (is_null($start) || !$start) {
   $start = 0;
}

if (is_null($dropdown) || !$dropdown) {
   $dropdown = 'ComputerType';
}

if (is_null($itemtype) || !$itemtype) {
   $itemtype = 'Ticket';
}

// Check if the dropdown and the itemtype are GLPI classes
$item = getItemForItemtype($dropdown);
if (!$item || !getItemForItemtype($itemtype)) {
   exit;
}

$stat = new Stat();
Stat::title();

echo "<form method='get' name='form' action='stat.location.php'>";
// keep it first param
echo "<input type='hidden' name='itemtype' value='". $itemtype ."'>";

echo "<table class='tab_cadre_fixe' ><tr class='tab_bg_2'><td rowspan='2' width='30%'>";
$values = [_n('Dropdown', 'Dropdowns', Session::getPluralNumber()) => ['ComputerType'    => _n('Type', 'Types', 1),
                                                       'ComputerModel'   => _n('Model', 'Models', 1),
                                                       'OperatingSystem' => OperatingSystem::getTypeName(1),
                                                       'Location'        => Location::getTypeName(1)],
               ];
$devices = Dropdown::getDeviceItemTypes();
foreach ($devices as $label => $dp) {
   foreach ($dp as $i => $name) {
      $values[$label][$i] = $name;
   }
}

Dropdown::showFromArray('dropdown', $values, ['value' => $dropdown]);

echo "</td>";

echo "<td class='right'>".__('Start date')."</td><td>";
Html::showDateField("date1", ['value' => $date1]);
echo "</td>";
echo "<td class='right'>".__('Show graphics')."</td>";
echo "<td rowspan='2' class='center'>";
echo "<input type='submit' class='submit' value='".__s('Display report')."'></td></tr>";

echo "<tr class='tab_bg_2'><td class='right'>".__('End date')."</td><td>";
Html::showDateField("date2", ['value' => $date2]);
echo "</td><td class='center'>";
Dropdown::showYesNo('showgraph', $showgraph);
echo "</td>";
echo "</tr>";
echo "</table>";
// form using GET method : CRSF not needed
echo "</form>";

if (!($item instanceof CommonDevice)) {
   // echo "Dropdown";
   $type = "comp_champ";

   $val = Stat::getItems($itemtype, $date1, $date2, $dropdown);
   $params = ['type'     => $type,
              'dropdown' => $dropdown,
              'date1'    => $date1,
              'date2'    => $date2,
              'start'    => $start];

} else {
   //   echo "Device";
   $type  = "device";

   $val = Stat::getItems($itemtype, $date1, $date2, $dropdown);
   $params = ['type'     => $type,
              'dropdown' => $dropdown,
              'date1'    => $date1,
              'date2'    => $date2,
              'start'    => $start];
}

if (!$showgraph) {
   Html::printPager($start, count($val), $CFG_GLPI['root_doc'].'/front/stat.location.php',
   "date1=".$date1."&amp;date2=".$date2.
       "&amp;itemtype=".$itemtype."&amp;dropdown=".$dropdown,
   'Stat', $params);

   Stat::showTable($itemtype, $type, $date1, $date2, $start, $val, $dropdown);
} else {
   $data = Stat::getData($itemtype, $type, $date1, $date2, $start, $val, $dropdown);

   if (isset($data['opened']) && is_array($data['opened'])) {
      $count = 0;
      $labels = [];
      $series = [];
      foreach ($data['opened'] as $key => $val) {
         if ($val > 0) {
            $newkey = Toolbox::unclean_cross_side_scripting_deep(Html::clean($key));
            $labels[] = $newkey;
            $series[] = ['name' => $newkey, 'data' => $val];
            $count += $val;
         }
      }

      if (count($series)) {
         $stat->displayPieGraph(
            sprintf(
               __('Opened %1$s (%2$s)'),
               Ticket::getTypeName(Session::getPluralNumber()),
               $count
            ),
            $labels,
            $series
         );
      }
   }

   if (isset($data['solved']) && is_array($data['solved'])) {
      $count = 0;
      $labels = [];
      $series = [];
      foreach ($data['solved'] as $key => $val) {
         if ($val > 0) {
            $labels[] = $newkey;
            $series[] = ['name' => $newkey, 'data' => $val];
            $count += $val;
         }
      }

      if (count($series)) {
         $stat->displayPieGraph(
            sprintf(
               __('Solved %1$s (%2$s)'),
               Ticket::getTypeName(Session::getPluralNumber()),
               $count
            ),
               $labels,
               $series
         );
      }
   }

   if (isset($data['late']) && is_array($data['late'])) {
      $count = 0;
      $labels = [];
      $series = [];
      foreach ($data['late'] as $key => $val) {
         if ($val > 0) {
            $labels[] = $newkey;
            $series[] = ['name' => $newkey, 'data' => $val];
            $count += $val;
         }
      }

      if (count($series)) {
         $stat->displayPieGraph(
            sprintf(
               __('Late solved %1$s (%2$s)'),
               Ticket::getTypeName(Session::getPluralNumber()),
               $count
            ),
            $labels,
            $series
         );
      }
   }

   if (isset($data['closed']) && is_array($data['closed'])) {
      $count = 0;
      $labels = [];
      $series = [];
      foreach ($data['closed'] as $key => $val) {
         if ($val > 0) {
            $labels[] = $newkey;
            $series[] = ['name' => $newkey, 'data' => $val];
            $count += $val;
         }
      }

      if (count($series)) {
         $stat->displayPieGraph(
            sprintf(
                __('Closed %1$s (%2$s)'),
               Ticket::getTypeName(Session::getPluralNumber()),
               $count
            ),
            $labels,
            $series
         );
      }
   }

   if (isset($data['opensatisfaction']) && is_array($data['opensatisfaction'])) {
      $count = 0;
      $labels = [];
      $series = [];
      foreach ($data['opensatisfaction'] as $key => $val) {
         if ($val > 0) {
            $labels[] = $newkey;
            $series[] = ['name' => $newkey, 'data' => $val];
            $count += $val;
         }
      }

      if (count($series)) {
         $stat->displayPieGraph(
            sprintf(
                __('%1$s satisfaction survey (%2$s)'),
               Ticket::getTypeName(Session::getPluralNumber()),
               $count
            ),
            $labels,
            $series
         );
      }
   }
}

Html::footer();
