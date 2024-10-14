<?php

namespace App\Models\Definitions;

class FormCategory
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
        'id'    => 4,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      // [
      //   'title' => $translator->translate('Historical'),
      //   'icon' => 'history',
      //   'link' => '',
      // ],
    ];
  }
}
