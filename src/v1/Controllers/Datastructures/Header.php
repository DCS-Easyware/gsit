<?php

namespace App\v1\Controllers\Datastructures;

use Illuminate\Support\Pluralizer;

trait Header
{
  public function initHeaderData($item, $request)
  {
    $this->header->title = 'GSIT - ' . $item->getTitle(1);
    $this->header->menu = \App\v1\Controllers\Menu::getMenu($request);
    $this->header->rootpath = \App\v1\Controllers\Toolbox::getRootPath($request);
    $this->header->name = $item->getTitle(1);
    $this->header->id = null;
    $this->header->icon = 'vector square';
    $this->header->color = 'blue';
    $this->header->route = Pluralizer::plural(strtolower((new \ReflectionClass($item))->getShortName()));

    $this->addHeaderId($item->id);
    $this->addHeaderIcon($item->getIcon());
    if (property_exists($item, 'getColor'))
    {
      $this->addHeaderColor($item->getColor());
    }
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

  public function addHeaderIcon($icon)
  {
    $this->header->icon = $icon;
  }

  public function addHeaderColor($color)
  {
    $this->header->color = $color;
  }
}
