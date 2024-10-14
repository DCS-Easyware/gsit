<?php

namespace App\v1\Controllers\Datastructures;

trait Translation
{
  public function addTranslation($key, $value)
  {
    $this->translation->{$key} = $value;
  }
}
