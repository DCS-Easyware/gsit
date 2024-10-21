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
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'text',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Visibility start date'),
        'type'  => 'datetime',
        'name'  => 'begin_view_date',
        'fillable' => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Visibility end date'),
        'type'  => 'datetime',
        'name'  => 'end_view_date',
        'fillable' => true,
      ],
      [
        'id'    => 32,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown',
        'name'  => 'state',
        'dbname' => 'state_id',
        'values' => self::getStateArray(),
        'fillable' => true,
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Planning'),
        'type'  => 'boolean',
        'name'  => 'is_planned',
        'fillable' => true,
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Planning start date'),
        'type'  => 'datetime',
        'name'  => 'begin',
        'fillable' => true,
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Planning end date'),
        'type'  => 'datetime',
        'name'  => 'end',
        'fillable' => true,
      ],
      [
        'id'    => 2,
        'title' => $translator->translate('Writer'),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
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
