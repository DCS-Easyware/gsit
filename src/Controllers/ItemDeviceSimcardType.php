<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class ItemDeviceSimcardType extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceSimcardType();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceSimcardType();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceSimcardType();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

}
