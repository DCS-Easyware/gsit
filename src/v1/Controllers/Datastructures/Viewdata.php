<?php

namespace App\v1\Controllers\Datastructures;

class Viewdata
{
  use Header;
  use Translation;
  use Information;

  // Attributes
  public object $header;
  public object $data;
  public array $relatedPages;
  public object $translation;
  public object $information;
  public array $message;

  public function __construct()
  {
    $this->header = (object)[];
    $this->data = (object)[];
    $this->relatedPages = [];
    $this->translation = (object)[];
    $this->information = (object)[];
    $this->message = [];

    $this->initHeaderData();
    $this->initInformationData();
  }

  public function addData($key, $value)
  {
    $this->data->{$key} = $value;
  }

  public function addRelatedPages($data)
  {
    $this->relatedPages = $data;
  }

  public function addMessage($message)
  {
    $this->message[] = $message;
  }
}
