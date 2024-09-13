<?php

namespace App\Models\Definitions;

class Reminder
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Title'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'text',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Visibility start date'),
        'type'  => 'datetime',
        'name'  => 'begin_view_date',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Visibility end date'),
        'type'  => 'datetime',
        'name'  => 'end_view_date',
      ],
      [
        'id'    => 32,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown',
        'name'  => 'state',
        'dbname' => 'states_id',
        'values' => self::getStateArray(),
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Planning'),
        'type'  => 'boolean',
        'name'  => 'is_planned',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Planning start date'),
        'type'  => 'datetime',
        'name'  => 'begin',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Planning end date'),
        'type'  => 'datetime',
        'name'  => 'end',
      ],
      [
        'id'    => 2,
        'title' => $translator->translate('Writer'),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'users_id',
        'itemtype' => '\App\Models\User',
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
         'id'                 => 'common',
         'name'               => __('Characteristics')
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      */
    ];
  }

  public static function getStateArray()
  {
    global $translator;
    return [
      0 => [
        'title' => $translator->translatePlural('Information', 'Information', 1),
        'color' => 'gsitmajor',
        'icon'  => 'fire extinguisher',
      ],
      1 => [
        'title' => $translator->translate('To do'),
        'color' => 'gsitveryhigh',
        'icon'  => 'fire alternate',
      ],
      2 => [
        'title' => $translator->translate('Done'),
        'color' => 'gsithigh',
        'icon'  => 'fire',
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
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
