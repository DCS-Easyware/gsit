<?php

namespace App\Models\Definitions;

class Savedsearch
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Visibility'),
        'type'  => 'dropdown',
        'name'  => 'is_private',
        'dbname' => 'is_private',
        'values' => self::getVisibilityArray(),
        'fillable' => true,
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Do count'),
        'type'  => 'dropdown',
        'name'  => 'do_count',
        'dbname' => 'do_count',
        'values' => self::getCountArray(),
        'fillable' => true,
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Last duration (ms)'),
        'type'  => 'input',
        'name'  => 'last_execution_time',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Last execution date'),
        'type'  => 'datetime',
        'name'  => 'last_execution_date',
        'readonly'  => 'readonly',
      ],

      /*





      $tab = [];

      $tab[] = ['id'                 => 'common',
                'name'               => __('Characteristics')
               ];


      $tab[] = ['id'                 => '2',
                'table'              => $this->getTable(),
                'field'              => 'id',
                'name'               => __('ID'),
                'massiveaction'      => false, // implicit field is id
                'datatype'           => 'number'
               ];


      $tab[] = ['id'                 => '8',
                'table'              => $this->getTable(),
                'field'              => 'itemtype',
                'name'               => __('Item type'),
                'massiveaction'      => false,
                'datatype'           => 'itemtypename',
                'types'              => self::getUsedItemtypes()
               ];
      $tab[] = [
         'id'            => 11,
         'table'         => SavedSearch_User::getTable(),
         'field'         => 'users_id',
         'name'          => __('Default'),
         'massiveaction' => false,
         'joinparams'    => [
            'jointype'  => 'child',
            'condition' => "AND NEWTABLE.users_id = " . Session::getLoginUserID()
         ],
         'datatype'      => 'specific',
         'searchtype'    => [
            0 => 'equals',
            1 => 'notequals'
         ],
      ];

      $tab[] = ['id'                 => 12,
                'table'              => $this->getTable(),
                'field'              => 'counter',
                'name'               => __('Counter'),
                'massiveaction'      => false,
                'datatype'           => 'number'
               ];

      */
    ];
  }

  public static function getVisibilityArray()
  {
    global $translator;
    return [
      1 => [
        'title' => $translator->translate('Private'),
      ],
      0 => [
        'title' => $translator->translate('Public'),
      ],
    ];
  }

  public static function getCountArray()
  {
    global $translator;
    return [
      2 => [
        'title' => $translator->translate('Auto'),
      ],
      1 => [
        'title' => $translator->translate('Yes'),
      ],
      0 => [
        'title' => $translator->translate('No'),
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Saved search', 'Saved searches', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Saved search alert', 'Saved searches alerts', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
