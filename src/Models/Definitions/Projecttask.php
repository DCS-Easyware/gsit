<?php

namespace App\Models\Definitions;

class Projecttask
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
      // [
      //   'id'    => 16,
      //   'title' => $translator->translate('Comments'),
      //   'type'  => 'textarea',
      //   'name'  => 'comment',
      // ],
      // [
      //    'id'    => 19,
      //    'title' => $translator->translate('Last update'),
      //    'type'  => 'datetime',
      //    'name'  => 'updated_at',
      //    'readonly'  => 'readonly',
      // ],
      // [
      //    'id'    => 121,
      //    'title' => $translator->translate('Creation date'),
      //    'type'  => 'datetime',
      //    'name'  => 'created_at',
      //    'readonly'  => 'readonly',
      // ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      // [
      //   'title' => $translator->translatePlural('Project tasks type', 'Project tasks types', 1),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
      // [
      //   'title' => $translator->translate('Historical'),
      //   'icon' => 'history',
      //   'link' => '',
      // ],
    ];
  }
}
