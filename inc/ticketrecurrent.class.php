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

/**
 * Ticket Recurrent class
 *
 * @since 0.83
**/
class TicketRecurrent extends CommonDropdown {

   // From CommonDBTM
   public $dohistory              = true;

   // From CommonDropdown
   public $first_level_menu       = "helpdesk";
   public $second_level_menu      = "ticketrecurrent";

   public $display_dropdowntitle  = false;

   static $rightname              = 'ticketrecurrent';

   public $can_be_translated      = false;



   static function getTypeName($nb = 0) {
      return __('Recurrent tickets');
   }


   static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {

      switch ($item->getType()) {
         case 'TicketRecurrent' :
            switch ($tabnum) {
               case 1 :
                  $item->showInfos();
                  return true;
            }
            break;
      }
      return false;
   }


   function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {

      if (Session::haveRight('itiltemplate', READ)) {
         switch ($item->getType()) {
            case 'TicketRecurrent' :
               $ong[1] = _n('Information', 'Information', Session::getPluralNumber());
               return $ong;
         }
      }
      return '';
   }


   function defineTabs($options = []) {

      $ong = [];
      $this->addDefaultFormTab($ong);
      $this->addStandardTab(__CLASS__, $ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }


   function prepareInputForAdd($input) {

      $input['next_creation_date'] = $this->computeNextCreationDate($input['begin_date'],
                                                                    $input['end_date'],
                                                                    $input['periodicity'],
                                                                    $input['create_before'],
                                                                    $input['calendars_id']);
      return $input;
   }


   function prepareInputForUpdate($input) {

      if (isset($input['begin_date'])
          && isset($input['periodicity'])
          && isset($input['create_before'])) {

         $input['next_creation_date'] = $this->computeNextCreationDate($input['begin_date'],
                                                                       $input['end_date'],
                                                                       $input['periodicity'],
                                                                       $input['create_before'],
                                                                       $input['calendars_id']);
      }
      return $input;
   }


   /**
    * Return Additional Fileds for this type
   **/
   function getAdditionalFields() {

      return [['name'  => 'is_active',
                         'label' => __('Active'),
                         'type'  => 'bool',
                         'list'  => false],
                   ['name'  => 'tickettemplates_id',
                         'label' => _n('Ticket template', 'Ticket templates', 1),
                         'type'  => 'dropdownValue',
                         'list'  => true],
                   ['name'  => 'begin_date',
                         'label' => __('Start date'),
                         'type'  => 'datetime',
                         'list'  => false],
                   ['name'  => 'end_date',
                         'label' => __('End date'),
                         'type'  => 'datetime',
                         'list'  => false],
                   ['name'  => 'periodicity',
                         'label' => __('Periodicity'),
                         'type'  => 'specific_timestamp',
                         'min'   => DAY_TIMESTAMP,
                         'step'  => DAY_TIMESTAMP,
                         'max'   => 2*MONTH_TIMESTAMP],
                   ['name'  => 'create_before',
                         'label' => __('Preliminary creation'),
                         'type'  => 'timestamp',
                         'max'   => 7*DAY_TIMESTAMP,
                         'step'  => HOUR_TIMESTAMP],
                   ['name'  => 'calendars_id',
                         'label' => _n('Calendar', 'Calendars', 1),
                         'type'  => 'dropdownValue',
                         'list'  => true],
                  ];
   }


   /**
    * @since 0.83.1
    *
    * @see CommonDropdown::displaySpecificTypeField()
   **/
   function displaySpecificTypeField($ID, $field = []) {

      switch ($field['name']) {
         case 'periodicity' :
            $possible_values = [];
            for ($i=1; $i<24; $i++) {
               $possible_values[$i*HOUR_TIMESTAMP] = sprintf(_n('%d hour', '%d hours', $i), $i);
            }
            for ($i=1; $i<=30; $i++) {
               $possible_values[$i*DAY_TIMESTAMP] = sprintf(_n('%d day', '%d days', $i), $i);
            }

            for ($i=1; $i<12; $i++) {
               $possible_values[$i.'MONTH'] = sprintf(_n('%d month', '%d months', $i), $i);
            }

            for ($i=1; $i<11; $i++) {
               $possible_values[$i.'YEAR'] = sprintf(_n('%d year', '%d years', $i), $i);
            }

            Dropdown::showFromArray($field['name'], $possible_values,
                                    ['value' => $this->fields[$field['name']]]);
            break;
      }
   }

   /**
    * @since 0.84
    *
    * @param $field
    * @param $values
    * @param $options   array
   **/
   static function getSpecificValueToDisplay($field, $values, array $options = []) {

      if (!is_array($values)) {
         $values = [$field => $values];
      }

      switch ($field) {
         case 'periodicity' :
            if (preg_match('/([0-9]+)MONTH/', $values[$field], $matches)) {
               return sprintf(_n('%d month', '%d months', $matches[1]), $matches[1]);
            }
            if (preg_match('/([0-9]+)YEAR/', $values[$field], $matches)) {
               return sprintf(_n('%d year', '%d years', $matches[1]), $matches[1]);
            }
            return Html::timestampToString($values[$field], false);
         break;
      }
      return parent::getSpecificValueToDisplay($field, $values, $options);
   }


   function rawSearchOptions() {
      $tab = parent::rawSearchOptions();

      $tab[] = [
         'id'                 => '11',
         'table'              => $this->getTable(),
         'field'              => 'is_active',
         'name'               => __('Active'),
         'datatype'           => 'bool'
      ];

      $tab[] = [
         'id'                 => '12',
         'table'              => 'glpi_tickettemplates',
         'field'              => 'name',
         'name'               => _n('Ticket template', 'Ticket templates', 1),
         'datatype'           => 'itemlink'
      ];

      $tab[] = [
         'id'                 => '13',
         'table'              => $this->getTable(),
         'field'              => 'begin_date',
         'name'               => __('Start date'),
         'datatype'           => 'datetime'
      ];

      $tab[] = [
         'id'                 => '17',
         'table'              => $this->getTable(),
         'field'              => 'end_date',
         'name'               => __('End date'),
         'datatype'           => 'datetime'
      ];

      $tab[] = [
         'id'                 => '15',
         'table'              => $this->getTable(),
         'field'              => 'periodicity',
         'name'               => __('Periodicity'),
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '14',
         'table'              => $this->getTable(),
         'field'              => 'create_before',
         'name'               => __('Preliminary creation'),
         'datatype'           => 'timestamp'
      ];

      $tab[] = [
         'id'                 => '18',
         'table'              => 'glpi_calendars',
         'field'              => 'name',
         'name'               => _n('Calendar', 'Calendars', 1),
         'datatype'           => 'itemlink'
      ];

      return $tab;
   }


   /**
    * Show next creation date
    *
    * @return void
   **/
   function showInfos() {

      if (!is_null($this->fields['next_creation_date'])) {
         echo "<div class='center'>";
         //TRANS: %s is the date of next creation
         echo sprintf(__('Next creation on %s'),
                      Html::convDateTime($this->fields['next_creation_date']));
         echo "</div>";
      }
   }


   /**
    * Compute next creation date of a ticket.
    *
    * @param string         $begin_date     Begin date of the recurrent ticket in 'Y-m-d H:i:s' format.
    * @param string         $end_date       End date of the recurrent ticket in 'Y-m-d H:i:s' format,
    *                                       or 'NULL' or empty value.
    * @param string|integer $periodicity    Periodicity of creation, could be:
    *                                        - an integer corresponding to seconds,
    *                                        - a string using "/([0-9]+)(MONTH|YEAR)/" pattern.
    * @param integer        $create_before  Anticipated creation delay in seconds.
    * @param integer|null   $calendars_id   ID of the calendar to use to restrict creation to working hours,
    *                                       or 0 / null for no calendar.
    *
    * @return string  Next creation date in 'Y-m-d H:i:s' format.
    *
    * @since 0.84 $calendars_id parameter added
    */
   function computeNextCreationDate($begin_date, $end_date, $periodicity, $create_before,
                                    $calendars_id) {

      $now = time();
      $periodicity_pattern = '/([0-9]+)(MONTH|YEAR)/';

      if (false === DateTime::createFromFormat('Y-m-d H:i:s', $begin_date)) {
         // Invalid begin date.
         return 'NULL';
      }

      $has_end_date = false;
      if (!is_null($end_date)) {
         $has_end_date = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);
      }
      if ($has_end_date && strtotime($end_date) < $now) {
         // End date is in past.
         return 'NULL';
      }

      if (!is_int($periodicity) && !preg_match('/^\d+$/', $periodicity)
          && !preg_match($periodicity_pattern, $periodicity)) {
         // Invalid periodicity.
         return 'NULL';
      }

      // Compute periodicity values
      $periodicity_as_interval = null;
      $periodicity_in_seconds = $periodicity;
      $matches = [];
      if (preg_match($periodicity_pattern, $periodicity, $matches)) {
         $periodicity_as_interval = "{$matches[1]} {$matches[2]}";
         $periodicity_in_seconds  = $matches[1]
            * MONTH_TIMESTAMP
            * ('YEAR' === $matches[2] ? 12 : 1);
      } else if ($periodicity % DAY_TIMESTAMP == 0) {
         $periodicity_as_interval = ($periodicity / DAY_TIMESTAMP) . ' DAY';
      } else {
         $periodicity_as_interval = ($periodicity / HOUR_TIMESTAMP) . ' HOUR';
      }

      // Check that anticipated creation delay is greater than periodicity.
      if ($create_before > $periodicity_in_seconds) {
         Session::addMessageAfterRedirect(
            __('Invalid frequency. It must be greater than the preliminary creation.'),
            false,
            ERROR
         );
         return 'NULL';
      }

      $calendar = new Calendar();
      $is_calendar_valid = !is_null($calendars_id) && $calendars_id && $calendar->getFromDB($calendars_id) && $calendar->hasAWorkingDay();

      if (!$is_calendar_valid || $periodicity_in_seconds >= DAY_TIMESTAMP) {
         // Compute next occurence without using the calendar if calendar is not valid
         // or if periodicity is at least one day.

         // First occurence of creation
         $occurence_time = strtotime($begin_date);
         $creation_time  = $occurence_time - $create_before;

         // Add steps while creation time is in past
         while ($creation_time < $now) {
            $creation_time  = strtotime("+ $periodicity_as_interval", $creation_time);
            $occurence_time = $creation_time + $create_before;

            // Stop if end date reached
            if ($has_end_date && $occurence_time > strtotime($end_date)) {
               return 'NULL';
            }
         }

         if ($is_calendar_valid) {
            // Jump to next working day if occurence is outside working days.
            while ($calendar->isHoliday(date('Y-m-d', $occurence_time))
                   || !$calendar->isAWorkingDay($occurence_time)) {
               $occurence_time = strtotime('+ 1 day', $occurence_time);
            }
            // Jump to next working hour if occurence is outside working hours.
            if (!$calendar->isAWorkingHour($occurence_time)) {
               $occurence_date = $calendar->computeEndDate(
                  date('Y-m-d', $occurence_time),
                  0 // 0 second delay to get the first working "second"
               );
               $occurence_time = strtotime($occurence_date);
            }
            $creation_time  = $occurence_time - $create_before;
         }
      } else {
         // Base computation on calendar if calendar is valid

         $occurence_date = $calendar->computeEndDate(
            $begin_date,
            0 // 0 second delay to get the first working "second"
         );
         $occurence_time = strtotime($occurence_date);
         $creation_time  = $occurence_time - $create_before;

         while ($creation_time < $now) {
            $occurence_date = $calendar->computeEndDate(
               date('Y-m-d H:i:s', $occurence_time),
               $periodicity_in_seconds,
               0,
               $periodicity_in_seconds >= DAY_TIMESTAMP
            );
            $occurence_time = strtotime($occurence_date);
            $creation_time  = $occurence_time - $create_before;

            // Stop if end date reached
            if ($has_end_date && $occurence_time > strtotime($end_date)) {
               return 'NULL';
            }
         };
      }

      return date("Y-m-d H:i:s", $creation_time);
   }


