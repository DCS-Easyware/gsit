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
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('As child of'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'state_id',
        'itemtype' => '\App\Models\State',
        'fillable' => true,
      ],
      [
        'id'    => 21,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Computer', 'Computers', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_computer',
        'fillable' => true,
      ],
      [
        'id'    => 23,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Monitor', 'Monitors', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_monitor',
        'fillable' => true,
      ],
      [
        'id'    => 27,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Network device', 'Network devices', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_networkequipment',
        'fillable' => true,
      ],
      [
        'id'    => 25,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Device', 'Devices', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_peripheral',
        'fillable' => true,
      ],
      [
        'id'    => 26,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Phone', 'Phones', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_phone',
        'fillable' => true,
      ],
      [
        'id'    => 24,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Printer', 'Printers', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_printer',
        'fillable' => true,
      ],
      [
        'id'    => 28,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('License', 'Licenses', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_softwarelicense',
        'fillable' => true,
      ],
      [
        'id'    => 29,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Certificate', 'Certificates', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_certificate',
        'fillable' => true,
      ],
      [
        'id'    => 32,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Enclosure', 'Enclosures', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_enclosure',
        'fillable' => true,
      ],
      [
        'id'    => 33,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('PDU', 'PDUs', 1)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_pdu',
        'fillable' => true,
      ],
      [
        'id'    => 31,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Line', 'Lines', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_line',
        'fillable' => true,
      ],
      [
        'id'    => 30,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Rack', 'Racks', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_rack',
        'fillable' => true,
      ],
      [
        'id'    => 22,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Version', 'Versions', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_softwareversion',
        'fillable' => true,
      ],
      [
        'id'    => 34,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Cluster', 'Clusters', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_cluster',
        'fillable' => true,
      ],
      [
        'id'    => 36,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Contract', 'Contract', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_contract',
        'fillable' => true,
      ],
      [
        'id'    => 37,
        'title' => sprintf(
          $translator->translate('%1$s - %2$s'),
          $translator->translate('Visibility'),
          $translator->translatePlural('Appliance', 'Appliances', 2)
        ),
        'type'  => 'boolean',
        'name'  => 'is_visible_appliance',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
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
        'fillable' => true,
      ],
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

  public static function getRelatedPages($rootUrl)
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
