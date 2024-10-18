<?php

namespace App\Models\Definitions\Forms;

class Section
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
        'id'    => 15,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date_creation',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Section', 'Sections', 2),
        'icon' => 'caret square down outline',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translatePlural('Question', 'Questions', 2),
        'icon' => 'caret square down outline',
        'link' => $rootUrl . '/questions',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
