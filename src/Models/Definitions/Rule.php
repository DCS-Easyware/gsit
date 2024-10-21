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
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Ranking'),
        'type'  => 'input',
        'name'  => 'ranking',
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'description',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Logical operator'),
        'type'  => 'input',
        'name'  => 'match',
        'fillable' => true,
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Active'),
        'type'  => 'input',
        'name'  => 'is_active',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Rule', 'Rules', 1),
        'icon' => 'home',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translatePlural('Criterion', 'Criteria', 2),
        'icon' => 'brain',
        'link' => $rootUrl . '/criteria',
      ],
      [
        'title' => $translator->translatePlural('Action', 'Actions', 2),
        'icon' => 'running',
        'link' => '', // $rootUrl . '/actions',
      ],
      [
        'title' => $translator->translate('Testing'),
        'icon' => 'vial',
        'link' => '', // $rootUrl . '/testing',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '', // $rootUrl . '/history',
      ],
    ];
  }
}
