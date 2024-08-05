<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class Common
{

  protected function getUrlWithoutQuery(Request $request)
  {
    $uri = $request->getUri();
    $query = $uri->getQuery();
    $url = (string) $uri;
    if (!empty($query))
    {
      $url = str_replace('?'.$query, '', $url);
    }
    return $url;
  }

  protected function commonGetAll(Request $request, Response $response, $args, $item): Response
  {
    $params = $request->getQueryParams();
    $page = 1;

    $globalViewData = [
      'title' => 'GSIT - ' . $item->getTitle(2),
      'menu'  => \App\Controllers\Menu::getMenu($request)
    ];

    $renderer = new PhpRenderer(__DIR__ . '/../Views/', $globalViewData);
    $renderer->setLayout('layout.php');
    
    $search = new \App\Controllers\Search();
    $url = $this->getUrlWithoutQuery($request);
    if (isset($params['page']) && is_numeric($params['page']))
    {
      $page = (int) $params['page'];
    }

    $viewData = $search->getData($item, $url, $page, $params);
    $headers = [
      'title' => $item->getTitle(2),
      'icon'  => $item->getIcon(),
    ];

    $renderData = [
      'fields' => $viewData,
      'headers' => [
        'title' => $item->getTitle(2),
        'icon'  => $item->getIcon(),
      ],
      'definition' => $item->getDefinitions(),
    ];
    return $renderer->render($response, 'search.php', $renderData);
  }

  protected function commonShowItem(Request $request, Response $response, $args, $item): Response
  {

    $globalViewData = [
      'title' => 'GSIT - ' . $item->getTitle(1),
      'menu'  => \App\Controllers\Menu::getMenu($request)
    ];
    $session = new \SlimSession\Helper();

    if ($session->exists('message'))
    {
      $globalViewData['message'] = $session->message;
      $session->delete('message');
    }

    $renderer = new PhpRenderer(__DIR__ . '/../Views/', $globalViewData);
    $renderer->setLayout('layout.php');

    // Load the item
    // $item->loadId($args['id']);
    $myItem = $item->find($args['id']);


    // form data
    $viewData = [
      'name' => $item->getTitle(2),
      'fields' => $item->getFormData($myItem)
    ];
    return $renderer->render($response, 'genericForm.php', $viewData);
  }
}