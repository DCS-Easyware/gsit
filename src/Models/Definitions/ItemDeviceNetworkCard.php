<?php

namespace App\Models\Definitions;

class ItemDeviceNetworkCard
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'designation',
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
        'id'    => 11,
        'title' => $translator->translate('MAC address by default'),
        'type'  => 'input',
        'name'  => 'mac_default',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Flow'),
        'type'  => 'input',
        'name'  => 'bandwidth',
      ],
      [
        'id'    => 13,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'devicenetworkcardmodels_id',
        'itemtype' => '\App\Models\ItemDeviceNetworkCardModel',
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
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Network card', 'Network cards', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
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
