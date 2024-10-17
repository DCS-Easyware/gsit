<?php

namespace App\v1\Controllers\Rules;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
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

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Rules\Ticket();
    $view = Twig::fromRequest($request);

    // Load the item
    $myItem = $item->find($args['id']);

    $rootUrl = $this->getUrlWithoutQuery($request);

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addHeaderColor('red');

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));

    return $view->render($response, 'genericForm.html.twig', (array)$viewData);
  }

  public function showCriteria(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Rules\Ticket();
    $view = Twig::fromRequest($request);

    // Load the item
    $myItem = $item->find($args['id']);

    $rulecriteria = \App\Models\Rules\Rulecriterium::
        where('rule_id', $myItem->id)
      ->get();

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/criteria');

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addHeaderColor('red');

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('criteria', $rulecriteria);

    $viewData->addData('model', 'Ticket');

    return $view->render($response, 'subitem/rulecriteria.html.twig', (array)$viewData);
  }
}
