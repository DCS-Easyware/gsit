<?php

namespace App\Models\Definitions;

class Peripheralmodel
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
        'id'    => 130,
        'title' => $translator->translate('Product Number'),
        'type'  => 'input',
        'name'  => 'product_number',
        'fillable' => true,
      ],
      [
        'id'    => 131,
        'title' => $translator->translate('Weight'),
        'type'  => 'input',
        'name'  => 'weight',
        'fillable' => true,
      ],
      [
        'id'    => 132,
        'title' => $translator->translate('Required units'),
        'type'  => 'input',
        'name'  => 'required_units',
        'fillable' => true,
      ],
      [
        'id'    => 133,
        'title' => $translator->translate('Depth'),
        'type'  => 'input',
        'name'  => 'depth',
        'fillable' => true,
      ],
      [
        'id'    => 134,
        'title' => $translator->translate('Power connections'),
        'type'  => 'input',
        'name'  => 'power_connections',
        'fillable' => true,
      ],
      [
        'id'    => 135,
        'title' => $translator->translate('Power consumption'),
        'type'  => 'input',
        'name'  => 'power_consumption',
        'fillable' => true,
      ],
      [
        'id'    => 136,
        'title' => $translator->translate('Is half rack'),
        'type'  => 'boolean',
        'name'  => 'is_half_rack',
        'fillable' => true,
      ],
      // [
      //   'id'    => 137,
      //   'title' => $translator->translate('Front picture'),
      //   'type'  => 'file',
      //   'name'  => 'picture_front',
      // ],
      // [
      //   'id'    => 138,
      //   'title' => $translator->translate('Rear picture'),
      //   'type'  => 'file',
      //   'name'  => 'picture_rear',
      // ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
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
        'title' => $translator->translatePlural('Peripheral model', 'Peripheral models', 1),
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
