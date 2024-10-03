<?php

namespace App\Models\Definitions;

class Location
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 14,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('As child of'),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'locations_id',
        'itemtype' => '\App\Models\Location',
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Address'),
        'type'  => 'input',
        'name'  => 'address',
      ],
      [
        'id'    => 17,
        'title' => $translator->translate('Postal code'),
        'type'  => 'input',
        'name'  => 'postcode',
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('Town'),
        'type'  => 'input',
        'name'  => 'town',
      ],
      [
        'id'    => 104,
        'title' => $translator->translate('location' . "\004" . 'State'),
        'type'  => 'input',
        'name'  => 'state',
      ],
      [
        'id'    => 105,
        'title' => $translator->translate('Country'),
        'type'  => 'input',
        'name'  => 'country',
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Building number'),
        'type'  => 'input',
        'name'  => 'building',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Room number'),
        'type'  => 'input',
        'name'  => 'room',
      ],
      [
        'id'    => 21,
        'title' => $translator->translate('Latitude'),
        'type'  => 'input',
        'name'  => 'latitude',
      ],
      [
        'id'    => 20,
        'title' => $translator->translate('Longitude'),
        'type'  => 'input',
        'name'  => 'longitude',
      ],
      [
        'id'    => 22,
        'title' => $translator->translate('Altitude'),
        'type'  => 'input',
        'name'  => 'altitude',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
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
      $tab = [];

      $tab[] = [
        'id'   => 'common',
        'name' => __('Characteristics')
      ];

      $tab[] = [
        'id'                => '1',
        'table'              => $this->getTable(),
        'field'              => 'completename',
        'name'               => __('Complete name'),
        'datatype'           => 'itemlink',
        'massiveaction'      => false
      ];

      $tab[] = [
        'id'                => '2',
        'table'              => $this->getTable(),
        'field'              => 'id',
        'name'               => __('ID'),
        'massiveaction'      => false,
        'datatype'           => 'number'
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab[] = [
        'id'                 => '101',
        'table'              => 'glpi_locations',
        'field'              => 'address',
        'name'               => __('Address'),
        'datatype'           => 'string',
        'autocomplete'       => true,
      ];

      $tab[] = [
        'id'                 => '102',
        'table'              => 'glpi_locations',
        'field'              => 'postcode',
        'name'               => __('Postal code'),
        'datatype'           => 'string',
        'autocomplete'       => true,
      ];

      $tab[] = [
        'id'                 => '103',
        'table'              => 'glpi_locations',
        'field'              => 'town',
        'name'               => __('Town'),
        'datatype'           => 'string',
        'autocomplete'       => true,
      ];
      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Location', 'Locations', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Network outlet', 'Network outlets', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
