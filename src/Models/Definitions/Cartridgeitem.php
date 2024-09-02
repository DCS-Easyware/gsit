<?php

namespace App\Models\Definitions;

class Cartridgeitem
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
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'cartridgeitemtypes_id',
        'itemtype' => '\App\Models\Cartridgeitemtype',
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
         'id'    => 16,
         'title' => $translator->translate('Comments'),
         'type'  => 'textarea',
         'name'  => 'comment',
       ],
       // [
       //   'id'    => 80,
       //   'title' => $translator->translate('Entity'),
       //   'type'  => 'dropdown_remote',
       //   'name'  => 'completename',
       //   'itemtype' => '\App\Models\Entity',
       // ],
       [
        'id'    => 34,
        'title' => $translator->translate('Reference'),
        'type'  => 'input',
        'name'  => 'ref',
      ],


      /*

      $tab[] = [
         'id'                 => '9',
         'table'              => $this->getTable(),
         'field'              => '_virtual',
         'name'               => _n('Cartridge', 'Cartridges', Session::getPluralNumber()),
         'datatype'           => 'specific',
         'massiveaction'      => false,
         'nosearch'           => true,
         'nosort'             => true,
         'additionalfields'   => ['alarm_threshold']
      ];

      $tab[] = [
         'id'                 => '17',
         'table'              => 'glpi_cartridges',
         'field'              => 'id',
         'name'               => __('Number of used cartridges'),
         'datatype'           => 'count',
         'forcegroupby'       => true,
         'usehaving'          => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`date_use` IS NOT NULL
                                     AND NEWTABLE.`date_out` IS NULL'
         ]
      ];

      $tab[] = [
         'id'                 => '18',
         'table'              => 'glpi_cartridges',
         'field'              => 'id',
         'name'               => __('Number of worn cartridges'),
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
         'table'              => 'glpi_cartridges',
         'field'              => 'id',
         'name'               => __('Number of new cartridges'),
         'datatype'           => 'count',
         'forcegroupby'       => true,
         'usehaving'          => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`date_use` IS NULL
                                     AND NEWTABLE.`date_out` IS NULL'
         ]
      ];

      $tab[] = [
         'id'                 => '8',
         'table'              => $this->getTable(),
         'field'              => 'alarm_threshold',
         'name'               => __('Alert threshold'),
         'datatype'           => 'number',
         'toadd'              => [
            '-1'                 => 'Never'
         ]
      ];

      $tab[] = [
         'id'                 => '40',
         'table'              => 'glpi_printermodels',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'name'               => _n('Printer model', 'Printer models', Session::getPluralNumber()),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_cartridgeitems_printermodels',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ]
      ];

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());


      */
    ];
  }


  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('Cartridge', 'Cartridges', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Printer model', 'Printer models', 2),
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
