<?php

namespace App\Models\Definitions;

class Printer
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
        'id'    => 31,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'state_id',
        'itemtype' => '\App\Models\State',
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'printertype_id',
        'itemtype' => '\App\Models\Printertype',
        'fillable' => true,
      ],
      [
        'id'    => 40,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'printermodel_id',
        'itemtype' => '\App\Models\Printermodel',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
        'autocomplete'  => true,
        'fillable' => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
        'autocomplete'  => true,
        'fillable' => true,
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Alternate username'),
        'type'  => 'input',
        'name'  => 'contact',
        'fillable' => true,
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Alternate username number'),
        'type'  => 'input',
        'name'  => 'contact_num',
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
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 42,
        'title' => $translator->translate('Serial'),
        'type'  => 'boolean',
        'name'  => 'have_serial',
        'fillable' => true,
      ],
      [
        'id'    => 43,
        'title' => $translator->translate('Parallel'),
        'type'  => 'boolean',
        'name'  => 'have_parallel',
        'fillable' => true,
      ],
      [
        'id'    => 44,
        'title' => $translator->translate('USB'),
        'type'  => 'boolean',
        'name'  => 'have_usb',
        'fillable' => true,
      ],
      [
        'id'    => 45,
        'title' => $translator->translate('Ethernet'),
        'type'  => 'boolean',
        'name'  => 'have_ethernet',
        'fillable' => true,
      ],
      [
        'id'    => 46,
        'title' => $translator->translate('Wifi'),
        'type'  => 'boolean',
        'name'  => 'have_wifi',
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => $translator->translatePlural('Memory', 'Memories', 1),
        'type'  => 'input',
        'name'  => 'memory_size',
        'fillable' => true,
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Initial page counter'),
        'type'  => 'input',
        'name'  => 'init_pages_counter',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Current counter of pages'),
        'type'  => 'input',
        'name'  => 'last_pages_counter',
        'fillable' => true,
      ],
      [
        'id'    => 32,
        'title' => $translator->translate('Network', 'Networks', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'network',
        'dbname' => 'network_id',
        'itemtype' => '\App\Models\Network',
        'fillable' => true,
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
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
      // [
      //   'id'    => 61,
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
      $tab[] = [
        'id'                 => '9',
        'table'              => $this->getTable(),
        'field'              => '_virtual',
        'linkfield'          => '_virtual',
        'name'               => _n('Cartridge', 'Cartridges', Session::getPluralNumber()),
        'datatype'           => 'specific',
        'massiveaction'      => false,
        'nosearch'           => true,
        'nosort'             => true
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

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());

      $tab = array_merge($tab, Item_Devices::rawSearchOptionsToAdd(get_class($this)));
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
        'title' => $translator->translatePlural('Operating system', 'Operating systems', 2),
        'icon' => 'laptop house',
        'link' => $rootUrl . '/operatingsystem',
      ],
      [
        'title' => $translator->translatePlural('Software', 'Softwares', 2),
        'icon' => 'cube',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Cartridge', 'Cartridges', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Component', 'Components', 2),
        'icon' => 'microchip',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Volume', 'Volumes', 2),
        'icon' => 'hdd',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Connection', 'Connections', 2),
        'icon' => 'microchip',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Network port', 'Network ports', 2),
        'icon' => 'ethernet',
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
        'title' => $translator->translatePlural('Reservation', 'Reservations', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
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
