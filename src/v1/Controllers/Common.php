<?php

namespace App\v1\Controllers;

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
      $url = str_replace('?' . $query, '', $url);
    }
    return $url;
  }

  protected function commonGetAll(Request $request, Response $response, $args, $item): Response
  {
    $params = $request->getQueryParams();
    $page = 1;

    $globalViewData = [
      'title'    => 'GSIT - ' . $item->getTitle(2),
      'menu'     => \App\v1\Controllers\Menu::getMenu($request),
      'rootpath' => \App\v1\Controllers\Toolbox::getRootPath($request),
    ];

    $renderer = new PhpRenderer(__DIR__ . '/../Views/', $globalViewData);
    $renderer->setLayout('layout.php');

    $search = new \App\v1\Controllers\Search();
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
      'title'    => 'GSIT - ' . $item->getTitle(1),
      'menu'     => \App\v1\Controllers\Menu::getMenu($request),
      'rootpath' => \App\v1\Controllers\Toolbox::getRootPath($request),
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
      'name'         => $item->getTitle(1),
      'fields'       => $item->getFormData($myItem),
      'relatedPages' => $item->getRelatedPages($this->getUrlWithoutQuery($request)),
      'icon'         => $item->getIcon(),
    ];

    return $renderer->render($response, 'genericForm.php', $viewData);
  }

  public function commonUpdateItem(Request $request, Response $response, $args, $item): Response
  {
    $data = (object) $request->getParsedBody();
    $myItem = $item->find($args['id']);

    // rewrite data with right database name (for dropdown mainly)
    $definitions = $item->getDefinitions();
    foreach ($definitions as $def)
    {
      echo "<br>";
      if (property_exists($data, $def['name']))
      {
        if (in_array($def['type'], ['input', 'textarea', 'dropdown']))
        {
          if ($myItem->{$def['name']} != $data->{$def['name']})
          {
            $myItem->{$def['name']} = $data->{$def['name']};
          }
        }
        elseif ($def['type'] == 'dropdown_remote')
        {
          if (isset($def['multiple']))
          {
            $values = $data->{$def['name']};
            if (!is_array($values))
            {
              if (empty($values))
              {
                $values = [];
              } else {
                $values = explode(',', $values);
              }
            }
            // save
            $myItem->{$def['name']}()->syncWithPivotValues($values, $def['pivot']);
          }
          elseif ($myItem->{$def['dbname']} != $data->{$def['name']})
          {
            $myItem->{$def['dbname']} = $data->{$def['name']};
          }
        }
      }
    }

    // update
    $myItem->save();

    // manage logs => manage it into model

    // post update

    // add message to session
    $session = new \SlimSession\Helper();
    $session->message = "The item has been updated correctly";

    $uri = $request->getUri();
    header('Location: ' . (string) $uri);
    exit();
  }

  protected function commonShowITILItem(Request $request, Response $response, $args, $item): Response
  {

    $globalViewData = [
      'title'    => 'GSIT - ' . $item->getTitle(1),
      'menu'     => \App\v1\Controllers\Menu::getMenu($request),
      'rootpath' => \App\v1\Controllers\Toolbox::getRootPath($request),
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
      'name'         => $item->getTitle(1),
      'fields'       => $item->getFormData($myItem),
      'feeds'        => $item->getFeeds($args['id']), //[
      'relatedPages' => $item->getRelatedPages($this->getUrlWithoutQuery($request)),
      'icon'         => $item->getIcon(),
      'color'        => $myItem->getColor(),
      'content'      => \App\v1\Controllers\Toolbox::convertMarkdownToHtml($myItem->content),
    ];
    return $renderer->render($response, 'ITILForm.php', $viewData);
  }
}
