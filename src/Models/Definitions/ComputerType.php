<?php

namespace App\Models\Definitions;

class ComputerType
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
