<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class Common
{
  protected $model = '';

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

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($item, $request);
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(2));

    $viewData->addData('fields', $fields);

    $viewData->addData('definition', $item->getDefinitions());

    return $view->render($response, 'search.html.twig', (array)$viewData);
  }

  protected function commonShowItem(Request $request, Response $response, $args, $item): Response
  {
    global $translator;
    $view = Twig::fromRequest($request);
    $session = new \SlimSession\Helper();

    $myItem = $item->find($args['id']);

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addRelatedPages($item->getRelatedPages($this->getUrlWithoutQuery($request)));

    $viewData->addData('fields', $item->getFormData($myItem));

    $viewData->addTranslation('savebutton', $translator->translate('Save'));
    $viewData->addTranslation('selectvalue', $translator->translate('Select a value...'));

    // Information TOP
    $informations = $this->getInformationTop($myItem, $request);
    foreach ($informations as $info)
    {
      $viewData->addInformation('top', $info['key'], $info['value'], $info['link']);
    }

    // Information BOTTOM
    $informations = $this->getInformationBottom($myItem, $request);
    foreach ($informations as $info)
    {
      $viewData->addInformation('bottom', $info['key'], $info['value'], $info['link']);
    }


    if ($session->exists('message'))
    {
      $viewData->addMessage($session->message);
      $session->delete('message');
    }

    return $view->render($response, 'genericForm.html.twig', (array)$viewData);
  }

  public function commonUpdateItem(Request $request, Response $response, $args, $item): Response
  {
    $data = (object) $request->getParsedBody();
    // $myItem = $item->find($args['id']);

    // // rewrite data with right database name (for dropdown mainly)
    // $definitions = $item->getDefinitions();
    // foreach ($definitions as $def)
    // {
    //   echo "<br>";
    //   if (property_exists($data, $def['name']))
    //   {
    //     if (in_array($def['type'], ['input', 'textarea', 'dropdown']))
    //     {
    //       if ($myItem->{$def['name']} != $data->{$def['name']})
    //       {
    //         $myItem->{$def['name']} = $data->{$def['name']};
    //       }
    //     }
    //     elseif ($def['type'] == 'dropdown_remote')
    //     {
    //       if (isset($def['multiple']))
    //       {
    //         $values = $data->{$def['name']};
    //         if (!is_array($values))
    //         {
    //           if (empty($values))
    //           {
    //             $values = [];
    //           } else {
    //             $values = explode(',', $values);
    //           }
    //         }
    //         // save
    //         $myItem->{$def['name']}()->syncWithPivotValues($values, $def['pivot']);
    //       }
    //       elseif ($myItem->{$def['dbname']} != $data->{$def['name']})
    //       {
    //         $myItem->{$def['dbname']} = $data->{$def['name']};
    //       }
    //     }
    //   }
    // }

    // // update
    // $myItem->save();
    $this->saveItem($data, $args['id']);

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
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addRelatedPages($item->getRelatedPages($this->getUrlWithoutQuery($request)));
    $viewData->addHeaderColor($myItem->getColor());

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('feeds', $item->getFeeds($args['id']));
    if (is_null($myItem->content))
    {
      $viewData->addData('content', null);
    } else {
      $viewData->addData('content', \App\v1\Controllers\Toolbox::convertMarkdownToHtml($myItem->content));
    }

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
    $viewData->addTranslation('selectvalue', $translator->translate('Select a value...'));
    $viewData->addTranslation('yes', $translator->translate('Yes'));
    $viewData->addTranslation('no', $translator->translate('No'));

    if ($session->exists('message'))
    {
      $viewData->addMessage($session->message);
      $session->delete('message');
    }

    return $view->render($response, 'ITILForm.html.twig', (array)$viewData);
  }

  public function showNewItem(Request $request, Response $response, $args): Response
  {
    global $translator;
    $view = Twig::fromRequest($request);

    $item = new $this->model();

    $session = new \SlimSession\Helper();

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($item, $request);

    $viewData->addData('fields', $item->getFormData($item));
    $viewData->addData('content', '');

    $viewData->addTranslation('selectvalue', $translator->translate('Select a value...'));

    if ($session->exists('message'))
    {
      $viewData->addMessage($session->message);
      $session->delete('message');
    }

    return $view->render($response, 'genericForm.html.twig', (array)$viewData);
  }

  public function commonShowITILNewItem(Request $request, Response $response, $args, $item): Response
  {
    global $translator;
    $view = Twig::fromRequest($request);

    $session = new \SlimSession\Helper();

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($item, $request);

    $viewData->addData('fields', $item->getFormData($item));
    $viewData->addData('feeds', []);
    $viewData->addData('content', '');

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
    $viewData->addTranslation('selectvalue', $translator->translate('Select a value...'));
    $viewData->addTranslation('yes', $translator->translate('Yes'));
    $viewData->addTranslation('no', $translator->translate('No'));

    if ($session->exists('message'))
    {
      $viewData->addMessage($session->message);
      // $session->delete('message');
    }

    return $view->render($response, 'ITILForm.html.twig', (array)$viewData);
  }

  public function showSubHistory(Request $request, Response $response, $args)
  {
    $item = new $this->model();
    $definitions = $item->getDefinitions();
    $view = Twig::fromRequest($request);

    $session = new \SlimSession\Helper();

    // Load the item
    $myItem = $item->find($args['id']);

    $logs = \App\Models\Log::
        where('item_type', ltrim($this->model, '\\'))
      ->where('item_id', $myItem->id)
      ->orderBy('id', 'desc')
      ->get();

// id: 1
// item_type: App\v1\Models\User
// item_id: 6
// itemtype_link: Profile_User
// linked_action: 17
// user_name: glpi
// updated_at: 2012-01-24 10:21:20
// id_search_option: 0
// old_value:
// new_value: post-only, Root entity, D

    $fieldsTitle = [];
    foreach ($definitions as $def)
    {
      $fieldsTitle[$def['id']] = $def['title'];
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/history');

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($item, $request);

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    // $viewData->addData('content', \App\v1\Controllers\Toolbox::convertMarkdownToHtml($myItem->content));
    $viewData->addData('history', $logs);
    $viewData->addData('titles', $fieldsTitle);

    if ($session->exists('message'))
    {
      $viewData['message'] = $session->message;
      $session->delete('message');
    }

    return $view->render($response, 'subitem/history.html.twig', (array)$viewData);
  }

  public function newItem(Request $request, Response $response, $args): Response
  {
    $data = (object) $request->getParsedBody();
    $id = $this->saveItem($data);

    if (property_exists($data, 'save') && $data->save == 'view')
    {
      $uri = $request->getUri();
      return $response
        ->withHeader('Location', str_replace('/new', '/' . $id, (string) $uri))
        ->withStatus(302);
      exit;
    }

    $uri = $request->getUri();
    return $response
      ->withHeader('Location', (string) $uri)
      ->withStatus(302);
  }

  public function saveItem($data, $id = null)
  {
    // Manage fields like dropdown where name not same in database
    $fieldsDef = [];
    $booleans = [];
    $item = new $this->model();
    $definitions = $item->getDefinitions();
    foreach ($definitions as $definition)
    {
      if (isset($definition['fillable']) && $definition['fillable'] && isset($definition['dbname']))
      {
        $fieldsDef[$definition['name']] = $definition['dbname'];
      }
      if ($definition['type'] == 'boolean')
      {
        $booleans[$definition['name']] = true;
      }
    }


    if (is_null($id))
    {
      foreach ((array) $data as $key => $value)
      {
        if (isset($booleans[$key]))
        {
          if ($value == 'on')
          {
            $data->{$key} = true;
          } else {
            $data->{$key} = false;
          }
        }
      }

      $item = $this->model::create((array) $data);
      return $item->id;
    }

    // update
    $item = $this->model::find($id);
    if (is_null($item))
    {
      // Error
      return $id;
    }

    $aData = (array) $data;
    foreach ($aData as $key => $value)
    {
      if (isset($fieldsDef[$key]))
      {
        $aData[$fieldsDef[$key]] = $value;
      }
      if (isset($booleans[$key]))
      {
        if ($value == 'on')
        {
          $aData[$key] = true;
        } else {
          $aData[$key] = false;
        }
      }
    }

    $item->update($aData);

    // manage multiple
    foreach ($definitions as $def)
    {
      if (isset($def['multiple']))
      {
        $key = $def['name'];
        $pivot = [];
        if (isset($def['pivot']))
        {
          $pivot = $def['pivot'];
        }
        if (!is_array($data->{$key}))
        {
          if (empty($data->{$key}))
          {
            $data->{$key} = [];
          } else {
            $data->{$key} = explode(',', $data->{$key});
          }
        }

        $dbItems = [];
        foreach ($item->$key as $relationItem)
        {
          $dbItems[] = $relationItem->id;
        }
        // To delete
        $toDelete = array_diff($dbItems, $data->{$key});
        foreach ($toDelete as $groupId)
        {
          $item->$key()->detach($groupId, $pivot);
        }

        // To add
        $toAdd = array_diff($data->{$key}, $dbItems);
        foreach ($toAdd as $groupId)
        {
          $item->$key()->attach($groupId, $pivot);
        }
      }
    }
    return $item->id;
  }

  protected function getInformationTop($item, $request)
  {
    return [];
  }

  protected function getInformationBottom($item, $request)
  {
    return [];
  }
}
