<?php

namespace App\Models\Definitions;

class News
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
        'id'    => 250,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'message',
      ],
      [
        'id'    => 255,
        'title' => $translator->translate('news' . "\004" . 'Type (to add an icon before alert title)'),
        'type'  => 'dropdown',
        'name'  => 'type',
        'dbname' => 'type',
        'values' => self::getTypeArray(),
      ],
      [
        'id'    => 2,
        'title' => $translator->translate('Visibility start date'),
        'type'  => 'date',
        'name'  => 'date_start',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Visibility end date'),
        'type'  => 'date',
        'name'  => 'date_end',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Recursive'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('news' . "\004" . 'Can close alert'),
        'type'  => 'boolean',
        'name'  => 'is_close_allowed',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('news' . "\004" . 'Show on login page'),
        'type'  => 'boolean',
        'name'  => 'is_displayed_onlogin',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('news' . "\004" . 'Show on helpdesk page'),
        'type'  => 'boolean',
        'name'  => 'is_displayed_onhelpdesk',
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
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
      // [
      //   'id'    => 4,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],

      /*
      $tab[] = [
        'id'               => 6,
        'table'            => PluginNewsAlert_Target::getTable(),
        'field'            => 'items_id',
        'name'             => PluginNewsAlert_Target::getTypename(),
        'datatype'         => 'specific',
        'forcegroupby'     => true,
        'joinparams'       => ['jointype' => 'child'],
        'additionalfields' => ['itemtype'],
      ];
      */
    ];
  }

  public static function getTypeArray()
  {
    global $translator;
    return [
      1 => [
        'title' => $translator->translate('news' . "\004" . 'General'),
      ],
      2 => [
        'title' => $translator->translate('news' . "\004" . 'Information'),
      ],
      3 => [
        'title' => $translator->translate('news' . "\004" . 'Warning'),
      ],
      4 => [
        'title' => $translator->translate('news' . "\004" . 'Problem'),
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Alert', 'Alerts', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Target', 'Targets', 2),
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
