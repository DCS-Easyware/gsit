<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

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
    $view = Twig::fromRequest($request);

    $search = new \App\v1\Controllers\Search();
    $url = $this->getUrlWithoutQuery($request);
    if (isset($params['page']) && is_numeric($params['page']))
    {
      $page = (int) $params['page'];
    }

    $fields = $search->getData($item, $url, $page, $params);

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(2));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addIconId($item->getIcon());

    $viewData->addData('fields', $fields);

    $viewData->addData('definition', $item->getDefinitions());

    return $view->render($response, 'search.html.twig', (array)$viewData);
  }

  protected function commonShowItem(Request $request, Response $response, $args, $item): Response
  {
    global $translator;
    $view = Twig::fromRequest($request);

    $session = new \SlimSession\Helper();

    if ($session->exists('message'))
    {
      $globalViewData['message'] = $session->message;
      $session->delete('message');
    }

    $myItem = $item->find($args['id']);

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($this->getUrlWithoutQuery($request)));

    $viewData->addData('fields', $item->getFormData($myItem));

    $viewData->addTranslation('savebutton', $translator->translate('Save'));

    $viewData->addInformation('top', 'operatingsystem', $translator->translatePlural('Operating system', 'Operating systems', 1), $this->getUrlWithoutQuery($request) . '/operatingsystem');
    $viewData->addInformation('top', 'softwares', $translator->translatePlural('Software', 'Software', 2), $this->getUrlWithoutQuery($request) . '/softwares');
    $viewData->addInformation('bottom', '1', 'Operating system : Windows 11 pro', 'free.fr');

    return $view->render($response, 'genericForm.html.twig', (array)$viewData);
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
    global $translator;
    $view = Twig::fromRequest($request);

    $session = new \SlimSession\Helper();

    // Load the item
    // $item->loadId($args['id']);
    $myItem = $item->find($args['id']);

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());
    $viewData->addColorId($myItem->getColor());

    $viewData->addRelatedPages($item->getRelatedPages($this->getUrlWithoutQuery($request)));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('feeds', $item->getFeeds($args['id']));
    $viewData->addData('content', \App\v1\Controllers\Toolbox::convertMarkdownToHtml($myItem->content));

    $viewData->addTranslation('description', $translator->translate('Description'));
    $viewData->addTranslation('feeds', $translator->translate('Feeds'));
    $viewData->addTranslation('followup', $translator->translatePlural('Followup', 'Followups', 1));
    $viewData->addTranslation('solution', $translator->translatePlural('Solution', 'Solutions', 1));
    $viewData->addTranslation('template', $translator->translatePlural('Template', 'Templates', 1));
    $viewData->addTranslation('private', $translator->translate('Private'));
    $viewData->addTranslation('sourcefollow', $translator->translate('Source of followup'));
    $viewData->addTranslation('category', $translator->translatePlural('Category', 'Categories', 1));
    $viewData->addTranslation('status', $translator->translate('Status'));
    $viewData->addTranslation('duration', $translator->translate('Duration'));
    $viewData->addTranslation('seconds', $translator->translatePlural('Second', 'Seconds', 2));
    $viewData->addTranslation('minutes', $translator->translatePlural('Minute', 'Minutes', 2));
    $viewData->addTranslation('hours', $translator->translatePlural('Hour', 'Hours', 2));
    $viewData->addTranslation('user', $translator->translatePlural('User', 'Users', 1));
    $viewData->addTranslation('group', $translator->translatePlural('Group', 'Groups', 1));
    $viewData->addTranslation('addfollowup', $translator->translate('Add followup'));
    $viewData->addTranslation('timespent', $translator->translate('Time spent'));
    $viewData->addTranslation('savebutton', $translator->translate('Save'));
    $viewData->addTranslation('selectvalue', $translator->translate('Select value...'));
    $viewData->addTranslation('yes', $translator->translate('Yes'));
    $viewData->addTranslation('no', $translator->translate('No'));

    if ($session->exists('message'))
    {
      $viewData->addMessage($session->message);
      // $session->delete('message');
    }

    return $view->render($response, 'ITILForm.html.twig', (array)$viewData);
  }
}
