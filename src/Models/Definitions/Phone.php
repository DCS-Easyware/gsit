<?php

namespace App\Models\Definitions;

class Phone
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
        'id'    => 3,
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'locations_id',
        'itemtype' => '\App\Models\Location',
      ],
      [
        'id'    => 31,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'states_id',
        'itemtype' => '\App\Models\State',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'phonetypes_id',
        'itemtype' => '\App\Models\PhoneType',
      ],
      [
        'id'    => 40,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'phonemodels_id',
        'itemtype' => '\App\Models\PhoneModel',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
        'autocomplete'  => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
        'autocomplete'  => true,
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Alternate username'),
        'type'  => 'input',
        'name'  => 'contact',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Alternate username number'),
        'type'  => 'input',
        'name'  => 'contact_num',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Number of lines'),
        'type'  => 'input',
        'name'  => 'number_line',
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
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Brand'),
        'type'  => 'input',
        'name'  => 'brand',
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
        'id'    => 42,
        'title' => $translator->translatePlural('Power supply', 'Power supplies', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'phonepowersupply',
        'dbname' => 'phonepowersupplies_id',
        'itemtype' => '\App\Models\PhonePowerSupply',
      ],
      [
        'id'    => 43,
        'title' => $translator->translate('Headset'),
        'type'  => 'boolean',
        'name'  => 'have_headset',
      ],
      [
        'id'    => 44,
        'title' => $translator->translate('Speaker'),
        'type'  => 'boolean',
        'name'  => 'have_hp',
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
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date_creation',
        'readonly'  => 'readonly',
      ],

      /*
      $tab[] = [
        'id'                 => '32',
        'table'              => 'glpi_devicefirmwares',
        'field'              => 'version',
        'name'               => _n('Firmware', 'Firmware', 1),
        'forcegroupby'       => true,
        'usehaving'          => true,
        'massiveaction'      => false,
        'datatype'           => 'dropdown',
        'joinparams'         => [
        'beforejoin'         => [
        'table'              => 'glpi_items_devicefirmwares',
        'joinparams'         => [
        'jointype'           => 'itemtype_item',
        'specific_itemtype'  => 'Phone'
        ]
        ]
        ]
      ];

      $tab[] = [
        'id'                 => '82',
        'table'              => $this->getTable(),
        'field'              => 'is_global',
        'name'               => __('Global management'),
        'datatype'           => 'bool',
        'massiveaction'      => false
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
        'title' => $translator->translate('Analysis impact'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Operating system', 'Operating systems', 2),
        'icon' => 'laptop house',
        'link' => $rootUrl.'/operatingsystem',
      ],
      [
        'title' => $translator->translatePlural('Software', 'Softwares', 2),
        'icon' => 'cube',
        'link' => $rootUrl.'/softwares',
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
        'icon' => 'linkify',
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
