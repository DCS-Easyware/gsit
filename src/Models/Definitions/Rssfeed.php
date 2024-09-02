<?php

namespace App\Models\Definitions;

class Rssfeed
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
        'id'    => 2,
        'title' => $translator->translate('By'),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'users_id',
        'itemtype' => '\App\Models\User',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('URL'),
        'type'  => 'input',
        'name'  => 'url',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Error retrieving RSS feed'),
        'type'  => 'boolean',
        'name'  => 'have_error',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Number of items displayed'),
        'type'  => 'input',
        'name'  => 'max_items',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Refresh rate'),
        'type'  => 'input',
        'name'  => 'refresh_rate',
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


  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('RSS feed', 'RSS feed', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Content'),
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
