<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
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

  public function showOperatingSystem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();

    // $globalViewData = [
    //   'title'    => 'GSIT - ' . $item->getTitle(1),
    //   'menu'     => \App\v1\Controllers\Menu::getMenu($request),
    //   'rootpath' => \App\v1\Controllers\Toolbox::getRootPath($request),
    // ];
    // $session = new \SlimSession\Helper();

    // if ($session->exists('message'))
    // {
    //   $globalViewData['message'] = $session->message;
    //   $session->delete('message');
    // }

    // $renderer = new PhpRenderer(__DIR__ . '/../Views/', $globalViewData);
    // $renderer->setLayout('layout.php');


    // $myItem = $item->find($args['id']);

    // // form data
    // $viewData = [
    //   'name'         => $item->getTitle(1),
    //   'fields'       => [],
    //   'relatedPages' => $item->getRelatedPages($this->getUrlWithoutQuery($request)),
    // ];
    // return $renderer->render($response, 'genericForm.php', $viewData);
  }

  public function showSoftwares(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('softwareversions.software:id,name')->find($args['id']);

    $softwares = [];
    foreach ($myItem->softwareversions as $softwareversion)
    {
      $softwares[] = [
        'id' => $softwareversion->id,
        'name' => $softwareversion->name,
        'software' => [
          'id' => $softwareversion->software->id,
          'name' => $softwareversion->software->name,
        ]
      ];
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/softwares');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('softwares', $softwares);

    return $view->render($response, 'subitem/softwares.html.twig', (array)$viewData);
  }
}
