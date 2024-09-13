<?php

namespace App\Models\Definitions;

class SoftwareVersion
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
    ];
  }

  public static function getRelatedPages()
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
