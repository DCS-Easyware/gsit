<?php

namespace App\v1\Controllers\Datastructures;

trait Header
{
  public function initHeaderData()
  {
    $this->header->title = '';
    $this->header->menu = [];
    $this->header->rootpath = '';
    $this->header->name = '';
    $this->header->id = null;
    $this->header->icon = 'vector square';
    $this->header->color = 'blue';
  }

  public function addHeaderTitle($title)
  {
    $this->header->title = $title;
  }

  public function addHeaderMenu($menu)
  {
    $this->header->menu = $menu;
  }

  public function addHeaderRootpath($rootpath)
  {
    $this->header->rootpath = $rootpath;
  }

  public function addHeaderName($name)
  {
    $this->header->name = $name;
  }

  public function addHeaderId($id)
  {
    $this->header->id = $id;
  }

  public function addIconId($icon)
  {
    $this->header->icon = $icon;
  }

  public function addCOlorId($color)
  {
    $this->header->color = $color;
  }
}
