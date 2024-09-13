<?php

namespace App\Models\Definitions;

class State
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
        'name'  => 'state',
        'dbname' => 'states_id',
        'itemtype' => '\App\Models\State',
      ],
      [
        'id'    => 21,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Computer', 'Computers', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_computer',
      ],
      [
        'id'    => 23,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Monitor', 'Monitors', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_monitor',
      ],
      [
        'id'    => 27,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Network device', 'Network devices', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_networkequipment',
      ],
      [
        'id'    => 25,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Device', 'Devices', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_peripheral',
      ],
      [
        'id'    => 26,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Phone', 'Phones', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_phone',
      ],
      [
        'id'    => 24,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Printer', 'Printers', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_printer',
      ],
      [
        'id'    => 28,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('License', 'Licenses', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_softwarelicense',
      ],
      [
        'id'    => 29,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Certificate', 'Certificates', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_certificate',
      ],
      [
        'id'    => 32,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Enclosure', 'Enclosures', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_enclosure',
      ],
      [
        'id'    => 33,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('PDU', 'PDUs', 1)),
        'type'  => 'boolean',
        'name'  => 'is_visible_pdu',
      ],
      [
        'id'    => 31,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Line', 'Lines', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_line',
      ],
      [
        'id'    => 30,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Rack', 'Racks', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_rack',
      ],
      [
        'id'    => 22,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Version', 'Versions', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_softwareversion',
      ],
      [
        'id'    => 34,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Cluster', 'Clusters', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_cluster',
      ],
      [
        'id'    => 36,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Contract', 'Contract', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_contract',
      ],
      [
        'id'    => 37,
        'title' => sprintf($translator->translate('%1$s - %2$s'), $translator->translate('Visibility'), $translator->translatePlural('Appliance', 'Appliances', 2)),
        'type'  => 'boolean',
        'name'  => 'is_visible_appliance',
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
         'id'                 => '35',
         'table'              => $this->getTable(),
         'field'              => 'is_visible_passivedcequipment',
         'name'               => sprintf(__('%1$s - %2$s'), __('Visibility'),
                                     PassiveDCEquipment::getTypeName(Session::getPluralNumber())),
         'datatype'           => 'bool'
      ];



      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Status of items', 'Statuses of items', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Status of items', 'Statuses of items', 2),
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
