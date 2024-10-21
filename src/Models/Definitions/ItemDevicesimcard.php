<?php

namespace App\Models\Definitions;

class ItemDevicesimcard
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 10,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'location_id',
        'itemtype' => '\App\Models\Location',
        'fillable' => true,
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'state_id',
        'itemtype' => '\App\Models\State',
        'fillable' => true,
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('PIN code'),
        'type'  => 'input',
        'name'  => 'pin',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('PIN2 code'),
        'type'  => 'input',
        'name'  => 'pin2',
        'fillable' => true,
      ],
      [
        'id'    => 17,
        'title' => $translator->translate('PUK code'),
        'type'  => 'input',
        'name'  => 'puk',
        'fillable' => true,
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('PUK2 code'),
        'type'  => 'input',
        'name'  => 'puk2',
        'fillable' => true,
      ],
      [
        'id'    => 20,
        'title' => $translator->translate('Mobile Subscriber Identification Number'),
        'type'  => 'input',
        'name'  => 'msin',
        'fillable' => true,
      ],
      [
        'id'    => 21,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 22,
        'title' => $translator->translatePlural('Group', 'Groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'group_id',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],

      /*
        'lines_id'        => ['long name'  => Line::getTypeName(1),
        'short name' => Line::getTypeName(1),
        'size'       => 20,
        'id'         => 19,
        'datatype'   => 'dropdown'],
      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translate('Management'),
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
      [
        'title' => $translator->translatePlural('Contract', 'Contract', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
