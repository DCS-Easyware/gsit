<?php

namespace App\Models\Definitions;

class ConsumableItem
{
   public static function getDefinition()
   {
      global $translator;
      return [
         [
            'id'    => 2,
            'title' => $translator->translate('Name'),
            'type'  => 'input',
            'name'  => 'name',
         ],
         [
            'id'    => 34,
            'title' => $translator->translate('Reference'),
            'type'  => 'input',
            'name'  => 'ref',
         ],
         [
            'id'    => 6,
            'title' => $translator->translate('Inventory number'),
            'type'  => 'input',
            'name'  => 'otherserial',
            'autocomplete'  => true,
         ],
         [
            'id'    => 4,
            'title' => $translator->translatePlural('Type', 'Types', 1),
            'type'  => 'dropdown_remote',
            'name'  => 'type',
            'dbname' => 'consumableitemtypes_id',
            'itemtype' => '\App\Models\ConsumableItemType',
         ],
         [
            'id'    => 23,
            'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
            'type'  => 'dropdown_remote',
            'name'  => 'manufacturer',
            'dbname' => 'manufacturers_id',
            'itemtype' => '\App\Models\Manufacturer',
         ],
         [
            'id'    => 3,
            'title' => $translator->translatePlural('Location', 'Locations', 1),
            'type'  => 'dropdown_remote',
            'name'  => 'location',
            'dbname' => 'locations_id',
            'itemtype' => '\App\Models\Location',
         ],
         [
            'id'    => 24,
            'title' => $translator->translate('Technician in charge of the hardware'),
            'type'  => 'dropdown_remote',
            'name'  => 'userstech',
            'dbname' => 'users_id_tech',
            'itemtype' => '\App\Models\User',
         ],
         [
            'id'    => 49,
            'title' => $translator->translate('Group in charge of the hardware'),
            'type'  => 'dropdown_remote',
            'name'  => 'groupstech',
            'dbname' => 'groups_id_tech',
            'itemtype' => '\App\Models\Group',
         ],
         [
            'id'    => 8,
            'title' => $translator->translate('Alert threshold'),
            'type'  => 'dropdown',
            'name'  => 'alarm_threshold',
            'dbname'  => 'alarm_threshold',
            'values' => self::getNumberArray(0, 100, 1, ['-1' => $translator->translate('Never')]),
         ],
         [
            'id'    => 16,
            'title' => $translator->translate('Comments'),
            'type'  => 'textarea',
            'name'  => 'comment',
         ],
         // [
         //    'id'    => 80,
         //    'title' => $translator->translate('Entity'),
         //    'type'  => 'dropdown_remote',
         //    'name'  => 'completename',
         //    'itemtype' => '\App\Models\Entity',
         // ],

         /*
         $tab[] = [
            'id'                 => '9',
            'table'              => $this->getTable(),
            'field'              => '_virtual',
            'linkfield'          => '_virtual',
            'name'               => _n('Consumable', 'Consumables', Session::getPluralNumber()),
            'datatype'           => 'specific',
            'massiveaction'      => false,
            'nosearch'           => true,
            'nosort'             => true,
            'additionalfields'   => ['alarm_threshold']
         ];

         $tab[] = [
            'id'                 => '17',
            'table'              => 'glpi_consumables',
            'field'              => 'id',
            'name'               => __('Number of used consumables'),
            'datatype'           => 'count',
            'forcegroupby'       => true,
            'usehaving'          => true,
            'massiveaction'      => false,
            'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`date_out` IS NOT NULL'
            ]
         ];

         $tab[] = [
            'id'                 => '19',
            'table'              => 'glpi_consumables',
            'field'              => 'id',
            'name'               => __('Number of new consumables'),
            'datatype'           => 'count',
            'forcegroupby'       => true,
            'usehaving'          => true,
            'massiveaction'      => false,
            'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`date_out` IS NULL'
            ]
         ];

         $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());

         */
      ];
   }

   public static function getNumberArray($min, $max, $step = 1, $toadd = [], $unit = '')
   {
      global $translator;

      $tab = [];
      foreach (array_keys($toadd) as $key) {
         $tab[$key]['title'] = $toadd[$key];
      }

      for ($i = $min; $i <= $max; $i = $i + $step) {
         $tab[$i]['title'] = self::getValueWithUnit($i, $unit, 0);
      }

      return $tab;
   }

