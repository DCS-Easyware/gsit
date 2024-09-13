<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class SoftwareLicense extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\SoftwareLicense();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\SoftwareLicense();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\SoftwareLicense();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }
}
