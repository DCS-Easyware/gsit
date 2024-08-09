<?php

namespace App\Models\Definitions;

class Rule
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
        'id'    => 3,
        'title' => $translator->translate('Ranking'),
        'type'  => 'input',
        'name'  => 'ranking',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'description',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Logical operator'),
        'type'  => 'input',
        'name'  => 'match',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Active'),
        'type'  => 'input',
        'name'  => 'is_active',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
    ];
  }
}
