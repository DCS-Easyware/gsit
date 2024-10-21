<?php

namespace App\Models\Definitions;

class Software
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
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'location_id',
        'itemtype' => '\App\Models\Location',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 62,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'softwarecategory_id',
        'itemtype' => '\App\Models\Softwarecategory',
        'fillable' => true,
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Publisher', 'Publishers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturer_id',
        'itemtype' => '\App\Models\Manufacturer',
        'fillable' => true,
      ],
      [
        'id'    => 24,
        'title' => $translator->translate('Technician in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'userstech',
        'dbname' => 'user_id_tech',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 49,
        'title' => $translator->translate('Group in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'groupstech',
        'dbname' => 'group_id_tech',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],
      [
        'id'    => 70,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 71,
        'title' => $translator->translatePlural('Group', 'Groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'group_id',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],
      [
        'id'    => 61,
        'title' => $translator->translate('Associable to a ticket'),
        'type'  => 'boolean',
        'name'  => 'is_helpdesk_visible',
        'fillable' => true,
      ],
      [
        'id'    => 63,
        'title' => $translator->translate('Valid licenses'),
        'type'  => 'boolean',
        'name'  => 'is_valid',
        'fillable' => true,
      ],
      // [
      //   'id'    => 64,
      //   'title' => $translator->translate('Template name'),
      //   'type'  => 'input',
      //   'name'  => 'template_name',
      // ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'updated_at',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'created_at',
        'readonly'  => 'readonly',
      ],


      /*
      $newtab = [
         'id'                 => '72',
         'table'              => 'glpi_items_softwareversions',
         'field'              => 'id',
         'name'               => _x('quantity', 'Number of installations'),
         'forcegroupby'       => true,
         'usehaving'          => true,
         'datatype'           => 'count',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'   => 'child',
            'beforejoin' => [
               'table'      => 'glpi_softwareversions',
               'joinparams' => ['jointype' => 'child'],
            ],
            'condition'  => "AND NEWTABLE.`is_deleted_item` = 0
                             AND NEWTABLE.`is_deleted` = 0
                             AND NEWTABLE.`is_template_item` = 0",
         ]
      ];

      if (Session::getLoginUserID())
      {
         $newtab['joinparams']['condition'] .= getEntitiesRestrictRequest(' AND', 'NEWTABLE');
      }
      $tab[] = $newtab;

      $tab[] = [
         'id'                 => '73',
         'table'              => 'glpi_items_softwareversions',
         'field'              => 'date_install',
         'name'               => __('Installation date'),
         'datatype'           => 'date',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'   => 'child',
            'beforejoin' => [
               'table'      => 'glpi_softwareversions',
               'joinparams' => ['jointype' => 'child'],
            ],
            'condition'  => "AND NEWTABLE.`is_deleted_item` = 0
                             AND NEWTABLE.`is_deleted` = 0
                             AND NEWTABLE.`is_template_item` = 0",
         ]
      ];

      $tab = array_merge($tab, Softwarelicense::rawSearchOptionsToAdd());

      $name = _n('Version', 'Versions', Session::getPluralNumber());
      $tab[] = [
         'id'                 => 'versions',
         'name'               => $name
      ];

      $tab[] = [
         'id'                 => '5',
         'table'              => 'glpi_softwareversions',
         'field'              => 'name',
         'name'               => __('Name'),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'displaywith'        => ['softwares_id'],
         'joinparams'         => [
            'jointype'           => 'child'
         ],
         'datatype'           => 'dropdown'
      ];

      $tab[] = [
         'id'                 => '31',
         'table'              => 'glpi_states',
         'field'              => 'completename',
         'name'               => __('Status'),
         'datatype'           => 'dropdown',
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_softwareversions',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ],
      ];

      $tab[] = [
         'id'                 => '170',
         'table'              => 'glpi_softwareversions',
         'field'              => 'comment',
         'name'               => __('Comments'),
         'forcegroupby'       => true,
         'datatype'           => 'text',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '4',
         'table'              => 'glpi_operatingsystems',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'name'               => OperatingSystem::getTypeName(1),
         'forcegroupby'       => true,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_softwareversions',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ],
      ];

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());
      $tab = array_merge($tab, Certificate::rawSearchOptionsToAdd());

*/



/*



      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 23,
        'title' => $translator->translate('Publisher'),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
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

      // [
      //   'id'    => 72,
      //   'title' => $translator->translate('Number of installations'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'nbinstallation',
      //   'itemtype' => '\App\Models\Softwareversion',
      //   'count' => 'devices_count',
      // ],
      // [
      //   'id'    => 5,
      //   'title' => $translator->translate('Versions'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'versions',
      //   'itemtype' => '\App\Models\Softwareversion',
      //   'multiple' => true,
      // ],

      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translate('Analysis impact'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Version', 'Versions', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('License', 'Licenses', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Installation', 'Installations', 2),
        'icon' => 'caret square down outline',
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
        'title' => $translator->translatePlural('Reservation', 'Reservations', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Domain', 'Domains', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Appliance', 'Appliances', 2),
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
