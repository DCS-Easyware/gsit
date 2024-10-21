<?php

namespace App\Models\Definitions;

class Devicebattery
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
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturer_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],
      [
        'id'    => 13,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'devicebatterytype_id',
        'itemtype' => '\App\Models\Devicebatterytype',
        'fillable' => true,
      ],
      [
        'id'    => 11,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translate('Capacity'),
          $translator->translate('mWh')
        ),
        'type'  => 'input',
        'name'  => 'capacity',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translate('Voltage'),
          $translator->translate('mV')
        ),
        'type'  => 'input',
        'name'  => 'voltage',
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
      // 'id'    => 80,
      // 'title' => $translator->translatePlural('Entity', 'Entities', 1),
      // 'type'  => 'dropdown_remote',
      // 'name'  => 'completename',
      // 'itemtype' => '\App\Models\Entity',
      ],
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
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Battery', 'Batteries', 1),
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
