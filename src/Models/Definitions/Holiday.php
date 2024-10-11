<?php

namespace App\Models\Definitions;

class Holiday
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
        'id'    => 11,
        'title' => $translator->translate('Start'),
        'type'  => 'date',
        'name'  => 'begin_date',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('End'),
        'type'  => 'date',
        'name'  => 'end_date',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Recurrent'),
        'type'  => 'boolean',
        'name'  => 'is_perpetual',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
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

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Close time', 'Close times', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Time range', 'Time ranges', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Close time', 'Close times', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
