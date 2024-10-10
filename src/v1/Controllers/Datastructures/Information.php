<?php

namespace App\v1\Controllers\Datastructures;

trait Information
{
  public function initInformationData()
  {
    $this->information->top = (object)[];
    $this->information->bottom = (object)[];
  }

  public function addInformation($type, $key, $value)
  {
    $this->information->{$type}->{$key} = $value;
  }
}
