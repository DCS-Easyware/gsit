<?php

namespace App\v1\Controllers\Rules;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class Ticket extends Common
{
  protected $use_output_rule_process_as_next_input = true;
  protected $criteriaDefinitionModel = '\App\v1\Controllers\Rules\Criteria\Ticket';
  protected $actionsDefinitionModel = '\App\v1\Controllers\Rules\Actions\Ticket';


  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Rules\Ticket();
    return $this->commonGetAll($request, $response, $args, $item);
  }
}
