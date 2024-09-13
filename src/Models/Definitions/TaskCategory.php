<?php

namespace App\Models\Definitions;

class TaskCategory
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 14,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('As child of'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'taskcategories_id',
        'itemtype' => '\App\Models\TaskCategory',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
       [
         'id'    => 79,
         'title' => $translator->translate('Knowledge base'),
         'type'  => 'dropdown_remote',
         'name'  => 'knowbaseitemcategories',
         'dbname' => 'knowbaseitemcategories_id',
         'itemtype' => '\App\Models\KnowbaseItemCategory',
       ],
       //  [
       //    'id'    => 80,
       //    'title' => $translator->translate('Entity'),
       //    'type'  => 'dropdown_remote',
       //    'name'  => 'completename',
       //    'itemtype' => '\App\Models\Entity',
       //  ],
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
        'title' => $translator->translatePlural('Task category', 'Task categories', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Task category', 'Task categories', 2),
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
