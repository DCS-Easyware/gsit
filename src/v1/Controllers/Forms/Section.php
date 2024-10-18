<?php

namespace App\v1\Controllers\Forms;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

final class Section extends \App\v1\Controllers\Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Section();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Section();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Forms\Section();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

  public function showQuestions(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Forms\Section;
    $view = Twig::fromRequest($request);

    $myItem = $item::with('questions')->find($args['id']);

    $questions = [];
    foreach ($myItem->questions as $question) {
      $questions[] = [
        'id' => $question->id,
        'name' => $question->name,
      ];
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
    $viewData->addData('questions', $questions);
    $viewData->addData('src', 'section');

    $viewData->addTranslation('question', $translator->translatePlural('Question', 'Questions', 1));

    return $view->render($response, 'subitem/questions.html.twig', (array)$viewData);
  }
}
