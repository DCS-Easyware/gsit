<?php

namespace App\Models\Definitions;

class SoftwareLicense
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 10,
        'title' => $translator->translatePlural('Software', 'Softwares', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'software',
        'dbname' => 'softwares_id',
        'itemtype' => '\App\Models\Software',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
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
        'id'    => 11,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Number'),
        'type'  => 'dropdown',
        'name'  => 'number',
        'dbname'  => 'number',
        'values' => self::getNumberArray(1, 10000, 1, ['-1' => $translator->translate('Unlimited')], ''),
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'softwarelicensetype',
        'dbname' => 'softwarelicensetypes_id',
        'itemtype' => '\App\Models\SoftwareLicenseType',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Expiration'),
        'type'  => 'date',
        'name'  => 'expire',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Valid'),
        'type'  => 'boolean',
        'name'  => 'is_valid',
      ],
      [
        'id'    => 168,
        'title' => $translator->translate('Allow Over-Quota'),
        'type'  => 'boolean',
        'name'  => 'allow_overquota',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
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
         'id'    => 70,
         'title' => $translator->translatePlural('User', 'Users', 1),
         'type'  => 'dropdown_remote',
         'name'  => 'user',
         'dbname' => 'users_id',
         'itemtype' => '\App\Models\User',
       ],
       [
         'id'    => 71,
         'title' => $translator->translatePlural('Group', 'Groups', 1),
         'type'  => 'dropdown_remote',
         'name'  => 'group',
         'dbname' => 'groups_id',
         'itemtype' => '\App\Models\Group',
       ],
       [
         'id'    => 31,
         'title' => $translator->translate('Status'),
         'type'  => 'dropdown_remote',
         'name'  => 'state',
         'dbname' => 'states_id',
         'itemtype' => '\App\Models\State',
       ],
       // [
       //   'id'    => 61,
       //   'title' => $translator->translate('Template name'),
       //   'type'  => 'input',
       //   'name'  => 'template_name',
       // ],
       // [
       //   'id'    => 80,
       //   'title' => $translator->translate('Entity'),
       //   'type'  => 'dropdown_remote',
       //   'name'  => 'completename',
       //   'itemtype' => '\App\Models\Entity',
       // ],
      [
        'id'    => 162,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
      ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Purchase version'),
        'type'  => 'dropdown_remote',
        'name'  => 'softwareversions_buy',
        'dbname' => 'softwareversions_id_buy',
        'itemtype' => '\App\Models\SoftwareVersion',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Version in use'),
        'type'  => 'dropdown_remote',
        'name'  => 'softwareversions_use',
        'dbname' => 'softwareversions_id_use',
        'itemtype' => '\App\Models\SoftwareVersion',
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],



/*


      $tab[] = [
         'id'                 => '13',
         'table'              => $this->getTable(),
         'field'              => 'completename',
         'name'               => __('Father'),
         'datatype'           => 'itemlink',
         'forcegroupby'       => true,
         'joinparams'        => ['condition' => "AND 1=1"]
      ];



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

  public static function formatNumber($number, $edit = false, $forcedecimal = -1) {
     if (!(isset($_SESSION['glpinumber_format']))) $_SESSION['glpinumber_format']='';

     // Php 5.3 : number_format() expects parameter 1 to be double,
     if ($number == "") {
        $number = 0;

     } else if ($number == "-") { // used for not defines value (from Infocom::Amort, p.e.)
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
        'title' => $translator->translatePlural('License', 'Licenses', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('License', 'Licenses', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Summary'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Management'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Contract', 'Contract', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Knowledge base'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Ticket', 'Tickets', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Problem', 'Problems', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Change', 'Changes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
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