   /**
    * Give cron information
    *
    * @param $name : task's name
    *
    * @return array of information
   **/
   static function cronInfo($name) {

      switch ($name) {
         case 'ticketrecurrent' :
            return ['description' => self::getTypeName(Session::getPluralNumber())];
      }
      return [];
   }


   /**
    * Cron for ticket's automatic close
    *
    * @param $task : crontask object
    *
    * @return integer (0 : nothing done - 1 : done)
   **/
   static function cronTicketRecurrent($task) {
      global $DB;

      $tot = 0;

      $iterator = $DB->request([
         'FROM'   => 'glpi_ticketrecurrents',
         'WHERE'  => [
            'next_creation_date' => ['<', new \QueryExpression('NOW()')],
            'is_active'          => 1,
            'OR'                 => [
               ['end_date' => null],
               ['end_date' => ['>', new \QueryExpression('NOW()')]]
            ]
         ]
      ]);

      while ($data = $iterator->next()) {
         if (self::createTicket($data)) {
            $tot++;
         } else {
            //TRANS: %s is a name
            $task->log(sprintf(__('Failed to create recurrent ticket %s'),
                               $data['name']));
         }
      }

      $task->setVolume($tot);
      return ($tot > 0 ? 1 : 0);
   }


   /**
    * Create a ticket based on ticket recurrent infos
    *
    * @param $data array data of a entry of glpi_ticketrecurrents
    *
    * @return boolean
   **/
   static function createTicket($data) {

      $result = false;
      $tt     = new TicketTemplate();

      // Create ticket based on ticket template and entity information of ticketrecurrent
      if ($tt->getFromDB($data['tickettemplates_id'])) {
         // Get default values for ticket
         $input = Ticket::getDefaultValues($data['entities_id']);
         // Apply itiltemplates predefined values
         $ttp        = new TicketTemplatePredefinedField();
         $predefined = $ttp->getPredefinedFields($data['tickettemplates_id'], true);

         if (count($predefined)) {
            foreach ($predefined as $predeffield => $predefvalue) {
               $input[$predeffield] = $predefvalue;
            }
         }
         // Set date to creation date
         $createtime    = strtotime($data['next_creation_date'])+$data['create_before'];
         $input['date'] = date('Y-m-d H:i:s', $createtime);
         if (isset($predefined['date'])) {
            $input['date'] = Html::computeGenericDateTimeSearch($predefined['date'], false,
                                                                $createtime);
         }
         // Compute time_to_resolve if predefined based on create date
         if (isset($predefined['time_to_resolve'])) {
            $input['time_to_resolve'] = Html::computeGenericDateTimeSearch($predefined['time_to_resolve'], false,
                                                                    $createtime);
         }

         // Compute internal_time_to_resolve if predefined based on create date
         if (isset($predefined['internal_time_to_resolve'])) {
            $input['internal_time_to_resolve'] = Html::computeGenericDateTimeSearch($predefined['internal_time_to_resolve'], false,
                                                                           $createtime);
         }
         // Set entity
         $input['entities_id'] = $data['entities_id'];
         $input['_auto_import'] = true;

         $ticket = new Ticket();
         $input  = Toolbox::addslashes_deep($input);
         if ($tid = $ticket->add($input)) {
            $msg = sprintf(__('Ticket %d successfully created'), $tid);
            $result = true;
         } else {
            $msg = __('Ticket creation failed (check mandatory fields)');
         }
      } else {
         $msg = __('Ticket creation failed (no template)');
      }
      $changes[0] = 0;
      $changes[1] = '';
      $changes[2] = addslashes($msg);
      Log::history($data['id'], __CLASS__, $changes, '', Log::HISTORY_LOG_SIMPLE_MESSAGE);

      // Compute next creation date
      $tr = new self();
      if ($tr->getFromDB($data['id'])) {
         $input                       = [];
         $input['id']                 = $data['id'];
         $input['next_creation_date'] = $tr->computeNextCreationDate($data['begin_date'],
                                                                     $data['end_date'],
                                                                     $data['periodicity'],
                                                                     $data['create_before'],
                                                                     $data['calendars_id']);
         $tr->update($input);
      }

      return $result;
   }


   static function getIcon() {
      return "fas fa-stopwatch";
   }

}
