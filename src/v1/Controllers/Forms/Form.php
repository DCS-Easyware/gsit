<?php

namespace App\v1\Controllers\Forms;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

final class Form extends \App\v1\Controllers\Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Form();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Form();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Form();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

  public function showSections(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Forms\Form();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('sections')->find($args['id']);

    $sections = [];
    foreach ($myItem->sections as $section) {
      $sections[$section->id] = [
        'id' => $section->id,
        'name' => $section->name,
      ];

      $item2 = new \App\Models\Forms\Section;
      $myItem2 = $item2::withCount('questions')->find($section->id);
      $sections[$section->id]['questions_count'] = $myItem2->questions_count;

    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/sections');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('sections', $sections);

    $viewData->addTranslation('section', $translator->translatePlural('Section', 'Sections', 1));
    $viewData->addTranslation('nb_questions', $translator->translate('Nombre de questions'));

    return $view->render($response, 'subitem/sections.html.twig', (array)$viewData);
  }

  public function showQuestions(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Forms\Form();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('sections')->find($args['id']);

    $sections = [];
    foreach ($myItem->sections as $section) {
      $item2 = new \App\Models\Forms\Section;
      $myItem2 = $item2::with('questions')->find($section->id);

      $sections[$section->id] = [];
      $sections[$section->id]['id'] = $section->id;
      $sections[$section->id]['name'] = $section->name;

      foreach ($myItem2->questions as $question) {
        $sections[$section->id]['questions'][] = [
          'id' => $question->id,
          'name' => $question->name,
        ];
      }
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/questions');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('sections', $sections);
    $viewData->addData('src', 'form');

    $viewData->addTranslation('section', $translator->translatePlural('Section', 'Sections', 1));
    $viewData->addTranslation('question', $translator->translatePlural('Question', 'Questions', 1));

    return $view->render($response, 'subitem/questions.html.twig', (array)$viewData);
  }
}
