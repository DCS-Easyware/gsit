<?php

namespace App\v1\Controllers\Datastructures;

trait Information
{
  public function initInformationData()
  {
    $this->information->top = [];
    $this->information->bottom = [];
  }

  public function addInformation($type, $key, $value, $link)
  {
    $this->information->{$type}[$key] = ['value' => $value, 'link' => $link];
  }
}
