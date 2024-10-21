<?php

namespace App\Models\Definitions;

class Solutiontemplate
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
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Solution type', 'Solution type', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'types',
        'dbname' => 'solutiontype_id',
        'itemtype' => '\App\Models\Solutiontype',
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Content'),
        'type'  => 'textarea',
        'name'  => 'content',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      //  [
      //    'id'    => 80,
      //    'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //    'type'  => 'dropdown_remote',
      //    'name'  => 'completename',
      //    'itemtype' => '\App\Models\Entity',
      //  ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
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
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Solution template', 'Solution templates', 1),
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
