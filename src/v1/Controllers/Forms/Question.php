<?php

namespace App\v1\Controllers\Forms;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class Question extends \App\v1\Controllers\Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Question();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Question();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Question();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }
}
