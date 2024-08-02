<?php

namespace App\Models\Definitions;


class State
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
