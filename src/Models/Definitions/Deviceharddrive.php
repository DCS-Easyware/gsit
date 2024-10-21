<?php

namespace App\Models\Definitions;

class Deviceharddrive
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
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturer_id',
        'itemtype' => '\App\Models\Manufacturer',
        'fillable' => true,
      ],
      [
        'id'    => 11,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translate('Capacity by default'),
          $translator->translate('Mio')
        ),
        'type'  => 'input',
        'name'  => 'capacity_default',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Rpm'),
        'type'  => 'input',
        'name'  => 'rpm',
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translate('Cache'),
          $translator->translate('Mio')
        ),
        'type'  => 'input',
        'name'  => 'cache',
        'fillable' => true,
      ],
      [
        'id'    => 15,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'deviceharddrivemodel_id',
        'itemtype' => '\App\Models\Deviceharddrivemodel',
        'fillable' => true,
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Interface'),
        'type'  => 'dropdown_remote',
        'name'  => 'interface',
        'dbname' => 'interfacetype_id',
        'itemtype' => '\App\Models\Interfacetype',
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
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Hard drive', 'Hard drives', 1),
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
