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
$dateRegex     = ['options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']];
$idRegex       = ['options' => ['regexp' => '/^\d+$/']];
$year          = date('Y') - 1;

$date1 = filter_input(INPUT_GET, 'date1', FILTER_VALIDATE_REGEXP, $dateRegex);
$date2 = filter_input(INPUT_GET, 'date2', FILTER_VALIDATE_REGEXP, $dateRegex);
$start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_REGEXP, $idRegex);

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

Stat::title();

echo "<div class='center'><form method='get' name='form' action='stat.item.php'>";
echo "<table class='tab_cadre'><tr class='tab_bg_2'>";
echo "<td class='right'>".__('Start date')."</td><td>";
Html::showDateField("date1", ['value' => $date1]);
echo "</td><td rowspan='2' class='center'>";
echo "<input type='submit' class='submit' value='".__s('Display report')."'></td></tr>";
echo "<tr class='tab_bg_2'><td class='right'>".__('End date')."</td><td>";
Html::showDateField("date2", ['value' => $date2]);
echo "</td></tr>";
echo "</table>";
Html::closeForm();
echo "</div>";

Stat::showItems($_SERVER['PHP_SELF'], $date1, $date2, $start);

Html::footer();
