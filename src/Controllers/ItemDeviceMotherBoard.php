<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class ItemDeviceMotherBoard extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceMotherBoard();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceMotherBoard();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\ItemDeviceMotherBoard();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }
}
