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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}


class RuleItilFollowup extends Rule {

   // From Rule
   static $rightname = 'rule_ticket';
   public $can_sort  = true;

   const PARENT  = 1024;


   const ONADD    = 1;
   const ONUPDATE = 2;

   function getTitle() {
      return __('Business rules for tickets followups');
   }

   /**
    * @since 0.85
   **/
   static function getConditionsArray() {

      return [static::ONADD                   => __('Add'),
                   static::ONUPDATE                => __('Update'),
                   static::ONADD|static::ONUPDATE  => sprintf(__('%1$s / %2$s'), __('Add'),
                                                              __('Update'))];
   }

   function executeActions($output, $params, array $input = []) {
      if (count($this->actions)) {
         foreach ($this->actions as $action) {
            switch ($action->fields["action_type"]) {
               case "assign" :
                  $output[$action->fields["field"]] = $action->fields["value"];

                  if ($action->fields["field"] === 'status') {
                     $output['_'.$action->fields["field"]] = $action->fields["value"];
                     // Add a flag to remember that status was forced by rule
                     $output['_do_not_compute_status'] = true;
                  }

                  break;
            }
         }
      }

      return $output;
   }

   function getCriterias() {

      static $criterias = [];

      if (count($criterias)) {
         return $criterias;
      }

      $criterias['itemtype']['name']                    = 'Type du parent';
      $criterias['itemtype']['field']                   = '__itilfollowup__itemtype';
      $criterias['itemtype']['type']                    = 'dropdown_followup_itemtype';

      $criterias['__itilfollowup_author']['name']                    = 'Auteur du suivi';
      $criterias['__itilfollowup_author']['field']                   = '__itilfollowup_author';
      $criterias['__itilfollowup_author']['type']                    = 'dropdown_followup_usertype';
      $criterias['__itilfollowup_author']['allow_condition']         = [
         Rule::PATTERN_IS,
         Rule::PATTERN_IS_NOT,
         ];

      return $criterias;
   }

   function getActions() {
      $actions = [];

      $actions['status']['name']                            = 'Status du parent';
      $actions['status']['type']                            = 'dropdown_status';

      return $actions;
   }

   function displayCriteriaSelectPattern($name, $ID, $condition, $value = "", $test = false) {
      $crit    = $this->getCriteria($ID);
      $display = false;
      $tested  = false;

      if (isset($crit['field'])) {
         if ($crit['field'] == '__itilfollowup_author') {
            Dropdown::showFromArray($name, $this->genereArrayDropdownFollowupUsertype());
            return;
         }
         if ($crit['field'] == '__itilfollowup__itemtype') {
            Dropdown::showFromArray($name, $this->genereArrayDropdownFollowupItemtype());
            return;
         }
      }

      return parent::displayCriteriaSelectPattern($name, $ID, $condition, $value, $test);
   }

   function checkCriteria(&$criteria, &$input) {
      if (isset($input['items_id'])) {
         $idParent = $input['items_id'];
      } else {
         return false;
      }
      if (isset($input['itemtype'])) {
         $itemtype = $input['itemtype'];
      } else {
         return false;
      }
      if (isset($input['users_id'])) {
         $users_id_add_followup = $input['users_id'];
      } else {
         return false;
      }

      if (isset($criteria->fields['criteria'])) {
         if ($criteria->fields['criteria'] == '__itilfollowup_author') {
            switch ($itemtype) {
               case 'Ticket':
                  $common = new Ticket_User;
                  $tab_actors = $common->find(['tickets_id' => $idParent, 'type' => $criteria->fields['pattern'], 'users_id' => $users_id_add_followup], [], 1);
                  break;

               case 'Change':
                  $common = new Change_User;
                  $tab_actors = $common->find(['changes_id' => $idParent, 'type' => $criteria->fields['pattern'], 'users_id' => $users_id_add_followup]);
                  break;

               case 'Problem':
                  $common = new Problem_User;
                  $tab_actors = $common->find(['problems_id' => $idParent, 'type' => $criteria->fields['pattern'], 'users_id' => $users_id_add_followup]);
                  break;

               default:
                  return false;
            }

            if ($tab_actors == 0) {
               return false;
            }
            return true;
         }

         if ($criteria->fields['criteria'] == 'itemtype') {
            if ($criteria->fields['pattern'] == $itemtype) {
               return true;
            }
            return false;
         }
      }

      return parent::checkCriteria($criteria, $input);

   }

   function getCriteriaDisplayPattern($ID, $condition, $pattern) {
      $crit = $this->getCriteria($ID);

      if (isset($crit['type'])) {
         switch ($crit['type']) {
            case "dropdown_followup_usertype" :
               $tab = $this->genereArrayDropdownFollowupUsertype();
               return $tab[$pattern];
            case "dropdown_followup_itemtype" :
               $tab = $this->genereArrayDropdownFollowupItemtype();
               return $tab[$pattern];

         }
      }
      return parent::getCriteriaDisplayPattern($ID, $condition, $pattern);

   }

   function genereArrayDropdownFollowupUsertype () {
      return [
         CommonITILActor::OBSERVER => _n('Watcher', 'Watchers', 1),
         CommonITILActor::REQUESTER => _n('Requester', 'Demandeurs', 1),
         CommonITILActor::ASSIGN => __('Technician'),
      ];
   }

   function genereArrayDropdownFollowupItemtype () {
      return [
         'Ticket' => _n('Ticket', 'Tickets', 1),
         'Change' => _n('Change', 'Changes', 1),
         'Problem' => _n('Problem', 'Problems', 1),
      ];
   }

}
