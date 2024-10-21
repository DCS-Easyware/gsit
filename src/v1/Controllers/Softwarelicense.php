<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Softwarelicense extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Softwarelicense();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Softwarelicense();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Softwarelicense();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }
}
