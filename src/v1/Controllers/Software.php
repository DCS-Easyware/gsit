<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Software extends Common
{
  protected $model = '\App\Models\Software';

  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Software();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Software();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Software();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }
}
