<?php

namespace App\v1\Controllers\Datastructures;

trait Information
{
  public function initInformationData()
  {
    $this->information->top = [];
    $this->information->bottom = [];
  }

  /**
   * Add information into form
   *
   * @param $type string top|bottom
   * @param $key string unique key
   * @param $value string value to display (often translation)
   * @param $link string the link to the webpage, null to disable it
   */
  public function addInformation($type, $key, $value, $link)
  {
    $this->information->{$type}[$key] = ['value' => $value, 'link' => $link];
  }
}
