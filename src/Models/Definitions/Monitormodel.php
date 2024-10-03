<?php

namespace App\Models\Definitions;

class Monitormodel
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
        'id'    => 130,
        'title' => $translator->translate('Product Number'),
        'type'  => 'input',
        'name'  => 'product_number',
      ],
      [
        'id'    => 131,
        'title' => $translator->translate('Weight'),
        'type'  => 'input',
        'name'  => 'weight',
      ],
      [
        'id'    => 132,
        'title' => $translator->translate('Required units'),
        'type'  => 'input',
        'name'  => 'required_units',
      ],
      [
        'id'    => 133,
        'title' => $translator->translate('Depth'),
        'type'  => 'input',
        'name'  => 'depth',
      ],
      [
        'id'    => 134,
        'title' => $translator->translate('Power connections'),
        'type'  => 'input',
        'name'  => 'power_connections',
      ],
      [
        'id'    => 135,
        'title' => $translator->translate('Power consumption'),
        'type'  => 'input',
        'name'  => 'power_consumption',
      ],
      [
        'id'    => 136,
        'title' => $translator->translate('Is half rack'),
        'type'  => 'boolean',
        'name'  => 'is_half_rack',
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
        'title' => $translator->translatePlural('Monitor model', 'Monitor models', 1),
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
