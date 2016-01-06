<?php
/*
 * @version $Id: dropdownObserver.php 22657 2014-02-12 16:17:54Z moyo $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/** @file
* @brief
*/

include ('../inc/includes.php');

header("Content-Type: text/html; charset=UTF-8");
Html::header_nocache();

Session::checkCentralAccess();

$types = array(''      => Dropdown::EMPTY_VALUE,
               'user'  => __('User'));
$types['group'] = __('Group');
$r = mt_rand();

$rand   = Dropdown::showFromArray("_itil_observer[_type][".$r."]", $types);
$params = array('type'            => '__VALUE__',
              'actortype'       => 'observer',
              'itemtype'        => 'Ticket',
              'allow_email'     => true,
              'entity_restrict' => $_POST['entities_id'],
              'r'               => $r);

Ajax::updateItemOnSelectEvent("dropdown__itil_observer[_type][".$r."]$rand",
                            "showitilactorobserver_$rand",
                            $CFG_GLPI["root_doc"]."/ajax/dropdownObserverActors.php",
                            $params);
echo "<span id='showitilactorobserver_$rand'>&nbsp;</span>";

?>