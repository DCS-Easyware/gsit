<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class Ticket extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Ticket();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Ticket();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Ticket();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

  /**
    * Compute Priority
    *
    * @param $urgency   integer from 1 to 5
    * @param $impact    integer from 1 to 5
    *
    * @return integer from 1 to 5 (priority)
   **/
  public static function computePriority($urgency, $impact)
  {
    $priority_matrix = \App\Models\Config::where('context', 'core')->where('name', 'priority_matrix')->first();
    if (!is_null($priority_matrix))
    {
      $matrix = json_decode($priority_matrix->value, true);
      if (isset($matrix[(int) $urgency][(int) $impact]))
      {
        return $matrix[(int) $urgency][(int) $impact];
      }
    }
    // Failback to trivial
    return round(($urgency + $impact) / 2);
  }
}
