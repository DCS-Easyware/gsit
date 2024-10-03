<?php

namespace App\Models\Definitions;

class Fieldunicity
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
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown',
        'name'  => 'itemtype',
        'dbname'  => 'itemtype',
        'values' => self::getTypeArray(),
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Record into the database denied'),
        'type'  => 'boolean',
        'name'  => 'action_refuse',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Send a notification'),
        'type'  => 'boolean',
        'name'  => 'action_notify',
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
      $tab[] = [
        'id'                 => '3',
        'table'              => $this->getTable(),
        'field'              => 'fields',
        'name'               => __('Unique fields'),
        'massiveaction'      => false,
        'datatype'           => 'specific',
        'additionalfields'   => ['itemtype']
      ];
      */
    ];
  }

  public static function getTypeArray()
  {
    global $translator;

    $types = [];
    $types['Budget'] = $translator->translatePlural('Budget', 'Budgets', 1);
    $types['Computer'] = $translator->translatePlural('Computer', 'Computers', 1);
    $types['Contact'] = $translator->translatePlural('Contact', 'Contacts', 1);
    $types['Contract'] = $translator->translatePlural('Contract', 'Contracts', 1);
    $types['Monitor'] = $translator->translatePlural('Monitor', 'Monitors', 1);
    $types['Networkequipment'] = $translator->translatePlural('Network device', 'Network devices', 1);
    $types['Peripheral'] = $translator->translatePlural('Device', 'Devices', 1);
    $types['Infocom'] = $translator->translate('Financial and administrative information');
    $types['Phone'] = $translator->translatePlural('Phone', 'Phones', 1);
    $types['Printer'] = $translator->translatePlural('Printer', 'Printers', 1);
    $types['Software'] = $translator->translatePlural('Software', 'Software', 1);
    $types['Supplier'] = $translator->translatePlural('Supplier', 'Suppliers', 1);
    $types['Rack'] = $translator->translatePlural('Rack', 'Racks', 1);
    $types['Enclosure'] = $translator->translatePlural('Enclosure', 'Enclosures', 1);
    $types['PDU'] = $translator->translatePlural('PDU', 'PDUs', 1);
    $types['SoftwareLicense'] = $translator->translatePlural('License', 'Licenses', 1);
    $types['Cluster'] = $translator->translatePlural('Cluster', 'Clusters', 1);
    $types['User'] = $translator->translatePlural('User', 'Users', 1);
    $types['ItemDeviceSimcard'] = $translator->translatePlural('Simcard', 'Simcards', 1);
    $types['Certificate'] = $translator->translatePlural('Certificate', 'Certificates', 1);

    asort($types);

    $newTypes = [];
    foreach (array_keys($types) as $key)
    {
      $newTypes[$key]['title'] = $types[$key];
    }

    return $newTypes;
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translate('Fields unicity'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Duplicates'),
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
