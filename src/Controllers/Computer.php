<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class Computer extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

  public function showOperatingsystem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();

    $globalViewData = [
      'title'    => 'GSIT - ' . $item->getTitle(1),
      'menu'     => \App\Controllers\Menu::getMenu($request),
      'rootpath' => \App\Controllers\Toolbox::getRootPath($request),
    ];
    $session = new \SlimSession\Helper();

    if ($session->exists('message'))
    {
      $globalViewData['message'] = $session->message;
      $session->delete('message');
    }

    $renderer = new PhpRenderer(__DIR__ . '/../Views/', $globalViewData);
    $renderer->setLayout('layout.php');

    // return $renderer->render($response, 'empty.php', []);

    $myItem = $item->find($args['id']);

    // form data
    $viewData = [
      'name'         => $item->getTitle(1),
      'fields'       => [],
      'relatedPages' => $item->getRelatedPages($this->getUrlWithoutQuery($request)),
    ];
    return $renderer->render($response, 'genericForm.php', $viewData);
  }
}