   public static function getValueWithUnit($value, $unit, $decimals = 0)
   {
      global $translator;

      $formatted_number = is_numeric($value)
         ? self::formatNumber($value, false, $decimals)
         : $value;

      if (strlen($unit) == 0) {
         return $formatted_number;
      }

      switch ($unit) {
         case 'year' :
            //TRANS: %s is a number of years
            return sprintf($translator->translatePlural('%s year', '%s years', $value), $formatted_number);

         case 'month' :
            //TRANS: %s is a number of months
            return sprintf($translator->translatePlural('%s month', '%s months', $value), $formatted_number);

         case 'day' :
            //TRANS: %s is a number of days
            return sprintf($translator->translatePlural('%s day', '%s days', $value), $formatted_number);

         case 'hour' :
            //TRANS: %s is a number of hours
            return sprintf($translator->translatePlural('%s hour', '%s hours', $value), $formatted_number);

         case 'minute' :
            //TRANS: %s is a number of minutes
            return sprintf($translator->translatePlural('%s minute', '%s minutes', $value), $formatted_number);

         case 'second' :
            //TRANS: %s is a number of seconds
            return sprintf($translator->translatePlural('%s second', '%s seconds', $value), $formatted_number);

         case 'millisecond' :
            //TRANS: %s is a number of milliseconds
            return sprintf($translator->translatePlural('%s millisecond', '%s milliseconds', $value), $formatted_number);

         case 'auto':
            return self::getSize($value*1024*1024);

         case '%' :
            return sprintf($translator->translate('%s%%'), $formatted_number);

         default :
            return sprintf($translator->translate('%1$s %2$s'), $formatted_number, $unit);
      }
   }

   public static function formatNumber($number, $edit = false, $forcedecimal = -1)
   {
      if (!(isset($_SESSION['glpinumber_format']))) $_SESSION['glpinumber_format']='';

      // Php 5.3 : number_format() expects parameter 1 to be double,
      if ($number == "") {
         $number = 0;
      } elseif ($number == "-") { // used for not defines value (from Infocom::Amort, p.e.)
         return "-";
      }

      $number  = doubleval($number);
      $decimal = 2;
      if ($forcedecimal>=0) {
         $decimal = $forcedecimal;
      }

      // Edit : clean display for mysql
      if ($edit) {
         return number_format($number, $decimal, '.', '');
      }

      // Display : clean display
      switch ($_SESSION['glpinumber_format']) {
         case 0 : // French
            return str_replace(' ', '&nbsp;', number_format($number, $decimal, '.', ' '));

         case 2 : // Other French
            return str_replace(' ', '&nbsp;', number_format($number, $decimal, ',', ' '));

         case 3 : // No space with dot
            return number_format($number, $decimal, '.', '');

         case 4 : // No space with comma
            return number_format($number, $decimal, ',', '');

         default: // English
            return number_format($number, $decimal, '.', ',');
      }
   }

   public static function getSize($size)
   {
      global $translator;

      //TRANS: list of unit (o for octet)
      $bytes = [$translator->translate('o'), $translator->translate('Kio'), $translator->translate('Mio'), $translator->translate('Gio'), $translator->translate('Tio')];
      foreach ($bytes as $val) {
         if ($size > 1024) {
            $size = $size / 1024;
         } else {
            break;
         }
      }
      //TRANS: %1$s is a number maybe float or string and %2$s the unit
      return sprintf($translator->translate('%1$s %2$s'), round($size, 2), $val);
   }

   public static function getRelatedPages($rootUrl)
   {
      global $translator;
      return [
         [
            'title' => $translator->translatePlural('Consumable', 'Consumables', 2),
            'icon' => 'caret square down outline',
            'link' => '',
         ],
         [
            'title' => $translator->translate('Management'),
            'icon' => 'caret square down outline',
            'link' => '',
         ],
         [
            'title' => $translator->translatePlural('Document', 'Documents', 2),
            'icon' => 'caret square down outline',
            'link' => '',
         ],
         [
            'title' => $translator->translatePlural('External link', 'External links', 2),
            'icon' => 'caret square down outline',
            'link' => '',
         ],
         [
            'title' => $translator->translatePlural('Note', 'Notes', 2),
            'icon' => 'caret square down outline',
            'link' => '',
         ],
         [
            'title' => $translator->translate('Historical'),
            'icon' => 'history',
            'link' => '',
         ],
      ];
   }
}
