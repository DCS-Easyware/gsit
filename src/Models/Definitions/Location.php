<?php

namespace App\Models\Definitions;

class Location
{
  public static function getDefinition()
  {
    return [
      [
        'id'    => 14,
        'title' => 'Nom',
        'type'  => 'input',
        'name'  => 'name',
      ],
    ];
  }
}
