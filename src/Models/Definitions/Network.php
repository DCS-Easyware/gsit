<?php

namespace App\Models\Definitions;

class Network
{
  public static function getDefinition()
  {
    return [
      [
        'id'    => 1,
        'title' => 'Nom',
        'type'  => 'input',
        'name'  => 'name',
      ],
    ];
  }
}
